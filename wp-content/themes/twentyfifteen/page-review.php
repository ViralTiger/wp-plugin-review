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

          ?>

          <!-- Form -->
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">
              <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
              <?php the_content(); ?>

							<?php echo do_shortcode("[reviews]"); ?>

            </div><!-- .entry-content -->

          </article><!-- #post -->


          </div>
        <article>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
