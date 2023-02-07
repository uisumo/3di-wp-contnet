<?php
namespace sgpbex;

class DefaultOptionsData
{
	public static function getOptionsDefaultData()
	{
		$optionsData = array();

		$exitIntentOptions = array(
			'soft' =>  __('Soft mode', SGPB_EXIT_INTENT_TEXT_DOMAIN),
			'aggressive' => __('Aggressive mode', SGPB_EXIT_INTENT_TEXT_DOMAIN),
			'softAndAggressive' => __('Soft and Aggressive modes', SGPB_EXIT_INTENT_TEXT_DOMAIN),
			'aggressiveWithoutPopup' => __('Aggressive without popup', SGPB_EXIT_INTENT_TEXT_DOMAIN)
		);

		$optionsData['exitIntentOptions'] = $exitIntentOptions;
		$optionsData['exitIntentExpireTime'] = 1;
		$optionsData['exitIntentCookieLevel'] = '';
		$optionsData['exitIntentFromTop'] = '';

		return $optionsData;
	}
}