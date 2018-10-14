<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Defines the form used to create and manipulate user login.
 * @author Florian Mornet <florian.mornet@enseirb-matmeca.fr>
 */
class LoginType extends AbstractType
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * LoginType constructor.
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('_target_path', HiddenType::class)
            ->add('submit', SubmitType::class, array('label' => 'Login'))
        ;

        $authUtils = $this->authenticationUtils;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($authUtils) {
            // Get login errors (if any)
            $error = $authUtils->getLastAuthenticationError();
            if ($error) {
                $event->getForm()->addError(new FormError($error->getMessage()));
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // This form has no data class (User entity does not match)
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
