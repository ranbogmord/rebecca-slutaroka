<?php
    /*
        Detta är functions.php, den laddas in tillsammans med Temat.
        Här kan vi göra väldigt mycket genom att använda såkallade hooks, dessa används via funktionerna: add_action och add_filter.
        När wordpress får in ett request så kallar den på dessa och kör därigenom vår kod
     */
    

/* Detta gör att menyn i toppen som dyker upp för användare inte visas om man inte har administratörsrättigheter */
if (!current_user_can("manage_options")) {
    add_filter("show_admin_bar", "__return_false");
}

/*
    Denna action består av 2 delar.
    När vi skickar in formuläret för att skapa en användare så skickas den till admin-post.php, som i sin tur kallar på actionen "admin_post_{det-värde-vi-satte-i-hidden}".
    När den kallar på den actionen säger vi åt WP att köra funktionen som vi skickar in som andra parameter, "handle_signup_request"
    Om admin_post skall triggas från något annat ställe än på /wp-admin så behöver vi även lägga till "nopriv"
 */
add_action("admin_post_signup-user", "handle_signup_request");
add_action("admin_post_nopriv_signup-user", "handle_signup_request");
function handle_signup_request() 
{
    /* Här har vi tillgång till $_POST objektet */
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $verify_password = $_POST["verify-password"];
    $clean_since = $_POST["clean-since"];
    $smokes_per_day = $_POST["smokes-per-day"];
    $price_per_package = $_POST["price-per-package"];
    $motivation = $_POST["motivation"];

    /* Vi börjar med att verifiera lösenordet */
    if ($password !== $verify_password) {
        wp_die("Lösenorden stämmer inte överens"); // wp_die dödar scriptet och visar ett felmeddelande. Som die i php, fast snyggare.
    }
    
    /* Kommer vi hit var lösenordet okej och vi kan fortsätta */

    if (username_exists($username) || email_exists($email)) { // Vi kollar ifall användarnamnet eller epostaddressen redan finns
        wp_die("Användarnamnet eller epostaddressen är redan tagen"); // Döda scriptet och visa felmeddelandet
    }

    $user_id = wp_create_user($username, $password, $email); // Om allt var okej med användarnamn/lösen så kallar vi på funktionen för att skapa en användare i wordpress. Den returnerar användarens id om denne kan skapas
    if (is_wp_error($user_id)) { // Om något ändå gick fel så returnerar funktionen ett WP_Error
        wp_die($user_id->get_error_message()); // WP_Error har en metod för att hämta ut felmeddelandet, detta använder vi för att visa för användaren vad som gick fel
    }

    /* Annars gick det bra och vi har ett användar-id! 
       Nu sätter vi resten av fälten som metadata 
       Syntaxen är update_user_meta($user_id, $meta_nyckel, $meta_värde, $unik(boolean))

       Vi hade kunnat göra en add_user_meta, men update kollar om fältet redan finns och uppdaterar, finns det inte så skapas det.
    */

    update_user_meta($user_id, "clean_since", $clean_since, true); // Vi vill att alla metafält skall vara unika
    update_user_meta($user_id, "smokes_per_day", $smokes_per_day, true);
    update_user_meta($user_id, "price_per_package", $price_per_package, true);
    update_user_meta($user_id, "motivation", $motivation, true);

    // Hämta ut användarobjektet
    $user = get_userdata($user_id);

    // Sen loggar vi in användaren
    wp_signon(array(
        "user_login" => $user->user_login,
        "user_password" => $password
    ));

    /* Redirect till användarens profil */
    wp_redirect(get_site_url('/profile/?user=' . $user_id));
}



/* Nu bygger vi en liknande för login */
add_action("admin_post_login-user", "handle_user_login");
add_action("admin_post_nopriv_login-user", "handle_user_login");
function handle_user_login()
{
    /* Hämta postdata */
    $username = $_POST["username"];
    $password = $_POST["password"];

    /* Logga in användaren */
    $logged_in = wp_signon(array(
        "user_login" => $username,
        "user_password" => $password,
    ));

    /* Om användaren inte kan loggas in får vi ett WP_Error, detta meddelande skickar vi då tillbaka */
    if (is_wp_error($logged_in)) {
        wp_die($logged_in->get_error_message());
    }

    /* Annars går vi till användarens profil (logged_in är då en WP_User) */
    wp_redirect(site_url("/profile/?user=" . $logged_in->ID));
}
