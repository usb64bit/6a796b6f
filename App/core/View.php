<?php

/**
 * handles all template and outputs
 */
class View
{
	private $args;
	private $layout = 'layout.php';
	private static $folder;
	private static $file;
	private static $instance;
	
	/**
	 * getter
	 * 
	 * @param type $name
	 * @return type $name
	 */
	public function __get($name) {
		if(empty($this->args[$name]))
			$this->args[$name] = '';
		if($name == 'script' && !empty($this->args[$name]))	{
			$returnvar = '';
			foreach($this->args[$name] as $key)	{
				$returnvar .= '<script type="text/javascript" src="'. PATH . 'js/' . $key . '"></script>';
			}
			$this->args[$name] = $returnvar;
		}
        return $this->args[$name];
    }
	
	//setters
	public function __set($key, $value){ $this->args[$key] = $value; }
	
	//sets folder
	public static function setFolder($folder) {
		self::$folder = $folder;
	}
	
	//static
	public static function setView($file){
		self::$file = APP_PATH . 'view' . DS . self::$folder . DS  . $file . '.php';
	}
	
	//dynamic
	public function set_view($file)
	{
		self::$file = APP_PATH . 'view' . DS . self::$folder . DS  . $file . '.php';
	}
	
	public function setLayout($file){ 
		$this->layout = $file;
	}
	
	//loads 404 file
	public function load404(){
		include_once(APP_PATH . 'view' . DS . '404' . DS . '404.php');
	}
	
	/**
	 * loads template and renders webpage
	 */
    public function render() {
		if (isset($this->args))
			extract($this->args);
		if(file_exists(self::$file)){
			include self::$file;
			$this->viewContent = ob_get_contents();
			ob_end_clean();
			include (APP_PATH . 'template' . DS . $this->layout . '.php');
		}else{
			$this->load404();
			throw new Exception(self::$file .': view does not exist');}
		echo '<br/>rendered in: ' . round(microtime(true) - START_TIME, 5);
    }
	
	public static function getInstance(){
		if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;}
        return self::$instance;
	}
		
}