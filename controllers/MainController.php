<?php

/**
 * Classe affichant la page d'accueil,
 * qui hérite de la méthode show() de BaseController
 */
class MainController extends BaseController
{
    public function __construct()
    {
        parent::__construct('MainController');
    }

    public function home()
    {
        $listModel = new ListModel;
        $lists = $listModel->findAll();

        $this->show('home', [
            'lists' => $lists,
        ]);
    }

}
