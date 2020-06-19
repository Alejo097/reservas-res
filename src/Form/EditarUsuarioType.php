<?php
namespace App\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\PasswordType; 
use Symfony\Component\Form\Extension\Core\Type\EmailType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditarUsuarioType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

    $builder->add('id', HiddenType::class)
            ->add('nombre', TextType::class)
            ->add('apellido', TextType::class)
            ->add('contrasena', RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=>'Los campos contraseña deben coincidir.',
                'first_options'=>['label'=>'Contraseña *'],
                'second_options'=>['label'=>'Repetir Contraseña *'],
            ])

            ->add('email', EmailType::class, ['label'=>'correo electronico'])
            ->add('telefono', TextType::class)
            ->add('imagen', FileType::class, array(
                'data_class' => null, 
                'required' => false)
                )

        ->add('save', SubmitType::class,[
        'label'=>'Guardar Gambios',
        'attr'=>['class'=>'btn-outline-dark']
        ]
    );

    }    
}
?>