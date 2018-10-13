<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Event name'))
            ->add('location', TextType::class, array('label' => 'Event location (optional)', 'required' => false))
            ->add('category', TextType::class, array('label' => 'Category (optional)', 'required' => false))
            ->add('hoster', TextType::class, array('label' => 'Event hoster'))
            ->add('poster', TextType::class)
            ->add('date_start', DateType::class, array('label' => 'Date when this event starts', 'widget' => 'single_text'))
            ->add('date_end', DateType::class, array('label' => 'Date when this event ends (optional)', 'widget' => 'single_text', 'required' => false))
            ->add('time_start', TimeType::class, array('label' => 'Time when this event starts', 'widget' => 'single_text'))
            ->add('time_end', TimeType::class, array('label' => 'Time when this event ends (optional)', 'widget' => 'single_text', 'required' => false))
            ->add('description', TextareaType::class, array('label' => 'Description', 'required' => false))
            ->add('phone', TelType::class, array('label' => 'Phone number to call (optional)', 'required' => false))
            ->add('email', EmailType::class, array('label' => 'Contact email address'))
            ->add('save', SubmitType::class, array('label' => 'Add'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
