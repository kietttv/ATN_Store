<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType {
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', RepeatedType::class,[
                'type' =>PasswordType::class,
                'invalid_message' => 'Not match',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password']
                
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
            ->add('address',TextType::class,[
                'label'=>'Address',
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('telephone',TelType::class,[
                'label'=>'Telephone',
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('email', EmailType::class,[
                'label'=>'Email'
            ])
            ->add('birthdate', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('save', SubmitType::class, [
                'label' => "Save"
            ]);
    }
}

?>