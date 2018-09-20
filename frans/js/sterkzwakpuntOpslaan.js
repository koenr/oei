


function sterkzwakpuntOpslaan(rijnr){ //rij met rijnummer x opslaan
	
	id = document.getElementById('id_'+rijnr).value;
	
	omschrijving = document.getElementById('omschrijving_'+rijnr).value;

	jaar = document.getElementById('jaar_'+rijnr).value;
	
	 id = encodeURIComponent(id);
	 omschrijving = encodeURIComponent(omschrijving);
	 jaar = encodeURIComponent(jaar);

	 
	puntOpslaan(''+id+'',''+omschrijving+'',''+jaar+'');
}




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


 function puntOpslaan(id,omschrijving,jaar) { 

	 
	http.open('get', '../phpajax/sterkzwakpuntOpslaan.php?id='+id+'&omschrijving='+omschrijving+'&jaar='+jaar); 
	http.onreadystatechange = handleResponseSearch; 
	http.send(null);       
}

 function handleResponseSearch() { 
     
       if(http.readyState == 4 && http.status == 200){ 
    	  // alert(http.responseText);
       }

 }


