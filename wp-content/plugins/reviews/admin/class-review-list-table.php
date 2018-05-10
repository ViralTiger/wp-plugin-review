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
        // search box
        $review_search_key = isset($_REQUEST['s']) ? wp_unslash(trim($_REQUEST['s'])) : '';

        $this->_column_headers = $this->get_column_info();

        // check and process any actions such as bulk actions.
        $this->handle_table_actions();
        // fetch the table data
        $table_data = $this->fetch_table_data();
        // filter the data in case of a search
        if ($review_search_key) {
            $table_data = $this->filter_table_data($table_data, $review_search_key);
        }

        //used by WordPress to build and fetch the _column_headers property
        $this->_column_headers = $this->get_column_info();
        $table_data = $this->fetch_table_data();

        // code to handle data operations like sorting and filtering
        $this->process_bulk_action();

        // start by assigning your data to the items variable
        $this->items = $table_data;

        // code for pagination
        $reviews_per_page = $this->get_items_per_page('reviews_per_page');
        $table_page = $this->get_pagenum();
        // provide the ordered data to the List Table
        // we need to manually slice the data based on the current pagination
        $this->items = array_slice($table_data, (($table_page - 1) * $reviews_per_page), $reviews_per_page);
        // set the pagination arguments
        $total_reviews = count($table_data);
        $this->set_pagination_args(array(
          'total_items' => $total_reviews,
          'per_page'    => $reviews_per_page,
          'total_pages' => ceil($total_reviews/$reviews_per_page)
        ));
    }

    public function fetch_table_data()
    {
        global $wpdb;
        $wpdb_table = $wpdb->prefix . 'reviews';
        $orderby = (isset($_GET['orderby'])) ? esc_sql($_GET['orderby']) : 'time';
        $order = (isset($_GET['order'])) ? esc_sql($_GET['order']) : 'ASC';
        $review_query = "SELECT
                     product, first_name, last_name, title, rating, is_approved, id
                   FROM
                     $wpdb_table
                    ORDER BY $orderby $order";
        // query output_type will be an associative array with ARRAY_A.
        $query_results = $wpdb->get_results($review_query, ARRAY_A);

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

    function column_is_approved($item)
    {
      $idaprv = $item['is_approved'];

        $aprv = ' ';
        if ($idaprv == 0){
          $aprv = 'Approve';
        }
        else {
          $aprv = 'Disaprove';
        }
        $actions = array(
          'edit' => sprintf('<a href="?page=%s&action=%s&id=%s">'.$aprv.'</a>',$_REQUEST['page'],'edit',$item['id']),
          'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
        );



        return sprintf(
            '%1$s %3$s',
            $item['is_approved'],
            $item['is_approved'],
            $this->row_actions($actions)
        );
    }

    function process_bulk_action()
    {
        global $wpdb;

        if ('delete' === $this->current_action()) {
          $event = $_GET['id'];
          $wpdb->delete($wpdb->prefix.'reviews', array('id' => $event));
          echo "<script> window.location.href = 'http://localhost:8888/wp-plugin-review/wp-admin/users.php?page=reviews' </script>";

        }

        if ('edit' === $this->current_action()) {
          $event = $_GET['id'];
          $wpdb->query( "
             UPDATE {$wpdb->prefix}reviews SET is_approved = CASE WHEN @is_approved = 0 THEN @is_approved =1 ELSE is_approved = 0 END WHERE id ={$event};"
          );
          echo "<script> window.location.href = 'http://localhost:8888/wp-plugin-review/wp-admin/users.php?page=reviews' </script>";
       }
    }

    /**
     * Get value for checkbox column.
     *
     * @param object $item  A row's data.
     * @return string Text to be placed inside the column <td>.
     */
    protected function column_cb($item)
    {
        return sprintf(
        '<label class="screen-reader-text" for="review_' . $item['id'] . '">' . sprintf(__('Select %s'), $item['id']) . '</label>'
        . "<input type='checkbox' name='reviews[]' id='review_{$item['id']}' value='{$item['id']}' />"
        );
    }

    protected function get_sortable_columns()
    {
        /*
        * actual sorting still needs to be done by prepare_items.
    	 * specify which columns should have the sort icon.
    	 */
        $sortable_columns = array(
                'id' => array( 'id', true ),
                'product'=>'product',
                'first_name'=>'first_name',
                'last_name'=>'last_name',
                'title'=>'title',
                'rating'=>'rating',
                'is_approved'=>'is_approved',
            );
        return $sortable_columns;
    }
}
