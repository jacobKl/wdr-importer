<?php

namespace WdrGsheetsImporter;

class Templating {

	protected $templates;

	public function init () {
		$this->templates = array();


		add_filter(
			'theme_page_templates', array($this, 'addNewTemplate')
		);

		add_filter(
			'theme_templates', \Closure::fromCallable([$this, 'addNewTemplate'])
		);

		$this->templates = array(
			'wdr-template' => 'Cennik',
		);
			
	} 

	public function addNewTemplate( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}
} 