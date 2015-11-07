<?php
namespace Pz\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Model extends AbstractType {

	public function getName() {
		return 'form';
	}

	public function buildForm(FormBuilderInterface $builder, array $options) {
		parent::buildForm($builder, $options);
		
		$builder->add('label', 'text', array(
			'label' => 'Name:',
			'constraints' => array(
				new Assert\NotBlank()
			)
		))->add('className', 'text', array(
			'label' => 'Class name:',
			'constraints' => array(
				new Assert\NotBlank()
			)
		))->add('modelType', 'choice', array(
			'label' => 'Model type:',
			'expanded' => true,
			'data' => 0,
			'choices' => array(
					0 => 'Customised',
					1 => 'Built in',
			)
		))->add('dataType', 'choice', array(
			'label' => 'Data type:',
			'expanded' => true,
			'data' => 0,
			'choices' => array(
				0 => 'User',
				1 => 'Admin',
				2 => 'Invisible',
			)
		))->add('listType', 'choice', array(
			'label' => 'Listing type:',
			'expanded' => true,
			'data' => 1,
			'choices' => array(
				1 => 'Full list',
				2 => 'Nested tree',
				0 => 'Pagination',
			)
		))->add('numberPerPage', 'text', array(
			'data' => 25,
			'label' => 'Limit:',
		))->add('defaultSortBy', 'choice', array(
			'label' => 'Sort:',
			'choices' => array(
			)
		))->add('defaultOrder', 'choice', array(
			'label' => 'Order:',
			'data' => 0,
			'expanded' => true,
			'choices' => array(
					0 => 'ASC',
					1 => 'DESC'
			)
		))->add('columnsJson', 'hidden');
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		parent::setDefaultOptions($resolver);
	}
}
