<?php

/**
 * The WP_List_Table Class copied from WP core
 */
require_once plugin_dir_path(__FILE__) . 'class-review-admin.php';
require_once plugin_dir_path(__DIR__) . 'libraries/class-wp-list-table.php';
require_once plugin_dir_path(__FILE__) . 'class-review-list-table.php';
// require_once plugin_dir_path(__DIR__) . 'libraries/class-wp-list-table.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The text domain of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_text_domain    The text domain of this plugin.
     */
    private $plugin_text_domain;

    /**
     * WP_List_Table object
     *
     * @since    1.0.0
     * @access   private
     * @var      review_list_table    $review_list_table
     */
    private $review_list_table;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version, $plugin_text_domain)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->plugin_text_domain = $plugin_text_domain;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/reviews-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/reviews-admin.js', array( 'jquery' ), $this->version, false);
    }


    /**
     * Callback for the user sub-menu in define_admin_hooks() for class Init.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu()
    {
        $page_hook = add_users_page(
                            __('User Reviews', $this->plugin_text_domain), //page title
                            __('User Reviews', $this->plugin_text_domain), //menu title
                            'manage_options', //capability
                            $this->plugin_name, //menu_slug,
                            array( $this, 'load_review_list_table' )
                        );

        /*
         * The $page_hook_suffix can be combined with the load-($page_hook) action hook
         * https://codex.wordpress.org/Plugin_API/Action_Reference/load-(page)
         *
         * The callback below will be called when the respective page is loaded
         *
         */
        add_action('load-'.$page_hook, array( $this, 'load_review_list_table_screen_options' ));
    }

    /**
    * Screen options for the List Table
    *
    * Callback for the load-($page_hook_suffix)
    * Called when the plugin page is loaded
    *
    * @since    1.0.0
    */
    public function load_review_list_table_screen_options()
    {
        $arguments	=	array(
                            'label'		=>	__('Reviews Per Page', $this->plugin_text_domain),
                            'default'	=>	5,
                            'option'	=>	'reviews_per_page'
                        );

        add_screen_option('per_page', $arguments);

        // instantiate the Review List Table
        $this->review_list_table = new Review_List_Table($this->plugin_text_domain);
    }

    /*
    * Callback for the add_reviews_page() in the add_plugin_admin_menu() method of this class.
    */
    public function load_review_list_table()
    {
        // query, filter, and sort the data
        $this->review_list_table->prepare_items();
        // render the List Table
        include_once('partials/plugin-reviews-display.php');
    }
}
