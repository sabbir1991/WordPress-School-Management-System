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
     * Minimum PHP version required
     *
     * @var string
     */
    private $min_php = '5.4.0';

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

        // dry check on older PHP versions, if found deactivate itself with an error
        register_activation_hook( __FILE__, array( $this, 'auto_deactivate' ) );

        if ( ! $this->is_supported_php() ) {
            return;
        }

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
     * Check if the PHP version is supported
     *
     * @return bool
     */
    public function is_supported_php() {
        if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Bail out if the php version is lower than
     *
     * @return void
     */
    function auto_deactivate() {
        if ( $this->is_supported_php() ) {
            return;
        }

        deactivate_plugins( basename( __FILE__ ) );

        $error = __( '<h1>An Error Occured</h1>', 'erp' );
        $error .= __( '<h2>Your installed PHP Version is: ', 'erp' ) . PHP_VERSION . '</h2>';
        $error .= __( '<p>The <strong>WP Education Mangement</strong> plugin requires PHP version <strong>', 'erp' ) . $this->min_php . __( '</strong> or greater', 'erp' );
        $error .= __( '<p>The version of your PHP is ', 'erp' ) . '<a href="http://php.net/supported-versions.php" target="_blank"><strong>' . __( 'unsupported and old', 'erp' ) . '</strong></a>.';
        $error .= __( 'You should update your PHP software or contact your host regarding this matter.</p>', 'erp' );
        wp_die( $error, __( 'Plugin Activation Error', 'erp' ), array( 'response' => 200, 'back_link' => true ) );
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
