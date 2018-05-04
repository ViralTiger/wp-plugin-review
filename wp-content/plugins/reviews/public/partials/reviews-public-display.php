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

<?php
  //response generation function

  $response = "";
  $fnamerr = "none";
  $emailerror = "none";
  $titlerr ="none";
  $lnamerr = "none";
  $descerr = "none";
  $humanerr = "none";


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



      // if (isset($_POST['submit'])) {
      //   $h = 'dfsdfsdfsdf';
      //   $review = [
      //       'product'   => $_POST['product'],
      //       'first_name' => $_POST['first_name'],
      //       'last_name'  => $_POST['last_name'],
      //       'email'      => $_POST['email'],
      //       'title'      =>  $_POST['title'],
      //       'description' => $_POST['description'],
      //       'rating'      => $_POST['rating'],
      //     ];
      //     echo '<script language="javascript">';
      //     // echo 'alert("'.$h.'")';
      //     echo '</script>';
      //     insertReview($review);
      // }
      //
      // function insertReview($review)
      // {
      //     global $wpdb;
      //     $wpdb->insert(
      //         $wpdb->prefix . 'reviews',
      //         $review
      //     );
      //
      // }


  //
  //user posted variables
  if (isset($_POST['submit'])) {

      $review = [
      'product'   => $_POST['product'],
      'first_name' => $_POST['first_name'],
      'last_name'  => $_POST['last_name'],
      'email'      => $_POST['email'],
      'title'      =>  $_POST['title'],
      'description' => $_POST['description'],
      'rating'      => $_POST['rating']
    ];

      $human  = $_POST['message_human'];
      //php mailer variables
      $to = get_option('admin_email');
      $subject = "Someone sent a message from ".get_bloginfo('name');
      $headers = 'From: '. $review['email'] . "\r\n" .
                 'Reply-To: ' . $review['email'] . "\r\n";


      if (!$human == 0) {
          if ($human != 2) {
              my_contact_form_generate_response("error", $not_human);
              // echo '<script language="javascript">';
                 echo "<div class='error'>{$not_human}</div>";
                 // echo '</script>';
                 $humanerr = "inline";

          } //not human!
          else {

            //validate email
              if (!filter_var($review['email'], FILTER_VALIDATE_EMAIL)) {
                  my_contact_form_generate_response("error", $email_invalid);
                  echo "<div class='error'>{$email_invalid}</div>";

              } else { //email is valid
                  //validate presence of name and message
                  if (($review['rating']) < 1) {
                    my_contact_form_generate_response("error", $missing_content);
                         echo "<div class='error'> please rate this product </div>";
                  }
        if (empty($review['first_name'])) {
                      my_contact_form_generate_response("error", $missing_content);
                         echo "<div class='error'> $missing_content</div>";
                         $fnamerr = "inline";
                  }
        if (empty($review['last_name'])) {
                      my_contact_form_generate_response("error", $missing_content);
                         echo "<div class='error'> $missing_content</div>";
                         $lnamerr = "inline";
                  }
        if (empty($review['email'])) {
                      my_contact_form_generate_response("error", $missing_content);
                         echo "<div class='error'> $missing_content</div>";
                         $emailerror = "inline";
                  }
                  if (empty($review['description'])) {
                      my_contact_form_generate_response("error", $missing_content);
                         echo "<div class='error'> $missing_content</div>";
                         $descerr = "inline";
                  }
                  if (empty($review['title'])) {
                      my_contact_form_generate_response("error", $missing_content);
                         echo "<div class='error'> $missing_content</div>";
                         $titlerr = "inline";
                  }

                  else { //ready to go!
                      $sent = wp_mail($to, $subject, strip_tags($review['description']), $headers);
                      if ($sent) {
                          insertReview($review);
                          my_contact_form_generate_response("success", $message_sent);
                          echo "<div class='success'>{$message_sent}</div>";
                      } //message sent!
                      else {
                          my_contact_form_generate_response("error", $message_unsent);
                          echo "<div class='error'>{$message_unsent}</div>";
                      } //message wasn't sent
                  }
              }
          }
      } elseif ($_POST['submitted']) {
          my_contact_form_generate_response("error", $missing_content);
          echo '<script language="javascript">';
             echo 'alert("'.$missing_content.'")';
             echo '</script>';
      }
  }


  function insertReview($review)
  {
      global $wpdb;
      $wpdb->insert(
          $wpdb->prefix . 'reviews',
          $review
      );
  }
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<section class="review-compser" id="respond">
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1" height="1" viewBox="0 0 1 1" style="visibility: none;">
    <defs>
      <symbol id="icon-star" data-name="icon-star" viewBox="0 0 25 25"><polygon points="12.47 18.39 6.28 21.44 7.26 14.61 2.45 9.65 9.25 8.48 12.47 2.37 15.7 8.48 22.5 9.65 17.69 14.61 18.67 21.44 12.47 18.39"/></symbol>
      <!-- <symbol id="icon-star-half" data-name="icon-star-half" viewBox="0 0 25 25"><polygon points="12.47 18.39 6.28 21.44 7.26 14.61 2.45 9.65 9.25 8.48 12.47 2.37 15.7 8.48 22.5 9.65 17.69 14.61 18.67 21.44 12.47 18.39" style="fill: #646464;opacity: 0.38"/><path d="M12.47,2.37h0L9.25,8.48,2.45,9.65l4.81,5-1,6.83,6.19-3.05Z"/></symbol> -->
      <symbol id="icon-arrow" data-name="icon-arrow" viewBox="0 0 24 24"><polygon points="13.71 3.29 12.29 4.71 18.59 11 3 11 3 13 18.59 13 12.29 19.29 13.71 20.71 22.41 12 13.71 3.29"/></symbol>
    </defs>
  </svg>
  <?php echo $response; ?>
  <form action="<?php the_permalink(); ?>" method="post">

    <div class="stars-controller">
      <?php for ($i = 0; $i < 5; $i ++): ?>
        <span class="review-star-symbol" data-rating="<?php echo $i + 1; ?>"><svg width="36" height="36" viewBox="0 0 36 36"><use xlink:href="#icon-star"></use></svg></span>
      <?php endfor ?>
      <input type="hidden" name="rating" value="<?php echo esc_attr($_POST['rating']); ?>">
    </div>

    <div class="review-composer__select required">
      <label for="name">Product: </label>
      <select name="product" value="<?php echo $_POST['product']; ?>">
        <option value="Product">Product  </option>
      </select>
    </div>

    <div class="review-composer__name-group">
      <div class="review-composer__text-input required">
        <label for="first_name">First Name: <div style="color:blue; display:<?php echo $fnamerr; ?> ;" class="fname-error"> ERRRROR  </div> </label>
        <input type="text" name="first_name" value="<?php echo esc_attr($_POST['first_name']); ?>">
      </div>

      <div class="review-composer__text-input required">
        <label for="last_name">Last Name: <div style="color:blue; display:<?php echo $lnamerr; ?> ;" class="fname-error"> ERRRROR  </div></label>
        <input type="text" name="last_name" value="<?php echo esc_attr($_POST['last_name']); ?>">
      </div>
    </div>

    <div class="review-composer__text-input required">
      <label for="email">Email: <div style="color:blue; display:<?php echo $emailerror; ?> ;" class="fname-error"> ERRRROR  </div></label>
      <input type="text" name="email" value="<?php echo esc_attr($_POST['email']); ?>">
    </div>

    <div class="review-composer__text-input required">
      <label for="title">Review Title: <div style="color:blue; display:<?php echo $titlerr; ?> ;" class="fname-error"> ERRRROR  </div></label>
      <input type="text" name="title" value="<?php echo esc_attr($_POST['title']); ?>">
    </div>

    <div class="review-composer__text-input required">
      <label for="description">Review Content: <div style="color:blue; display:<?php echo $descerr; ?> ;" class="fname-error"> ERRRROR  </div></label>
      <textarea type="text" name="description"><?php echo esc_textarea($_POST['description']); ?></textarea>
    </div>

    <div class="review-composer__text-input required">
      <label for="message_human">Human Verification: <div style="color:blue; display:<?php echo $humanerr; ?> ;" class="fname-error"> ERRRROR  </div></div></label>
      <input type="text" style="width: 60px;" name="message_human"> + 3 = 5
    </div>

    <!-- <input type="hidden" name="submitted" value="1"> -->
    <input type="submit" name="submit">
  </form>
</section>
