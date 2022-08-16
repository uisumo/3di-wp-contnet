=== GravityView - Maps ===
Tags: gravityview
Requires at least: 3.8
Tested up to: 5.8
Stable tag: trunk
Contributors: katzwebservices, luistinygod, soulseekah, mrcasual
License: GPL 3 or higher

Displays entries over a map using markers

== Description ==

### To set up:

* Use existing View connected to a form with an Address field
* Switch View Type, select Maps
* Add Address parent field to the Address zone
* Save the View
* Voilà

### Map Icons

GravityView Maps uses map icons from the [Maps Icons Collection by Nicolas Mollet](http://mapicons.nicolasmollet.com/). By default, a pre-selection of about 100 icons (from more than 700 available icons) has been added to the plugin.

== Installation ==

1. Upload plugin files to your plugins folder, or install using WordPress' built-in Add New Plugin installer
2. Activate the plugin
3. Configure "Maps" via the Maps metabox when editing a View

== Changelog ==

= 1.7.3.1 on September 1, 2021 =

* Fixed: 1.7.3 release was causing a fatal error due to some missing files

= 1.7.3 on September 1, 2021 =

* Fixed: Map not initializing when the View is embedded in a custom post type
* Updated translations: Dutch (thanks Erik!), Russian (thanks Irina!)

= 1.7.2 on May 19, 2021 =

* Added: Support for Gravity Forms 2.5
* Updated: Map zoom level settings to include 19–21
* Fixed: Map not being initialized when the View shortcode is embedded via the [Elementor](https://elementor.com/) page builder
* Fixed: Cached coordinates for multi-input fields would not clear when updating entries

__Developer Updates:__

* Added: Ability to center the map using the map options filter. [See sample code here](https://gist.github.com/zackkatz/cb1f52f563cb13fd7abe06b0553cdec2)
* Added: `gravityview/maps/marker/add` filter to modify marker before it gets added to the map

= 1.7.1 on October 14, 2019 =

* Updated: Polish translation (Thanks, Dariusz Zielonka!)
* Fixed: Locations not being updated when non-Address fields were used for coordinates
* Fixed: Google Maps API-checking script being loaded on all admin pages

= 1.7 on September 2, 2019 =

* Improved: Allow input of latitude and longitude all the time for an Address field
* Improved: Many enhancements to the API key setup
    - Maps now will show a warning to administrators when the API settings aren't valid
    - Maps will now not show to users if the API isn't configured properly (instead of showing a broken map)
    - Added API key validation in the Maps section of the GravityView settings screen
    - Simplified settings by removing less-used methods of geocoding addresses (they are still available via developer filters)
    - Improved error message language
* Improved: Allow deleting geocoding results by saving empty latitude/longitude fields
* Changed: If an address only contains default values (such as Default State/Province or Default Country), do not show a marker on the map
* Fixed:  Map Icon Picker field #97
* Fixed: JS console error in Chrome
* Fixed: When the Google Maps key isn't working for geocoding, it was preventing other providers from working
* Fixed: Address wasn't being properly formatted when passed to geocoding providers

= 1.6.2 on December 21, 2018 =

* Fixed: Hide map when "Hide View data until search is performed" is enabled for a View
* Updated: Turkish translation (thanks, [@suhakaralar](https://www.transifex.com/accounts/profile/suhakaralar/)!)

= 1.6.1 on December 3, 2018 =

* Fixed: "Hide View data until search is performed" setting not working (also requires GravityView 2.2.1)
* Fixed: JavaScript error when map has no markers
* Updated translations - thank you, translators!
    - Polish translated by [@dariusz.zielonka](https://www.transifex.com/user/profile/dariusz.zielonka/)
    - Russian translated by [@awsswa59](https://www.transifex.com/user/profile/awsswa59/)

__Developer Updates:__

* Added: `alt` tag to default icon in Map Icon field
* Added: `gravityview/maps/available_icons/sections` and `gravityview/maps/available_icons/icons` filters to modify the icons shown in the Map Icon field
* Fixed: Add additional marker icons to the list in the Map Icon by adding .png images to your theme's ``/gravityview/mapicons/` subdirectory
* Fixed: Map Icon field compatibility with Gravity Forms 2.4 deprecation of `conditional_logic_event()`
* Modified: `maps-body.php` template file to run `gv_container_class()` on the `.gv-map-entries` container DIV

= 1.6 on October 15, 2018 =

[Learn all about this update on our blog post](https://gravityview.co/?p=590392)

* Added: Marker clustering—display multiple markers on a map as a single "cluster" [Learn how](https://docs.gravityview.co/article/495-map-marker-clustering)
* Added: When multiple markers are at the same location, clicking the location expands to show all markers
* Added: You can now override coordinates for address fields [Learn how](https://docs.gravityview.co/article/493-override-geocoding-coordinates)
* Added: Support for multiple address fields for a single entry [Here's how](https://docs.gravityview.co/article/492-markers-from-multiple-address-fields)
* Improved: When geocoding fails for an address, a note is added to the entry
* Improved: Map Icon field scripts are only loaded when the field is present
* Improved: When an entry is updated, refresh the geocoding cache only if the address has changed
* Improvement: If an entry has no address, but the Gravity Forms field has defaults set, use the defaults for geocoding
* Fixed: Google Maps API key not being added properly
* Fixed: When site was in debug mode (`WP_DEBUG` was enabled), addresses would be re-geocoded on each page load
* Fixed: Map Icon field styles loaded on Gravity Forms Preview and Gravity Forms Edit Entry screens

= 1.5 on May 31, 2018 =

* Fixed: Address fields with no label were appearing blank in the View settings dropdown
* Fixed: Standalone map fields not rendering
* Fixed: Address fields displaying multiple times on embedded Views
* Fixed: Error related to custom marker icons
* Fixed: Empty address field dropdown choice in View Settings when the field had no label
* Fixed: Maps scripts loading on all admin screens
* Tweak: Reduced number of database calls
* Changed: Hide the map widget when there are no results
* Changed: If GravityView core caching isn't available, don't cache markers
* Updated translations

= 1.4.2 on August 18, 2016 =

* Updated: "Zoom Control" setting has been simplified to "None", "Small", or "Default"; this is because Google Maps [no longer allows](https://developers.google.com/maps/documentation/javascript/releases#324) custom zoom control sizes
* Fixed: Don't render Maps widget if using a DataTables layout (we are hoping to support this in the future)
    * Also don't show Maps widget and fields in the Edit View screen when using a DataTables layout
* Fixed: Map not displaying when widget is in "Below Entries Widgets" zone
* Fixed: Javascript error when using the WordPress Customizer

__Developer Notes:__

* Allow global access to manipulate maps after instantiation ([see example](https://gist.github.com/zackkatz/1fccef0835aacd6693903c96ba146973))
* Added ability to set `mobile_breakpoint` via the `gravityview/maps/render/options` filter
* `zoomControlOptions` no longer allows `style` value to be set; instead, only `position` is valid ([See example](https://gist.github.com/zackkatz/630da145c8c813a48ba3b282b3610e5a))

= 1.4.1 on April 7, 2016 =

* New: Configure info boxes to display additional information when clicking a map marker. [Learn how here!](http://docs.gravityview.co/article/345-how-to-configure-info-boxes)
* Fixed: "Undefined index" PHP warning on frontend when saving a new Map View for the first time
* No longer in beta!

__Developer Notes:__

* Added: Filter `gravityview/maps/field/icon_picker/button_text` to modify the text of the Icon Picker button (Default: "Select Icon")
* Added: Use the `gravityview/maps/marker/url` hook to filter the marker single entry view link url
* Added: Use the `gravityview/maps/render/options` hook to change the marker link target attribute (marker_link_target`). [Read more](http://docs.gravityview.co/article/339-how-can-i-make-the-marker-link-to-open-in-a-new-tab)

= 1.3.1-beta on November 13, 2015 =

* Added: Option to set map zoom, separate from maximum and minimum zoom levels. Note: this will only affect Entry Map field maps or maps with a single marker.
* Fixed: Don't show a map if longitude or latitude is empty
* Fixed: If entry has an icon already set, show it as selected in the icon picker

= 1.2-beta on September 25, 2015 =

* Fixed: Google Maps geocoding requires HTTPS connection
* Fixed: Support all WordPress HTTP connections, not just `cURL`
* Added: Custom filters to allow the usage of different fields containing the address value [Read more](http://docs.gravityview.co/article/292-how-can-i-pull-the-address-from-a-field-type-that-is-not-address)
* Added: Filter to enable marker position based on the latitude and longitude stored in the form fields [Read more](http://docs.gravityview.co/article/300-how-can-i-use-the-latitude-and-longitude-form-fields-to-position-map-markers)
* Added: Entry Map field on the Multiple Entries view
* Added: How-to articles showing how to sign up for Google, Bing, and MapQuest API keys
* Fixed: Map layers not working for multiple maps on same page
* Fixed: `GRAVITYVIEW_GOOGLEMAPS_KEY` constant not properly set
* Fixed: Error when `zoomControl` disabled and `zoomControlOptions` not default
* Modified: Check whether other plugins or themes have registered a Google Maps script. If it exists, use it instead to avoid conflicts.
* Tweak: Update CSS to prevent icon picker from rendering until Select Icon button is clicked
* Tweak: Update Google Maps script URL from `maps.google.com` to `maps.googleapis.com`

= 1.1-beta on September 11, 2015 =

* Added: Lots of map configuration options
    - Map Layers (traffic, transit, bike path options)
    - Minimum/Maximum Zoom
    - Zoom Control (none, small, large, let Google decide)
    - Draggable Map (on/off)
    - Double-click Zoom (on/off)
    - Scroll to Zoom (on/off)
    - Pan Control (on/off)
    - Street View (on/off)
    - Custom Map Styles (via [SnazzyMaps.com](http://snazzymaps.com)
* Fixed: Single entry map not rendering properly
* Fixed: Reversed `http` and `https` logic for Google Maps script
* Fixed: Only attempt to geocode an address if the address exists (!)
* Fixed: Only render map if there are map markers to display
* Tweak: Added support for using longitude & latitude fields instead of an Address field [learn how](http://docs.gravityview.co/article/300-how-can-i-use-the-latitude-and-longitude-form-fields-to-position-map-markers)
* Tweak: Hide illogical field settings
* Tweak: Improved translation file fetching support

= 1.0.3-beta on August 4, 2015 =

* Added: Ability to prevent the icon from bouncing on the map when hovering over an entry [see sample code](https://gist.github.com/zackkatz/635638dc761f6af8920f)
* Modified: Set a `maxZoom` default of `16` so that maps on the single entry screen aren't too zoomed in
* Fixed: Map settings filtering out `false` values, which caused the `gravityview/maps/render/options` filter to not work properly
* Fixed: Map settings conflicting with Edit Entry feature for subscribers
* Fixed: `Fatal error: Call to undefined method GFCommon::is_entry_detail_edit()`
* Updated: French, Turkish, Hungarian, and Danish translations. Thanks to all the translators!

= 1.0.2-beta on May 15, 2015 =

* Added: New Gravity Forms field type: Map Icon. You can choose different map markers per entry.
* Added: Middle field zone in View Configuration
* Tweak: Improved styling of the map using CSS
* Updated translations

= 1.0.1-beta on April 27, 2015 =

* Fixed: Missing Geocoding library
* Updated translations

= 1.0-beta on April 24, 2015 =

* Initial release


= 1642201873-3565 =