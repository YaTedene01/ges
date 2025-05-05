<?php
// Assurez-vous que cette fonction est correctement définie

// Fonction pour rediriger vers une URL
function redirect($url) {
    header("Location: $url");
    exit;
}