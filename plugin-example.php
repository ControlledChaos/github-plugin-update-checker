<?php
/**
 * Plugin Name:   GitHub Plugin Update Check
 * Plugin URI:    https://github.com/brasofilo/github-plugin-update-checker
 * Description:   Update plugins from GitHub hosted repositories
 * Author:        Rodolfo Buaizz
 * Version:       0.1
 * Licence:       GPLv3
 * Author URI:    http://brasofilo.com
 * Last Change:   10/11/2013
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
        
        // Workaround to remove the suffix "-master" from the unzipped directory
        add_filter( 'upgrader_source_selection', array( $this, 'rename_github_zip' ), 1, 3 );
        
        // Plugin love
        add_filter( 'plugin_row_meta', array( $this, 'donate_link' ), 10, 4 );

        // Self hosted updates
        include_once 'inc/plugin-update-checker.php';
        $updateChecker = new PluginUpdateCheckerB(
            'https://raw.github.com/brasofilo/'.self::$repo_slug.'/master/inc/update.json', 
            __FILE__, 
            self::$repo_slug.'-master'
        );
    }
	
	
	/**
	 * points the class
	 *
	 * @access public
	 * @since  0.0.1
	 * @return object
	 */
	public static function get_instance() {
		
		NULL === self::$instance and self::$instance = new self;
		
		return self::$instance;
	}
	
    
    /**
     * Add donate link to plugin description in /wp-admin/plugins.php
     * 
     * @param array $plugin_meta
     * @param string $plugin_file
     * @param string $plugin_data
     * @param string $status
     * @return array
     */
    public function donate_link( $plugin_meta, $plugin_file, $plugin_data, $status ) 
	{
		if( plugin_basename( __FILE__ ) == $plugin_file )
			$plugin_meta[] = sprintf(
                '&hearts; <a href="%s">%s</a>',
                'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=JNJXKWBYM9JP6&lc=US&item_name=Rodolfo%20Buaiz&item_number=Plugin%20donation&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted',
                __('Donate','wp_admin_style')
            );
		return $plugin_meta;
	}


    /**
	 * Removes the prefix "-master" when updating from GitHub zip files
	 * 
	 * See: https://github.com/YahnisElsts/plugin-update-checker/issues/1
	 * 
	 * @param string $source
	 * @param string $remote_source
	 * @param object $thiz
	 * @return string
	 */
	public function rename_github_zip( $source, $remote_source, $thiz )
	{
		if(  strpos( $source, self::$repo_slug ) === false )
			return $source;

		$path_parts = pathinfo($source);
		$newsource = trailingslashit($path_parts['dirname']). trailingslashit( self::$repo_slug );
		rename($source, $newsource);
		return $newsource;
	}
}
