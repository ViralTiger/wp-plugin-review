<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="respond">
  <?php echo $response; ?>
  <form action="<?php the_permalink(); ?>" method="post">
    <label for="name">Product: <span>*</span></label>
    <select name="product" value="<?php echo esc_attr($_POST['product']); ?>">
      <option value="Product">Product</option>
    </select>

    <label for="first_name">First Name: <span>*</span></label>
    <input type="text" name="first_name" value="<?php echo esc_attr($_POST['first_name']); ?>">

    <label for="last_name">Last Name: <span>*</span></label>
    <input type="text" name="last_name" value="<?php echo esc_attr($_POST['last_name']); ?>">

    <label for="email">Email: <span>*</span></label>
    <input type="text" name="email" value="<?php echo esc_attr($_POST['email']); ?>">

    <label for="title">Title: <span>*</span></label>
    <input type="text" name="title" value="<?php echo esc_attr($_POST['title']); ?>">

    <label for="rating">Rating: <span>*</span></label>
    <input type="text" name="rating" value="<?php echo esc_attr($_POST['rating']); ?>">

    <label for="description">Message: <span>*</span></label>
    <textarea type="text" name="description"><?php echo esc_textarea($_POST['description']); ?></textarea>

    <label for="message_human">Human Verification: <span>*</span></label>
    <input type="text" style="width: 60px;" name="message_human"> + 3 = 5

    <input type="hidden" name="submitted" value="1">
    <input type="submit"></p>
  </form>
</div>
