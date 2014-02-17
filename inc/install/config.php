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
        <div class="box"><label for="bs-adminemail">Admin email :</label><input required name="bs-adminemail" id="bs-adminemail" type="email" value="admin" /></div>
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
    'bs-adminemail' => '',
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

    // Test install
    $db = new BS_Database( $dbfields );

    // Create config file
    $currentpageurl = getCurrentPageURL();
    define( 'BS_BASEURL', $currentpageurl );

    $filecontent = file_get_contents( BS_PATH . 'bs-default-config.php' );
    $filecontent .= "
/* Base URL */
define( 'BS_BASEURL', '".$currentpageurl."' );

/* Database */
define( 'BS_DBHOST', '".$dbfields['bs-dbhost']."' );
define( 'BS_DBNAME', '".$dbfields['bs-dbname']."' );
define( 'BS_DBUSER', '".$dbfields['bs-dbuser']."' );
define( 'BS_DBPASS', '".$dbfields['bs-dbpass']."' );
define( 'BS_PREFIX', '".$dbfields['bs-dbprefix']."' );
";
    file_put_contents( BS_PATH . 'bs-config.php', $filecontent );


    if ( $db->test_install() ) {
        // Redirect to home
        bs_redirect();
        return;
    }

    // Create tables
    // - Users
    $db->create_table( 'user', array(
            'id' => '',
            'email' => '',
            'password' => '',
            'level' => 'int(11) unsigned NOT NULL',
        ) ) ;

    // - Options
    $db->create_table( 'options', array(
            'id' => '',
            'name' => '',
            'value' => 'text'
        ) ) ;

    // Create admin
    $user = new BS_User();
    $new_user = $user->create( $db, array(
            'email' => $dbfields['bs-adminemail'],
            'password' => $dbfields['bs-adminpass'],
        ) );

    if ( is_numeric( $new_user ) ) {
        // Redirect to home
        bs_redirect();
    }
    else {
        $content = 'Admin user couldn’t be created :(';
    }

}
