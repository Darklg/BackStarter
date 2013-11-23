<?php

class BS_Page {

    private $infos;

    public function __construct() {
        $this->infos = array(
            'lang' => BS_LANG,
            'title' => BS_NAME,
            'template' => 'index.php'
        );
    }

    /* ----------------------------------------------------------
      Template
    ---------------------------------------------------------- */

    public function loadPage( ) {
        $base_url = BS_PATH . 'views/';
        $template = $base_url . $this->getInfo( 'template' );
        if ( !file_exists( $template ) ) {
            $template = $base_url . '404.php';
        }
        include $template;
    }

    public function getModule( $id ) {
        $content = '';
        $base_url = BS_PATH . 'views/modules/';
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
