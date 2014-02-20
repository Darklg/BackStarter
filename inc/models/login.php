<?php

class BS_Model_Login extends BS_Model {
    public $dbfields = array(
        'email' => array( 'name' => 'User email', 'value' => '', 'test' => array( 'required', 'email' ) ),
        'password' => array( 'name' => 'User password', 'value' => '', 'test' => array( 'required', 'minlength:6' ) ),
    );

    private $after_login = '';

    function __construct() {
        $this->user = new BS_User( 'current' );
        if ( $this->user->isLoggedIn() ) {
            bs_redirect( $this->after_login );
        }
        $this->postAction();
    }

    private function postAction() {
        if ( empty( $_POST ) ) {
            return;
        }

        $this->dbfields = $this->set_fields_from( $this->dbfields, $_POST );
        $test_fields = $this->test_fields( $this->dbfields );

        if ( !empty( $test_fields ) ) {
            $this->add_messages( $test_fields );
            return;
        }

        $db = new BS_Database( );

        $connect = $this->user->connect( $db, array(
                'email' => $this->dbfields['email']['value'],
                'password' => $this->dbfields['password']['value'],
            ) );

        if ( $connect ) {
            bs_redirect( $this->after_login );
            die;
        }
        else {
            $this->add_messages( 'Invalid username or password.' );
        }
        return false;
    }
}

$model = new BS_Model_Login();
