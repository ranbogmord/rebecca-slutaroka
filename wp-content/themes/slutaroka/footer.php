    <?php if (is_user_logged_in()) : ?>
        <a href="<?php echo wp_logout_url(site_url('/login')); ?>">Logga ut</a>
    <?php endif; ?>
    </div> <!-- Avslutar #main i header.php -->
    <!-- wp_footer för att ladda in javascript genom wp -->
    <?php wp_footer(); ?>
</body>
</html>