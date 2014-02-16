<?php

$errors = array();
include BS_INC_DIR . 'install/config.php';
if ( empty( $errors ) ) {
    include BS_INC_DIR . 'install/user.php';
}

// Display admin form
// - Si ok
// -- Creer user admin

$error_content = '';
if ( !empty( $errors ) ) {
    $error_content = '<p><strong>Error:</strong><br />'.implode( '<br/>', $errors ).'</p>';
}

?>
<!DOCTYPE HTML>
<html lang="en-EN">
    <head>
    <meta charset="UTF-8" />
    <title>BackStarter Install</title>
    </head>
    <body>
        <h1>BackStarter Install</h1>
        <?php echo $error_content . $content; ?>
    </body>
</html>
