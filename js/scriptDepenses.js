//  Fonction qui permet l'affichage du champs du nom de la personne si la case remboursable est cocher
function showPersonne() { 
	// aller chercher les elements
	var checkBox = document.getElementById("checkBoxRembours");
	var lbl = document.getElementById("lblPersonne");
	var txtbx = document.getElementById("txtbxPersonne");
  // If the checkbox is checked, display the output text
	if (checkBox.checked == true){
		lbl.style.display = "block";
		txtbx.style.display = "block";
	} 
	else {
		lbl.style.display = "none";
		txtbx.style.display = "none";
	}
}
// Fonction qui valide si l'utilisateur est sur de vouloir supprimer la depense
function validerSuppressionDepense(idSupp){
    document.body.scrollTop = 0;// Retourner dans le haut de la page
	document.getElementById ("lienSuppressionDepense").href += idSupp;
	var notif = document.getElementById ("notificationSuppressionDepense");
	if(notif.style.display=="none")notif.style.display="block";
	else notif.style.display="none";
}
function afficherFormDepense(){
	var form = document.getElementById("depenseForm");
	if(form.style.display=="none")form.style.display="block";
	else form.style.display="none";
}
function annulerSuppressionDepense(){
	document.getElementById("lienSuppressionDepense").href="?action=supprimerDepense&numeroDepense=validerSuppressionDepense()&numASupprimer=";
}
function validerSuppressionCategorie(idSupp){
	document.getElementById ("lienSuppressionCategorie").href += idSupp;
	var notif = document.getElementById ("notificationSuppressionCategorie");
	if(notif.style.display=="none")notif.style.display="block";
	else notif.style.display="none";
}
function afficherFormCategorie(){
	var form = document.getElementById("categorieForm");
	if(form.style.display=="none")form.style.display="block";
	else form.style.display="none";
}
function annulerSuppressionCategorie(){
	document.getElementById("lienSuppressionCategorie").href="?action=supprimerCategorie&numeroCategorie=validerSuppressionCategorie()&numASupprimer=";
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