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

    function __construct( $fields = array() ) {
        // Test fields
        $this->fields = $this->test_fields( $fields );
        // Create connection
        try {
            $this->connection = new PDO( 'mysql:host='. $this->fields['bs-dbhost'] .';dbname='.$this->fields['bs-dbname'] , $this->fields['bs-dbuser'], $this->fields['bs-dbpass'] );
        }
        catch( Exception $e ) {
            exit( "<strong>" ._( 'MySQL fails:' ). "</strong> " . $e->getMessage() );
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
        $res->setFetchMode( PDO::FETCH_ASSOC );
        $rows = array();
        while ( $row = $res->fetch() ) {
            $rows[] = $row;
        }
        $res->closeCursor();
        return $rows;
    }

    function select_where( $table_name, $params ) {
        $where = array();
        foreach ( $params as $key => $var ) {
            $this_var = $this->protect_field( $var );
            if ( $key == 'id' ) {
                $this_var = $var;
            }
            $where[] = $key . "=".$this_var;
        }
        $req = 'SELECT * FROM `'.$this->fields['bs-dbprefix'].$table_name.'`';
        $req .= ' WHERE ' . implode( ' AND ', $where );

        return $this->select( $req );
    }

    function insert( $table_name, $values = array() ) {
        $keys = array_keys( $values );
        $values = array_map( array( &$this, 'protect_field' ), $values );
        $req = 'INSERT INTO `'.$this->fields['bs-dbprefix'].$table_name.'`(`'.implode( '`,`', $keys ).'`) VALUES('.implode( ',', $values ).');';
        $insert = $this->query( $req );
        if ( $insert !== false ) {
            $insert = $this->connection->lastInsertId();
        }
        return $insert;
    }

    /* Utilities */

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

    function protect_field( $field ) {
        return $this->connection->quote( $field );
    }

    /* Test */
    function test_fields( $fields ) {
        $new_fields = array();
        foreach ( $this->default_fields as $id => $field ) {
            if ( isset( $fields[$id] ) ) {
                $new_fields[$id] = $fields[$id]['value'];
            }
            else {
                $new_fields[$id] = $field;
            }
        }
        return $new_fields;
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
