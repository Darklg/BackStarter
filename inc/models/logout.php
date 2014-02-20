<?php

class BS_Model_Logout extends BS_Model {
    function __construct() {
        $this->user = new BS_User( 'current' );
        $this->user->disconnect();
        if ( $this->user->isLoggedIn() ) {
            bs_redirect( $this->after_login );
        }
    }
}

$model = new BS_Model_Logout();
