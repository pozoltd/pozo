<?php
namespace Pz\Forms\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RobotValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $myvars = 'response=' . $_POST['g-recaptcha-response'] . '&secret=' . RECAPTCHA_SERVER;

//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $response = curl_exec($ch);

        $response = file_get_contents("{$url}?{$myvars}");
//		var_dump($value, $_POST['g-recaptcha-response'], $response);exit;
        $response = json_decode($response);
        if (!$response || !$response->success) {
            $this->context->addViolation(
                $constraint->message,
                array()
            );
        }
    }
}