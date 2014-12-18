<?php get_header(); // Inkludera header.php ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> <!-- WP loopen -->
<!-- post -->
    <h1><?php the_title(); ?></h1>
    <div class="content"><?php the_content(); ?></div>
<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); // Inkludera footer.php ?>