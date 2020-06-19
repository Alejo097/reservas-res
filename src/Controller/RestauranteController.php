<?php
namespace App\Controller;
use App\Entity\Restaurante;
use App\Entity\Datos;
use App\Entity\GuardarImagen;
use App\Entity\Comentar;
use App\Entity\Promocion;
use App\Repository\RestauranteRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 

class RestauranteController extends AbstractController
{
    /**
     *@Route("/restaurantes/buscar", name="buscar-tipo") 
    */
    public function buscarTipoRestaurante(RestauranteRepository $r, Request $request) {

        $repositorio = $this->getDoctrine()->getRepository(Restaurante::class);        
        $restaurantes = $repositorio->findAll();    

        $restaurante = "";
        $ubi = "";

        $form = $this->createFormBuilder()
            ->add('restaurante',TextType::class,[
                'label'=>'Buscar restaurantes por:',
                'required'=> false,
                'attr'=> ['placeholder'=>'nombre o tipo o dirección ...']
                ])

            ->add('ubicacion',TextType::class,[
                'label'=>'Buscar ubicacion:',
                'required'=> false,
                'attr'=> ['placeholder'=>'provincia ...']
                ])

            ->add('save', SubmitType::class, [
                'label'=>'Buscar...',
                'attr'=>['class'=>'btn btn-outline-dark my-2 my-sm-0']
                ])
        ->getForm();

        $form->handleRequest($request);
        
        if($form-> isSubmitted() && $form->isValid())
        {
            $restaurante = $form->get('restaurante')->getData(); //obtengo el texto a buscar 
            $ubi = $form->get('ubicacion')->getData();

            $restaurantes = $r->buscarRestaurante($restaurante, $ubi);
            
            return $this->render('buscar_restaurantes.html.twig', array('form_busqueda' => $form->createView(), 'restaurantes'=> $restaurantes));
        }
    
        return $this->render('buscar_restaurantes.html.twig', array('form_busqueda' => $form->createView(), 'restaurantes'=> $restaurantes));
    }

    /**
     *@Route("/restaurante/perfil/{id}", name="restaurante") 
     */
    public function perfilRestaurante($id)//Muestra todos los datos del restaurante
    {
        $puntuacion=0;
        $contador=0;
        $media=0;

        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repository->find($id);
        $id_datos = $restaurante->getDatos()->getId();

        $repository = $this->getDoctrine()->getRepository(Promocion::class);
        $promocion = $repository->findBy(['restaurante'=> $restaurante]);

        $repository = $this->getDoctrine()->getRepository(Datos::class);
        $datos = $repository->find($id_datos);

        $repositori = $this->getDoctrine()->getRepository(GuardarImagen::class);
        $imagenes = $repositori->findBy(['restaurante'=> $id]);

        $repository = $this->getDoctrine()->getRepository(Comentar::class);
        $comentarios = $repository->findBy(['restaurante' => $restaurante]);
        
        foreach($comentarios as $c){

            $puntuacion += $c->getResena()->getPuntuacion();
            $contador++;
        }

    
        $media = @($puntuacion / $contador);

        if(!is_nan($media) || $media > 0){

            $datos->setMediaRestPuntuacion($media);
            $em = $this->getDoctrine()->getManager();
            $em->persist($datos);
            $em->flush();

        }else{
            $media = null;
        }
        
        return $this->render('perfil_restaurante.html.twig', [
            'restaurante'=>$restaurante, 
            'imagenes'=>$imagenes,
            'comentarios'=>$comentarios,
            'promociones'=>$promocion,
            'media'=>$media,
            'contador'=>$contador
        ]);
    }  

    /**
     *@Route("/restaurante/favoritos", name="restaurant_favoritos") 
    */
    public function restaurantesFavoritos() //Muestra todos los restaurantes favoritos, si los hay :)
    {
        $repository = $this->getDoctrine()->getRepository(Restaurante::class);
        $restaurante = $repository->findAll();
        
        return $this->render('restaurantes_favoritos.html.twig', ['restaurantes'=>$restaurante]);
        
    }  
}
?>