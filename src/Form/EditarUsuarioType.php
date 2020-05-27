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

class EditarUsuarioType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

    $builder->add('id', HiddenType::class)
            ->add('nombre', TextType::class)
            ->add('apellido', TextType::class)
            ->add('contrasena', PasswordType::class)
            ->add('email', EmailType::class)
            ->add('telefono', TextType::class)
            ->add('imagen', FileType::class, array('data_class' => null, 'required' => false))

    ->add('save', SubmitType::class, array('label' => 'Guardar cambios'));
    }
}
?>