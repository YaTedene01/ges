<?php
/**
 * Charge un message d'erreur depuis le fichier de langue
 * 
 * @param string $key La clé du message d'erreur (format: 'section.message')
 * @param string $lang La langue (par défaut: 'fr')
 * @return string Le message d'erreur ou la clé si le message n'existe pas
 */
function get_error_message($key, $lang = 'fr') {
    $path = __DIR__ . "/../lang/error.{$lang}.php";
    
    if (!file_exists($path)) {
        return $key;
    }
    
    $messages = require $path;
    
    $keys = explode('.', $key);
    $message = $messages;
    
    foreach ($keys as $part) {
        if (!isset($message[$part])) {
            return $key;
        }
        $message = $message[$part];
    }
    
    return $message;
}