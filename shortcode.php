<?php 
function custom_password_shortcode($atts, $content = null) {
    // Extract attributes
    extract(shortcode_atts(array(
        'password_field' => 'custom_password',
    ), $atts));

    // Check if the password has been submitted
    // I am using Metabox.io for custom fields - if you are not then replace "rwmb_meta('')" with your custom field accessor
    if(isset($_POST['custom_password_submit'])) {
        if(isset(rwmb_meta('password-protected')) && sanitize_text_field($_POST['custom_password']) === rwmb_meta('password-protected')) {
            // Correct password entered, set a session variable
            session_start();
            $_SESSION['custom_password_' . get_the_ID()] = true;
        }
    }

    session_start();
    if((isset($_SESSION['custom_password_' . get_the_ID()]) && $_SESSION['custom_password_' . get_the_ID()] === true) || rwmb_meta('password-protected') == '') {
        // If password custom field empty or correct password is entered, display the content
        return do_shortcode($content);
    } else {
        // Display password form
        return '
            <div class="password-protected-wrapper"><h2>Password Required</h2>
            <form action="' . get_permalink() . '" method="post">
                    <input type="password" name="custom_password" />
                    <input type="submit" name="custom_password_submit" value="Enter" />
                </form></div>';
    }
}

add_shortcode('custom_protected', 'custom_password_shortcode');


?>
