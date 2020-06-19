<?php
namespace App\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;  
use Symfony\Component\Form\Extension\Core\Type\EmailType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 

class EditarAdminType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

    $builder->add('id', HiddenType::class)
            ->add('nombre', TextType::class)
            ->add('apellido', TextType::class)
            ->add('email', EmailType::class)
            ->add('telefono', TextType::class)
        ->add('save', SubmitType::class,[
        'label'=>'Guardar Gambios',
        'attr'=>['class'=>'btn-outline-dark']
        ]
    );
    }    
}
?>