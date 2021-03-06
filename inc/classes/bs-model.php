<?php

class BS_Model {

    function __construct() {
        $this->messages = array();
    }

    /* Fields */

    function set_fields_from( $dbfields, $post ) {
        foreach ( $dbfields as $id => $value ) {
            if ( isset( $post[$id] ) ) {
                $dbfields[$id]['value'] = trim( $post[$id] );
            }
        }
        return $dbfields;
    }

    function test_fields( &$dbfields ) {
        $errors = array();
        foreach ( $dbfields as $id => $field ) {
            if ( isset( $field['test'], $field['value'], $field['name'] ) && is_array( $field['test'] ) ) {
                foreach ( $field['test'] as $test ) {
                    $field_ok = true;
                    switch ( $test ) {
                    case 'required':
                        if ( empty( $field['value'] ) ) {
                            $field_ok = false;
                            $errors[] = sprintf( _( 'The field "%s" should not be empty' ), $field['name'] );
                        }
                        break;
                    case 'minlength:6':
                        if ( strlen( $field['value'] ) < 6 ) {
                            $field_ok = false;
                            $errors[] = sprintf( _( 'The field "%s" should be at least 6 characters long' ), $field['name'] );
                        }
                        break;
                    case 'email':
                        if ( filter_var( $field['value'], FILTER_VALIDATE_EMAIL ) === false ) {
                            $field_ok = false;
                            $errors[] = sprintf( _( 'The field "%s" should be an email' ), $field['name'] );
                        }
                        break;
                    }
                    if ( !$field_ok ) {
                        $dbfields[$id]['value'] = '';
                    }
                }
            }
        }
        return $errors;
    }

    function getFieldValue( $id ) {
        if ( isset( $this->dbfields[$id]['value'] ) ) {
            return htmlentities( $this->dbfields[$id]['value'] );
        }
        return '';
    }

    /* Messages */

    function add_messages( $messages ) {
        if ( !isset( $this->messages ) || !is_array( $this->messages ) ) {
            $this->messages = array();
        }
        if ( !is_array( $messages ) ) {
            $messages = array( $messages );
        }
        $this->messages = array_merge( $this->messages, $messages );
    }

    function display_messages() {
        if ( !empty( $this->messages ) ) {
            return '<ul class="messages"><li>'.implode( '</li><li>', $this->messages ).'</li></ul>';
        }
    }

    function get_db() {
        $this->db = new BS_Database();
        return $this->db;
    }

    function getUrl( $page = '', $lang = false ) {
        global $current_lang, $default_lang;

        // Set lang to current if it isnt specified
        if ( $lang == false ) {
            $lang = $current_lang;
        }

        // Prefix lang if $lang isnt default lang
        if ( $lang == $default_lang ) {
            $lang = false;
        }

        $url = '';
        if ( !empty( $page ) && !in_array( $page, array( 'index' ) ) ) {
            if ( BS_URLREWRITE ) {
                $url .= $page . '.html';
            }
            else {
                $url .= '?p='.$page;
            }
        }

        $url = BS_BASEURL . $this->setLangURL( $url, $lang );

        return $url;
    }

    private function setLangURL( $url, $lang ) {
        if ( $lang == false ) {
            return $url;
        }
        if ( BS_URLREWRITE ) {
            return $lang . '/' . $url;
        }
        else {
            return $url . '&lang=' . $lang;
        }
    }
}
