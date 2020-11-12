<?php   

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\{TextareaType,SubmitType};
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpFoundation\Request;


class Menu extends AbstractController{

    /**
    * @Route("/" , name="menu", methods={"GET", "POST"})
    */
    public function Menu(){
        return $this->render('menu.html.twig');
    }

}