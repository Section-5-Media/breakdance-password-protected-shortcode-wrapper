<?php
function custom_password_shortcode($atts, $content = null) {
    // Extract attributes
    extract(shortcode_atts(array(
        'password_field' => 'custom_password',
    ), $atts));

    // Start the session
    session_start();

    // Fetch the password from the custom field using MetaBox.io or another method
    $stored_password = rwmb_meta('password-protected');

    // Check if the password has been submitted via POST or exists in the URL as a parameter
    $input_password = '';
    if (isset($_POST['custom_password_submit'])) {
        $input_password = sanitize_text_field($_POST['custom_password']);
    } elseif (isset($_GET['password'])) {
        $input_password = sanitize_text_field($_GET['password']);
    }

    // If the correct password is entered or provided via the URL, set the session variable
    if ($input_password && $input_password === $stored_password) {
        $_SESSION['custom_password_' . get_the_ID()] = true;
    }

    // Check if the session variable is set, or if the password field is empty (no protection)
    if ((isset($_SESSION['custom_password_' . get_the_ID()]) && $_SESSION['custom_password_' . get_the_ID()] === true) || $stored_password == '') {
        // If the password field is empty or the correct password is entered, display the content
        return do_shortcode($content);
    } else {
        // Display the password form if the password is incorrect or not yet entered
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
