<?php

namespace GFPDF_Vendor\Mpdf;

use GFPDF_Vendor\Mpdf\File\LocalContentLoaderInterface;
use GFPDF_Vendor\Mpdf\File\StreamWrapperChecker;
use GFPDF_Vendor\Mpdf\Http\ClientInterface;
use GFPDF_Vendor\Mpdf\Http\Request;
use GFPDF_Vendor\Mpdf\Log\Context as LogContext;
use Psr\Log\LoggerInterface;
class AssetFetcher implements \Psr\Log\LoggerAwareInterface
{
    private $mpdf;
    private $contentLoader;
    private $http;
    private $logger;
    public function __construct(\GFPDF_Vendor\Mpdf\Mpdf $mpdf, \GFPDF_Vendor\Mpdf\File\LocalContentLoaderInterface $contentLoader, \GFPDF_Vendor\Mpdf\Http\ClientInterface $http, \Psr\Log\LoggerInterface $logger)
    {
        $this->mpdf = $mpdf;
        $this->contentLoader = $contentLoader;
        $this->http = $http;
        $this->logger = $logger;
    }
    public function fetchDataFromPath($path, $originalSrc = null)
    {
        /**
         * Prevents insecure PHP object injection through phar:// wrapper
         * @see https://github.com/mpdf/mpdf/issues/949
         * @see https://github.com/mpdf/mpdf/issues/1381
         */
        $wrapperChecker = new \GFPDF_Vendor\Mpdf\File\StreamWrapperChecker($this->mpdf);
        if ($wrapperChecker->hasBlacklistedStreamWrapper($path)) {
            throw new \GFPDF_Vendor\Mpdf\Exception\AssetFetchingException('File contains an invalid stream. Only ' . \implode(', ', $wrapperChecker->getWhitelistedStreamWrappers()) . ' streams are allowed.');
        }
        if ($originalSrc && $wrapperChecker->hasBlacklistedStreamWrapper($originalSrc)) {
            throw new \GFPDF_Vendor\Mpdf\Exception\AssetFetchingException('File contains an invalid stream. Only ' . \implode(', ', $wrapperChecker->getWhitelistedStreamWrappers()) . ' streams are allowed.');
        }
        $this->mpdf->GetFullPath($path);
        return $this->isPathLocal($path) || $originalSrc !== null && $this->isPathLocal($originalSrc) ? $this->fetchLocalContent($path, $originalSrc) : $this->fetchRemoteContent($path);
    }
    public function fetchLocalContent($path, $originalSrc)
    {
        $data = '';
        if ($originalSrc && $this->mpdf->basepathIsLocal && ($check = @\fopen($originalSrc, 'rb'))) {
            \fclose($check);
            $path = $originalSrc;
            $this->logger->debug(\sprintf('Fetching content of file "%s" with local basepath', $path), ['context' => \GFPDF_Vendor\Mpdf\Log\Context::REMOTE_CONTENT]);
            return $this->contentLoader->load($path);
        }
        if ($path && ($check = @\fopen($path, 'rb'))) {
            \fclose($check);
            $this->logger->debug(\sprintf('Fetching content of file "%s" with non-local basepath', $path), ['context' => \GFPDF_Vendor\Mpdf\Log\Context::REMOTE_CONTENT]);
            return $this->contentLoader->load($path);
        }
        return $data;
    }
    public function fetchRemoteContent($path)
    {
        $data = '';
        try {
            $this->logger->debug(\sprintf('Fetching remote content of file "%s"', $path), ['context' => \GFPDF_Vendor\Mpdf\Log\Context::REMOTE_CONTENT]);
            /** @var \Mpdf\Http\Response $response */
            $response = $this->http->sendRequest(new \GFPDF_Vendor\Mpdf\Http\Request('GET', $path));
            if ($response->getStatusCode() !== 200) {
                $message = \sprintf('Non-OK HTTP response "%s" on fetching remote content "%s" because of an error', $response->getStatusCode(), $path);
                if ($this->mpdf->debug) {
                    throw new \GFPDF_Vendor\Mpdf\MpdfException($message);
                }
                $this->logger->info($message);
                return $data;
            }
            $data = $response->getBody()->getContents();
        } catch (\InvalidArgumentException $e) {
            $message = \sprintf('Unable to fetch remote content "%s" because of an error "%s"', $path, $e->getMessage());
            if ($this->mpdf->debug) {
                throw new \GFPDF_Vendor\Mpdf\MpdfException($message, 0, \E_ERROR, null, null, $e);
            }
            $this->logger->warning($message);
        }
        return $data;
    }
    public function isPathLocal($path)
    {
        return \strpos($path, '://') === \false;
        // @todo More robust implementation
    }
    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
