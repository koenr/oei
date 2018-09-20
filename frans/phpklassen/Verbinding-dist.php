<?php

class Verbinding{
	
	/* Default parameters */
	private $default_host = "localhost";
	private $default_user = "oeidb";
	private $default_pass = "oeidb";
	private $default_db = "oei_frans";
	
	/* gebruikte parameters 
	 * De parameters die daadwerkelijk zullen gebruikt worden om te connecteren
	 * Als er in de constructor geen nieuwe gegevens worden ingegeven zullen de default parameters ingevuld worden
	 * */ 


	private $host;
	private $user;
	private $pass;
	private $db;

	public static $link = NULL;
	
	
	public function __construct($host=false,$user=false,$pass=false,$db=false){
		if(!$host){$this->host=$this->default_host;}
		if(!$user){$this->user=$this->default_user;}
		if(!$pass){$this->pass=$this->default_pass;}
		if(!$db){$this->db=$this->default_db;}
	
	}
	
	public function connect(){
	

		if(Verbinding::$link = mysqli_connect($this->host,$this->user,$this->pass))
			{
				mysqli_select_db(Verbinding::$link, $this->db);
				mysqli_query(Verbinding::$link,"SET NAMES 'utf8'");
			}
	
	}
}

?>