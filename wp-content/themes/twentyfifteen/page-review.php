<?php
/**
 * Template Name: Post Data
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>


        <article id="post-2" class="post-2 page type-page status-publish hentry">
          <div class="entry-content">
            <?php

              //response generation function

              $response = "";

              //function to generate response
              function my_contact_form_generate_response($type, $message)
              {
                  global $response;
                  if ($type == "success") {
                      $response = "<div class='success'>{$message}</div>";
                  } else {
                      $response = "<div class='error'>{$message}</div>";
                  }
              }

              //response messages
              $not_human       = "Human verification incorrect.";
              $missing_content = "Please supply all information.";
              $email_invalid   = "Email Address Invalid.";
              $message_unsent  = "Message was not sent. Try Again.";
              $message_sent    = "Thanks! Your message has been sent.";

              //user posted variables
              $review = [
                'product' => $_POST['product'],
                'full_name' => $_POST['first_name'],
                'last_name'  => $_POST['last_name'],
                'email'      => $_POST['email'],
                'title'      =>  $_POST['title'],
                'description' => $_POST['description'],
                'rating'      => $_POST['rating'],
              ];

              $human  = $_POST['message_human'];


              function insertReview($review)
              {
                  global $wpdb;
                  $wpdb->insert(
                      $wpdb->prefix . 'reviews',
                      $review
                  );
              }



              //php mailer variables
              $to = get_option('admin_email');
              $subject = "Someone sent a message from ".get_bloginfo('name');
              $headers = 'From: '. $review['email'] . "\r\n" .
                         'Reply-To: ' . $review['email'] . "\r\n";

              if (!$human == 0) {
                  if ($human != 2) {
                      my_contact_form_generate_response("error", $not_human);
                  } //not human!
                  else {

                  //validate email
                      if (!filter_var($review['email'], FILTER_VALIDATE_EMAIL)) {
                          my_contact_form_generate_response("error", $email_invalid);
                      } else { //email is valid
                          //validate presence of name and message
                          if (empty($review['email'])) {
                              my_contact_form_generate_response("error", $missing_content);
                          } else { //ready to go!
                              $sent = wp_mail($to, $subject, strip_tags($review['description']), $headers);
                              if ($sent) {
                                  insertReview($review);
                                  my_contact_form_generate_response("success", $message_sent);
                              } //message sent!
                              else {
                                  my_contact_form_generate_response("error", $message_unsent);
                              } //message wasn't sent
                          }
                      }
                  }
              } elseif ($_POST['submitted']) {
                  my_contact_form_generate_response("error", $missing_content);
              }
          ?>

          <!-- Form -->
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">
              <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
              <?php the_content(); ?>

              <style type="text/css">
                .error{
                  padding: 5px 9px;
                  border: 1px solid red;
                  color: red;
                  border-radius: 3px;
                }

                .success{
                  padding: 5px 9px;
                  border: 1px solid green;
                  color: green;
                  border-radius: 3px;
                }

                form span{
                  color: red;
                }
              </style>

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


            </div><!-- .entry-content -->

          </article><!-- #post -->


          </div>
        <article>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
