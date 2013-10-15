<?php
/**
 * Plugin Name:   GitHub Plugin Update Check
 * Plugin URI:    https://github.com/brasofilo/github-plugin-update-checker
 * Description:   Update plugins from GitHub hosted repositories
 * Author:        Rodolfo Buaiz
 * Version:       2013.10.15
 * Licence:       GPLv3
 * Author URI:    http://brasofilo.com
 */

! defined( 'ABSPATH' ) and exit;

add_action( 
	'plugins_loaded',
	array( B5F_GitHub_Plugin_Update_Check::get_instance(), 'plugin_setup' )
);

class B5F_GitHub_Plugin_Update_Check 
{
	
	protected static $instance = NULL;    
    public static $repo_slug = 'github-plugin-update-checker';
	
    
	/**
	 * Constructer
	 *
	 * @uses
	 * @access public
	 * @since  0.0.1
	 * @return void
	 */
	public function __construct() {}

    
	/**
	 * points the class
	 *
	 * @access public
	 * @since  0.0.1
	 * @return object
	 */
	public static function get_instance() 
    {		
		NULL === self::$instance and self::$instance = new self;		
		return self::$instance;
	}
	
    
	/**
	 * Used for regular plugin work.
	 * 
	 * @wp-hook  plugins_loaded
	 * @since    05/02/2013
	 * @return   void
	 */
	public function plugin_setup() 
    {
		if ( ! is_admin() )
			return;
        
        // Self hosted updates
        include_once 'inc/plugin-update-dispatch.php';
        new B5F_General_Updater_and_Plugin_Love(array( 
            'repo' => self::$repo_slug, 
            'user' => 'brasofilo',
            'plugin_file' => plugin_basename( __FILE__ ),
            'donate_text' => 'Buy me a beer',
            'donate_icon' => '&hearts; ',
            'donate_link' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=JNJXKWBYM9JP6&lc=US&item_name=Rodolfo%20Buaiz&item_number=Plugin%20donation&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted'
        ));	
    }
	
	
}
