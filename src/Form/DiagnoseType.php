<?php

namespace App\Form;

use App\Entity\Diagnose;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DiagnoseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', TextType::class, ['label' => 'Date du diagnostic'])
            ->add('diagnoseType', TextType::class, ['label' => 'Type diagnostic'])
            ->add('patientName', TextType::class, ['label' => 'Nom du patient'])
            ->add('patientAge', IntegerType::class, ['label' => 'Age du patient'])
            ->add('image', FileType::class, [
                'label' => 'Photo (au format .jpg ou .png)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1m',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de donner un document jpg ou png valide',
                    ])
                ],
            ])
            ->add('dentistName', TextType::class, ['label' => 'Nom du praticien'])
            ->add('observations', TextareaType::class, ['label' => 'Observations'])
            ->add('save', SubmitType::class, ['label' => 'Ajouter un diagnostic'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Diagnose::class,
        ]);
    }
}
