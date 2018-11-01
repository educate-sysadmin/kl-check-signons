<?php
/*
KL Access Admin
Author: b.cunningham@ucl.ac.uk
Author URI: https://educate.london
License: GPL2
*/
add_action('admin_menu', 'kl_check_signons_plugin_menu');

function kl_check_signons_plugin_menu(){
    //add_menu_page( 'KL Check Signons', 'KL Check Signons', 'manage_options', 'kl-check-signons-plugin', 'kl_check_signons_admin' );
    add_management_page( 'KL Check Signons', 'KL Check Signons', 'manage_options', 'kl-check-signons-plugin', 'kl_check_signons_admin' );
}


function kl_check_signons_admin() {
	echo '<div class="wrap">'."\n";
	
	echo "<h1>KL Check Signons</h1>";
	
	echo '<p>Note: This will change logged in user (to last signon tested), requiring logout/re-login after run.</p>';
	
    echo '<form action="" method="post">';
    
    $content = isset($_POST['kl_signons'])?$_POST['kl_signons']:"username:password;username2:password2";
	echo '<textarea name = "kl_signons" style="width: 100%;" rows=10>'.$content.'</textarea>';
	
	echo '<input name="submit" id="submit" class="button button-primary" value="submit" type="submit">';	
	echo '</form>';
	
	if (isset($_POST['kl_signons'])) {		
		$kl_signons = explode(';',$_POST['kl_signons']);
		foreach ($kl_signons as $signon) {
			echo '<p>';			
			$creds = array();
			$creds['user_login'] = substr($signon,0,strpos($signon,':'));
			$creds['user_password'] = substr($signon,strpos($signon,':')+1);
			$creds['remember'] = false;
			echo $creds['user_login'].'? ';
			$user = wp_signon( $creds, false );
			if ( is_wp_error($user) ) {
				echo $user->get_error_message();
			} else {
				echo "OK. ";
			}
			echo '</p>';
		}
	}
	echo '</div>'."\n"; // class="wrap
}

