<?php

  function reviews_form()
  {
      require_once plugin_dir_path(__DIR__) . 'public/partials/reviews-public-display.php';
  }

  add_shortcode('reviews', 'reviews_form');
