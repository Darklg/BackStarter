<?php

/* ----------------------------------------------------------
  Template
---------------------------------------------------------- */

$content = '
<form action="?step=config" method="post">
    <fieldset class="cssc-form">
        <div class="box"><label for="bs-name">Site Name :</label><input required name="bs-name" id="bs-name" type="text" value="Back Starter" /></div>
    </fieldset>
    <fieldset class="cssc-form">
        <div class="box"><label for="bs-admin">Admin :</label><input required name="bs-admin" id="bs-admin" type="text" value="admin" /></div>
        <div class="box"><label for="bs-adminpass">Pass :</label><input required name="bs-adminpass" id="bs-adminpass" type="password" value="pass" /></div>
    </fieldset>
    <fieldset class="cssc-form">
        <div class="box"><label for="bs-dbhost">Host :</label><input required name="bs-dbhost" id="bs-dbhost" type="text" value="localhost" /></div>
        <div class="box"><label for="bs-dbname">Name :</label><input required name="bs-dbname" id="bs-dbname" type="text" /></div>
        <div class="box"><label for="bs-dbuser">User :</label><input required name="bs-dbuser" id="bs-dbuser" type="text" /></div>
        <div class="box"><label for="bs-dbpass">Pass :</label><input required name="bs-dbpass" id="bs-dbpass" type="text" /></div>
        <div class="box"><label for="bs-dbprefix">Prefix :</label><input required name="bs-dbprefix" id="bs-dbprefix" type="text" value="bs_" /></div>
    </fieldset>
    <div>
        <button class="cssc-button" type="submit">Submit</button>
    </div>
</form>
';

/* ----------------------------------------------------------
  App
---------------------------------------------------------- */

$dbfields = array(
    'bs-name' => '',
    'bs-admin' => '',
    'bs-adminpass' => '',
    'bs-dbhost' => '',
    'bs-dbname' => '',
    'bs-dbuser' => '',
    'bs-dbpass' => '',
    'bs-dbprefix' => ''
);

if ( !empty( $_POST ) && isset( $_POST['bs-dbhost'] ) ) {
    // Search for  values
    $fields = true;
    foreach ( $dbfields as $id => $value ) {
        if ( !isset( $_POST[$id] ) || empty( $_POST[$id] ) ) {
            $errors[] = 'The field <em>' . $id . '</em> is empty';
            $fields = false;
        }
        else {
            $dbfields[$id] = $_POST[$id];
        }
    }
    if ( !$fields ) {
        return;
    }

    // Create config file
    $filecontent = file_get_contents( BS_PATH . 'bs-default-config.php' );

    $filecontent .= "
/* Database */
define( 'BS_DBHOST', '".$dbfields['bs-dbhost']."' );
define( 'BS_DBNAME', '".$dbfields['bs-dbname']."' );
define( 'BS_DBUSER', '".$dbfields['bs-dbuser']."' );
define( 'BS_DBPASS', '".$dbfields['bs-dbpass']."' );
define( 'BS_PREFIX', '".$dbfields['bs-dbprefix']."' );
";


    file_put_contents( BS_PATH . 'bs-config.php', $filecontent );

    // Test install
    $db = new BS_Database( $dbfields );
    if ( $db->test_install() ) {
        // Redirect to home
        return;
    }

    // Create tables
    // - Users
    // - Options

}
