<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProjectAssignment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AssignmentType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('person_id', ChoiceType::class, array(
      'choices' => array(
        //
      ),

      'choices_as_values' => true,
    ));
    //
    $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        // ... adding the name field if needed
      });
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => ProjectAssignment::class,
    ));
  }
}
