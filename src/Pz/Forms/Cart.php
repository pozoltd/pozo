<?php
namespace Pz\Forms;

use Pz\Common\Utils;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Cart extends AbstractType
{

    public function getName()
    {
        return 'form';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $order = isset($options['data']) ? $options['data'] : null;
        $countries = array();
        if ($order) {
            $countries = $order->getCountries();
        }

        $builder->add('firstname', 'text', array(
            'label' => 'First name:',
            'constraints' => array(
                new Assert\NotBlank()
            )
        ))->add('lastname', 'text', array(
            'label' => 'Last name:',
            'constraints' => array(
                new Assert\NotBlank()
            )
        ))->add('email', 'email', array(
            'label' => 'Email:',
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Email()
            )
        ))->add('phone', 'text', array(
            'label' => 'Phone:',
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 7
                ))
            )
        ))->add('message', 'textarea', array(
            'label' => 'Message:',
            'constraints' => array(
//                new Assert\NotBlank()
            )
        ))->add('address1', 'text', array(
            'label' => 'Address line 1:',
            'constraints' => array(
                new Assert\NotBlank()
            )
        ))->add('address2', 'text', array(
            'label' => 'Address line 2:',
            'constraints' => array(
//                new Assert\NotBlank()
            )
        ))->add('city', 'text', array(
            'label' => 'City:',
            'constraints' => array(
                new Assert\NotBlank()
            )
        ))->add('postcode', 'text', array(
            'label' => 'Zip / Postal code:',
            'constraints' => array(
                new Assert\NotBlank()
            )
        ))->add('state', 'text', array(
            'label' => 'State / Region:',
            'constraints' => array(
//                new Assert\NotBlank()
            )
        ))->add('country', 'text', array(
            'label' => 'Country:',
            'constraints' => array(
                new Assert\NotBlank()
            )
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            //
            'order' => null,
        ));
    }
}
