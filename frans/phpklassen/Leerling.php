<?php
class Leerling extends Gebruiker{
	
	
	//moet dezelfde naam hebben als in tabel
	private $id;
	private $inschrijvingsnummer;
	private $voornaam;
	private $achternaam;
	private $email;
	private $klas_id;
	private $klasnr;
	private $sterkpunt1_id;
	private $sterkpunt2_id;
	private $zwakpunt1_id;
	private $zwakpunt2_id;
	private $sterkpunt1_opnieuw;
	private $zwakpunt1_opnieuw;
	private $sem1_punten;
	private $sem1_totaal;
	private $sem2_punten;
	private $sem2_totaal;
	private $sem1_verbeterd;
	private $sem2_verbeterd;
	private $gebruiker_id;
	private $achtergrond;
	private $tekstkleur;
	private $sterkpunt1_vijfde;
	private $sterkpunt2_vijfde;
	private $zwakpunt1_vijfde;
	private $zwakpunt2_vijfde;
	
	private $default_type = 1; //type van de gebruiker
	
	private $laatste_error;
	
	
	private $bladen; //verzameling van bladen van de leerling
	
	/*
	 * CONSTRUCTOR 
	 * $inschrijvingsnummer: het inschrijvingsnummer van de leerling
	 * $bladenorderby: De bladen van de leerling worden opgehaald in een bepaalde volgorde: default 
	 * 
	 * Alle data van de leerling wordt opgehaald en in variabelen gestoken
	 * Alle bladen van de leerlinge worden als objecten in een array 'bladen' gestoken
	 * 
	 */
	public function __construct($inschrijvingsnummer="",$bladenorderby=" kan_bewerken DESC, laatst_bewerkt DESC"){ //als inschrijvingsnummer niet wordt meegegeven is de gebruiker nog niet ingelogd
		
		if($inschrijvingsnummer!==""){
		/* leerlinginfo ophalen */
		$result = mysqli_query(Verbinding::$link,"SELECT * FROM leerlingen WHERE inschrijvingsnummer='".$inschrijvingsnummer."'");
		$leerling = mysqli_fetch_assoc($result);
		
		foreach($leerling as $naam=>$waarde){
			$this->$naam = $waarde;
		}
		
	
		/* bladen id's ophalen en bladobjecten opslaan in array bladen */
		
		$this->bladen = array();
		
		
		$bladen = mysqli_query(Verbinding::$link,"SELECT id FROM bladen WHERE inschrijvingsnummer='".$inschrijvingsnummer."' ORDER BY ".$bladenorderby."");
			while($blad = mysqli_fetch_assoc($bladen)){
				$this->bladen[] = new Blad($blad['id']);
			}
		}
		
	}
	
	/* Bladen invoegen
	 * Titel van het blad
	 * Semester bepaald in welke semestermap het blad terechtkomt
	 * */
	public function maakBlad($titel){
		$titel = HelperFuncties::safety($titel);
		$aangemaakt = date("Y-m-d");
		$laatst_bewerkt = date("Y-m-d H:i:s");
		$semester = HelperFuncties::geefSemester();
		if(mysqli_query(Verbinding::$link,"INSERT INTO bladen (inschrijvingsnummer,titel,aangemaakt,laatst_bewerkt,semester) VALUES ('".$this->inschrijvingsnummer."','".$titel."','".$aangemaakt."','".$laatst_bewerkt."','".$semester."')")){
			return true;
		}else{
			return false;
		}
	}
	
	/*Verwijderen
	 * 
	 * Enkel als het blad van de gebruiker is kan het blad worden verwijderd
	 * Eerst wordt het blad verwijderd daarna alle fouten die in het blad zaten
	 * 
	 */
	public function verwijderBlad($blad_id){
		$blad = new Blad($blad_id);
		if($this->inschrijvingsnummer == $blad->geefInschrijvingsnummer()){ //eigenaarcontrole
			
			$query = "DELETE FROM bladen WHERE id='".$blad_id."'";
			
		if(mysqli_query(Verbinding::$link,$query)){
			mysqli_query(Verbinding::$link,"DELETE FROM fouten WHERE blad_id='".$blad_id."'");
			return true;
		}else{
			$this->error = "".mysqli_error(Verbinding::$link);
			return false;
		}
	}
	}
				
		
	
	
	/* BEPAAL RESULTAAT 
	 * Geef een procent met de punten van sem1 of sem2 terug
	 */
	public function bepaalResultaat($semester){
		if($semester==1){
			$procent = (100*$this->geefSem1Punten()/$this->geefSem1Totaal())."";
		}else{
			$procent = (100*$this->geefSem2Punten()/$this->geefSem2Totaal())."";
		}
		
		return round($procent)."%"; 
	}
	
