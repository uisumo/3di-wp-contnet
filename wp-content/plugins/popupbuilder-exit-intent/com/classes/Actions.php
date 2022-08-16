<?php
namespace sgpbex;

class Actions
{
	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		add_filter('sgPopupEventsData', array($this, 'addPopupEventColumn'), 2, 1);
		add_filter('sgPopupEventTypes', array($this, 'addPopupEventTypes'), 2, 1);
		add_filter('sgEventsHiddenData', array($this, 'eventHiddenData'), 2, 1);
		add_filter('sgPopupEventAttrs', array($this, 'addPopupEvents'), 2, 1);
	}

	public function addPopupEvents($eventsAttrs)
	{
		$eventsAttrs['sgpb-exit-intent-soft-from-top'] = array(
			'htmlAttrs' => array(
				'class' => 'sgpb-popup-option sgpb-checkbox-clear-margin',
				'data-name' => 'sgpb-exit-intent-soft-from-top',
				'autocomplete' => 'off'
			),
			'infoAttrs' => array(
				'label' =>  __('Detect exit only from top bar', SGPB_EXIT_INTENT_TEXT_DOMAIN),
				'labelAttrs' => array(
					'class' => 'sgpb-align-center-with-checkbox'
				)
			)
		);

		$eventsAttrs['sgpb-exit-intent-cookie-level'] = array(
			'htmlAttrs' => array(
				'class' => 'sgpb-popup-option sgpb-checkbox-clear-margin',
				'data-name' => 'sgpb-exit-intent-cookie-level',
				'autocomplete' => 'off'
			),
			'infoAttrs' => array(
				'label' =>  __('Page level cookie saving', SGPB_EXIT_INTENT_TEXT_DOMAIN),
				'info' => __('If this option is checked the exit intent will be saved for the current page. Otherwise, the exit intent will refer site wide, and the popup will be shown for specific times on each page selected.', SG_POPUP_TEXT_DOMAIN),
				'labelAttrs' => array(
					'class' => 'sgpb-align-center-with-checkbox'
				)
			)
		);

		$eventsAttrs['sgpb-exit-intent-expire-time'] = array(
			'htmlAttrs' => array(
				'class' => 'sgpb-popup-option form-control input-sm sgpb-input-max-3',
				'data-name' => 'sgpb-exit-intent-expire-time',
				'autocomplete' => 'off'
			),
			'infoAttrs' => array(
				'label' =>  __('Expiry time', SGPB_EXIT_INTENT_TEXT_DOMAIN),
				'labelAttrs' => array(
					'class' => 'sgpb-align-center-with-input'
				),
				'rightLabel' => array(
					'value' => __('day(s)', SGPB_EXIT_INTENT_TEXT_DOMAIN),
					'classes' => 'sgpb-input-right-label'
				)
			)
		);

		$eventsAttrs[SGPB_EXIT_INTENT_ACTION_KEY] = array(
			'htmlAttrs' => array('class' => 'js-sg-select2'),
			'infoAttrs' => array(
				'label' => __('Mode', SGPB_EXIT_INTENT_TEXT_DOMAIN),
				'info' => __('Select the Exit Intent mode. Soft - This mode will show the popup when the user hovers the mouse cursor over the "X" close button of the page, or navigates out of the page. Aggressive - This mode will show the popup when the user refreshes the page, or clicks to exit it via external links or the "X" button of the tab.', SGPB_EXIT_INTENT_TEXT_DOMAIN)
			)
		);

		$eventAttrs[SGPB_EXIT_INTENT_ACTION_KEY] = array(
			'class' => 'js-sg-select2 js-select-basic sgpb-popup-option',
			'data-select-class' => 'js-select-basic',
			'data-select-type' => 'basic'
		);

		$eventAttrs['sgpb-exit-intent-expire-time'] = array('class' => 'sgpb-exit-intent-expire-time sgpb-popup-option');
		$eventAttrs['sgpb-exit-intent-cookie-level'] = array('class' => 'sgpb-exit-intent-cookie-level sgpb-popup-option');
		$eventAttrs['sgpb-exit-intent-soft-from-top'] = array('class' => 'sgpb-exit-intent-soft-from-top sgpb-popup-option');

		return $eventsAttrs;
	}

	public function addPopupEventColumn($eventsColumnData)
	{
		$optionsData = DefaultOptionsData::getOptionsDefaultData();
		$eventsColumnData['param'][SGPB_EXIT_INTENT_ACTION_KEY] = __('Exit intent', SGPB_EXIT_INTENT_TEXT_DOMAIN);
		$eventsColumnData[SGPB_EXIT_INTENT_ACTION_KEY] = $optionsData['exitIntentOptions'];
		$eventsColumnData['sgpb-exit-intent-expire-time'] = $optionsData['exitIntentExpireTime'];
		$eventsColumnData['sgpb-exit-intent-cookie-level'] = $optionsData['exitIntentCookieLevel'];
		$eventsColumnData['sgpb-exit-intent-soft-from-top'] = $optionsData['exitIntentFromTop'];

		return $eventsColumnData;
	}

	public function addPopupEventTypes($eventColumnType)
	{
		$eventColumnType[SGPB_EXIT_INTENT_ACTION_KEY] = 'select';
		$eventColumnType['sgpb-exit-intent-expire-time'] = 'number';
		$eventColumnType['sgpb-exit-intent-cookie-level'] = 'checkbox';
		$eventColumnType['sgpb-exit-intent-soft-from-top'] = 'checkbox';

		return $eventColumnType;
	}

	public function eventHiddenData($hiddenData)
	{
		$optionsData = DefaultOptionsData::getOptionsDefaultData();
		$hiddenData[SGPB_EXIT_INTENT_ACTION_KEY] = array(
			'settings' => array(
				'sgpb-exit-intent-expire-time' => $optionsData['exitIntentExpireTime'],
				'sgpb-exit-intent-cookie-level' => $optionsData['exitIntentCookieLevel'],
				'sgpb-exit-intent-soft-from-top' => $optionsData['exitIntentFromTop']
			)
		);

		return $hiddenData;
	}
}
