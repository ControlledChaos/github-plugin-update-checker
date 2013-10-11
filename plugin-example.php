<?php
/**
 * Plugin Name:   GitHub Plugin Update Check
 * Plugin URI:    https://github.com/brasofilo/github-plugin-update-checker
 * Description:   Update plugins from GitHub hosted repositories
 * Author:        Rodolfo Buaiz
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
		if(  strpos( $source, 'WordPress-Admin-Style') === false )
			return $source;

		$path_parts = pathinfo($source);
		$newsource = trailingslashit($path_parts['dirname']). trailingslashit('WordPress-Admin-Style');
		rename($source, $newsource);
		return $newsource;
	}
}