	/* GETTERS */
	
	public function geefDefaultType(){
		return $this->default_type;
	}
	
	public function geefVoornaam(){
		return $this->voornaam;
	}
	
	public function geefAchternaam(){
		return $this->achternaam;
	}
	
	public function geefID(){
		return $this->id;
	}
	
	public function geefEmail(){
		return $this->email;
	}
	
	public function geefInschrijvingsnummer(){
		return $this->inschrijvingsnummer;
	}
	
	public function geefKlasID(){
		return $this->klas_id;
	}
	
	public function geefKlasNr(){
		return $this->klasnr;
	}

	public function geefSterkpunt1_id(){
		return $this->sterkpunt1_id;
	}
	
	public function geefSterkpunt2_id(){
		return $this->sterkpunt2_id;
	}
	
	public function geefSterkZwakPunt($sterkOFzwak,$semester){
		if($sterkOFzwak == "sterk"){
		
			if($semester == 1){return $this->geefSterkpunt1_id();}
			elseif($semester == 2){return $this->geefSterkpunt2_id();}else{return false;}
		}elseif($sterkOFzwak == "zwak"){
			if($semester == 1){return $this->geefZwakpunt1_id();}elseif($semester == 2){
				return $this->geefZwakpunt2_id(); }else{return false;}
		}else{
		
			return false;
			
		}
	}
	
	public function geefZwakpunt1_id(){
		return $this->zwakpunt1_id;
	}
	
	public function geefZwakpunt2_id(){
		return $this->zwakpunt2_id;
	}
	
	public function geefSterkpunt1_opnieuw(){
		return $this->sterkpunt1_opnieuw;
	}
	
	public function geefZwakpunt1_opnieuw(){
		return $this->zwakpunt1_opnieuw;
	}
	
	public function geefSem1Punten(){
		return $this->sem1_punten;
	}
	
	public function geefSem2Punten(){
		return $this->sem2_punten;
	}
	
	public function geefSem1Totaal(){
		return $this->sem1_totaal;
	}
	
	public function geefSem2Totaal(){
		return $this->sem2_totaal;
	}
	
	public function geefSem1Verbeterd(){
		return $this->sem1_verbeterd;
	}
	
	public function geefSem2Verbeterd(){
		return $this->sem2_verbeterd;
	}
	
	public function geefGebruikerID(){
		return $this->gebruiker_id;
	}
	
	public function geefLaatsteError(){
		return $this->laatste_error;
		
	}
	
	public function geefAchtergrond(){
		return $this->achtergrond;
	}
	
	public function geefTekstkleur(){
		return $this->tekstkleur;
	}
	
	public function geefSterkpunt1_vorigjaar(){
		$query = mysqli_query(Verbinding::$link,"SELECT * FROM sterkezwakke_punten_vorigjaar WHERE inschrijvingsnummer = '".$this->inschrijvingsnummer."'") or die(mysqli_error(Verbinding::$link));
		$return = false;
		if($punt = mysqli_fetch_object($query)){
			$return = $punt->sterkpunt1;
		}
		
		return $return;
	}
	
	public function geefSterkpunt2_vorigjaar(){
		$query = mysqli_query(Verbinding::$link,"SELECT * FROM sterkezwakke_punten_vorigjaar WHERE inschrijvingsnummer = '".$this->inschrijvingsnummer."'");
		$return = false;
		if($punt = mysqli_fetch_object($query)){
			$return = $punt->sterkpunt2;
		}
		
		return $return;
	}
	
	public function geefZwakpunt1_vorigjaar(){
		$query = mysqli_query(Verbinding::$link,"SELECT * FROM sterkezwakke_punten_vorigjaar WHERE inschrijvingsnummer = '".$this->inschrijvingsnummer."'");
		$return = false;
		if($punt = mysqli_fetch_object($query)){
			$return = $punt->zwakpunt1;
		}
		
		return $return;
	}
	
	public function geefZwakpunt2_vorigjaar(){
		$query = mysqli_query(Verbinding::$link,"SELECT * FROM sterkezwakke_punten_vorigjaar WHERE inschrijvingsnummer = '".$this->inschrijvingsnummer."'");
		$return = false;
		if($punt = mysqli_fetch_object($query)){
			$return = $punt->zwakpunt2;
		}		
		return $return;
	}
	

	/* Parameter bepaald het semester waarvan info wordt opgehaal */
	public function geefSemesterVerbeterd($semester){
		if($semester==1){ 
			return $this->geefSem1Verbeterd();
		}else{
			return $this->geefSem2Verbeterd();
		}
	}
	
	/* Parameter bepaald het semester waarvan info wordt opgehaald */
	public function geefSemesterPunten($semester){
		if($semester==1){ 
			return $this->geefSem1Punten();
		}else{
			return $this->geefSem2Punten();
		}
	}
	
