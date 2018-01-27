<?php

/**
 * Clase para internacionalización.
 *
 * @author dani
 */
class i18n 
{
    public function getClientLang()
    {
        $local = $this->getDefaultLanguage();
        
        $langCode = explode(';', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $langCode = explode(',', $langCode['0']);
        
        if (strlen($langCode['0']) > 0)
        {
            $local = $_SESSION['lang'] = substr($langCode['0'], 0, 2);
        }
        
        return $local;
    }
    
    private function getDefaultLanguage()
    {
        // Consultar o ficheiro de configuración onde ven o idioma por defecto:
        
        return "en_US";
    }
    
    public function setLocale($local)
    {
        switch ($local)
        {
            case 'es':
                $lang = 'es_ES.utf8';
                break;
            case 'en':
                $lang = 'en_US.utf8';
                break;
            default:
                $lang = 'en_US.utf8';
                break;
        }
        
        // Definir ó idioma:
        putenv("LC_ALL=$lang");
        setlocale(LC_ALL, $lang);
        
        // Definir a ubicación dos ficheiros de traducción:
        bindtextdomain("messages", "./../locale");
        // Codificación:
        bind_textdomain_codeset("messages", "UTF-8");
        // Nomes ficheiros:
        textdomain("messages");
    }
}
