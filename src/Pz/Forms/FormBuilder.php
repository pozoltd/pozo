<?php

namespace Pz\Forms;

use Pz\Common\Utils;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;


class FormBuilder extends AbstractType
{

    protected $app;
    protected $formDescriptor;
    protected $options;

    public function __construct($formDescriptor, $app, $options = array())
    {
        $this->formDescriptor = $formDescriptor;
        $this->app = $app;
        $this->options = $options;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        while (@ob_end_clean());
        $fields = json_decode($this->formDescriptor->fields);
        foreach ($fields as $key => $field) {
//            Utils::dump($field);
            $builder->add($field->id, $field->widget, $this->getOptionsForField($field));
        }

        $builder->add('antispam', new \Pz\Forms\Types\Robot(), array(
            "mapped" => false,
            'label' => '',
            'constraints' => array(
                new \Pz\Forms\Constraints\Robot(),
            )
        ));
//        exit;
    }

    public function getName()
    {
        return 'form_' . $this->formDescriptor->code;
    }

    public function getOptionsForField($field)
    {
        $options = array(
            'label' => $field->label
        );

        switch ($field->widget) {
            case 'choice':
                $options['choices'] = $this->getChoicesForField($field);
                $options['multiple'] = false;
                $options['expanded'] = false;
                break;
            case 'repeated':
                $options['type'] = 'password';
                $options['invalid_message'] = 'The password fields must match.';
                $options['options'] = array('attr' => array('class' => 'password-field'));
                $options['required'] = true;
                $options['first_options'] = array('label' => 'Password:');
                $options['second_options'] = array('label' => 'Repeat Password:');
                break;
        }

        $constraints = $this->getValidationForField($field);
        if (count($constraints) > 0) {
            $options['constraints'] = $constraints;
        }

        return $options;
    }


    public function getChoicesForField($field)
    {
        if (isset($field->sql)) {
            $conn = $this->app['em']->getConnection();
            $stmt = $conn->executeQuery($field->sql);
            $stmt->execute();
            $choices = array();
            foreach ($stmt->fetchAll() as $key => $val) {
                $choices[$val['key']] = $val['value'];
            }
            return $choices;
        }
        return array();
    }


    public function getValidationForField($field)
    {

        $validations = array();

        if ($field->widget == 'email') {
            $validations[] = new Assert\Email();
        }

        if (isset($field->required) && $field->required) {
            $validations[] = new Assert\NotBlank();
        }

        return $validations;
    }

}
