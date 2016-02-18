<?php
// src/Blb/LocationBundle/Form/ReservationType.php

namespace Blb\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ReservationType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      
      ->add('start','date', array('input'  => 'datetime', 'widget' => 'single_text', 'format'=>'yyyy-MM-dd','attr' => array('class' => 'form-control daterange','placeholder'=>'Date arrivée locataires')))
      ->add('end','date', array('input'  => 'datetime', 'widget' => 'single_text','format'=>'yyyy-MM-dd','attr' => array('class' => 'form-control daterange','placeholder'=>'Date départ locataires')))
      
    ;

    // On récupère la factory (usine)
    $factory = $builder->getFormFactory();

   
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Blb\LocationBundle\Entity\Reservation',
      'intention' => 'task_form',
    ));
  }

  public function getName()
  {
    return 'Blb_LocationBundle_Reservationtype';
  }
}