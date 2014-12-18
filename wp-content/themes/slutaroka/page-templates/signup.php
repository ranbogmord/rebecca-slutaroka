<?php
    /*
        Template Name: User Signup

        Denna templaten kommer endast innehålla signup-rutan
     */
    
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        wp_redirect(site_url("/profile?user=" . $user_id));
    }
    
    get_header();
?>
<h1>Bli medlem</h1>
<div class="signup-form">
    <form action="<?php echo get_admin_url() ?>/admin-post.php" method="post"> <!-- Action går till WPs inbyggda hanterare för post-requests -->
        <input type="hidden" name="action" value="signup-user"><!-- Denna använder vi för att säga åt vilken funktion WP ska kalla på när formuläret skickas -->

        <!-- Helt vanlig formulär -->
        Namn: <input type="text" name="username" placeholder="username"> <br>
        Epost: <input type="email" name="email" placeholder="you@example.com"> <br>
        Lösenord: <input type="password" name="password" placeholder="********"> <br>
        Verifiera lösenord: <input type="password" name="verify-password" placeholder="********"> <br>
        Rökfri sedan? <input type="date" name="clean-since"> <br>
        Cigaretter per dag: <input type="number" name="smokes-per-day" placeholder="tex. 15"> <br>
        Pris per paket: <input type="number" placeholder="tex. 45" name="price-per-package"> <br>
        Största motivation: <input type="text" name="motivation" placeholder="Text"> <br>

        <input type="submit" value="Skapa Konto">
    </form>
</div>

<?php get_footer(); ?>