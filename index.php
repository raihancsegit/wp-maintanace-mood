<?php
/**
 * Plugin Name: WordPress Maintenance Mode
 * Plugin URI: https://yourwebsite.com/maintenance-mode-plugin
 * Description: Enables maintenance mode for your WordPress site.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WMM {

    public function __construct()
    {
        add_action('admin_menu',array(&$this,'wp_maintenance_mood_plugin_menu'));
        add_action('admin_init',array(&$this,'wp_maintenance_mood_setting'));
      
        $wmm_enable = '';
        $wmm_enable = get_option('wmm_enable') ? get_option('wmm_enable') : '';
        if($wmm_enable == 1){
            add_action('wp', array(&$this,'maintenance_mode'));
        }
        
        
    }


    public function maintenance_mode() {
        
        if (!current_user_can('edit_themes') || !is_user_logged_in()) {
            wp_die('<h1>Maintenance Mode</h1><br />This website is currently undergoing maintenance. Please check back soon.');
        }
    }
    public function wp_maintenance_mood_plugin_menu()
    {
        add_submenu_page( 
        'options-general.php', 
        'Maintenance Mode', 
        'Maintenance Mode', 
        'manage_options', 
        'wp-maintenance-mood', 
        array(&$this,'init_wp_maintenance_mood')
        );
    }

    public function init_wp_maintenance_mood(){
        ?>
<div class="product-sales-count">
    <h2>WP Maintanace Mood</h2>
    <form action="options.php" method="post">
        <div class="main-setting-section-wdp">
            <table cellpadding="10">
                <tr>
                    <td valign="top" style="padding-left: 20px;" width="500">
                        <p>
                            <input type="checkbox" id="wmm_enable" name="wmm_enable" value="1"
                                <?php checked(get_option('wmm_enable'),1);?> />
                            <label> Enabale/Disable Maintenance Mode</label>
                        </p>

                    </td>
                </tr>
            </table>
        </div>
        <span class="submit-btn">
            <?php _e( get_submit_button('Save Settings','button-primary','submit','','') , 'wdp');?>
        </span>
        </p>
        <?php settings_fields('wmm_options'); ?>
    </form>
</div>
<?php
    }

    public function wp_maintenance_mood_setting(){
        register_setting( 'wmm_options', 'wmm_enable', 'sanitize_text_field');
         
    } 

}
if(class_exists('WMM')):
    $wdpobj = new WMM;
endif;