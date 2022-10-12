<?php
namespace App\Form;

use App\Entity\Brand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandManageType extends AbstractType{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Brand::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('BrandName', TextType::class)
        ->add('Branddes', TextType::class)
        ->add('Status', ChoiceType::class, [
            'choices' => [
                'Available' => '1',
                'Unavailable' => '0',
            ],
            'expanded'=> true
        ])
        ->add('save', SubmitType::class, [
            'label' => "Save"
        ]);        
    }
}
?>