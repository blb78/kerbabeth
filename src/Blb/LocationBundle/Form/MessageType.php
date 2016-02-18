<?php
// src/Blb/LocationBundle/Form/MessageType.php

namespace Blb\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class MessageType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      
      ->add('name',     'text', array(
             'attr' => array('class' => 'form-control','placeholder'=>'Nom')))
      ->add('email',    'email', array(
             'attr' => array('class' => 'form-control','placeholder'=>'Email')))
      ->add('message',   'textarea', array(
             'attr' => array('class' => 'form-control', 'rows'=>5,'placeholder'=>'Message')))
      ->add('epoch','hidden',array('mapped' => false,'required'=> false))
      
      
    ;

    // On récupère la factory (usine)
    $factory = $builder->getFormFactory();

   
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Blb\LocationBundle\Entity\Message',
      'intention' => 'task_form',
    ));
  }

  public function getName()
  {
    return 'Blb_LocationBundle_Messagetype';
  }
}