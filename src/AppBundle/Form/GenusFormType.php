<?php

namespace AppBundle\Form;

use AppBundle\Entity\Genus;
use AppBundle\Entity\SubFamily;
use AppBundle\Repository\SubFamilyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenusFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('subFamily', EntityType::class, [
                'placeholder' => "Choose a subfamily",
                'class' => SubFamily::class,
                'query_builder' => function(SubFamilyRepository $repository) {
                    return $repository->createAlphabeticalQueryBuilder();
                }
            ])
            ->add('speciesCount')
            ->add('funFact', null, [
                'help' => 'For example, Leatherback sea turtles can travel more than 10,000 miles every year!'
            ])
            ->add('isPublished', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false
                ]
            ])
            ->add('firstDiscoveredAt', DateType::class, [
                //'widget' => 'single_text',
                //'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => Genus::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_genus_form_type';
    }

    /*
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view['funFact']->vars['help'] = 'For example, Leatherback sea turtles can travel more than 10,000 miles every year!';
    }*/


}
