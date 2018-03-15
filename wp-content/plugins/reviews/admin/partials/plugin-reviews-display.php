<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php _e('WP List Table Demo', $this->plugin_text_domain); ?></h2>
        <div id="nds-wp-list-table-demo">
            <div id="nds-post-body">
		<form id="nds-user-list-form" method="get">
			<?php $this->user_list_table->display(); ?>
		</form>
            </div>
        </div>
</div>
