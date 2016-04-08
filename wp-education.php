<?php
/**
 * Plugin Name: WP Education Mangement
 * Description: Education management system in WordPress. A complete solution for education management using WordPress
 * Plugin URI: http://web-apps.ninja
 * Author: NinjaCoders
 * Author URI: http://web-apps.ninja
 * Version: 1.0
 * License: GPL2
 * Text Domain: wp-education
 * Domain Path: /i18n/languages/
 *
 * Copyright (c) 2016 NinjaCoders (email: ninjacoders2@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WebApps_WPEDU class
 *
 * @class WebApps_WPEDU The class that holds the entire WebApps_WPEDU plugin
 */
final class WebApps_WPEDU {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.0';

    /**
     * Initializes the WebApps_WPEDU() class
     *
     * Checks for an existing WebApps_WPEDU() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Constructor for the WebApps_WPEDU class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {

        // Define constants
        $this->defines();

        // Include required files
        $this->includes();

        // instantiate classes
        $this->instantiate();

        // Initialize the action hooks
        $this->init_actions();

        // Loaded action
        do_action( 'wpedu_loaded' );
    }

    /**
     * Define the plugin constants
     *
     * @return void
     */
    private function defines() {
        define( 'WPEDU_VERSION', $this->version );
        define( 'WPEDU_FILE', __FILE__ );
        define( 'WPEDU_PATH', dirname( WPEDU_FILE ) );
        define( 'WPEDU_INCLUDES', WPEDU_PATH . '/includes' );
        define( 'WPEDU_MODULES', WPEDU_PATH . '/modules' );
        define( 'WPEDU_URL', plugins_url( '', WPEDU_FILE ) );
        define( 'WPEDU_ASSETS', WPEDU_URL . '/assets' );
        define( 'WPEDU_VIEWS', WPEDU_PATH . '/views' );
    }

    /**
     * Include the required files
     *
     * @return void
     */
    private function includes() {
        include dirname( __FILE__ ) . '/vendor/autoload.php';
    }

    /**
     * Instantiate classes
     *
     * @return void
     */
    private function instantiate() {
        // new \WebApps\WPEDU\Admin\Admin_Menu();
    }

    /**
     * Initialize WordPress action hooks
     *
     * @return void
     */
    private function init_actions() {

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'wp-education', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n/languages/' );
    }


} // WebApps_WPEDU

/**
 * Init the wpedu plugin
 *
 * @return WebApps_WPEDU the plugin object
 */
function wpedu() {
    return WebApps_WPEDU::init();
}

// kick it off
wpedu();
