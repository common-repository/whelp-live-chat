<?php
/*
 * Plugin Name: Whelp Live Chat
 * Version: 0.0.4
 * Description: Perfectly designed for you to chat with your visitors in real time on your Website, Facebook, Viber or Telegram and increase your online sales. 
 * Author: Whelp
 * Author URI: https://getwhelp.com/?ref=wordpress
 * Plugin URI: https://getwhelp.com/?ref=wordpress
 */

// Prevent Direct Access
defined('ABSPATH') or die("Restricted access!");

/*
* Define
*/
define('whelp_url', plugin_dir_url(__FILE__));

// Register settings
function Whelp_register_settings() {
	register_setting('Whelp_settings_group', 'Whelp_settings');
}
add_action('admin_init', 'Whelp_register_settings');

// Delete options on uninstall
function Whelp_uninstall() {
	delete_option('Whelp_settings');
}
register_uninstall_hook( __FILE__, 'Whelp_uninstall');

//add plugin to options menu
function whelp_admin_menu(){
    add_menu_page(
        'Whelp Live Chat', 
        'Whelp Live Chat',
        'manage_options', 
        basename(__FILE__), 
        'whelp_options_page',
        whelp_url.'img/icon.png'
    );
}
add_action('admin_menu', 'whelp_admin_menu');

