<?php

/*
 * core
 */
class Core{

	private static $instance;
	private static $_class;			//Class to load
	private static $_action;		//Action to run
	public $url;					//url array
	public $view;
	
	/**
	 * creates Core object
	 */
	function __construct(){
		$this->view = View::getInstance();
		self::$instance = &$this;
		$this->parseUrl();
	}
	
	/**
	 * runs application
	 */
	public function run()
	{
		ob_start();
		$this->view->setLayout('layout');
		$this->setRoute($this->url[0], $this->url[1]);
		if(method_exists(self::getClass(), 'init'))
			self::getClass()->init();
		$class	= self::getClass();
		$action = self::getAction();
		if(method_exists($class, $action))
			$class->$action();
		else{
			echo 'method does not exists why? ';
			var_dump($class);
			throw new Exception('404 at core->run()', '404');
		}
		$this->view->render();
	}
	
	/**
	 * parses url into an array
	 * 
	 * www.example.com/test/index/asdf 
	 * as array('test','index','asdf')
	 */
	public function parseUrl(){
		$this->url = explode(' ',trim(str_replace('/', ' ', $_SERVER['REQUEST_URI'])));
		
		//if url has only 1 it pushes index so we can get index controller
		if (count($this->url) <= 1) array_push($this->url, 'index');
		
		//goes through each uri, if null puts index such as www.test.com/test/ adds index
		foreach($this->url as &$value){
			if(!empty($_SERVER['QUERY_STRING'])){
				if (strpos($value, $_SERVER['QUERY_STRING']) !== false)
					$value = str_replace('?' . $_SERVER['QUERY_STRING'], '', $value);
				if ($value == '')
					$value = 'index';
			}
			elseif($value == '')
				$value = 'index';			
		}
	}
	
	/*
	 * setters and getters
	 */
	
	public static function setClass($class){
		self::$_class = $class . 'Controller';
	}
	
	public static function setDynamic($action){
		self::setAction($action);
		View::setView($action);
	}
	
	public static function getClass(){
		return new self::$_class;
	}
	
	public static function setAction($action){
		self::$_action = $action . 'Action';
	}
	
	public static function getAction(){
		return self::$_action;
	}
	
	/**
	 * returns url array or part of url
	 * 
	 * @param type $part integer corresponding in array
	 * @return type Array URL
	 */
	public function getUrl($part = null){
		if ($part == null)
			return $this->url;
		else{
			if(!empty($this->url[$part]))
				return $this->url[$part];
			else
				throw new Exception('404','404');
		}
	}

	/**
	 * sets view folder, and setView
	 * 
	 * @param type $class controller
	 * @param type $index action
	 */
	public function setRoute($class, $index = 'index'){
		View::setFolder($class);
		View::setView($index);
		self::setClass($class);
		self::setAction($index);
	}
}