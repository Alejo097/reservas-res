<?php
namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Restaurante;
use App\Entity\Oferta;
use App\Entity\Promocion;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PromocionController extends AbstractController
{
	/**
	*@Route("/admin/restaurante/promocion/{id}", name="promocion")
	*/
	public function promocionRestaurante(Request $request, $id) {
        $promocion = new Promocion();
        $oferta = new Oferta();

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);

        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restauranteAdmin = $repository->findOneBy(['usuario'=>$admin]);

        $form = $this->createFormBuilder($oferta)
                ->add('id', HiddenType::class)
                ->add('descuento', NumberType::class)
                ->add('descripcion', TextareaType::class)
                ->add('fecha_hora', DateTimeType::class,[
                    'date_widget'=>'choice',
                ])
                ->add('save', SubmitType::class,[
                    'label'=>'Guardar Gambios',
                    'attr'=>['class'=>'btn-outline-dark']
                    ]
        )->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $fecha_promo_set = $form->get('fecha_hora')->getData();
            $fecha_promo = $fecha_promo_set->format('d-m-Y H:i:00');
            $fecha_hora_promo = strtotime($fecha_promo);
    
            $fecha = new \DateTime('now');
            $fecha_actual = $fecha->format('d-m-Y H:i:00');
            $fecha_hora_actual = strtotime($fecha_actual);

            if($fecha_hora_actual <= $fecha_hora_promo) {

                $oferta->setFechaHora($fecha_promo_set);
                $oferta = $form->getData();
        
                $promocion->setOferta($oferta);
                $promocion->setRestaurante($restauranteAdmin); 
                   
                $em = $this->getDoctrine()->getManager();
                $em->persist($oferta);
                $em->persist($promocion);

                try {
                    $em->flush();
                } 
                catch (\Exception $e) {
                    die();
                }

                $this->addFlash(
                    'promocion-nice',
                    'Promocion publicada !'
                );
            }
            else{
                $this->addFlash(
                    'fecha-bad-promocion',
                    'La fecha no es valida.'
                );
            }
        }

        return $this->render('promociones_admin.html.twig', ['form'=>$form->createView()]);
    }

    /**
	*@Route("/admin/restaurante/promociones/{id}", name="promociones")
	*/
	public function verPromocionesAdmin($id) {

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);

        $repository  = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repository->findOneBy(['usuario'=>$admin]);

        $repository = $this->getDoctrine()->getRepository(Promocion::class);
        $promociones = $repository->findBy(['restaurante'=>$restaurante]);

        return $this->render('ver_promociones_admin.html.twig', ['promociones'=>$promociones]);
    }

    /**
	*@Route("/admin/restaurante/promocion/eliminar/{id}", name="eliminar-promocion")
    */
    public function eliminarPromocionAdmin($id) {

        $repository = $this->getDoctrine()->getRepository(Promocion::class);
        $promocion = $repository->find($id);
        $ofertaId = $promocion->getOferta()->getId();

        $repository = $this->getDoctrine()->getRepository(Oferta::class);
        $oferta = $repository->find($ofertaId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($promocion);
        $em->remove($oferta);

        try {
            $em->flush();
        } catch (\Exception $th) {
            die();
        }

        return $this->redirectToRoute('inicio-admin');
    }
}
?>