 window.onload=function()
        {
        var tabCheckBox = document.getElementsByName('chkActivites');
        var chkAutres = tabCheckBox[tabCheckBox.length -1];
        chkAutres.onchange = function()
            {
                var txtAutres = document.getElementById('txtAutres');
                if(this.checked)
                {
                    txtAutres.disabled=false;
                    txtAutres.focus();
                }
                else
                {
                    txtAutres.disabled=true;
                    txtAutres.vakue='';
                }
            }
          
        // script des mois
        var moisAnnees=["Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"];
        var mois = document.getElementsByName("mois") ;
	 
        for(var i = 0; i < moisAnnees.length; i++ )
            {
                var unMois = new Option();
                unMois.value = i + 1;
                unMois.text = moisAnnees[i];
                mois[0].add(unMois);
            }
        
        // script Annees
        var cbAnnee = document.getElementById('annee');
        
        var anneeEnCours = new Date().getFullYear();
        
        for(var i = anneeEnCours; i >= 1969; i-- )
            {
                var annee = new Option();
                annee.value = i;
                annee.text = i;
                cbAnnee.add(annee);
            }
        }
       
        //script Jour / mois / annee      
        function updateCbJours()
        {
            var valMois=document.getElementById('mois').value;
            var valAnnee=document.getElementById('annee').value;
            var cbJours = document.getElementById('jour');
            var nbJours = 0;

            if(valMois == 0 || valAnnee == 0)
                {
                    cbJours.disabled = true;
                }
            else
            {
                if(valMois == 4 || valMois == 6 || valMois == 9 || valMois == 11)
                    {
                        nbJours = 30;
                    }
                else if(valMois == 2)
                    {
                        if(estBissextile(valAnnee)){
                            nbJours = 29;
                        }
                        else
                            {
                                nbJours = 28;
                            }
                    }
                else
                    {
                        nbJours = 31;
                    }
                remplitCbjours(nbJours);
                cbJours.disabled = false;
            }
        }
        function estBissextile(annee)
        {
            return (annee % 4 ==0 || annee % 400 ==0 && annee % 100 !==0);
        }
            
        function remplitCbjours(limite)
        {
            var cbJours = document.getElementById('jour');
            cbJours.innerHTML = '';
            for(i = 0; i <= limite; i++)
                {
                    var optJour = new Option();
                    optJour.value = i;
                    if(i == 0)
                        {
                            optJour.text = 'Jour';
                        }
                    else
                        {
                            optJour.text = i;
                        }
                    cbJours.add(optJour); 
                }
        }
        
        document.getElementById('mois').onchange = function(){ updateCbJours(); }
        document.getElementById('annee').onchange = function(){ updateCbJours(); }

        
        
        // validation des champs premiere facon
/*        function foncverif()
        {
            var ttcivilite = document.getElementById('civilite')
            if(ttcivilite.value.trim() == 0)
                {
                    alert("la civilite est obligatoire");
                    ttcivilite.focus();
                    return false;
                }
            
            var ttnom = document.getElementById('nom')
            if(ttnom.value.trim() == "")
                {
                    alert("le nom est obligatoire");
                    ttnom.focus();
                    return false;
                }
            
            var ttprenom = document.getElementById('prenom')
            if(ttprenom.value.trim() == "")
                {
                    alert("le prenom est obligatoire");
                    ttprenom.focus();
                    return false;
                }   

            //test bouton radio
            var radioCiv = document.getElementsByName("rdCiv");
            if(!radionCiv[0].checked && !radioCiv[1].checked)
                {
                    alert('Vous devez choisir la civilite');
                    radioCiv[0].focus; // pas obligatoire
                    return false;
                }
            return true;
        }*/
		
// fonction de validation version 2
	function isValid(champ){
		if(champ.value.trim()==''){
			champ.style.borderColor ='red';
			champ.focus();
			return false;
		}else{
			champ.style.borderColor='initial';
			return true;
		}
	}

	function foncverif(){
		var ttnom = document.getElementById('nom');
		var ttprenom = document.getElementById('prenom');
		if(!isValid(ttnom)){
			alert('Vous devez renseigner le nom !');
			return false;
		}
		if(!isValid(ttprenom)){
			alert('Vous devez renseigner le prenom !');
			return false;
		}
		var cbJours = document.getElementById('jour');
		if(cbJours.selectedIndex == 0){
			alert('Vous devez selectionner une date');
			cbJours.focus;
			return false;
		}
		var tabCheckbox = document.getElementsByName('chkActivites');
		var chkAutres = tabCheckbox[tabCheckbox.length -1];
		var ttPrecissions = document.getElementById['txtAutres'];

		if(chkAutres.checked && !isValid(ttPrecissions)){
			alert('Vous devez preciser !!!');
			return false;
		}
		return true;
	}
