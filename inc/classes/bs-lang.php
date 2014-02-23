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

    function __construct() {

        $lang = $this->languages[$this->default_lang]['lang'];

        // If translation is available for the requested language
        if ( isset( $_GET['lang'] ) && array_key_exists( $_GET['lang'], $this->languages ) ) {
            $lang = $this->languages[$_GET['lang']]['lang'];
        }

        // Setting language
        putenv( 'LC_ALL=' . $lang );
        setlocale( LC_ALL, $lang );

        // Loading translation
        bindtextdomain( "backstarter", BS_INC_DIR . "locale" );
        bind_textdomain_codeset( "backstarter", "UTF-8" );
        textdomain( "backstarter" );
    }
}
