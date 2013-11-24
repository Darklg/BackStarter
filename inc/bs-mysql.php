<?php

class BS_Database {
    function __construct() {
        // Create connection
        try {
            $this->connection = new PDO( 'mysql:host=' . BS_DBHOST . ';dbname=' . BS_DBNAME, BS_DBUSER, BS_DBPASS );
        }
        catch ( Exception $e ) {
            die( 'Error : ' . $e->getMessage() );
        }
    }

    function __destruct() {
        // Kill connection
        $this->connection = null;
    }
}
