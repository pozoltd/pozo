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
			'pages' => new \Twig_Filter_Method($this, 'pages'),

		);
	}

	public function jsonDecode($str) {
		return json_decode($str);
	}

	public function ceil($number) {
		return ceil($number);
	}

	public function pages($node) {
		if (count($node->_c) == 0) {
			return '';
		}
		$str = '<ol class="dd-list">';
		foreach ($node->_c as $itm) {
			$str .= '<li class="dd-item dd3-item content-container" data-id="' . $itm->id . '">';
			$str .= '<div class="dd-handle dd3-handle"></div>';
			$str .= '<div class="dd3-content">';
			$str .= '<span>' . $itm->title . '</span>';
			$str .= '<a href="/pz/content/edit/7/' . Utils::encodeURL(Utils::getURL()) . '/' . $itm->id  . '/" class="edit btn-xs btn-circle btn-info"><i class="fa fa-pencil"></i></a>';
 			$str .= '<a href="#" class="delete content-delete btn-xs btn-circle btn-warning" data-content="' . $itm->id . '" data-model="' . $itm->modelId . '"><i class="fa fa-times"></i></a>';
			$str .= '</div>';
			$str .= $this->pages($itm);
			$str .= '</li>';
		}
		$str .= '</ol>';
		return $str;
	}
}