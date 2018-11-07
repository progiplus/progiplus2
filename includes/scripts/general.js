function getLangageDataTable(typeDeDonnee = "enregistrements", estMotFeminin = false)
{
	var texteDataTable =
	{
		decimal:        ",",
		emptyTable:     "Aucune donnée disponible dans le tableau",
		info:           premiereLettreEnMaj(typeDeDonnee) + "s _START_ &agrave; _END_ sur _TOTAL_",
		infoEmpty:      "Aucun " + typeDeDonnee + " disponible",
		infoFiltered:   "(filtrés parmi _MAX_ "+ typeDeDonnee + "s)",
		infoPostFix:    "",
		thousands:      " ",
		lengthMenu:     "Affichage de _MENU_ " + typeDeDonnee + "s par page",
		loadingRecords: "Chargement...",
		processing:     "Traitement...",
		search:         "Chercher :",
		zeroRecords:    "Aucun " + typeDeDonnee + " trouvé" ,
		paginate: 
		{
			first:      "Première",
			last:       "Dernière",
			next:       "Suivante",
			previous:   "Précédente"
		},
		aria: 
		{
			sortAscending:  ": trier la clonne par ordre croissant",
			sortDescending: ": trier la clonne par ordre décroissant"
		}
	};
	
	if(estMotFeminin)
	{
		texteDataTable.infoEmpty = "Aucune " + typeDeDonnee + " disponible";
		texteDataTable.zeroRecords = "Aucune " + typeDeDonnee + " trouvée";
		texteDataTable.infoFiltered = "(filtrées parmi _MAX_ "+ typeDeDonnee + "s)";
	}
	
	return texteDataTable;
}

function premiereLettreEnMaj(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}