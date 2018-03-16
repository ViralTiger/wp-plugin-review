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
        $table_columns = array(
            'cb'		=> '<input type="checkbox" />', // to display the checkbox.
            'product'	=> __('Product', $this->plugin_text_domain),
            'first_name'	=> __('First Name', $this->plugin_text_domain),
            'last_name'	  => __('Last Name', $this->plugin_text_domain),
            'title'       => __('Title', $this->plugin_text_domain),
            'rating'      => __('Rating', $this->plugin_text_domain),
            'is_approved'		=> __('Is Approved', $this->plugin_text_domain),
            'id'		        => __('Id', $this->plugin_text_domain),
        );
        return $table_columns;
    }

    public function no_items()
    {
        _e('No reviews avaliable.', $this->plugin_text_domain);
    }

    public function prepare_items()
    {

      // code to handle bulk actions

        //used by WordPress to build and fetch the _column_headers property
        $this->_column_headers = $this->get_column_info();
        $table_data = $this->fetch_table_data();

        // code to handle data operations like sorting and filtering

        // start by assigning your data to the items variable
        $this->items = $table_data;

        // code to handle pagination
    }

    public function fetch_table_data()
    {
        global $wpdb;
        $wpdb_table = $wpdb->prefix . 'reviews';
        $orderby = (isset($_GET['orderby'])) ? esc_sql($_GET['orderby']) : 'time';
        $order = (isset($_GET['order'])) ? esc_sql($_GET['order']) : 'ASC';
        $user_query = "SELECT
                     product, first_name, last_name, title, rating, is_approved, id
                   FROM
                     $wpdb_table
                    ORDER BY $orderby $order";
        // query output_type will be an associative array with ARRAY_A.
        $query_results = $wpdb->get_results($user_query, ARRAY_A);

        // return result array to prepare_items.
        return $query_results;
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
        case 'product':
        case 'first_name':
        case 'last_name':
        case 'title':
        case 'rating':
        case 'is_approved':
        case 'id':
            return $item[$column_name];
        default:
          return $item[$column_name];
        }
    }
}
