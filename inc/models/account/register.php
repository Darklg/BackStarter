<?php

class BS_Model_Register extends BS_Model {
    public $dbfields = array();

    function __construct() {
        // Test current user
        $this->user = new BS_User( 'current' );
        if ( $this->user->isLoggedIn() ) {
            bs_redirect( $this->getUrl( 'account/dashboard' ) );
        }
        // Set dbfields from user model
        $this->dbfields = $this->user->dbfields;
        // Set action after post
        $this->postAction();
    }

    private function postAction() {
        if ( empty( $_POST ) ) {
            return;
        }

        $this->dbfields = $this->set_fields_from( $this->dbfields, $_POST );
        $test_fields = $this->test_fields( $this->dbfields );

        // Invalid fields
        if ( !empty( $test_fields ) ) {
            $this->add_messages( $test_fields );
            return;
        }

        // Try to create user
        $db = new BS_Database( );

        $new_user = $this->user->create( $db, array(
                'name' => $this->dbfields['name']['value'],
                'email' => $this->dbfields['email']['value'],
                'password' => $this->dbfields['password']['value'],
            ) );

        // If creation ok
        if ( is_numeric( $new_user ) ) {
            $connect = $this->user->connect( $db, array(
                    'id' => $new_user
                ) );
            $_SESSION['welcome'] = 1;
            bs_redirect( $this->getUrl( 'account/dashboard' ) );
        }
        else {
            $this->add_messages( $new_user );
        }

        return false;
    }
}

$model = new BS_Model_Register();
