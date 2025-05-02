<?php
namespace App\Models;

require_once __DIR__.'/../enums.php';
use Referentiel_Model_Key;
use ModelFunction;
use DataKey;

return [
    Referentiel_Model_Key::GET_ALL->value => function() {
        global $fonctions_models;
        return $fonctions_models[ModelFunction::GET_ALL->value](DataKey::REFERENTIELS);
    },
    Referentiel_Model_Key::GET_BY_ID->value => function($id) {
        global $fonctions_models;
        $referentiels = $fonctions_models[ModelFunction::GET_ALL->value](DataKey::REFERENTIELS);
        return array_filter($referentiels, function($referentiel) use ($id) {
            return $referentiel['id'] == $id;
        });
    },
    Referentiel_Model_Key::ADD->value => function($newReferentiel) {
        global $fonctions_models;
        $referentiels = $fonctions_models[ModelFunction::GET_ALL->value](DataKey::REFERENTIELS);
        $newReferentiel['id'] = uniqid('ref_');
        $referentiels[] = $newReferentiel;
        $fonctions_models[ModelFunction::SAVE->value](DataKey::REFERENTIELS, $referentiels);
        return $newReferentiel;
    },
    Referentiel_Model_Key::UPDATE->value => function($id, $updatedReferentiel) {
        global $fonctions_models;
        $referentiels = $fonctions_models[ModelFunction::GET_ALL->value](DataKey::REFERENTIELS);
        array_walk($referentiels, function(&$referentiel) use ($id, $updatedReferentiel) {
            if ($referentiel['id'] == $id) {
                $referentiel = array_merge($referentiel, $updatedReferentiel);
            }
        });
        $fonctions_models[ModelFunction::SAVE->value](DataKey::REFERENTIELS, $referentiels);
        return $updatedReferentiel;
    },
    Referentiel_Model_Key::DELETE->value => function($id) {
        global $fonctions_models;
        $referentiels = $fonctions_models[ModelFunction::GET_ALL->value](DataKey::REFERENTIELS);
        foreach ($referentiels as $key => $referentiel) {
            if ($referentiel['id'] == $id) {
                unset($referentiels[$key]);
                break;
            }
        }
        $fonctions_models[ModelFunction::SAVE->value](DataKey::REFERENTIELS, $referentiels);
    },
    Referentiel_Model_Key::GET_NBR->value => function() {
        global $fonctions_models;
        return $fonctions_models[ModelFunction::GET_NBR->value](DataKey::REFERENTIELS);
    },
];