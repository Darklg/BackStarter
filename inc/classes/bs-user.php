<?php

class BS_User {
    private $user_details = array(
        'id' => 0,
        'email' => 'anon@nymous.org',
        'password' => 'password',
        'name' => 'Anonymous',
        'level' => 0,
        'logged_in' => 0
    );

    public $dbfields = array();

    public function __construct( $mode = '' ) {
        $this->dbfields = array(
            'name' => array( 'name' => _( 'User name' ), 'value' => '', 'test' => array( 'required', 'minlength:6' ) ),
            'email' => array( 'name' => _( 'User email' ), 'value' => '', 'test' => array( 'required', 'email' ) ),
            'password' => array( 'name' => _( 'User password' ), 'value' => '', 'test' => array( 'required', 'minlength:6' ) ),
        );
        switch ( $mode ) {
        case 'current':
            // Try to load from session
            if ( isset( $_SESSION['bs_user'] ) && !empty( $_SESSION['bs_user'] ) ) {
                $this->user_details = $_SESSION['bs_user'];
            }
            return $this->user_details;
            break;
        }
        return false;
    }

    public function create( $db = false, $user_details = array() ) {
        $values = array();

        if ( $db === false ) {
            return;
        }

        $errors = array();

        // Test values
        $test_email = $this->invalidValue( 'email', $user_details );
        if ( $test_email !== true ) {
            $errors[] = $test_email;
        }
        else {
            $values['email'] = $user_details['email'];
        }

        // Test password
        $test_password = $this->invalidValue( 'password', $user_details );
        if ( $test_password !== true ) {
            $errors[] = $test_password;
        }
        else {
            $values['password'] = $this->hashPassword( $user_details['password'] );
        }

        // Clean name
        $user_details['name'] = strip_tags( $user_details['name'] );
        // Test name
        $test_name = $this->invalidValue( 'name', $user_details );
        if ( $test_name !== true ) {
            $errors[] = $test_name;
        }
        else {
            $values['name'] = $user_details['name'];
        }

        $values['key'] = md5( $values['email'].microtime( 1 ).$values['password'] );
        $values['api_key'] = md5( microtime( 1 ).$values['password'].$values['email'] );

        if ( !empty( $errors ) ) {
            return $errors;
        }
        else {
            $user_exists = $this->get_user_by( $db, array(
                    'email' => $values['email']
                ) );
            // Create user
            if ( empty( $user_exists ) ) {
                return $db->insert( 'user', $values );
            }
            else {
                return array( _( 'This user already exists' ) );
            }
        }
    }

    private function get_user_by( $db = false, $details = array() ) {
        if ( $db === false ) {
            return;
        }
        foreach ( $details as $id => $var ) {
            if ( $id == 'password' ) {
                $details[$id] = $this->hashPassword( $var );
            }
        }
        return $db->select_where( 'user', $details );
    }

    public function connect( $db, $details ) {
        $user = $this->get_user_by( $db, $details );
        if ( empty( $user ) ) {
            return false;
        }
        return $this->login( $user[0] );
    }

    public function disconnect() {
        $_SESSION['bs_user'] = array();
    }

    private function login( $user ) {
        $user['logged_in'] = 1;
        $_SESSION['bs_user'] = $user;
        $this->user_details = $user;
        return true;
    }


    private function invalidValue( $id, $user_details ) {
        $test = true;
        switch ( $id ) {
        case 'email':
            if ( !isset( $user_details['email'] ) || filter_var( $user_details['email'], FILTER_VALIDATE_EMAIL ) === false ) {
                return _( 'Email address is invalid' );
            }
            break;
        case 'name':
            if ( !isset( $user_details['name'] ) || empty( $user_details['name'] ) ) {
                return _( 'Name is invalid' );
            }
            break;
        case 'password':
            if ( !isset( $user_details['password'] ) || empty( $user_details['password'] ) || strlen( $user_details['password'] ) < 6 ) {
                return _( 'Password is invalid' );
            }
            break;
        }

        return $test;
    }

    private function hashPassword( $password ) {
        // _todo: improve this <3
        $hash = md5( '?salt?' . $password );
        return $hash;
    }

    // Getters
    public function getAvatar( $size = 32 ) {
        $size = is_numeric( $size ) ? $size : 32;
        $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->user_details['email'] ) ) ) . "?s=" . $size;
        return $grav_url;
    }
    public function getEmail() {
        return $this->user_details['email'];
    }
    public function getName() {
        return $this->user_details['name'];
    }
    public function getID() {
        return $this->user_details['id'];
    }
    public function getLevel() {
        return $this->user_details['level'];
    }
    public function isLoggedIn() {
        return $this->user_details['logged_in'];
    }
}
