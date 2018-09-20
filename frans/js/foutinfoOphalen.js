

var http = createRequestObject(); 



function createRequestObject() { 

   var req; 

   if(window.XMLHttpRequest){ 
      req = new XMLHttpRequest(); 

   } else if(window.ActiveXObject) { 

      req = new ActiveXObject("Microsoft.XMLHTTP"); 

   } else { 

      alert('Probleem'); 
   } 

   return req; 

}


 function foutOmschrijvingOphalen(foutnr) { 

	
	
	 	
       http.open('get', '../phpajax/foutomschrijvingophalen.php?foutnr='+foutnr); 
       http.onreadystatechange = handleResponseSearch; 
       http.send(null); 
      
    }

 function handleResponseSearch() { 
     
       if(http.readyState == 4 && http.status == 200){ 

          if(http.responseText) { 
             document.getElementById("foutnr_info").innerHTML = http.responseText; 
           

			//writetxt("<center><b> Faute "+ nummer +"</b></center><br>"+http.responseText+"");
			
             } else { 
             document.getElementById("foutnr_info").innerHTML = " &nbsp; "; 
          } 

 }else if(http.readyState == 0){
 document.getElementById("foutnr_info").innerHTML = " Typ uw zoekopdracht in "; 

 }else if(http.readyState == 1){
	 document.getElementById("foutnr_info").innerHTML = "Bezig met laden... ";
	// document.getElementById("navtxt").innerHTML = "Bezig met laden... ";  

 }else if(http.readyState == 2){
 document.getElementById("foutnr_info").innerHTML = " Het laden is voltooit"; 
       } else { 
          document.getElementById("foutnr_info").innerHTML = " &nbsp; "; 
       } 
     
    }


