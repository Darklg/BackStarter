<?php

class BS_Database {
    private $fields = array();
    public $connection;
    private $default_fields = array(
        'bs-dbhost' => BS_DBHOST,
        'bs-dbname' => BS_DBNAME,
        'bs-dbprefix' => BS_PREFIX,
        'bs-dbuser' => BS_DBUSER,
        'bs-dbpass' => BS_DBPASS
    );

    function __construct( $fields ) {
        // Test fields
        $this->fields = $this->test_fields( $fields );
        // Create connection
        try {
            $this->connection = new PDO( 'mysql:host='. $this->fields['bs-dbhost'] .';dbname='.$this->fields['bs-dbname'] , $this->fields['bs-dbuser'], $this->fields['bs-dbpass'] );
        }
        catch( Exception $e ) {
            exit( "<strong>MySQL fails :</strong> " . $e->getMessage() );
        }
    }

    function __destruct() {
        // Kill connection
        $this->connection = null;
    }

    /* Basic */

    function query( $req ) {
        return $this->connection->query( $req );
    }

    function select( $query ) {
        $res = $this->query( $query );
        $rows = array();
        foreach ( $res as $row ) {
            $rows[$row];
        }
        return $row;
    }

    function insert( $database, $values = array() ) {}

    function create_table( $table_name, $columns = array() ) {
        // Set values if empty
        if ( isset( $columns['id'] ) && empty( $columns['id'] ) ) {
            $columns['id'] = 'int(11) unsigned NOT NULL AUTO_INCREMENT';
        }
        // Set default values
        foreach ( $columns as $id => $value ) {
            if ( empty( $value ) ) {
                $columns[$id] = 'varchar(100) DEFAULT NULL';
            }
        }

        // Build query
        $query = "CREATE TABLE `".$this->fields['bs-dbprefix'].$table_name."` (";
        foreach ( $columns as $id => $value ) {
            $query .= "`".$id."` " . $value . ",";
        }
        $query .= "PRIMARY key( `id` ) ) CHARSET=utf8;";
        return $this->query( $query );
    }

    /* Test */
    function test_fields( $fields ) {
        foreach ( $this->default_fields as $id => $field ) {
            if ( !isset( $fields[$id] ) ) {
                $fields[$id] = $field;
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
