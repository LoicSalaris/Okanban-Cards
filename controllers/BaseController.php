<?php

/**
 * Classe de base dont hériteront les contrôleurs de notre MVC
 * (ceux qui souhaitent afficher un template HTML)
 */
class BaseController
{
    public $name;

    public function __construct($name = 'BaseController')
    {
        $this->name = $name;
    }

    public function show($viewName, $viewVars = array())
    {
        // $viewVars est donc disponible dans les include
        // On inclus la page index
        // __DIR__ => chemin du fichier courant (MainController)
        include(__DIR__.'/../views/header.php');
        include(__DIR__.'/../views/'.$viewName.'.php');
        include(__DIR__.'/../views/footer.php');
    }
}
