<?php
namespace App\Enums;
// app/enums.php
enum DataKey: string{
    case STUDENTS = 'students';
    case PROMOTIONS = 'promotions';
    case REFERENTIELS = 'referentiels';
    case USERS = 'users';
}
enum ModelFunction: string{
    case GET_ALL = 'getAll';
    case SAVE = 'save';
    case GET_BY_ID = 'getById';
    case GET_NBR = "get_nbr";
    case DELETE = 'delete';
    case UPDATE = 'update';

}
enum UserModelKey:string{
    case AUTHENTICATE = 'authenticate';
    case UPDATE_PASSWORD = 'update_password';
    case GET_BY_ID = 'get_by_id';
    case GET_USER_INDEX = 'get_user_index';
}
enum JsonOperation: string{
    case DECODE = 'decode';
    case ENCODE = 'encode';
}
enum StudentStatus: string{
    case ACTIVE = 'actif';
    case INACTIVE = 'inactif';
}
enum PromotionStatus: string{
    case ACTIVE = 'actif';
    case INACTIVE = 'inactif';
}

enum StudentAttribute: string {
    case ID = "id";
    case NAME = "nom";
    case EMAIL = "email";
    case PROMOTION = "promotion";
    case STATUS = "statut";
}
enum PromotionAttribute: string {
    case ID = "id";
    case NAME = "nom";
    case STATUS = "statut";
    case START_DATE = "date_debut";
    case END_DATE = "date_fin";
    case REFERENTIELS = "referentiels";
    case PHOTO = "photo";
    case STUDENTS_NB = "nbr_etudiants";
}
enum Promotion_Model_Key:string {
    case DELETE = "delete";
    case GET_ALL = "get_all";
    case GET_BY_ID = "get_by_id";
    case UPDATE = "update";
    case ADD = "add";
    case GET_NBR = "get_nbr";
    case DESACTIVATE_ALL = "desactivate_all";
    case GET_BY_STATUS = "get_by_status";
   
}
enum ReferentielAttribute: string {
    case ID = "id";
    case NAME = "nom";
    case DESCRIPTION = "description";
    case PROMOTION = "promotion";
}

enum Referentiel_Model_Key: string {
    case GET_ALL = "get_all";
    case GET_BY_ID = "get_by_id";
    case ADD = "add";
    case UPDATE = "update";
    case DELETE = "delete";
    case GET_NBR = "get_nbr";
    
}
enum CourseAttribute: string {
    case ID = "id";
    case NAME = "nom";
    case PROMOTION = "promotion";
    case START_DATE = "date_debut";
    case END_DATE = "date_fin";
}

enum UtilisateurAttribute: string {
    case ID = "id";
    case NAME = "nom";
    case EMAIL = "email";
    case PASSWORD = "mot_de_passe";
    case ROLE = "role";
}
enum ErrorCode: string {
    case REQUIRED_FIELD = 'required_field';
    case UNIQUE_NAME = 'unique_name';
    case PHOTO_FORMAT = 'photo_format';
    case PHOTO_SIZE = 'photo_size';
    case REFERENTIEL_REQUIRED = 'referentiel_required';
    case INVALID_STATUS = 'invalid_status';
    case INVALID_DATE = 'date invalide';
   case PHOTO_REQUIRED = 'photo requis';
}

enum SuccessCode: string {
    case PROMOTION_CREATED = 'promotion_created';
    case PROMOTION_UPDATED = 'promotion_updated';
}
