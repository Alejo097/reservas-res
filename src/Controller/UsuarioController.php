<?php
namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Restaurante;
use App\Entity\Datos;
use App\Entity\Informacion;
use App\Entity\Ubicacion;
use App\Entity\GuardarImagen;
use App\Entity\Imagen;
use App\Entity\Comentar;
use App\Form\EditarUsuarioType;
use App\Form\EditarRestauranteType;
use App\Form\EditarAdminType;
use App\Form\NuevoRestauranteType;
use App\Form\NuevoUsuarioType;
use App\Form\UbicacionRestauranteType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UsuarioController extends AbstractController {   

    /**
     *@Route("/nuevo/usuario/admin", name="admin_nuevo") 
     */
    public function nuevoAdmin(Request $request) {

        $usuario = new Usuario();
        $restaurante = new Restaurante();
        $datos = new Datos();
        $info = new Informacion();
        $ubicacion = new Ubicacion();

        $form2 = $this->createForm(NuevoUsuarioType::class, $usuario);
        $form2->handleRequest($request);
        
        $restaurante->setDatos($datos);
        $restaurante->setInformacion($info);
        $restaurante->setUbicacion($ubicacion);
        $usuario->addTienerestaurante($restaurante);

        if($form2->isSubmitted() && $form2->isValid()) {

            $usuario = $form2->getData();
            $usuario->setRol('ROLE_ADMIN');

            $datos->setTotalOpiniones(0);
            $datos->setMediaRestPuntuacion(0);
            $datos->setReservasAceptadas(0);
            $datos->setReservasCanceladas(0);
    
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->persist($restaurante);
            
            try {
                $em->flush();    
            } catch (\Exception $e) {
                die();
            }
            
            $this->addFlash('user-nuevo','¡BIENVENIDO! Cuenta creada, ingrese con sus credenciales para iniciar sesión.');

            return $this->redirectToRoute("inicio-admin");  
        }

        return $this->render('nuevo_admin.html.twig', array('form2'=>$form2->createView()));
    }

    /**
     *@Route("/admin/perfil/{id}", name="admin_edit") 
    */
    public function editarAdmin(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);

        $form = $this->createForm(EditarAdminType::class, $admin);

        //cambiar la contraseña
        $form2 = $this->createFormBuilder($admin)
        ->add('id', HiddenType::class)
        ->add('contrasena', RepeatedType::class, [
            'type'=>PasswordType::class,
            'first_options'=>['label'=>'Password'],
            'second_options'=>['label'=>'Repetir Password'],
        ])
        ->add('save', SubmitType::class,[
            'label'=>'Guardar Gambios',
            'attr'=>['class'=>'btn-outline-dark']
            ]
        )->getForm();
        
        $form->handleRequest($request);
        $form2->handleRequest($request);

        if($form2->isSubmitted() && $form2->isValid()) {
            
            $admin = $form2->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
              
            $this->addFlash(
                'pass-update',
                'contraseña actualiza'
            );

            try {
                $em->flush();    
            } catch (\Exception $th) {
                die();
            }
            return $this->redirectToRoute('admin_edit', ['id'=>$id]);
        }

        if($form->isSubmitted() && $form->isValid()) {
            
            $admin = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);

            $this->addFlash(
                'datos-nice-admin',
                'Cambios guardados !'
            );

            try {
                $em->flush();    
            } catch (\Exception $th) {
                die();
            }  
            return $this->redirectToRoute('admin_edit',['id'=>$id]);
        }

        return $this->render('editar_admin.html.twig',
        ['formulario'=>$form->createView(), 
         'form2'=>$form2->createView()]);
    }

    /**
     *@Route("/admin/restaurante/{id}", name="restaurante_edit") 
    */
    public function editarRestauranteAdmin(Request $request, $id) {
        
        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);

        //obtenemos el id del restaurante de ese administrador
        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repository->findOneBy(['usuario'=>$admin]);
        $imgactual = $restaurante->getImagen();
        $idUbicacion = $restaurante->getUbicacion()->getId();

        $repository = $this->getDoctrine()->getRepository(Ubicacion::class);
        $ubicacion = $repository->find($idUbicacion);

        $form2 = $this->createForm(UbicacionRestauranteType::class, $ubicacion);
        $form2->handleRequest($request);

        $form = $this->createForm(EditarRestauranteType::class, $restaurante);
        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()) {
            
            $restaurante = $form->getData();
            $imagen = $form->get('imagen')->getData();

            if($imagen === null) 
            {
                $restaurante->setImagen($imgactual);
                $em = $this->getDoctrine()->getManager();
                $em->persist($restaurante);
                try {
                    $em->flush();    
                } catch (\Exception $e) {
                    die("Error $e");
                }
                            
                $this->addFlash(
                    'datos',
                    'Datos actualizados! '
                );
            }
            else
            {
                $imgName = md5(uniqid()).'.'.$imagen->guessExtension();
                $ext_img = $imagen->guessExtension();

                if($ext_img == 'png' || $ext_img == 'jpg' || $ext_img == 'jpeg'){
                
                    $restaurante = $form->getData();    
                    $imagen->move("imgRestaurantesPerfil", $imgName);
                    $restaurante->setImagen($imgName);
    
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($restaurante);
                    try {
                        $em->flush();    
                    } catch (\Exception $e) {
                        die("Error $e");
                    }
    
                    return $this->redirectToRoute("restaurante_edit", ['id'=>$id]);
    
                }else{
    
                    $this->addFlash(
                        'img_error',
                        'Extención invalida.'
                    );
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($restaurante);
            try {
                $em->flush();    
            } catch (\Exception $e) {
                die("Error $e");
            }
        }

        if($form2->isSubmitted() && $form2->isValid()) {
            
            $ubicacion = $form2->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($ubicacion);
            try {
                $em->flush();    
            } catch (\Exception $th) {
                die();
            }

            $this->addFlash(
                'ubi-nice',
                'Ubicación actualizada! '
            );
        }

        return $this->render('editar_restaurante.html.twig', [
            'formulario'=>$form->createView(),
            'form2'=>$form2->createView(),
            'restaurante'=>$restaurante
        ]);
    }

    /**
     *@Route("/admin/restaurante/datos/{id}", name="restaurante_datos") 
    */
    public function datosRestauranteAdmin($id) {

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);

        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repository->findOneBy(['usuario'=>$admin]);
        $id_datos = $restaurante->getDatos()->getId();

        $repository = $this->getDoctrine()->getRepository(Datos::class);
        $datos = $repository->find($id_datos);

        return $this->render('datos_admin.html.twig', ['datos'=>$datos]);
    }

    /**
     *@Route("/admin/restaurante/informacion/{id}", name="restaurante_info") 
    */
    public function informacionRestautanteAdmin(Request $request,  $id) {

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);
        
        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restauranteAdmin = $repository->findOneBy(['usuario'=>$admin]);

        $infoId = $restauranteAdmin->getInformacion()->getId();
        $repositor = $this->getDoctrine()->getRepository(Informacion::class);
        $info = $repositor->find($infoId);

        $form = $this->createFormBuilder($info)
                    ->add('id', HiddenType::class)
                    ->add('apertura', TextareaType::class)
                    ->add('descripcion', TextareaType::class)
                    ->add('servicios',TextareaType::class)
                    ->add('save', SubmitType::class,[
                        'label'=>'Guardar Gambios',
                        'attr'=>['class'=>'btn-outline-dark']
                        ]
                    )->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $info = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($info);

            try {
                $em->flush();    
            } catch (\Exception $th) {
                die();
            }
        }

        return $this->render('restaurante_info.html.twig', ['form'=>$form->createView()]);
    }

    /**
     *@Route("/admin/restaurante/imagen/{id}", name="subir-imagenes") 
    */
    public function subirImagenesAdmin(Request $request, $id) {
        
        $guardar_img = new GuardarImagen();
        $img = new Imagen();

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);
          
        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restauranteAdmin = $repository->findOneBy(['usuario'=>$admin]);

        $form = $this->createFormBuilder($img)
            ->add('id', HiddenType::class)
            ->add('imagen', FileType::class, array('data_class' => null, 'required' => true))
            ->add('save', SubmitType::class,[
                'label'=>'Subir imagen',
                'attr'=>['class'=>'btn-outline-dark']
                ]
            )->getForm();

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $img_actual = $form->get('imagen')->getData();

            $imgMimeType = image_type_to_mime_type(exif_imagetype($img_actual));
            $imgName = md5(uniqid()).'.'.$img_actual->guessExtension();
            $ext_img = $img_actual->guessExtension();
            
            if($ext_img == 'png' || $ext_img == 'jpg' || $ext_img == 'jpeg'){
        
            $img->setTipo($imgMimeType);
            $img->setImagen($imgName);
            $img_actual->move("restaurantesIMG", $imgName);

            $guardar_img->setFechaHora(new \DateTime('now'));
            $guardar_img->setImagen($img);
            $guardar_img->setRestaurante($restauranteAdmin);

            $em = $this->getDoctrine()->getManager();
            $em->persist($img);
            $em->persist($guardar_img);
            try {
                $em->flush();    
            } catch (\Exception $th) {
                die();
            }
        
            $this->addFlash(
                'img',
                'Imagen subida.'
            );

            }else{

                $this->addFlash(
                    'error',
                    'Formato invalido, verifica es que una extención (.jpg, .png, .jpeg)'
                );
                
            }
        
        }

        return $this->render('restaurante_imagenes.html.twig', ['form'=>$form->createView()]);
    }

    //mostrara las imagenes en el panel del administrador
    /**
     *@Route("/admin/restaurante/imagenes/{id}", name="imagenes-admin") 
    */
    public function imagenesAdmin($id) {
        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);
          
        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restauranteAdmin = $repository->findOneBy(['usuario'=>$admin]);

        $repositori = $this->getDoctrine()->getRepository(GuardarImagen::class);
        $imagenes = $repositori->findBy(['restaurante'=> $restauranteAdmin]);
    
        return $this->render('ver_imagenes_restaurante.html.twig',['imagenes'=>$imagenes]);
    }

    //Elimina las imagenes del administrador
    /**
     *@Route("/admin/restaurante/imagenes/{id}/{idadmin}", name="eliminar-img") 
    */
    public function eliminarImagenAdmin($id, $idadmin) {

        $repository = $this->getDoctrine()->getRepository(GuardarImagen::class);
        $img_guardada = $repository->find($id);
        $imgId = $img_guardada->getImagen()->getId();

        $repository = $this->getDoctrine()->getRepository(Imagen::class);
        $img = $repository->find($imgId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($img_guardada);
        $em->remove($img);

        try {
            $em->flush();    
        } catch (\Exception $th) {
            die();
        }
    
        return $this->redirectToRoute('imagenes-admin',['id'=>$idadmin]);
    }

    /**
     *@Route("/admin/restaurante/opiniones/{id}", name="admin_opiniones") 
    */
    public function opinionesRestauranteAdmin($id)
    {
        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $admin = $repository->find($id);
          
        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restauranteAdmin = $repository->findOneBy(['usuario'=>$admin]);

        $repositorio = $this->getDoctrine()->getRepository(Comentar::class);
        $opiniones = $repositorio->findBy(['restaurante'=> $restauranteAdmin]);
        

        return $this->render('opiniones_admin.html.twig', ['opiniones'=>$opiniones]);
    }

    /**
     *@Route("/nuevo/usuario", name="usuario_nuevo") 
     */
    public function nuevoUsuario(Request $request, MailerInterface $mailer) {

        $usuario = new Usuario();

        $form = $this->createForm(NuevoUsuarioType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $usuario->setRol('ROLE_USER');
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
                die();
            }
            $this->addFlash('user-nuevo','¡Bienvenido! Cuenta creada, ingrese con sus credenciales para iniciar sesión.');

            return $this->redirectToRoute("login");  
        }

        return $this->render('nuevo_usuario.html.twig', array('formulario'=>$form->createView()));
    }

    /**
     *@Route("/usuario/editar/{id}", name="usuario_perfil_edit") 
     */
    public function editarUsuario(Request $request, $id) {

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repository->find($id);
        $imgActual = $usuario->getImagen();

        $form = $this->createForm(EditarUsuarioType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $usuario = $form->getData();
            $img = $form->get('imagen')->getData();
                 
            if($img == null) {

                $usuario->setImagen($imgActual);
                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                try {
                    $em->flush();    
                } catch (\Exception $e) {
                    die("Error $e");
                }
                              
                $this->addFlash(
                    'datos-update-user',
                    'Datos actualizados! '
                );

                return $this->redirectToRoute('usuario_perfil_edit',['id'=>$id]);

            } else {

            $imgMimeType = image_type_to_mime_type(exif_imagetype($img));
            $imgName = md5(uniqid()).'.'.$img->guessExtension();
            $ext_img = $img->guessExtension();
            
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
 
                $this->addFlash(
                    'datos_update-user',
                    'Datos actualizados! '
                );

                return $this->redirectToRoute('usuario_perfil_edit',['id'=>$id]);

            }else{

                $this->addFlash(
                    'img_error',
                    'Extención invalida.'
                );
                }
            }            
        }

        return $this->render('editar_usuario.html.twig',[
        'formulario'=>$form->createView()]);
    }

    /**
     *@Route("/usuario/comentarios/{id}", name="res_comentarios")
    */
    public function comentariosRestaurante($id) {

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repository->find($id);

        $repositorio = $this->getDoctrine()->getRepository(Comentar::class);
        $comentarios = $repositorio->findBy(['usuario'=> $usuario]);

        return $this->render('comentarios.html.twig', ['usuario'=> $usuario, 'comentarios'=>$comentarios]);
    }

    /**
     *@Route("/usuario/favoritos/{id}/{id_user}", name="res_favoritos")
     */    
    public function restauranteFavorito($id, $id_user) {

        $repositorio = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repositorio->find($id);

        $repositorio = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repositorio->find($id_user);
        
        if(!$restaurante->getFavorito()) {
            $restaurante->setFavorito(true);

            if ($usuario->getRestaurantesFavoritos() >= 0){
                $usuario->setRestaurantesFavoritos($usuario->getRestaurantesFavoritos()+1);
            }
        }else{
            $restaurante->setFavorito(false);

            if ($usuario->getRestaurantesFavoritos() > 0){
                $usuario->setRestaurantesFavoritos($usuario->getRestaurantesFavoritos()-1);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($restaurante);

        try {
            $em->flush();    
        } catch (\Exception $th) {
            die();
        }

        return $this->redirectToRoute('restaurant_favoritos');
    }

    /**
     *@Route("/usuario/puntos/{id}", name="puntos")
    */
    public function puntos($id)
    {
        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repository->find($id);

        return $this->render('puntos.html.twig', ['usuario'=> $usuario]);
    }    
}
?>