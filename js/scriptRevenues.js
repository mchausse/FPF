// Fonction qui valide si l'utilisateur est sur de vouloir supprimer la depense
function validerSuppressionRevenue(idSupp){
	document.getElementById ("lienSuppressionRevenue").href += idSupp;
	var notif = document.getElementById ("notificationSuppressionRevenue");
	if(notif.style.display=="none")notif.style.display="block";
	else notif.style.display="none";
}
function afficherFormRevenue(){
	var form = document.getElementById("revenueForm");
	if(form.style.display=="none")form.style.display="block";
	else form.style.display="none";
}
function annulerSuppressionRevenue(){
	document.getElementById("lienSuppressionRevenue").href="?action=supprimerRevenue&numeroRevenue=validerSuppressionRevenue()&numASupprimer=";
}
function afficherTableau(x){
	// Aller chercher les inforamtions
	var tableau=document.getElementById("tableau"+x);
	var icon=document.getElementById("iconeTableau"+x);
	if(tableau.style.display=="block"){
		// Modifier l'icone
		icon.className="glyphicon glyphicon-plus";
		icon.title="Afficher";
		// Msquer le tableau
		tableau.style.display = "none";
	}
	else{
		// Modifier l'icone
		icon.className="glyphicon glyphicon-minus";
		icon.title="Masquer";
		// Afficher le tableau
		tableau.style.display = "block";
	}
}