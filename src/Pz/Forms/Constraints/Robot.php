<?php
namespace Pz\Forms\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Robot extends Constraint
{
	public $message = 'Please try again';
}