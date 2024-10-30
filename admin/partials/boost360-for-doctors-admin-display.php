<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.nowfloats.com
 * @since      1.0.0
 *
 * @package    Boost360_For_Doctors
 * @subpackage Boost360_For_Doctors/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>Configure: Boost360 for Doctors</h2>
    <hr/>
    <form method="post" name="boostx_options" action="options.php">
    <?php
        //Grab all options
        $options = get_option($this->plugin_name);
        // Cleanup
        $boostxscript = $options['boostxscript'];
        $sync_post = $options['sync_post'];
        $sync_image = $options['sync_image'];
        $sync_int_id = $options['int_id'];
    ?>

    <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>
        <p class="welcome_text">
            Hello Doctor,<br/>
            You can configure your new <strong>online clinic</strong> with the steps below. Online clinic would eable your patients to book appointments and directly online. 
            The system is HIPAA compliant and the consultation flow is in accordance to Indian medical regulations.
        </p>
        <ul class="welcome_text">
            <li>1. Setup or Login using Boost app on <a href="https://play.google.com/store/apps/details?id=com.biz2.nowfloats" target="_blank">Android</a>, <a href="https://apps.apple.com/in/app/nowfloats-boost/id639599562" target="_blank">iOS</a>, <a href="https://boost.nowfloats.com" target="_blank">web</a>.</li>
            <li>2. Ensure that your 'Doctor profile' is configured in the Appointment Scheduler</li>
        </ul>
        <small>You can find more information about Online Clinic <a href="https://online-clinic.getboost360.com" target="_blank">here</a> or <a href="https://www.youtube.com/watch?v=UYjlbTnF-YE" target="_blank">watch video</a>.</small>
        <br/>
        <hr/>
        <p class="welcome_text">
            3. Go to Settings -> Boost360 Extensions -> Wordpress<br/>
            4. Copy & enter the "Integration Key"
        </p>
        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Enter the integration key', $this->plugin_name); ?></span></legend>
            <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-int_id" name="<?php echo $this->plugin_name; ?>[int_id]" value="<?php if(!empty($sync_int_id)) echo $sync_int_id; ?>"/>
        </fieldset>
        <hr/>
        <p class="welcome_text">
            5. Enable Boost360 social media sync
        </p>
        <fieldset>
            <legend class="screen-reader-text">
                <span>&nbsp;Sync published posts</span>
            </legend>
            <label for="<?php echo $this->plugin_name; ?>-sync_post">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-sync_post" name="<?php echo $this->plugin_name; ?>[sync_post]" value="1" <?php checked($sync_post, 1); ?> />
                <span><?php esc_attr_e('Sync published posts', $this->plugin_name); ?></span>
            </label>
            <fieldset>
                <legend class="screen-reader-text">
                    <span>&nbsp;Sync uploaded media</span>
                </legend>
                <label for="<?php echo $this->plugin_name; ?>-sync_product">
                    <input type="checkbox" id="<?php echo $this->plugin_name; ?>-sync_image" name="<?php echo $this->plugin_name; ?>[sync_image]" value="1" <?php checked($sync_image, 1); ?> />
                    <span><?php esc_attr_e('Sync published images/photos', $this->plugin_name); ?></span>
                </label>
            </fieldset>
        </fieldset>
        <hr/><br/>
        <p class="welcome_text" style="margin-bottom:0px">    
            6. Copy & enter the "wordpress-plugin script" below:
        </p>
        <small>(this will enable the Boost360 bar on your website, for patients to check your profile, read testimonials and book appointment for clinical / online consultation.)</small>
        <br/>
        <fieldset>
            <textarea class="script_area" rows="15" id="<?php echo $this->plugin_name; ?>-boostxscript" 
            name="<?php echo $this->plugin_name; ?>[boostxscript]"><?php if(!empty($boostxscript)) echo $boostxscript; ?></textarea>
        </fieldset>
        <br/>
        <hr/>
        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>
    </form>
</div>