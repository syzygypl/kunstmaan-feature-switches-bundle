<?php

namespace SZG\KunstmaanFeatureSwitchesBundle\Form;

use SZG\KunstmaanFeatureSwitchesBundle\Entity\FeatureSwitch;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class FeatureSwitchAdminType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Nazwa',
            'constraints' => [
                new NotNull,
            ],
        ]);

        $builder->add('enabled', CheckboxType::class, [
            'label' => 'Włączony',
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FeatureSwitch::class,
            'constraints' => new UniqueEntity(['fields' => ['code', 'name']]),
        ]);
    }

    public function getBlockPrefix()
    {
        return 'featureswitch_form';
    }

}
