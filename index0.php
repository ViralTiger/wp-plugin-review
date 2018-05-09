
<?php include 'head.php' ?>

<style media="screen">
  .repair-section p{
    margin-bottom: 1.5em;
    font-size: 1em;
  }
  span {
    text-align: center;
  }

  .repair-section img:first-child {
     margin: auto 0;
  }

  ul{
    text-align: center;
    padding-bottom: 3em;
  }

h3{
  margin-bottom: 1em;
}

</style>
<body class="product-body">
<div class="product-page">

 <?php include 'components/view-backstage.php' ?>
 <?php include 'header.php' ?>

 <div class="product">


  <section class="repair-section">

    <?php while ( have_posts() ) : the_post();?>
    <h1 style="text-align:center; margin-bottom:1em; font-size:2.8em;"><?php the_title(); ?></h1>
    <?php
           the_content();
      endwhile;
    ?>

  </section>
</div>
</div>

<div class="footer-filler"></div>

<?php get_footer(); ?>

</body>
