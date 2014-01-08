<?php

/* ----------------------------------------------------------
  In-use constants
---------------------------------------------------------- */

$constants = array(
    /* Default lang */
    'BS_LANG' => 'en_EN',
    /* Default Site Name */
    'BS_NAME' => 'BackStarter',
    /* MySQL */
    'BS_DBHOST' => '',
    'BS_DBNAME' => '',
    'BS_DBUSER' => '',
    'BS_DBPASS' => '',
    'BS_PREFIX' => '',
);

/* ----------------------------------------------------------
  Define constants if they dont exists
---------------------------------------------------------- */

foreach ( $constants as $id => $value ) {
    if ( !defined( $id ) ) {
        define( $id, $value );
    }
}
