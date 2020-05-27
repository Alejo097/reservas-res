<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InicioController extends AbstractController
{
	
	/**
	*@Route("/", name="inicio")
	*/
	public function inicio()
	{
	  return $this->render('inicio.html.twig');
	}

	/**
	*@Route("/admin", name="inicio-admin")
	*/
	public function inicioAdmin()
	{
	  return $this->render('layout_admin.html.twig');
	}
}
?>