		/* Parameter bepaald het semester waarvan info wordt opgehaald */
	public function geefSemesterTotaal($semester){
		if($semester==1){ 
			return $this->geefSem1Totaal();
		}else{
			return $this->geefSem2Totaal();
		}
	}
	
	public function geefBladen(){
		return $this->bladen;
	}
	
		/* Geef bladen van een bepaald semester terug in een array */
	public function geefBladenSem($semester){ //geef bladen van semester $semester
		$aantal_bladen = count($this->bladen);
		$bladen_sem = array();
		for($i=0;$i<$aantal_bladen;$i++){
			if($this->bladen[$i]->geefSemester() == $semester)
				$bladen_sem[] = $this->bladen[$i];
		}
	
		return $bladen_sem;
		
	}
	
	

	/* Toont Voornaam, achternaam, klas, klasnr
	 * edit mode: als op true staat wordt er een edit icoontje weergegeven
	 */	
	public function toonNaamHeader($edit_mode_boolean=false){
		$voornaam = $this->geefVoornaam();
		$achternaam = $this->geefAchternaam();
		$klasnr = $this->geefKlasNr();
		$klas = $this->klasIDNaarKlas($this->geefKlasID());
		
		if($edit_mode_boolean){
			$edit_klas= "<img src='../images/edit.gif' style='border:0px;' title='Wijzig de klas en klasnr' onclick=\"wijzigKlas('".$this->inschrijvingsnummer."')\"/>";
		}else{
			$edit_klas="";
		}
		
		return "<b>$voornaam&nbsp;$achternaam</b>&nbsp;&nbsp;&nbsp;$klasnr&nbsp;&nbsp;&nbsp;$klas $edit_klas<br><br><br>";
		
	}
	
	/*
	 * Toont de header voor leerlingen
	 * Bevat NaamHeader
	 * en een tabel met sterke en zwakke punten
	 * 
	 * Als edit mode true: edit images
	 */
	public function toonLeerlingHeaderHTML($edit_mode_boolean=false){ //standaard boolean
		
$pointfort1 = $this->sterkzwakpuntIDNaarOmschrijving($this->geefSterkpunt1_id());
		if($this->geefSterkpunt1_opnieuw()){
			$pointfort1 = "<span class='opnieuw' >".$pointfort1."</span>";
		}

$pointfort2 = $this->sterkzwakpuntIDNaarOmschrijving($this->geefSterkpunt2_id());
$pointfaible1 = $this->sterkzwakpuntIDNaarOmschrijving($this->geefZwakpunt1_id());
	if($this->geefZwakpunt1_opnieuw()){
			$pointfaible1 = "<span class='opnieuw' >".$pointfaible1."</span>";
		}
$pointfaible2 = $this->sterkzwakpuntIDNaarOmschrijving($this->geefZwakpunt2_id());

if($edit_mode_boolean){
$edit_klas= "<img src='../images/edit.gif' style='border:0px;' onclick = \"wijzigSterkeZwakkePunten('".$this->geefInschrijvingsnummer()."')\" />";
$edit_pointfort1= "<img src='../images/edit.gif' style='border:0px;' onclick = \"wijzigSterkeZwakkePunten('".$this->geefInschrijvingsnummer()."')\" />";
	$edit_pointfort1 .= "<img src='../images/opnieuw.png' title='Leerling moet dit opnieuw doen' onclick= \"sterkpuntOpnieuw('".$this->geefInschrijvingsnummer()."')\" />"; 
$edit_pointfort2= "<img src='../images/edit.gif' style='border:0px;' onclick = \"wijzigSterkeZwakkePunten('".$this->geefInschrijvingsnummer()."')\" />";
$edit_pointfaible1= "<img src='../images/edit.gif' style='border:0px;' onclick = \"wijzigSterkeZwakkePunten('".$this->geefInschrijvingsnummer()."')\" />";
	$edit_pointfaible1 .=  "<img src='../images/opnieuw.png'  title='Leerling moet dit opnieuw doen' onclick= \"zwakpuntOpnieuw('".$this->geefInschrijvingsnummer()."')\"/>"; 
$edit_pointfaible2= "<img src='../images/edit.gif' style='border:0px;' onclick = \"wijzigSterkeZwakkePunten('".$this->geefInschrijvingsnummer()."')\" />";
}else{
$edit_klas= "";
$edit_pointfort1= "";
$edit_pointfort2= "";
$edit_pointfaible1= "";
$edit_pointfaible2= "";
}

echo $this->toonNaamHeader($edit_mode_boolean);


	echo <<<HTML
<table border='1' style="border-collapse:collapse;"  bordercolor='silver'>
<th></th>
<th>Eerste Semester</th>
<th>Tweede Semester</th>
<tr>
	<td><b>Point d'action</b></td>
	<td align="center">$pointfort1 $edit_pointfort1</td>
	<td align="center">$pointfort2 $edit_pointfort2</td>
</tr>
<!--
<tr>
	<td><b>Point <span onclick="layout('F');">F</span>aible</b></td>
	<td align="center">$pointfaible1 $edit_pointfaible1</td>
	<td align="center">$pointfaible2 $edit_pointfaible2</td>
</tr>
-->
</table>
<br>
HTML;
	}
	
