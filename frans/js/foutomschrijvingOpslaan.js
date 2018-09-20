
function nl2br(text){
	text = text.replace(/\n/g,'<br />')
	return text;
}



function in_array (needle, haystack, argStrict) {
    // Checks if the given value exists in the array  
    // 
    // version: 1008.1718
    // discuss at: http://phpjs.org/functions/in_array
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: vlado houba
    // +   input by: Billy
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: true
    // *     example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
    // *     returns 2: false
    // *     example 3: in_array(1, ['1', '2', '3']);
    // *     returns 3: true
    // *     example 3: in_array(1, ['1', '2', '3'], false);
    // *     returns 3: true
    // *     example 4: in_array(1, ['1', '2', '3'], true);
    // *     returns 4: false
    var key = '', strict = !!argStrict;
 
    if (strict) {
        for (key in haystack) {
            if (haystack[key] === needle) {
                return true;
            }
        }
    } else {
        for (key in haystack) {
            if (haystack[key] == needle) {
                return true;
            }
        }
    }
 
    return false;
}

function controleerDubbele( A ) {                          // finds any duplicate array elements using the fewest possible comparison
	var i, j, n;
	n=A.length;
                                                     // to ensure the fewest possible comparisons
	for (i=0; i<n; i++) {                        // outer loop uses each item i at 0 through n
		for (j=i+1; j<n; j++) {              // inner loop only compares items j at i+1 to n
			if (A[i]==A[j]) return true;
	}	}
	return false;
}






function omschrijvingOpslaan(rijnr,foutnrarray){ //rij met rijnummer x opslaan
	
	id = document.getElementById('id_'+rijnr).value;
	
		
		
	foutnr = document.getElementById('foutnr_'+rijnr).value;
	//	foutnr = foutnr.replace("'",'"');

		
	titel = document.getElementById('titel_'+rijnr).value;
	//	titel = titel.replace("'",'"');
		
	omschrijving = document.getElementById('omschrijving_'+rijnr).value;
	//	omschrijving = nl2br(omschrijving.replace("'",'"'));
		
	grammatica = document.getElementById('grammatica_'+rijnr).value;
	//	grammatica = grammatica.replace("'",'"');
	foutnr = encodeURIComponent(foutnr);
	titel = encodeURIComponent(titel);
	omschrijving = encodeURIComponent(omschrijving);
	grammatica = encodeURIComponent(grammatica);
		
	foutomschrijvingOpslaan(''+id+'',''+foutnr+'',''+titel+'',''+omschrijving+'',''+grammatica+'');
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


 function foutomschrijvingOpslaan(id,foutnr,titel,omschrijving,grammatica) { 

	
	
	 	
       http.open('get', '../phpajax/foutomschrijvingOpslaan.php?id='+id+'&foutnr='+foutnr+'&titel='+titel+'&omschrijving='+omschrijving+'&grammatica='+grammatica); 
       http.onreadystatechange = handleResponseSearch; 
       http.send(null); 
      
    }

 function handleResponseSearch() { 
     
       if(http.readyState == 4 && http.status == 200){ 
    	  // alert(http.responseText);
       }

 }


