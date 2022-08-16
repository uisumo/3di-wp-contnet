<# checked = ( data.value === '1' || data.value === 1 ) ? ' checked="checked"' : ''; #>
<div class="bb-toggle-group">
    <label class="bb-toggle-switch">
        <input type="checkbox" name="{{data.name}}" class="bb-switch-input" value="1" tabindex="1"{{checked}}>
        <span class="bb-switch-label" data-on="On" data-off="Off"></span>
        <span class="bb-switch-handle"></span>
    </label>
</div>