// Output the options page
function whelp_options_page() {
	// Get options
	$options = get_option('Whelp_settings');

	// Check to see if Whelp identify is checked
	$whelp_identify = false;
	if (esc_attr($options['whelp_identify'])=="on") {
		$whelp_identify = true;
		wp_cache_flush();
	}

?>
<style type="text/css">
.whelp-main-box{width:700px;margin-left:auto;margin-right:auto}.whelp-main-box h1{text-align:center;margin-bottom:20px}.whelp-main-box h1 img{width:250px}.whelp-main-box .whelp-success-text{background:no-repeat scroll left center transparent;font-weight:bold;margin-left:10px;padding:20px 10px 20px 80px;margin-bottom:15px}.whelp-main-box .whelp-small-box{background-color:#fff;padding:25px 20px 35px 20px;border-radius:5px;box-shadow:0 8px 52px rgba(52, 56, 59, 0.075)}.whelp-main-box .whelp-small-box form{width:400px;margin-left:auto;margin-right:auto}.whelp-main-box .whelp-small-box form label{width:100%;display:inline-block;margin-bottom:10px}.whelp-main-box .whelp-small-box form input[type="text"], .whelp-main-box .whelp-small-box form input[type="submit"]{width:100%;height:45px}.whelp-main-box .whelp-small-box form input[type="text"]:last-child, .whelp-main-box .whelp-small-box form input[type="submit"]:last-child{margin-top:10px}.whelp-main-box .whelp-small-box form .label-checkbox{padding-top:12px}.whelp-main-box .whelp-small-box form .label-checkbox input{margin-right:10px}.whelp-main-box .whelp-small-box .whelp-buttons-list{width:250px;margin-left:auto;margin-right:auto}.whelp-main-box .whelp-small-box .whelp-buttons-list .button{width:100%;display:inline-block;margin-bottom:10px;height:45px;line-height:41px;text-align:center}.whelp-main-box .whelp-small-box .whelp-buttons-list .button:last-child{margin-bottom:0}.whelp-main-box .whelp-small-box pre{margin-top: 25px;margin-bottom: 0;}.whelp-main-box .whelp-small-box .whelp-install-text{margin-bottom:25px}.whelp-main-box .whelp-footer-text{text-align:center}
</style>

<div class="wrap">
    <div class="whelp-main-box">
        <h1>
            <a href="https://getwhelp.com/?ref=wp_plugin_settings" target="_blank">
                <img src="https://getwhelp.com/assets/images/logo.png">
            </a>
        </h1>

        <?php if($options['whelp_widget_code']=='') { ?>

            <div class="whelp-small-box">
                <div class="whelp-install-text">To install live chat from Whelp, please <a href="https://app.getwhelp.com/signup?ref=wp_plugin_settings" target="_blank">create a new account</a>, or use your existing one. Copy and paste the live chat ID from Apps -> Live chat -> Configure -> Installation.</div>

                <form action="options.php" method="post" enctype="multipart/form-data">
                	<?php settings_fields('Whelp_settings_group'); ?>
					<?php do_settings_sections('Whelp_settings_group'); ?>

                    <label for="webchat_id">Live Chat ID</label>
                    <input id="webchat_id" type="text" value=""  pattern=".{32}" max-width="32" title="ID must be 32 characters long" name="Whelp_settings[whelp_widget_code]" required>

                    <label for="whelp_identify" class="label-checkbox"><input type="checkbox" id="whelp_identify" name="Whelp_settings[whelp_identify]">Indentify Users</label>

                    <input type="submit" name="submit" class="button button-primary" value="Install Live chat now">
                </form>
            </div>

            <p class="whelp-footer-text">If you need help, please chat with us on <a href="https://getwhelp.com/?ref=wp_plugin_settings">our website</a></p>

        <?php } else{ ?>

            <div class="whelp-success-text" style="background-image: url(<?php echo whelp_url; ?>img/success.png);">
                Congratulations! You have successfully installed Whelp live chat on your website. Now you need to install the agent’s web app on your computer and customize the chat window.
            </div>

            <div class="whelp-small-box">
                <div class="whelp-buttons-list">
                    <a class="button button-primary" href="https://app.getwhelp.com/conversations/me" target="_blank">Go to my Conversations</a>
                    <a class="button" href="https://app.getwhelp.com/apps/settings/<?php print $options['whelp_widget_code']; ?>/main" target="_blank">Go to live chat settings</a>

                    <form action="options.php" method="post" enctype="multipart/form-data" style="width: auto;">
	                	<?php settings_fields('Whelp_settings_group'); ?>
						<?php do_settings_sections('Whelp_settings_group'); ?>
						<input type="hidden" name="Whelp_settings[whelp_widget_code]" value="">
                    	<input type="hidden" name="Whelp_settings[whelp_identify]" value="">
	                    <input type="submit" name="submit" class="button button-link" value="Reset account" style="margin: 0;">
	                </form>
                </div>

                <pre>
                    Live Chat ID: <?php print $options['whelp_widget_code']; ?>
                </pre>
            </div>

            <p class="whelp-footer-text">Loving Whelp <b style="color:red">♥</b>? Rate us on the <a target="_blank" href="https://wordpress.org/support/plugin/whelp-live-chat/reviews/?filter=5">Wordpress Plugin Directory</a></p>

        <?php } ?>
    </div>
</div>

<?php
}

// Add the Whelp Javascript
add_action('wp_head', 'add_whelp');

// If we can indentify the current user output
function get_whelp_identify() {
	$current_user = wp_get_current_user();
	// print_r($current_user->roles[0]);
	// print_r(sanitize_text_field($current_user->roles[0]));

	// [ID] => 1
	// [user_login] => admin
	// [user_nicename] => admin
	// [user_email] => admin@workmore.pro
	// [user_url] => 
	// [user_registered] => 2019-03-11 22:47:26
	// [user_status] => 0
	// [display_name] => admin

	if ($current_user->user_email) {
		$sanitized_email = sanitize_email($current_user->user_email);

		return json_encode(array(
			"email" => $sanitized_email,
			"name" => sanitize_text_field($current_user->user_login),
			"userRole" => sanitize_text_field($current_user->roles[0])
		));
	}
	else {
		// See if current user is a commenter
		$commenter = wp_get_current_commenter();
		if ($commenter['comment_author_email']) {
			return json_encode(array(
				"email" => sanitize_email($commenter['comment_author_email']),
				"name" => sanitize_text_field($commenter['comment_author'])
			));
		}
	}

	return "";
}

// The guts of the Whelp script
function add_whelp() {
	// Ignore admin, feed, robots or trackbacks
	if (is_feed() || is_robots() || is_trackback()) {return;}

	$options = get_option('Whelp_settings');

	// If options is empty then exit
	if(empty($options)) {return;}

	$widget_code = $options['whelp_widget_code'];

	// Optional
	$custom_fields = "";
	if (!empty($options['whelp_identify']) && esc_attr($options['whelp_identify'])=="on") {
		$get_custom = get_whelp_identify();
		$custom_fields = $get_custom=="" ? "" : ",\n\t\tcustom: ".$get_custom;
	}

	// Insert tracker code
	if ($widget_code!='') {
		echo "\n\n\n<!-- Start Whelp Live Chat Plugin -->\n";
		echo "<script type=\"text/javascript\">
    window.WhelpConfig = {
        app_id: \"$widget_code\"$custom_fields
    };

    (function(w, d){
        function l(){
            var s = d.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://widget.getwhelp.com/widget.js';
            s.onload = function () {
                Whelp.Init();
            };
            var x = d.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        }
        if(w.attachEvent){w.attachEvent('onload',l);}
        else{w.addEventListener('load',l,false);}
    })(window, document);
</script>";
		echo"\n<!-- End Whelp Live Chat Plugin -->\n\n\n";
	}
}