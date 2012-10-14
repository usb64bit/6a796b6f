<?php

class indexController extends Core{
	
	public function init()
	{
		parent::setDynamic('index');
	}
	
	public function indexAction()
	{
		echo ' <br/> asdf<pre> ';
		$this->view->set_view('test');
	}
}