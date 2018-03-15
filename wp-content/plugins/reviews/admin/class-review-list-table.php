<?php

// namespace Reviews\Admin;
//
// use Reviews\Libraries;

require_once plugin_dir_path(__DIR__) . 'libraries/class-wp-list-table.php';
// require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
//
// if(!class_exists('WP_List_Table')){
//     require_once( ABSPATH . 'wp-admin/includes/screen.php' );
//     require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
// }


class Review_List_Table extends Duplicate_WP_List_Table
{
    /**
     * The text domain of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_text_domain    The text domain of this plugin.
     */
    protected $plugin_text_domain;

    /*
     * Call the parent constructor to override the defaults $args
     *
     * @param string $plugin_text_domain	Text domain of the plugin.
     *
     * @since 1.0.0
     */
    public function __construct($plugin_text_domain)
    {
        $this->plugin_text_domain = $plugin_text_domain;

        parent::__construct(array(
        'plural'	=>	'reviews',	// Plural value used for labels and the objects being listed.
        'singular'	=>	'review',		// Singular label for an object being listed, e.g. 'post'.
        'ajax'		=>	false,		// If true, the parent class will call the _js_vars() method in the footer
      ));
    }


    // just the barebone implementation.
    public function get_columns()
    {
    }
    public function prepare_items()
    {
    }
}
