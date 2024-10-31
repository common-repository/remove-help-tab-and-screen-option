<?php 
/* 
Plugin Name: Remove Help tab and screen option
Plugin URI: https://venugopalphp.wordpress.com
Description: This plugin removes the screen option and help tabs depending on this plugin settings. By default its removed both.
Author: Venugopal
Author URI: https://venugopalphp.wordpress.com
Version: 1.0
 */
 
 /**
 * Including plugin  styles
 */
 add_action('admin_init', 'rmsh_load_styles');
  function rmsh_load_styles() {
	 wp_enqueue_style('rmsh_style',plugins_url('css/rmsh_style.css',__FILE__));
 }
 
 /* Initializing  plugin function */
 add_action( 'admin_menu', 'rmsh_plugin_raise' );
 function rmsh_plugin_raise() {	 
 add_options_page('Remove Help & Screen tabs', 'Remove Help & Screen tabs','manage_options','rmsh-help-screen','rmsh_plugin_load');
}
 
 /* Calling plugin function */
 function rmsh_plugin_load() {
	/* Plugin heading */
echo "<h3> Welcome to Remove Help tab and Screen option Plugin</h3>";
	 
	 /* Checking submit button clicked or not	 */
	 if(isset($_REQUEST['r_s_h_tabs_submit'])){
		 
		 $screen_tab = intval($_REQUEST['screen']);
		 $help_tab = intval($_REQUEST['help']);
		 
         /* Updting values in options table */		 
		 update_option('rmsh_screen_tab',$screen_tab);
		 update_option('rmsh_help_tab', $help_tab);
	 }
	 
	    /* Getting stored values for checkbox checked */
		 $op_screen = get_option('rmsh_screen_tab');
		 $op_help = get_option('rmsh_help_tab')
		 
/* Display Checkboxes List below */	 ?>	 
<div class="r_s_h_tabs">
    <form name="r_s_h_tabs" method="post">	
        <div class="r_s_h_check">
            <label><input type="checkbox"  name="screen" class="r_s_h_screen" value="1" <?php if ($op_screen == '1') { ?>checked="checked" <?php } ?>> Remove Screen Tab</label>
        </div>
        <div class="r_s_h_check">
            <label><input type="checkbox"  name="help" class="r_s_h_help" value="1" <?php if ($op_help == '1') { ?>checked="checked" <?php } ?>> Remove Help Tab</label>
        </div>
        <div class="r_s_h_submit">
            <i> Please select or unselect above and click on SUBMIT button</i><br><br>
            <input type="submit" name="r_s_h_tabs_submit" class="r_s_h__sub" value="Submit"> 
        </div> 
    </form>
</div>    
<?php  } // Plugin function end here

/* Getting stored values for hiding help or screen tabs */
 $op_screen_check = get_option('rmsh_screen_tab');
 $op_help_check = get_option('rmsh_help_tab');
 
   /* If Screen checkbox checked REMOVE Screen Tab */
 	if($op_screen_check == '1'){
	   add_filter('screen_options_show_screen', '__return_false');	// Removing Screen filter
	}	
     
	 /* If Help checkbox checked REMOVE Help Tab */
	 if($op_help_check == '1'){
		
		add_filter( 'contextual_help', 'rmsh_help_tabs'); // Removing help tab filter
		function rmsh_help_tabs(){
		   $screen = get_current_screen();
			$screen->remove_help_tabs();
		}
	}
	
/* By default checkboxes checked on plugin activation */
 class Remove_help_screen_default {
     static function screen_help_default_checked() {
		update_option('rmsh_screen_tab', '1');
		update_option('rmsh_help_tab', '1');
     }
}
register_activation_hook( __FILE__, array( 'Remove_help_screen_default', 'screen_help_default_checked' ) );	


/* Delete the stored data while uninstall this plugin  */
function rmsh_plugin_Uninstall(){
	delete_option('rmsh_screen_tab');
	delete_option('rmsh_help_tab');
}
register_deactivation_hook( __FILE__, 'rmsh_plugin_Uninstall' );