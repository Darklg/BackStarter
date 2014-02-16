<?php

class BS_Database {
    private $fields = array();
    public $connection;
    private $default_fields = array(
        'bs-dbhost' => '',
        'bs-dbname' => '',
        'bs-dbprefix' => '',
        'bs-dbuser' => '',
        'bs-dbpass' => ''
    );

    function __construct( $fields ) {
        // Test fields
        $this->fields = $this->test_fields( $fields );
        // Create connection
        try {
            $this->connection = new PDO( 'mysql:host='. $this->fields['bs-dbhost'] .';dbname='.$this->fields['bs-dbname'] , $this->fields['bs-dbuser'], $this->fields['bs-dbpass'] );
        }
        catch( Exception $e ) {
            die( "MySQL fails : " );
        }
    }

    function __destruct() {
        // Kill connection
        $this->connection = null;
    }

    /* Basic */

    function query( $req ) {
        $res = $this->connection->query( $req );
        return $res;
    }

    /* Test */
    function test_fields( $fields ) {
        foreach ( $this->default_fields as $id => $field ) {
            if ( !isset( $fields[$id] ) ) {
                $fields[$id] = '';
            }
        }
        return $fields;
    }

    function test_install() {
        $test_table = $this->fields['bs-dbprefix'] . 'options';

        $db = $this->connection;
        $req = $db->prepare( "SHOW TABLES LIKE :db" );
        $req->execute( array( 'db' => $test_table ) );
        $results = $req->fetch( PDO::FETCH_BOTH );
        return isset( $results[0] ) && $results[0] == $test_table;
    }
}
