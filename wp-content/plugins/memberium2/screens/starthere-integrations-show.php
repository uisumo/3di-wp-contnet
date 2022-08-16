<?php
 if (!defined('ABSPATH' ) ) { die(); } ?>
<style>
	.columns {
		float:left;
		width:30%;
		display:inline-block;
		text-align:left;
		margin-right:25px;
		min-width:300px;
	}
</style>
<?php
 memberium_app()->wpllfqh_('view_integrations' ); $vwplxsc1yt = wpliebn::wpld1h0s(); $vwply2bex1 = false; echo '<div style="width:100%;border-color:#000;">'; echo '<div class="columns">'; if (! empty($vwplxsc1yt['detected'] ) ) { $vwply2bex1 = true; echo '<h3>Activated Integrations</h3>'; echo '<p class="indented">'; foreach ($vwplxsc1yt['detected'] as $vwplx9hkf ) { echo 'Detected: <span class="', $vwplx9hkf['class'], 'plugin">', $vwplx9hkf['name'], '</span>'; if ($vwplx9hkf['help'] > 0 ) { echo wpljwbf2::wplypewkt($vwplpxoyt['help'] ); } echo '<br>'; } echo '</p>'; } if (! empty($vwplxsc1yt['problem'] ) ) { $vwply2bex1 = true; echo '<h3>Potential conflicts</h3>'; echo '<p class="indented">'; foreach ($vwplxsc1yt['problem'] as $vwplx9hkf ) { echo 'Detected: <span class="badplugin ', $vwplx9hkf['class'], 'plugin">', $vwplx9hkf['name'], '</span>'; if ($vwplx9hkf['help'] > 0 ) { echo wpljwbf2::wplypewkt($vwplpxoyt['help'] ); } echo '<br>'; } echo '</p>'; } if (! $vwply2bex1 ) { echo '<p>No Integrations Detected.</p>'; } echo '</div>'; echo '<div class="columns">'; echo '<h3>Available Integrations</h3>'; echo '<p class="indented">'; if (! empty($vwplxsc1yt['available'] ) ) { foreach ($vwplxsc1yt['available'] as $vwplx9hkf ) { echo $vwplx9hkf['name']; if ($vwplx9hkf['help'] > 0 ) { echo wpljwbf2::wplypewkt($vwplpxoyt['help'] ); } echo '<br>'; } } else { echo 'No additional available integrations.<br>'; } unset($vwplxsc1yt, $vwplx9hkf ); echo '</p>'; echo '</div>'; echo '</div>';
