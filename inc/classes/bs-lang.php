<?php

class BS_Lang {
    private $languages = array(
        'en' => array(
            'lang' => 'en_US.utf8',
            'name' => 'English'
        ),
        'fr' => array(
            'lang' => 'fr_FR',
            'name' => 'Fran&ccedil;ais'
        )
    );
    private $default_lang = 'fr';

    function __construct( $p ) {
        $this->id_lang = $this->getDefaultLangId();

        // If default language is forced in url, redirect without lang id
        if ( isset( $_GET['lang'] ) && $_GET['lang'] == $this->id_lang ) {
            $m = new BS_Model();
            bs_redirect( $m->getUrl( $p ) );
        }

        $lang = $this->languages[$this->id_lang]['lang'];
        // If translation is available for the requested language
        if ( isset( $_GET['lang'] ) && array_key_exists( $_GET['lang'], $this->languages ) ) {
            $this->id_lang = $_GET['lang'];
            $lang = $this->languages[$this->id_lang]['lang'];
        }

        // Setting language
        putenv( 'LC_ALL=' . $lang );
        setlocale( LC_ALL, $lang );

        // Loading translation
        bindtextdomain( "backstarter", BS_INC_DIR . "locale" );
        bind_textdomain_codeset( "backstarter", "UTF-8" );
        textdomain( "backstarter" );
    }

    public function getCurrentLangId() {
        return $this->id_lang;
    }

    public function getDefaultLangId() {
        return $this->default_lang;
    }
}
