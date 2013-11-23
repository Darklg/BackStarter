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

include BS_PATH . 'inc/bs-page.php';

/* ----------------------------------------------------------
  Launch project
---------------------------------------------------------- */

$page = new BS_Page();

$page->loadPage();
