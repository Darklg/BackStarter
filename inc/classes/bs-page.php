<?php

class BS_Page {

    private $infos;

    public function __construct( $p, &$model ) {
        $this->model = &$model;
        $this->infos = array(
            'lang' => BS_LANG,
            'title' => BS_NAME,
            'template' => $p,
            'body_class' => 'page-'.$p
        );
    }

    public function getModel() {
        return $this->model;
    }

    /* ----------------------------------------------------------
      Template
    ---------------------------------------------------------- */

    private function sendHeaders() {
        $headers = array();

        // Error 404
        if ( $this->infos['template'] == '404' ) {
            $headers[] = 'HTTP/1.0 404 Not Found';
        }

        foreach ( $headers as $header ) {
            header( $header );
        }
    }

    public function loadPage( ) {
        $base_url = BS_VIEWS_DIR;
        $template = $base_url . $this->getInfo( 'template' ) . '.php';
        if ( file_exists( $template ) ) {
            $this->sendHeaders();
            include $template;
        }
    }

    public function getModule( $id ) {
        $content = '';
        $base_url = BS_VIEWS_DIR . 'modules/';
        $module = $base_url . $id . '.php';
        if ( preg_match( '/^([a-z-0-9_]+)$/', $id ) && file_exists( $module ) ) {
            ob_start();
            include $module;
            $content = ob_get_clean();
        }
        return $content;
    }

    /* ----------------------------------------------------------
      Infos
    ---------------------------------------------------------- */

    public function getInfo( $id ) {
        $info = false;
        if ( isset( $this->infos[$id] ) ) {
            $info = $this->infos [$id];
        }
        return $info;
    }

    public function setInfo( $id ) {
        $this->infos[$id] = $info;
    }

    /* ----------------------------------------------------------
      Special Infos
    ---------------------------------------------------------- */

    public function getPageHTMLLang( ) {
        return str_replace( '-', '_', $this->infos['lang'] );
    }

}
