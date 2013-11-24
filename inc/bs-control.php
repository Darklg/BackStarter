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

include BS_PATH . 'inc/bs-config.php';

/* ----------------------------------------------------------
  Includes
---------------------------------------------------------- */

include BS_PATH . 'inc/bs-mysql.php';
include BS_PATH . 'inc/bs-page.php';

/* ----------------------------------------------------------
  Launch project
---------------------------------------------------------- */

/* Get wanted page
-------------------------- */

$p = 'index';

if ( isset( $_GET['p'] ) ) {
    $p = '404';
    if ( $_GET['p'] != 'index' && preg_match( '/^([a-z0-9-_]+)$/', $_GET['p'] ) ) {
        $p = $_GET['p'];
    }
}

/* Set Page
-------------------------- */

$page = new BS_Page( $p );

$page->loadPage();
