<?php

/* ----------------------------------------------------------
  Get Current Page URL
---------------------------------------------------------- */

function getCurrentPageURL() {
    // Get Base URL
    $pageURL = 'http';
    if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
        $pageURL .= 's';
    }
    $pageURL .= '://';
    $pageURL .= $_SERVER['SERVER_NAME'];
    if ( $_SERVER['SERVER_PORT'] != '80' ) {
        $pageURL .= ':'.$_SERVER['SERVER_PORT'];
    }
    $baseURL = $pageURL;

    // Get URI details
    $pageURL .= $_SERVER['REQUEST_URI'];

    // Retrieve only path
    $details = parse_url( $pageURL );
    if ( $path = $details['path'] ) {
        $baseURL .= $path;
    }

    return $baseURL;
}

/* ----------------------------------------------------------
  Redirect to
---------------------------------------------------------- */

function bs_redirect( $url = '', $code = 302 ) {
    if ( empty( $url ) ) {
        $url = BS_BASEURL . $url;
    }
    switch ( $code ) {
    case 302:
        break;
    case 301:
        header( "HTTP/1.1 301 Moved Permanently" );
        break;
    }
    header( "Location: " . $url );
    exit();
}