	/* Als een leerling in het vorig jaar ook al in het systeem zat kan hij een tabel met sterke 
	 * en zwakke punten van vorig jaar tonen
	 */
	public function toonSterkeZwakkePuntenVorigJaar(){
		$pointfort1 = $this->geefSterkpunt1_vorigjaar();
		$pointfort2 = $this->geefSterkpunt2_vorigjaar();

		$pointfaible1 = $this->geefZwakpunt1_vorigjaar();
		$pointfaible2 = $this->geefZwakpunt2_vorigjaar();
		
	echo <<<HTML
<table border='1' style="border-collapse:collapse; "  bordercolor='silver'>
<caption>Actiepunten van vorig jaar</caption>
<th></th>
<th>Eerste Semester</th>
<th>Tweede Semester</th>
<tr>
	<td><b>Point d’action</b></td>
	<td align="center">$pointfort1 </td>
	<td align="center">$pointfort2 </td>
</tr>
<!--
<tr>
	<td><b>Point <span onclick="layout('F');">F</span>aible</b></td>
	<td align="center">$pointfaible1 </td>
	<td align="center">$pointfaible2 </td>
</tr>
-->
</table>
<br>
HTML;
	
	}
	
	
		/* SETTERS */
	
	public function setAchtergrond($achtergrond){
		$this->achtergrond = HelperFuncties::safety($achtergrond);
		if(mysqli_query(Verbinding::$link,"UPDATE leerlingen SET achtergrond = '".$achtergrond."' WHERE inschrijvingsnummer='".$this->geefInschrijvingsnummer()."'")){
			return true;
		}else{
			return false;
		}
	}
	
	public function setTekstkleur($kleur){
		$this->tekstkleur = HelperFuncties::safety($kleur);
		if(mysqli_query(Verbinding::$link,"UPDATE leerlingen SET tekstkleur = '".$kleur."' WHERE inschrijvingsnummer='".$this->geefInschrijvingsnummer()."'")){
			return true;
		}else{
			return false;
		}
	}
	
		
	
	public static function registreerLeerling($inschrijvingsnummer,$wachtwoord,$voornaam,$achternaam,$sterkpunt1_id,$sterkpunt2_id,$zwakpunt1_id,$zwakpunt2_id,$klas_id,$klasnr){
		
		$inschrijvingsnummer = HelperFuncties::safety($inschrijvingsnummer);
		$voornaam = urldecode($voornaam);
		$voornaam = HelperFuncties::safety($voornaam);		
		$achternaam = urldecode($achternaam);
		$achternaam = HelperFuncties::safety($achternaam);
		$sterkpunt1_id = HelperFuncties::safety($sterkpunt1_id);
		$sterkpunt2_id = HelperFuncties::safety($sterkpunt2_id);
		$zwakpunt1_id = HelperFuncties::safety($zwakpunt1_id);
		$zwakpunt2_id = HelperFuncties::safety($zwakpunt2_id);
		$klas_id = HelperFuncties::safety($klas_id);
		$klasnr = HelperFuncties::safety($klasnr);
		
		$gebruiker_id = Gebruiker::maakGebruiker($inschrijvingsnummer,$wachtwoord,1);
		if($gebruiker_id){
			
		$query = "INSERT INTO leerlingen (inschrijvingsnummer, voornaam, achternaam, klas_id, klasnr, sterkpunt1_id, sterkpunt2_id, zwakpunt1_id, zwakpunt2_id, gebruiker_id, achtergrond, tekstkleur) VALUES ('".$inschrijvingsnummer."','".$voornaam."','".$achternaam."','".$klas_id."','".$klasnr."','".$sterkpunt1_id."','".$sterkpunt2_id."','".$zwakpunt1_id."','".$zwakpunt2_id."','".$gebruiker_id."','../images/achtergronden/gnome-green.png','black') ";
			//echo $query;	
		if(mysqli_query(Verbinding::$link,$query)){
				return true;
			}else{
				Gebruiker::verwijderGebruiker($gebruiker_id);
				die(mysqli_error(Verbinding::$link));
				return false;
			}
		}else{
			return false;
		}
	}
	
	
	
		
	

	
	
	
	
}
