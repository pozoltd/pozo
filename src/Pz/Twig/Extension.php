<?php
namespace Pz\Twig;

use \Twig_Extension;
use Pz\Common\Utils;

class Extension extends Twig_Extension {

	public function getName() {
		return 'some.extension';
	}

	public function getFilters() {
		return array(
			'json_decode' => new \Twig_Filter_Method($this, 'jsonDecode'),
			'ceil' => new \Twig_Filter_Method($this, 'ceil'),
		);
	}

	public function jsonDecode($str) {
		return json_decode($str);
	}

	public function ceil($number) {
		return ceil($number);
	}
}