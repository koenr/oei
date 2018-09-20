<?php
class Blad {
	
	//moet dezelfde naam hebben als in tabel

	private $id;
	private $inschrijvingsnummer;
	private $titel;
	private $aangemaakt;
	private $laatst_bewerkt;
	private $commentaar;
	private $kan_bewerken;
	private $verbeterd;
	private $semester;
	private $gelezen;
	
	private $fouten; //array van objecten van klasse Fout
	
	/* CONSTRUCTOR 
	 * 
	 * Eerste alle data ophalen van het blad -> in variabelen
	 * Daarna alle fouten van het bad als objecten in een array 'fouten' opslaan
	 */
	
	public function __construct($blad_id=false){
		
	  if($blad_id){
		$blad_id = HelperFuncties::safety($blad_id);
		
		/* bladdata ophalen */
		$result = mysqli_query(Verbinding::$link,"SELECT * FROM bladen WHERE id='".$blad_id."'");
		$blad = mysqli_fetch_assoc($result);
		
		foreach($blad as $naam=>$waarde){
			$this->$naam = $waarde;
		}
		
		/* fouten id's ophalen en als object opslaan in array fouten*/
		$this->fouten = array();
		
		$fouten = mysqli_query(Verbinding::$link,"SELECT id FROM fouten WHERE blad_id='".$this->id."' ORDER BY id ASC");
		
		while($fout = mysqli_fetch_assoc($fouten)){
			$this->fouten[] = new Fout($fout['id']);
		}
	  }
	}
	
	/* Er wordt gecontroleerd of de bewerker/bekijker ook eigenaar is van het blad */
	public function controleerEigenaar($inschrijvingsnummer){
			if($this->inschrijvingsnummer == $inschrijvingsnummer){
				return true;
			}else{
				return false;
			}
		}
		
		
		/* een fout toevoegen aan het blad */
	public function maakFout(){

		if(mysqli_query(Verbinding::$link,"INSERT INTO fouten (blad_id) VALUES ('".$this->id."')")){
			return true;
		}else{
			return false;
		}
		
	}	
	
	
	/* LEERLING: kan het blad bewaren 
	 * laatst bewerkt wordt bijgewerkt: DATETIME*/
	public function bewaarBlad($titel){
		$titel = HelperFuncties::safety($titel);
		$laatst_bewerkt = date("Y-m-d H:i:s");
		if(mysqli_query(Verbinding::$link,"UPDATE bladen SET titel='".$titel."', laatst_bewerkt='".$laatst_bewerkt."' WHERE id='".$this->geefID()."'" )){
			return true;
		}else{
			return false;
		}
		
	}
	
	/* Fout verwijderen uit blad */
	public function verwijderFout($fout_id,$inschrijvingsnummer_eigenaar){
		if($inschrijvingsnummer_eigenaar == $this->inschrijvingsnummer){
			if(mysqli_query(Verbinding::$link,"DELETE FROM fouten WHERE id='".$fout_id."' ")){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		
		
	
	}
	
	/* Foutomschrijving ophalen op basis van de foutnr
	 * 
	 * RETURN:
	 * een array:(0=>titel,1=>omschrijving ,grammatica)
	 * 
	 *  */
	public function geefFoutOmschrijving($foutnr){

		$this->query = mysqli_query(Verbinding::$link,"SELECT * FROM foutomschrijvingen WHERE foutnr = '".$foutnr."'");
		$fout = mysqli_fetch_assoc($this->query);
		
		return array($fout['titel'],$fout['omschrijving'],$fout['grammatica']);
	}
	
	/* GETTERS */
	public function geefID(){
		return $this->id;
	}
	
	public function geefInschrijvingsnummer(){
		return $this->inschrijvingsnummer;
	}
	
	public function geefTitel(){
		return $this->titel;
	}
	
	public function geefAangemaakt(){
		return $this->aangemaakt;
	}
	
	public function geefLaatstBewerkt(){
		return $this->laatst_bewerkt;
	}
	
	public function geefCommentaar(){
		return $this->commentaar;
	}
	
	public function geefKanBewerken(){
		return $this->kan_bewerken;
	}
	
	public function geefVerbeterd(){
		return $this->verbeterd;
	}
	
	public function geefSemester(){
		return $this->semester;
	}
	
	public function geefGelezen(){
		return $this->gelezen;
	}
	
	public function geefFouten(){
		return $this->fouten;
	}
	
	
	/* SETTERS */
	
	/* De gelezenstatus van het blad veranderen */
	public function setGelezen($status){
		$this->gelezen = $status;
		if(mysqli_query(Verbinding::$link,"UPDATE bladen SET gelezen = '".$status."' WHERE id='".$this->geefID()."'")){
			return true;
		}else{
			return false;
		}
	}
	
	/* De algemene commentaar van het blad veranderen */
	public function setCommentaar($commentaar){
		$this->commentaar = $commentaar;
		if(mysqli_query(Verbinding::$link,"UPDATE bladen SET commentaar = '".$this->geefCommentaar()."' WHERE id='".$this->geefID()."'")){
			return true;
		}else{
			return false;
		}
	}
}