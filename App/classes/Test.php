<?php
/**
 * image uploader handler
 *  
 * usage:
 *		$iu = new imageuploader();
 *		$iu->saveFile();
 */
class ImageUploader
{
	/////////////////////
	// config varibles //
	/////////////////////
	
	//set size Limit;
	private $limit = 300000;
	
	//create thumbnails? true or false;
	const thumbnails = true;
	
	//max width of thumbnail in pixels;
	private $thumbSize = 200;
	
	//allowed extensions
	private $allowed = array('.jpg','.jpeg','.gif','.png');
	
	//end of config
	private $path;
	private $size;
	private $name;
	private $type;
	private $error;
	private $tmp;

	/**
	 * main function of fileHandler 
	 */
	public function saveFile($path)
	{
		try{
		if(!isset($_FILES))
			throw new Exception('$_FILES is not set');
		
		$this->setPath($path);

		if(!$this->setFiles())
			throw new Exception('set files failed');
		//return true;
		}catch(Exception $e)	{
			echo $e->getMessage();
		}
	}
	
	/**
	 * prepends Year_month_date to file
	 * 
	 * @return type date
	 */
	public function prependFileName()
	{
		return date("Y_m_d_"); //edit to your liking
	}
	
	public function setFiles(){
		foreach($_FILES as $file)
		{
			$this->name		= $this->prependFileName() . $file['name'];
			$this->tmp		= $file['tmp_name'];
			$this->error	= $file['error'];
			$this->size		= $file['size'];
			$this->type		= $file['type'];
			
			$ext = strrchr($this->name, '.');
			if($this->error == 0)
			{
				if(!$this->moveFile())
					throw new Exception("move file is not sucessful check to " . $this->fullPath);
				//check if thumbnails
				if(ImageUploader::thumbnails)
				{
					
				}
				
			}
		}
		return true;
	}
			 
	/**
	 * handles single image files from $_FILES
	 * moves and renames;
	 * 
	 * @return type bool
	 */
	public function moveFile()
	{
		//check for thumbnails
		return (move_uploaded_file($this->tmp, $this->fullpath . $this->name))
				  ? true:false;
	}
	
	/**
	 * sets full path to where the imgs need to go
	 * @param type $path 
	 */
	public function setPath($path){
		$this->fullpath = $path;
	}
}