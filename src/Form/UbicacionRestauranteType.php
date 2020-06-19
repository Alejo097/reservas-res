<?php
namespace App\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\PasswordType; 
use Symfony\Component\Form\Extension\Core\Type\EmailType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UbicacionRestauranteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

    $builder->add('id', HiddenType::class)
        ->add('nombre_pais', ChoiceType::class,[
            'empty_data' => null,
            'choices'=> [
                'España'=>'España',
            ]
        ])            
        ->add('provincia', ChoiceType::class,[
            'empty_data' => null,
            'choices'=> [
                'Barcelona'=>'Barcelona',
                'Alicante'=>'Alicante',
                'Malaga'=>'Malaga',
                'Valencia'=>'Valencia',
                'Castellon'=>'Castellon',
                'Almeria'=>'Almeria',
                'Sevilla'=>'Sevilla',
                'Granada'=>'Granada',
                'Albacete'=>'Albacete',
                'Madrid'=>'Madrid',
                'Murcia'=>'Murcia',
                'Tarragona'=>'Tarragona',
                'Cantabria'=>'Cantabria',
            ]
        ])
        ->add('save', SubmitType::class,[
            'label'=>'Guardar Gambios',
            'attr'=>['class'=>'btn-outline-dark']
            ]
        );
    }
}
?>