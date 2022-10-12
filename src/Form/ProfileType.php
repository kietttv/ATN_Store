<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType {
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', TextType::class, [
            'label' => 'Username',
            'disabled' => true
        ])
            ->add('fullname', TextType::class)
            ->add('Gender', ChoiceType::class, 
            [
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
                'expanded' => true
            ])
            ->add('address', )
            ->add('telephone')
            ->add('email')
            ->add('birthdate', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('save', SubmitType::class, [
                'label' => "Save"
            ]);
    }
}

?>