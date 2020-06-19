<?php
namespace App\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\EmailType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EditarRestauranteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

    $builder->add('id', HiddenType::class)
            ->add('nombre', TextType::class)
            ->add('direccion', TextType::class)
            ->add('email', EmailType::class)
            ->add('telefono', NumberType::class)
            ->add('tipo', ChoiceType::class,[
                'empty_data' => null,
                'choices'=> [
                    'Italiano'=>'Italiano',
                    'Árabe'=>'Arabe',
                    'Asiático'=>'Asiatico',
                    'Frances'=>'Frances',
                    'Latino'=>'Latino',
                    'Internacional'=>'Internacional',
                    'Mexicano'=>'Mexicano',
                    'Chino'=>'Chino',
                    'Americano'=>'Americano',
                    'Vegetariano'=>'Vegetariano',
                    'Japonés'=>'Japones',
                    'Inglés'=>'Ingles',
                    'Griego'=>'Griego',
                    'Indio'=>'Indio',
                    'Gallego'=>'Gallego',
                    'Cubano'=>'Cubano',
                    'Colombiano'=>'Colombiano',
                    'Catalán'=>'Catalan',
                    'Andaluz'=>'Andaluz',
                    'Argentino'=>'Argentino',
                    'Belga'=>'Belga',
                    'Alemán'=>'Aleman',
                    'Canario'=>'Canario',
                    'Coreano'=>'Coreano',
                    'Ecuatoriano'=>'Ecuatoriano',
                    'Español'=>'Español',
                    'Egipcio'=>'Egipcio',
                    'Marroquí'=>'Marroqui',
                    'Iraní'=>'Irani',
                    'Peruano'=>'Peruano',
                    'Portugués'=>'Portugues',
                    'Ruso'=>'Ruso',
                    'Tailandés'=>'Tailandes',
                    'Turco'=>'Turco',
                    'Vasco'=>'Vasco',
                    'Venezolano'=>'Venezolano',
                    'Mediterránea'=>'Mediterranea'
                ]
            ])   
            ->add('imagen', FileType::class,['data_class'=>null, 'required'=>false])
            ->add('save', SubmitType::class,[
                'label'=>'Guardar Gambios',
                'attr'=>['class'=>'btn-outline-dark']
                ]
            );
    }
}
?>