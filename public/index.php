<?php
/**
* FrontController
*/

// On inclus les classes utilisées par l'appli
include('../inc/AltoRouter.php');
include('../inc/Database.php');
include('../models/CardModel.php');
include('../models/ListModel.php');
include('../controllers/ApiCardController.php');
include('../controllers/ApiListController.php');
include('../controllers/BaseController.php');
include('../controllers/MainController.php');
include('../controllers/PagesController.php');

// Routeur
$router = new AltoRouter;
// Si on bosse sous localhost, on doit indiquer à AltoRouter le chemin complet
// Sans slash de début mais avec slash de fin
$router->setBasePath('hyperspace/s06/e07/s06-e06-challenge-okanban-cards-jc-oclock/public/');

// Mapping
// Méthode, URL, Controller#méthode, (nom de la route)
// Main
$router->map('GET', '/', 'MainController#home', 'homepage');
// API List
$router->map('GET', '/list/get/all', 'ApiListController#getAll', 'api_list_get_all');
$router->map('POST', '/list/create', 'ApiListController#create', 'api_list_create');
$router->map('POST', '/list/update', 'ApiListController#update', 'api_list_update');
// API Card
$router->map('GET', '/card/get/all', 'ApiCardController#getAll', 'api_card_get_all');
$router->map('POST', '/card/create', 'ApiCardController#create', 'api_card_create');
$router->map('POST', '/card/delete/[i:id]', 'ApiCardController#delete', 'api_card_delete');
$router->map('POST', '/card/update/order', 'ApiCardController#order', 'api_card_order');
// Pages
$router->map('GET', '/cgu', 'PagesController#cgu', 'pages_cgu');
$router->map('GET', '/contact', 'PagesController#contact', 'pages_contact');
$router->map('GET', '/help', 'PagesController#besoinDaide', 'pages_help');

// Match des routes (la route demandée est-elle définie dans le routeur ?)
$match = $router->match();
// match() retourne false si URL non trouvée
// Retourne un tableau si trouvée, exemple :
// Array
// (
//     [target] => ListController#create
//     [params] => Array
//         (
//         )
//
//     [name] => list_create
// )

// Dispatch ma route vers la bonne méthode de contrôleur
// On vérifie si la clé existe dans le tableau de routes
// cf : http://php.net/manual/fr/function.array-key-exists.php
if($match !== false) {
    // On va récupérer notre destination Controller/Method
    $target = $match['target'];
    // Je récupère mes 2 éléments dans un tableau via explode(délimiteur, chaine)
    $route = explode('#', $target);
    // A l'index 0, on a le nom du contrôleur
    $controllerName = $route[0];
    // A l'index 1, on a le nom de la méthode
    $methodName = $route[1];
    // On instancie dynamiquement notre contrôleur
    $controller = new $controllerName();
    // On récupère nos paramètres
    $params = $match['params'];
    // On appelle la méthode demandée de manière dynamique
    $controller->$methodName($params);
} else {
    // On envoie une 404 (spoil)
    header("HTTP/1.0 404 Not Found");
    exit;
}
