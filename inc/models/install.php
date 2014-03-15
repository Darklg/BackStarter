<?php

class BS_Model_Install extends BS_Model {
    public $dbfields = array(
        'bs-name' => array( 'name' => 'Site name', 'value' => '', 'test' => array( 'required' ) ),
        'bs-adminemail' => array( 'name' => 'Admin email', 'value' => '', 'test' => array( 'required', 'email' ) ),
        'bs-adminpass' => array( 'name' => 'Admin password', 'value' => '', 'test' => array( 'required', 'minlength:6' ) ),
        'bs-dbhost' => array( 'name' => 'DB: Host', 'value' => '', 'test' => array( 'required' ) ),
        'bs-dbname' => array( 'name' => 'DB: Name', 'value' => '', 'test' => array( 'required' ) ),
        'bs-dbuser' => array( 'name' => 'DB: User', 'value' => '', 'test' => array( 'required' ) ),
        'bs-dbpass' => array( 'name' => 'DB: Pass', 'value' => '', 'test' => array( 'required' ) ),
        'bs-dbprefix' => array( 'name' => 'DB: Prefix', 'value' => '', 'test' => array( 'required' ) )
    );

    function __construct() {

        if ( !empty( $_POST ) && isset( $_POST['bs-dbhost'] ) ) {

            $this->base_url = getCurrentPageURL();

            // Search for values
            $this->dbfields = $this->set_fields_from( $this->dbfields, $_POST );

            $test_fields = $this->test_fields( $this->dbfields );

            if ( !empty( $test_fields ) ) {
                $this->add_messages( $test_fields );
                return;
            }

            // Test install
            try {
                $db = new BS_Database( $this->dbfields );
            }
            catch( Exception $e ) {
                $this->add_messages( $e->getMessage() );
                return;
            }

            $this->set_config_file();

            if ( $db->test_install() ) {
                // Redirect to home
                bs_redirect( $this->base_url );
                return;
            }

            $this->set_htaccess( );

            $this->set_sql_tables( $db );

            $this->create_admin_user( $db );
        }

    }

    private function set_config_file() {
        // Create config file
        $filecontent = file_get_contents( BS_PATH . 'bs-default-config.php' );
        $filecontent .= "
/* Base URL */
define( 'BS_BASEURL', '".$this->base_url."' );

/* Database */
define( 'BS_DBHOST', '".$this->dbfields['bs-dbhost']['value']."' );
define( 'BS_DBNAME', '".$this->dbfields['bs-dbname']['value']."' );
define( 'BS_DBUSER', '".$this->dbfields['bs-dbuser']['value']."' );
define( 'BS_DBPASS', '".$this->dbfields['bs-dbpass']['value']."' );
define( 'BS_PREFIX', '".$this->dbfields['bs-dbprefix']['value']."' );
";
        file_put_contents( BS_PATH . 'bs-config.php', $filecontent );
    }

    private function set_sql_tables( $db ) {
        // Create tables
        // - Users
        $db->create_table( 'user', array(
                'id' => '',
                'email' => '',
                'password' => '',
                'level' => 'int(11) unsigned NOT NULL',
                'api_key' => '',
                'key' => '',
            ) ) ;

        // - Options
        $db->create_table( 'options', array(
                'id' => '',
                'name' => '',
                'value' => 'text'
            ) ) ;
    }

    private function set_htaccess( $value='' ) {
        $htaccess_file = BS_PATH . '.htaccess';
        $htaccess_content = '<IfModule mod_rewrite.c>
    Options +FollowSymlinks
    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^([a-z]{2})\/$ ?lang=$1 [L]
    RewriteRule ^([a-z]{2})\/([a-z0-9-_\/]+)\.html$ ?lang=$1&p=$2 [L]
    RewriteRule ^([a-z0-9-_\/]+)\.html$ ?p=$1 [L]
</IfModule>';
        if ( !file_exists( $htaccess_file ) ) {
            file_put_contents( $htaccess_file, $htaccess_content );
        }
    }

    private function create_admin_user( $db ) {
        // Create admin
        $user = new BS_User();
        $new_user = $user->create( $db, array(
                'email' => $this->dbfields['bs-adminemail']['value'],
                'name' => 'Admin',
                'password' => $this->dbfields['bs-adminpass']['value'],
            ) );

        if ( is_numeric( $new_user ) ) {
            // Redirect to home
            bs_redirect( $this->base_url );
        }
        else {
            $this->add_messages( 'Admin user couldn\'t be created :(' );
        }
    }
}

$model = new BS_Model_Install();
