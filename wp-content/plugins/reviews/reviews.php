<?php
/*
Plugin Name: Reviews
*/


# Activation and deactivation hooks provide ways to perform actions when plugins are activated or deactivated.

register_activation_hook(__FILE__, 'tableCreation');

function tableCreation()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . "reviews";
    $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    name tinytext NOT NULL,
    text text NOT NULL,
    url varchar(55) DEFAULT '' NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_deactivation_hook(__FILE__, 'pluginprefix_function_to_run');
