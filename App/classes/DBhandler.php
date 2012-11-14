<?php

class DBhandler
{
	private $host= "Localhost";
	private $user= "47278";
	private $pass= "cis47278";
	private $db; //db handler
	private $st; //statement handler
	protected $rs = array(); //return statement
	
	//inserts query
	public function insert($data)
	{
		$this->connect();
		$this->st = $this->db->prepare($this->format_data($data));
		$this->bind_params($this->set_binds($data));
		if($this->st->exec())
			return true;
		else
		{
			if(DEV)
				throw new Exception($this->st->errorCode());
			return false;
		}
	}
	
	public function bind_params($params)
	{
		foreach($params as $key => &$val)
		{
			$this->st->bindParam($key, $val);
		}
	}
	public function query($query)
	{
		$this->connect();
		$this->st = $this->db->query($query);
		if($this->st->exec())
			return true;
		else 
			return false;
		
	}
	public function prepare($query, $data)
	{
		$this->connect();
		$this->st = $this->db->prepare($query);
		$this->bind_params($this->set_binds($data));
		if($this->st->exec())
			return true;
		else
			return false;
	}
	
	public function return_array()
	{
		while($row = $this->st->fetch(PDO::FETCH_ASSOC))
			$this->rs[] = $row;
		return (count($this->rs))? $this->rs: false;
	}
	
	public function set_binds($data)
	{
		$array = array();
		foreach($data as $key => $value)
		{
			$array[':'.$key] = $value;
		}
		return $array;
	}
	
	/**
	 * format_data formats array data into a query string
	 * 
	 * @param type $data
	 * @return string querys
	 */
	public function format_data($data)
	{
		$query = "INSERT into $this->table ";
		$insert = array();
		$values = array();
		foreach($data as $key => $value)
		{
			$insert[] = $key;
			$values[] = ':'.$key;
		}
		$query .= '(' . implode(',', $insert). ") VALUES ('" . implode("','",$values) ."')";
		//change
		
		return $query;
	}
	
	/**
	 * creates new PDO
	 */
	public function connect()
	{
		if(!DEV)
			$this->db = new PDO('mysql:host='.$this->host.';dbname=47278', $this->user, $this->pass);
		else
			$this->db = new PDO('mysql:host=localhost;dbname=47278', 'root', '');
	}
	
	public function asdf()
	{
		return $this->host;
	}
	
	/**
	 * closes PDO handler
	 */
	public function close()
	{
		$this->db = null;
	}
}