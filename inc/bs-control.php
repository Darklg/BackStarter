<?php

session_start();

if ( !defined( 'BS_PATH' ) ) {
    exit( 'Error' );
}

/* ----------------------------------------------------------
  Models
---------------------------------------------------------- */

include BS_INC_DIR . 'functions.php';
include BS_INC_DIR . 'classes/bs-model.php';
include BS_INC_DIR . 'classes/bs-database.php';
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
    if ( !in_array( $_GET['p'], array( 'index', 'install' ) ) && preg_match( '/^([a-z0-9-_\/]+)$/', $_GET['p'] ) ) {
        $m = $p = $_GET['p'];
    }
}

/* ----------------------------------------------------------
  Config
---------------------------------------------------------- */

if ( file_exists( BS_PATH . 'bs-config.php' ) ) {
    include BS_PATH . 'bs-config.php';
}
else {
    $p = $m = 'install';
}

include BS_INC_DIR . 'bs-config.php';

/* Set Model
-------------------------- */

$model = false;
$model_path = BS_INC_DIR . 'models/'.$m.'.php';
if ( !file_exists( $model_path ) ) {
    $p = $m = '404';
    $model_path = BS_INC_DIR . 'models/404.php';
}

include $model_path;


/* Set Page Template
-------------------------- */

$page = new BS_Page( $p, $model );

$page->loadPage();
