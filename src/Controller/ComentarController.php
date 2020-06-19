<?php
namespace App\Controller;

use App\Entity\Reserva;
use App\Entity\Resena;
use App\Entity\Usuario;
use App\Entity\Restaurante;
use App\Entity\Comentar;
use App\Entity\Datos;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class ComentarController extends AbstractController {

    /**
     *@Route("/restaurante/comentar/{id_res}/{id_user}/{id_reserva}", name="comentar-puntuar") 
    */
    public function comentarYpuntuar($id_res, $id_user, $id_reserva, Request $request) {
        
        $comentada = 'completed-coment';

        $resena = new Resena();
        $comentar = new Comentar();

        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repository->find($id_res);
        $id_datos = $restaurante->getDatos()->getId();

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repository->find($id_user);

        $repository = $this->getDoctrine()->getRepository(Datos::class);
        $datos = $repository->find($id_datos);
        

        $repository = $this->getDoctrine()->getRepository(Reserva::class);
        $reserva = $repository->find($id_reserva);


        $form = $this->createFormBuilder($resena)
            ->add('id', HiddenType::class)
            ->add('comentario', TextareaType::class)
            ->add('puntuacion', RangeType::class,[
                'attr'=>[
                    'min'=>1,
                    'max'=>10
                ]
            ])
        ->add('save', SubmitType::class,[
            'label'=>'Comentar',
            'attr'=>['class'=>'btn-outline-dark']
            ]
        )->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $comentario = $form->get('comentario')->getData();
            $puntuacion = intval($form->get('puntuacion')->getData());

            if($datos->getTotalOpiniones() >= 0){
                $datos->setTotalOpiniones($datos->getTotalOpiniones()+1);
            }     

            if($usuario->getComentarios() >= 0){
                $usuario->setComentarios($usuario->getComentarios()+1);
            }

            $reserva->setRealizada($comentada);

            $comentar->setFecha(new \DateTime('now'));
            $comentar->setHora(new \DateTime('now'));
            $comentar->setRestaurante($restaurante);
            $comentar->setResena($resena);
            $comentar->setUsuario($usuario);

            $resena->setComentario($comentario);
            $resena->setPuntuacion($puntuacion);
            $resena->addComentar($comentar);

            $em->persist($usuario);
            $em->persist($resena);
            $em->persist($comentar);
            $em->persist($datos);
            $em->persist($reserva);

            try {
                $em->flush();    
            } catch (\Throwable $th) {
                die();
            }

            $this->addFlash('comentario-nice','Reseña publicada.');

            return $this->redirectToRoute('usuario_reservas',['id'=>$id_user]);

        }
        
        return $this->render('comentar_y_puntuar.html.twig', ['form'=>$form->createView()]);
    }

    /**
     *@Route("/restaurante/comentar/{id}", name="no-puntuar") 
    */
    public function noComentar($id)
    {
        $nocomentario = 'completed-no-coment';

        $repository = $this->getDoctrine()->getRepository(Reserva::class);
        $reserva = $repository->find($id);
        $id_user = $reserva->getUsuario()->getId();

        $reserva->setRealizada($nocomentario);
        $em = $this->getDoctrine()->getManager();
        $em->persist($reserva);
        $em->flush();

        $this->addFlash('comentario-bad','En otra ocasión.');

        return $this->redirectToRoute('usuario_reservas',['id'=>$id_user]);

    }

}

?>