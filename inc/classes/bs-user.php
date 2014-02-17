<?php

class BS_User {
    private $user_details = array(
        'id' => 0,
        'name' => 'Anon',
        'email' => 'anon@nymous.org',
        'password' => 'password',
        'level' => 0,
    );

    public function __construct( $user_details = false ) {
        if ( is_array( $user_details ) ) {
            return $this->load( $user_details );
        }
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


        if ( !empty( $errors ) ) {
            return $errors;
        }
        else {
            $user_exists = $db->select_where( 'user', array(
                    'email' => $values['email']
                ) );
            // Create user
            if ( empty( $user_exists ) ) {
                return $db->insert( 'user', $values );
            }
            else {
                return 'This user already exists';
            }
        }
    }

    public function load( $user_details = array() ) {

    }

    public function validateDetails( $user_details = array() ) {

    }

    public function invalidValue( $id, $user_details ) {
        $test = true;
        switch ( $id ) {
        case 'email':
            if ( !isset( $user_details['email'] ) || filter_var( $user_details['email'], FILTER_VALIDATE_EMAIL ) === false ) {
                return 'Email address is invalid';
            }
            break;
        case 'password':
            if ( !isset( $user_details['password'] ) || empty( $user_details['password'] ) || strlen( $user_details['password'] ) < 6 ) {
                return 'Password is invalid';
            }
            break;
        }

        return $test;
    }

    public function hashPassword( $password ) {
        // _todo: improve this <3
        $hash = md5( '?salt?' . $password );
        return $hash;
    }
}
