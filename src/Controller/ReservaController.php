<?php
namespace App\Controller;

use App\Entity\Comentar;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Entity\Restaurante;
use App\Entity\Datos;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ReservaController extends AbstractController
{
    //Reservas por parte del usuario
    /**
     *@Route("/reservar/{id_res}/{id_user}/", name="reservar") 
    */
    public function reserva(Request $request, $id_res, $id_user) {
        
        $reserva = new Reserva();
        $repositoryR = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repositoryR->find($id_res);
        $repositoryU = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repositoryU->find($id_user);

        $reserva->setRestaurante($restaurante);
        $reserva->setUsuario($usuario);
        $usuario->addReserva($reserva);

        $form = $this->createFormBuilder($reserva)
            ->add('id', HiddenType::class)
            ->add('numero_personas', NumberType::class)
            ->add('fecha', DateType::class, [
                'widget'=>'single_text',
                'empty_data'=> null
            ])
            ->add('hora', TimeType::class)
            ->add('save', SubmitType::class,[
                'label'=>'Reservar',
                'attr'=>['class'=>'btn-outline-dark']
                ]
            )->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $proceso = 'en-proceso';
            // fecha actual
            $fecha = new \DateTime('now');
            $hora = new \DateTime('now');

            $fecha_actual = $fecha->format('d-m-Y');
            $hora_actual = $hora->format('H:i:00');

            $fecha_hora_actual = strtotime($fecha_actual." ".$hora_actual);

            //fecha obtenida del formulario
            $reserva = $form->getData();
            $fecha_reserva = $reserva->getFecha()->format('d-m-Y');
            $hora_reserva = $reserva->getHora()->format('H:i:00');
            $fecha_hora_reserva = strtotime($fecha_reserva." ".$hora_reserva);

            if($fecha_hora_actual <= $fecha_hora_reserva) {

                $reserva->setRealizada($proceso);
                $em = $this->getDoctrine()->getManager();
                $em->persist($reserva);
                $em->persist($usuario);
                $em->flush();

                $this->addFlash(
                    'reserva-nice',
                    'Reserva efectuada.'
                );

            return $this->redirectToRoute('usuario_reservas',['id'=>$id_user]);

            }else{
                $this->addFlash(
                    'reserva_bad',
                    'La fecha no es valida.'
                );
            }
        }

        //enviar un email para avisar

        return $this->render('reservar.html.twig', ['form'=>$form->createView(), 'restaurante'=> $restaurante]);
    }

    //Reservar con puntos
    /**
     *@Route("/reservar/puntos/{id_res}/{id_user}", name="reservar-puntos") 
    */
    public function reservaConPuntos(Request $request, $id_res, $id_user) {
        
        
        $reserva = new Reserva();
        $repositoryR = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repositoryR->find($id_res);
        $repositoryU = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repositoryU->find($id_user);

        if($usuario->getPuntos() >= 100) {

            $reserva->setRestaurante($restaurante);
            $reserva->setUsuario($usuario);
            $usuario->addReserva($reserva);

            $form = $this->createFormBuilder($reserva)
            ->add('id', HiddenType::class)
            ->add('numero_personas', NumberType::class)
            ->add('fecha', DateType::class, [
                'widget'=>'single_text',
                'empty_data'=> null
            ])
            ->add('hora', TimeType::class)
            ->add('save', SubmitType::class,[
                'label'=>'Reservar',
                'attr'=>['class'=>'btn-outline-dark']
                ]
            )->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $proceso = 'en-proceso-puntos';
                            // fecha actual
                $fecha = new \DateTime('now');
                $hora = new \DateTime('now');
                $fecha_actual = $fecha->format('d-m-Y');
                $hora_actual = $hora->format('H:i:00');
                $fecha_hora_actual = strtotime($fecha_actual." ".$hora_actual);

                //fecha obtenida del formulario
                $reserva = $form->getData();
                $fecha_reserva = $reserva->getFecha()->format('d-m-Y');
                $hora_reserva = $reserva->getHora()->format('H:i:00');
                $fecha_hora_reserva = strtotime($fecha_reserva." ".$hora_reserva);

                //cuando reste los puntos que guarde de que tipo es el descuento
                if($fecha_hora_actual <= $fecha_hora_reserva) {

                    if($usuario->getReservas() >= 0){

                        $usuario->setReservas( $usuario->getReservas()+1);
                    }
                    if($usuario->getPuntos() >= 100) {


                        $usuario->setPuntos($usuario->getPuntos() -100);
                        $reserva->setPuntos(100);
                    }
                    elseif($usuario->getPuntos() >= 200){

                        $usuario->setPuntos($usuario->getPuntos() -200);
                        $reserva->setPuntos(200);
                    }
                    
                    $reserva->setRealizada($proceso);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($reserva);
                    $em->persist($usuario);
                    $em->flush();

                    $this->addFlash(
                        'reserva-nice',
                        'Reserva efectuada.'
                    );

                    return $this->redirectToRoute("usuario_reservas",['id'=>$id_user]);

                }
                else
                {
                    $this->addFlash(
                    'reserva_bad',
                    'La fecha no es valida.');
                }
            }

            return $this->render('reservas_puntos.html.twig', ['form'=>$form->createView(), 'restaurante'=> $restaurante]);
        }
        else
        {

            $this->addFlash(
            'error-puntos',
            'No tienes puntos para efectuar una reserva.');
        }
        
        return $this->redirectToRoute("usuario_reservas",['id'=>$id_user]);

    }

    //El usuario cancela la reserva actual
    /**
     *@Route("/reservar/cancelar/{id}/{id_user}", name="cancelar")
    */
    public function cancelarReservaUsuario($id, $id_user) {

        $cancelar = 'cancelada';
        $cancelPuntos = 'cancel-puntos';

        $repository = $this->getDoctrine()->getRepository(Reserva::class);
        $reserva = $repository->find($id);
        $id_restaurante = $reserva->getRestaurante()->getId();

        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repository->find($id_restaurante);
        $id_datos = $restaurante->getDatos()->getId();
        
        $repository = $this->getDoctrine()->getRepository(Datos::class);
        $datos = $repository->find($id_datos);

        $repositorio = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repositorio->find($id_user);

        if($datos->getReservasCanceladas() >= 0){
            $datos->setReservasCanceladas($datos->getReservasCanceladas()+1);
        }

        //Se suman los puntos al usuario que cancele la reserva
        if($reserva->getRealizada() == 'en-proceso-puntos')
        {
            $usuario->setPuntos($usuario->getPuntos() +100);
            $reserva->setRealizada($cancelPuntos);
        }
        else{
            $reserva->setRealizada($cancelar);
        }

        if($usuario->getRol() == 'USER' || $usuario->getReservas() > 0){

            $usuario->setReservas($usuario->getReservas()-1);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->persist($reserva);
        $em->persist($datos);
        $em->flush();

        $this->addFlash(
            'reserva-cancel',
            'En otra ocasión será.'
        );

        return $this->redirectToRoute("usuario_reservas",['id'=>$id_user]);
        
    }

    //Devolvera todas las reservas que ha hecho ese usuario, y comentario respectivo del usuario
    /**
     *@Route("/reservas/usuario/{id}", name="usuario_reservas")
    */
    public function reservasDelUsuario($id) {

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repository->find($id);

        $repository = $this->getDoctrine()->getRepository(Reserva::class);  
        $reservas = $repository->findBy(['usuario'=> $usuario], ['id'=>'DESC']); 

        $repository = $this->getDoctrine()->getRepository(Comentar::class);
        $comentario = $repository->findOneBy(['id' => $usuario]);

        return $this->render('reservas.html.twig', ['reservas'=> $reservas, 'comentario'=> $comentario]);
    }


    //Administrador acepta la reserva, si el acuidio al lugar
    /**
     *@Route("/admin/reservas/aceptar/{id}", name="aceptar-reserva")
    */
    public function aceptarReservaAdmin($id) {

        $aceptar = 'completada';
        $aceptarPuntos = 'completed-puntos';

        $puntos = 10;

        $repository = $this->getDoctrine()->getRepository(Reserva::class);
        $reserva = $repository->find($id);
        $id_restaurante = $reserva->getRestaurante()->getId();

        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repository->find($id_restaurante);
        $id_datos = $restaurante->getDatos()->getId();
        
        $repository = $this->getDoctrine()->getRepository(Datos::class);
        $datos = $repository->find($id_datos);

        if($datos->getReservasAceptadas() >= 0){
            $datos->setReservasAceptadas($datos->getReservasAceptadas()+1);
        }

        $usuario = $reserva->getUsuario();

        if($reserva->getRealizada() == 'en-proceso'){

            $reserva->setRealizada($aceptar);
        }
        else{
            $reserva->setRealizada($aceptarPuntos);
        }
        
        $usuario->setPuntos($puntos);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->persist($reserva);
        $em->persist($datos);
        $em->flush();

        return $this->redirectToRoute("inicio-admin");
    }

    //Administrador cancela la reserva, si el usuario no acuidio al lugar
    /**
     *@Route("/admin/reservas/cancelar/{id}", name="cancelar-reserva")
    */
    public function cancelarReservaAdmin($id) {

        $cancelar = 'cancelada-ad';
        $canceladaPuntos = 'cancel-puntos-ad';

        $repository = $this->getDoctrine()->getRepository(Reserva::class);
        $reserva = $repository->find($id);

        $id_restaurante = $reserva->getRestaurante()->getId();
        $id_usuario = $reserva->getUsuario()->getId();

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repository->find($id_usuario);

        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repository->find($id_restaurante);
        $id_datos = $restaurante->getDatos()->getId();
        
        $repository = $this->getDoctrine()->getRepository(Datos::class);
        $datos = $repository->find($id_datos);

        if($datos->getReservasCanceladas() >= 0){
            $datos->setReservasCanceladas($datos->getReservasCanceladas()+1);
        }

        if($usuario->getReservas() > 0){

            $usuario->setReservas($usuario->getReservas()-1);
        }

        //Se suman los puntos al usuario cliente, en este caso lo cancelo el administrador
        if($reserva->getRealizada() == 'en-proceso-puntos')
        {
            $usuario->setPuntos($usuario->getPuntos() +100);
            $reserva->setRealizada($canceladaPuntos);
        }else{
            $reserva->setRealizada($cancelar);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->persist($reserva);
        $em->persist($datos);
        $em->flush();

        return $this->redirectToRoute("inicio-admin");
    }

    // Mostrar todas las reservas del admin
    /**
     *@Route("/admin/reservas/{id}", name="admin-reservas")
    */
    public function reservasDelAdmin($id) {

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);
        
        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restauranteAdmin = $repository->findOneBy(['usuario'=> $admin]);

        $repository = $this->getDoctrine()->getRepository(Reserva::class);  //Devolvera todas las reservas del para el admin
        $reservas = $repository->findBy(['restaurante'=> $restauranteAdmin],['id'=>'DESC']); 


        return $this->render('reservas_admin.html.twig', ['reservas'=> $reservas]);
    }
}
?>