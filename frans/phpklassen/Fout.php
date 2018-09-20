<?php
class Fout{

		//variabelen moet dezelfde naam hebben als in tabel
	private $id;
	private $blad_id;
	private $foutnr;
	private $fout;
	private $verbetering;
	private $verantwoording;
	private $commentaar;
	private $leerkracht_bekeken;
	
	/* CONSTRUCTOR
	 * 
	 * In de constructor klasse wordt alle data van de fout opgehaald en in de variabelen gestoken
	 */
	
	public function __construct($fout_id){
		
		/* foutdata ophalen */
		$result = mysqli_query(Verbinding::$link,"SELECT * FROM fouten WHERE id='".$fout_id."'");
		$fout = mysqli_fetch_assoc($result);
		
		foreach($fout as $naam=>$waarde){
			$this->$naam = $waarde;
		}
	}
	
	/* LEERLING: kan deze functie gebruiken om de fout tijdens het bewerken op te slaan */
	public function bewaarFout($fout_id,$foutnr,$fout,$verbetering,$verantwoording){
				
		$foutnr = HelperFuncties::safety($foutnr);
		$fout = HelperFuncties::safety($fout);
		$verbetering = HelperFuncties::safety($verbetering);
		$verantwoording = HelperFuncties::safety($verantwoording);
		$foutid = HelperFuncties::safety($fout_id);

		$laatst_bewerkt = date("Y-m-d H:i:s");
		$query = "UPDATE fouten SET foutnr='".$foutnr."', fout='".$fout."',verbetering='".$verbetering."',verantwoording='".$verantwoording."' WHERE id='".$fout_id."'" ;
		if(mysqli_query(Verbinding::$link,$query)){
			
			return true;
		}else{
			echo"mysql probleem";
			die(mysqli_error(Verbinding::$link));
			return false;
		}
		
	}
	
	/* LEERKRACHT: fout die verbeterd wordt opslaan */
	public function bewaarFoutVerbetering($fout_id,$commentaar,$bekeken){

		$fout_id = HelperFuncties::safety($fout_id);
		$commentaar = HelperFuncties::safety($commentaar);
		$bekeken = HelperFuncties::safety($bekeken);
		
		if($commentaar !== ""){ $blad = new Blad($this->blad_id); $blad->setGelezen(0);} //als er commentaar gegeven wordt -> dan is het blad ongelezen verklaart voor de leerling
		
	
		
		$query = "UPDATE fouten SET commentaar='".$commentaar."',leerkracht_bekeken='".$bekeken."' WHERE id='".$fout_id."'" ;
		if(mysqli_query(Verbinding::$link,$query)){
			
			return true;
		}else{
			echo"mysql probleem";
			die(mysqli_error(Verbinding::$link));
			return false;
		}
		
	}
	
	/* GETTERS */
	public function geefID(){
		return $this->id;
	}
	public function geefBladID(){
		return $this->blad_id;
	}
	public function geefFoutnr(){
		return $this->foutnr;
	}
	public function geefFout(){
		return $this->fout;
	}
	public function geefVerbetering(){
		return $this->verbetering;
	}
	public function geefVerantwoording(){
		return $this->verantwoording;
	}
	public function geefCommentaar(){
		return $this->commentaar;
	}
	public function geefLeerkrachtBekeken(){
		return $this->leerkracht_bekeken;
	}
	
	
	

}