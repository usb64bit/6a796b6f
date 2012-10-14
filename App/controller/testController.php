<?php

class testController extends Core{
	
	public function init()
	{
		parent::setDynamic('index');
	}
	
	public function indexAction()
	{
		$test = new Test();
		$test->asdf();
	}
}