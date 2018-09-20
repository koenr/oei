<?php
class HelperFuncties{

	/* tegen sql injection 
	 * Als magiq quotes aanstaan worden er automatisch slashed toegevoegt, deze worden gestripped 
	 * Daarna wordt alles naar &-tekens omgezet vb: &euro;*/ 
	public static function safety($return){
		/*
  		 if( get_magic_quotes_gpc() ){
      $return = stripslashes($return);
      }
		$return = htmlentities($return,ENT_QUOTES);
		*/
		$return = mysqli_real_escape_string(Verbinding::$link,$return);
   		return $return;
   }

	public static function escapeForHtmlUse($value){		
   		return htmlspecialchars($value,ENT_QUOTES,'utf-8');
   }
   
   
   /* De functie die gebruikt wordt om de wachtwoorden te coderen */
  static  function codeer($string=null){
   	   return md5(sha1(md5($string)));
   }
 
   /* Bepaalt in welk semester we zitten 
    * Vanaf januari is het het tweede semester
    */
   function bepaalSemester(){
   	$maand = date("m");
		if($maand >= 9 && $maand <= 12){
			$semester = 1;
		}else{
			$semester = 2;
		}
	return $semester;
   }	
  
   
      /* STATIC: Bepaalt in welk semester we zitten 
    * Vanaf januari is het het tweede semester
    */
  public static function geefSemester(){
 	  	$maand = date("m");
		if($maand >= 9 && $maand <= 12){
			$semester = 1;
		}else{
			$semester = 2;
		}
	return $semester;
  }
  
  /* Als je het huidige semester ingeeft, krijg je het vorige of volgende semester 
   * vb:
   * 1 -> 2
   * 2 -> 1
   */
 public static function geefAnderSemester($huidig_sem){
  	if($huidig_sem == 1){
  		return 2;
  	}else{
  		return 1;
  	}
  }
  
  /* Semester in tekstvorm */
 public static function semesterNaarTekst($semester){
  	if($semester==1){
  		return "Eerste Semester";
  	}else{
  		return "Tweede Semester";
  	}
 }
 
 /* om het floating komma probleem op te lossen
  * Bij het rekenen met punten wordt deze functie gebruikt om de komma's om te
  * zetten in punten
  */
 public static function kommaNaarPunt($string){
 	$string = str_ireplace(",", ".", $string);
 	return $string;
 }
 
 
 
 
 
 
}



?>