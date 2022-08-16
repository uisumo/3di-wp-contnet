<?php
require_once(SG_POPUP_EXTENSION_PATH.'SgpbIPopupExtension.php');

class SGPBExitIntentExtension implements SgpbIPopupExtension
{
	public function getScripts($pageName, $data)
	{

	}

	public function getStyles($page, $data)
	{

	}

	public function getFrontendScripts($page, $popupData)
	{
		$scriptData = array();
		$hasExitIntent = false;

		if (empty($popupData['popups'])) {
			return $scriptData;
		}

		foreach ($popupData['popups'] as $popup) {

			if (empty($popup)) {
				continue;
			}

			$popupId = $popup->getId();
			$eventsData = get_post_meta($popupId, 'sg_popup_events');

			if (empty($eventsData)) {
				continue;
			}

			$eventsData = $eventsData[0];
			if (!empty($eventsData[0])) {
				foreach ($eventsData[0] as $eventData) {
					if ($eventData['param'] == SGPB_EXIT_INTENT_ACTION_KEY) {
						$hasExitIntent = true;
					}
				}
			}
		}

		if (!$hasExitIntent) {
			return $scriptData;
		}

		$jsFiles = array();
		$localizeData = array();
		$jsFiles[] = array('folderUrl' => SGPB_EXIT_INTENT_JAVASCRIPT_URL, 'filename' => 'ExitIntent.js', 'dep' => array('PopupBuilder.js'));

		$localizeData[] = array(

		);

		$scriptData = array(
			'jsFiles' => $jsFiles,
			'localizeData' => $localizeData
		);

		return $scriptData;
	}

	public function getFrontendStyles($page, $popupData)
	{

	}
}
