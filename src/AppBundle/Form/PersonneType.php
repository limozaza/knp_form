<?php

namespace AppBundle\Form;

use AppBundle\Repository\ServiceRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            /*->add('service',null, [
                'placeholder' => 'Choisir le service'
            ])*/
            ->add('service',EntityType::class, [
                'class'=> 'AppBundle\Entity\Service',
                'placeholder' => 'Choisir le service',
                'query_builder' => function(ServiceRepository $repository){
                    return $repository->createAplphabeticalQueryBuilder();
                }
            ])
            ->add('dateDeNaissance',DateType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr'=> [
                    'class' => "js-datepicker"
                ],
                'html5' => false
            ])
            ->add('isActive',ChoiceType::class,[
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ]

            ])
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Personne'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_personne';
    }


}
