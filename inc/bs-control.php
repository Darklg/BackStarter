<?php

if ( !defined( 'BS_PATH' ) ) {
    exit( 'Error' );
}

/* ----------------------------------------------------------
  Config
---------------------------------------------------------- */

if ( file_exists( BS_PATH . 'bs-config.php' ) ) {
    include BS_PATH . 'bs-config.php';
}

include BS_INC_DIR . 'bs-config.php';

/* ----------------------------------------------------------
  Models
---------------------------------------------------------- */

include BS_INC_DIR . 'classes/bs-mysql.php';
include BS_INC_DIR . 'classes/bs-user.php';
include BS_INC_DIR . 'classes/bs-page.php';

/* ----------------------------------------------------------
  Launch project
---------------------------------------------------------- */

/* Get wanted page
-------------------------- */

$m = $p = 'index';

if ( isset( $_GET['p'] ) ) {
    $p = '404';
    if ( $_GET['p'] != 'index' && preg_match( '/^([a-z0-9-_]+)$/', $_GET['p'] ) ) {
        $m = $p = $_GET['p'];
    }
}

/* Set Model
-------------------------- */

$model = false;
$model_path = BS_INC_DIR . 'models/'.$m.'.php';
if ( file_exists( $model_path ) ) {
    include $model_path;
}

/* Set Page Template
-------------------------- */

$page = new BS_Page( $p, $model );

$page->loadPage();
