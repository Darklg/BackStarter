<?php

class BS_Model_Dashboard extends BS_Model {
    function __construct() {
        $this->user = new BS_User( 'current' );
        if ( !$this->user->isLoggedIn() ) {
            bs_redirect( $this->getUrl( 'account/login' ) );
        }
    }

    function getUser() {
        return $this->user;
    }
}

$model = new BS_Model_Dashboard();
