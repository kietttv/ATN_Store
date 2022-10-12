<?php 
namespace App\Form;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateOrderType extends AbstractType{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Order::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('user', EntityType::class, [
            'label' => 'Customer Name',
            'class' => User::class,
            'choice_label' => 'username',
            'disabled' => true
        ])
        ->add('Address', TextType::class, [
            'label' => 'Address',
            'disabled' => true
        ])
        ->add('Payment', TextType::class, [
            'label' => 'Payment',
            'disabled' => true
        ])
        ->add('Status', ChoiceType::class, [
            'choices' => [
                'Delivered' => '1',
                'Delivering' => '0',
            ],
            'expanded'=> true
        ])
        ->add('save', SubmitType::class, [
            'label' => "Save"
        ]);
    }
}
?>