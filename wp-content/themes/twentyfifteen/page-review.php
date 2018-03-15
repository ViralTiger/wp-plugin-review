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
            <div id="respond">
              <?php echo $response; ?>
              <form action="<?php the_permalink(); ?>" method="post">
                <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>"></label></p>
                <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>"></label></p>
                <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea></label></p>
                <p><label for="message_human">Human Verification: <span>*</span> <br><input type="text" style="width: 60px;" name="message_human"> + 3 = 5</label></p>
                <input type="hidden" name="submitted" value="1">
                <p><input type="submit"></p>
              </form>
            </div>
          </div>
        <article>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
