<?php

/**
 * Classe affichant les pages annexes,
 * qui hérite de la méthode show() de BaseController
 */
class PagesController extends BaseController
{
    public function __construct()
    {
        parent::__construct('PagesController');
    }

    public function contact()
    {
        $this->show('contact');
    }

    public function cgu()
    {
        $this->show('cgu');
    }

    public function besoinDaide()
    {
        $this->show('need_help');
    }

}
