<?php
/*
Plugin Name: Reviews
*/


# Activation and deactivation hooks provide ways to perform actions when plugins are activated or deactivated.

register_activation_hook(__FILE__, 'createTable');



function createTable()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . "reviews";
    $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    product varchar(191) DEFAULT '' NOT NULL,
    full_name varchar(191) DEFAULT '' NOT NULL,
    last_name varchar(191) DEFAULT '' NOT NULL,
    title varchar(191) DEFAULT '' NOT NULL,
    description varchar(191) DEFAULT '' NOT NULL,
    is_approved tinyint(1) DEFAULT 0 NOT NULL,
    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_deactivation_hook(__FILE__, 'dropTable');

function dropTable()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . "reviews";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    dbDelta($sql);
}
