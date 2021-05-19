<?php
namespace App\Form\Type;

use App\Document\CSV_Upload;
use Doctrine\ODM\MongoDB\Types\IdType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class ShowType extends AbstractType implements FormTypeInterface
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    { 
        $builder
        
            ->add('file_content', TextType::class)
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CSV_Upload::class
        ]);
    }
}