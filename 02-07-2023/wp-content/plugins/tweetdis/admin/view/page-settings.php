<?php 
    if ( isset($_REQUEST['send_activate']) && $_REQUEST['send_activate']=='true') {
        Tweetdis_Connect::get_instance()->send_activation();
    }

    $status = Tweetdis_Settings::get_instance()->check_status();
    if ($status):
?>

        <h1 class="tweetdis_page_heading">Tweet Dis Settings</h1>

        <div class="tweetdis_page_wrap tweetdis_clearfix tweetdis_settings">

                <div class="tweetdis_tabs">
                    <input type="radio" id="box" name="main-tabs" checked="checked"/>
                    <label for="box">Box</label>
                    <input type="radio" id="hint" name="main-tabs"/>
                    <label for="hint">Hint</label>
                    <input type="radio" id="image" name="main-tabs"/>
                    <label for="image">Image</label>
                    <input type="radio" id="tweet" name="main-tabs"/>
                    <label for="tweet">Tweet</label>
                </div>

                <div id="tweetdis_preview"></div>

        </div>
        
<?php else: ?>
        
        <form name='activate' id='activate' method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
            <input type='hidden' name='domain' value='<?php echo $_SERVER['SERVER_NAME'];?>'>
            <input type='hidden' name='email' value='<?php echo get_option('admin_email');?>'>
            <input type='hidden' name='send_activate' value='true'>
            <p>Please enter your Plugin Purchase Code in the field below:</p>
            <div><input type='text' name='key'></div>
            <div><input type='submit' id="activate_btn" value='Activate'></div>
        </form>
        
<?php endif;