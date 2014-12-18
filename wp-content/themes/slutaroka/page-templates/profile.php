<?php 
    /*
        Template Name: Profile
     */
    /* Om man inte är inloggad blir man skickad till loginformuläret */
    if (!is_user_logged_in()) {
        wp_redirect(site_url('/login'));
    }

    /* Om user id saknas så redirectar vi till den inloggade användarens profil */
    if (empty($_GET["user"])) {
        $user_id = get_current_user_id(); // Hämta ut den nuvarande användaren
        wp_redirect(site_url("/profile?user=" . $user_id));
    } else {
        $user_id = intval($_GET["user"]);
    }


    /* Hämta ut metadatan */
    $userdata = get_userdata($user_id);
    $username = $userdata->user_login;
    $clean_since = get_user_meta($user_id, "clean_since", true); // True för att hämta ut ett fält, annars ges det som en array
    $smokes_per_day = get_user_meta($user_id, "smokes_per_day", true);
    $price_per_package = get_user_meta($user_id, "price_per_package", true);
    $motivation = get_user_meta($user_id, "motivation", true);

    get_header();
?>
<h1>Profil</h1>
<!-- Visa alla fält -->
<h2><?php echo $username; ?></h2>
Rökfri sedan: <?php echo $clean_since; ?> <br>
Cigg per dag: <?php echo $smokes_per_day; ?> <br>
Pris per paket: <?php echo $price_per_package; ?> <br>
Motivation: <?php echo $motivation; ?> <br>

<?php get_footer(); ?>
