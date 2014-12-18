<?php 
    /*
        Template Name: Login
     */
    
    /* Om användaren redan är inloggad kan vi skicka dom till sin profil */
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        wp_redirect(site_url('/profile?user=' . $user_id));
    }

    get_header();
?>

<h1>Logga in</h1>
<form action="<?php echo get_admin_url(); ?>/admin-post.php" method="post"> <!-- Se signup-user.php för förklaringar ang. formulär -->
    <input type="hidden" name="action" value="login-user">
    Användarnamn: <input type="text" name="username"> <br>
    Lösenord: <input type="password" name="password"> <br>
    <input type="submit" value="Logga in"> <a href="<?php echo site_url('/signup'); ?>">Bli medlem</a>
</form>

<?php get_footer(); ?>