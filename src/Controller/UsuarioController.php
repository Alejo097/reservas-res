<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\EditarUsuarioType;
use App\Form\NuevoUsuarioType;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsuarioController extends AbstractController
{   
    /**
     *@Route("/usuario/nuevo", name="usuario_nuevo") 
     */
    public function nuevoUsuario(Request $request, MailerInterface $mailer) {

        $usuario = new Usuario();

        $form = $this->createForm(NuevoUsuarioType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $usuario->setRol('USER');
            $usuario->setPuntos(0);
            $usuario->setRestaurantesFavoritos(0);
            $usuario->setComentarios(0);
            $usuario->setReservas(0);

            /* Enviar email #############################
            $destinario = $form->get('email')->getData();            
            $email = (new Email())
                ->from('hello@example.com')
                ->to($destinario)
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html('See Twig integration for better HTML integration!');
            $mailer->send($email);*/


            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            try {
                $em->flush();    
            } catch (\Exception $e) {
                die("Error $e");
            }
            
            return $this->redirectToRoute("inicio");  
        }

        return $this->render('nuevo_usuario.html.twig', array('formulario'=>$form->createView()));
    }

    /**
     *@Route("/usuario/editar/{id}", name="usuario_perfil_edit") 
     */
    public function editarUsuario(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repository->find($id);

        $imgActual = $usuario->getImagen();

        $form = $this->createForm(EditarUsuarioType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $usuario = $form->getData();
            $img = $form->get('imagen')->getData();
                 
            if($img === null) {

                $usuario->setImagen($imgActual);

                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                try {
                    $em->flush();    
                } catch (\Exception $e) {
                    die("Error $e");
                }

                return $this->redirectToRoute("inicio");

            }else{

            $imgMimeType = image_type_to_mime_type(exif_imagetype($img));
            $imgName = md5(uniqid()).'.'.$img->guessExtension();
            $ext_img = $img->guessExtension();
            

                //recordarme tambien, controlar el tamaño
                if($ext_img == 'png' || $ext_img == 'jpg' || $ext_img == 'jpeg'){
                    
                    $usuario = $form->getData();    
                    $img->move("perfilImg", $imgName);

                    $usuario->setImagen($imgName);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($usuario);
                    try {
                        $em->flush();    
                    } catch (\Exception $e) {
                        die("Error $e");
                    }

                    return $this->redirectToRoute("inicio");

                }else{

                    $this->addFlash(
                        'img_error',
                        'Extención invalida.'
                    );
                }
            }            
        }
        return $this->render('editar_usuario.html.twig', array('formulario'=>$form->createView()));
    }

    /**
     *@Route("/admin/nuevo", name="admin_nuevo") 
     */
    public function nuevoAdmin(Request $request) {

        $usuario = new Usuario();

        $form = $this->createForm(NuevoUsuarioType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $usuario->setRol('ADMIN');

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            try {
                $em->flush();    
            } catch (\Exception $e) {
                die("Error $e");
            }
            
            return $this->redirectToRoute("inicio");  
        }

        return $this->render('login_admin.html.twig', array('formulario'=>$form->createView()));
    }

}
?>