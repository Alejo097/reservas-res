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
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class NuevoUsuarioType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

    $builder->add('id', HiddenType::class)
            ->add('nombre', TextType::class, ['label'=>'Nombre *'])
            ->add('apellido', TextType::class, ['label'=>'Apellido'])
            ->add('contrasena', RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=>'Los campos contraseña deben coincidir.',
                'first_options'=>['label'=>'Contraseña *'],
                'second_options'=>['label'=>'Repetir Contraseña *'],
            ])
            ->add('email', EmailType::class, ['label'=>'Correo electronico *'])
            ->add('telefono', NumberType::class, ['label'=>'Telefono *'])

            ->add('save', SubmitType::class,[
                'label'=>'Crear usuario',
                'attr'=>['class'=>'btn-outline-dark']
                ]
            );
    }
}
?>