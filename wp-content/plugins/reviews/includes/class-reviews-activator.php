<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . "reviews";
        $sql = "CREATE TABLE $table_name (
		    id mediumint(9) NOT NULL AUTO_INCREMENT,
		    product varchar(191) DEFAULT '' NOT NULL,
		    full_name varchar(191) DEFAULT '' NOT NULL,
		    email varchar(191) DEFAULT '' NOT NULL,
		    title varchar(191) DEFAULT '' NOT NULL,
		    description varchar(191) DEFAULT '' NOT NULL,
		    rating tinyint(9) DEFAULT 0 NOT NULL,
		    is_approved tinyint(1) DEFAULT 0 NOT NULL,
		    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		    PRIMARY KEY  (id)
		    ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
