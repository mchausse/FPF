<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<div id="accueil">
	<h2>Page d'accueil - Bonjour <?php echo $_SESSION["nom"]; ?></h2>
	<?php
	include_once("./modele/CompteDAO.class.php");
	include_once("./modele/CategorieDAO.class.php");
	include_once("./modele/DepenseDAO.class.php");
	?>
	<script>
		// Initialization des tableaux qui vont contenir les informations dans la pie
		var listeCatJav = [];// Categorie des depenses
		var listeDepJav = [];// Liste des depenses
		var listeCatRev = [];// Categorie de revenues
		var listeRev = [];// Liste des revenues
		var listeCatMois = [];// Categorie des depenses
		var listeDepMois = [];// Liste des listes de depenses pour les diagrammes des mois
		var listeListeCatMois = [];
		var listeListeDepMois = [];
	</script>
	<?php
	date_default_timezone_set(DateTimeZone::listIdentifiers(DateTimeZone::UTC)[0]);
	// Initialization des DAO
	$cDao=new CompteDAO();
	$catDao=new CategorieDAO();
	$dDao=new DepenseDAO();
	$rDao=new RevenueDAO();
	// Aller chercher les informations pour le diagramme des depenses
	$compte=$cDao->find($_SESSION["connected"]);
	$idCompte = $compte->getId();
	$listeItem= "";
	$listeCat=$catDao->findAll($idCompte);
	$totalMontant=0;
	while($listeCat->next()){
		$listeItem=$listeCat->current();
		$item=$listeItem->getNom();
		$idCat=$listeItem->getId();
		$res=$dDao->findTotalMontantSequence($idCompte,$idCat,'annee');
		if($row=$res->fetch(PDO::FETCH_OBJ))$totDep=$row->montantTot;
		?>
		<script>
			listeCatJav.push(<?php echo json_encode($item)?>);
			listeDepJav.push(<?php echo json_encode($totDep)?>);
		</script>
		<?php
	}
	// Aller chercher les informations pour le diagramme des revenues
	$listeItemRev="";
	$listeCatRev=$rDao->findAllNom($idCompte);
	$totalMontantRev=0;
	while($listeCatRev->next()){
		$listeItemRev=$listeCatRev->current();
		$res=$rDao->findTotalMontantNomSequence($idCompte,$listeItemRev[0],"annee");
		if($row=$res->fetch(PDO::FETCH_OBJ))$totRev=$row->montantTot;
		?>
		<script>
			listeCatRev.push(<?php echo json_encode($listeItemRev[0])?>);
			listeRev.push(<?php echo json_encode($totRev)?>);
		</script>
		<?php
	}
	// Aller chercher les informations pour les diagrammes des mois
	$idMois = 1;
	while($idMois <= date('m')){
		// Generer le diagramme selon la date
		$listeItem= "";
		$listeCat=$catDao->findAll($idCompte);
		$totalMontant=0;
		while($listeCat->next()){
			$listeItem=$listeCat->current();
			$item=$listeItem->getNom();
			$idCat=$listeItem->getId();
			$res=$dDao->findTotalDepenseMoisCat($idCompte,$idCat,$idMois);
			if($row=$res->fetch(PDO::FETCH_OBJ))$totDep=$row->montantTot;
			?>
			<script>
				listeCatMois.push(<?php echo json_encode($item)?>);
				listeDepMois.push(<?php echo json_encode($totDep)?>);
			</script>
			<?php
		}
		?>
		<script>
			listeListeCatMois.push(listeCatMois);
			listeListeDepMois.push(listeDepMois);
			var listeCatMois = [];// Categorie des depenses
			var listeDepMois = [];// Liste des listes de depenses pour les diagrammes des mois
		</script>
		<?php
		// Incrementer le mois
		$idMois = $idMois + 1;
	}
	?>
	<!-- Diagrammes de l'annee -->
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="infoTableau">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3>Diagrammes de l'année</h3>
					</div>
				</div>
			</div>
		</div>
		<!-- Section des diagrammes -->
		<div class="row">
			<!-- Diagramme des depenses -->
			<div class="col-sm-5 col-md-5 col-lg-6">
				<canvas id="depChart" width="100" height="100"></canvas>
			</div>
			<!-- Diagrammes des revenus -->
			<div class="col-sm-5 col-md-5 col-lg-6">
				<canvas id="revChart" width="100" height="100"></canvas>
			</div>
		</div>
		<!-- fin Section des diagrammes -->
	</div>
	<!-- Fin Diagrammes de l'annee -->

	
	<!-- Diagrammes de mois -->
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="infoTableau">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3>Dépenses par mois</h3>
					</div>
				</div>
			</div>
		</div>
		<!-- Section des diagrammes -->
		<div class="row">
			<!-- Diagrammes des mois -->
			<div class="col-sm-5 col-md-5 col-lg-6">
				<canvas id="diaMois1"></canvas>
			</div>
			<div class="col-sm-5 col-md-5 col-lg-6">
				<canvas id="diaMois2"></canvas>
			</div>
			<div class="col-sm-5 col-md-5 col-lg-6">
				<canvas id="diaMois3"></canvas>
			</div>
			<div class="col-sm-5 col-md-5 col-lg-6">
				<canvas id="diaMois4"></canvas>
			</div>
		</div>
		<!-- fin Section des diagrammes -->
	</div>
	<!-- Fin Diagrammes de l'annee -->

</div>
<!-- Fin de la page -->

<!-- Debut des scripts -->
<script>
	var pieChart = new Chart(depChart,{
		type:'pie',
		data: {
			labels: listeCatJav,
			datasets: [{
				label: '$',
				data: listeDepJav,
				backgroundColor: ['red','blue','yellow','cyan','magenta','green','orange','purple','grey','white','pink','black'],
				borderWidth: 1
			}]
		},
		options: {
			title:{display:true, text:'Dépense '+new Date().getFullYear(), fontSize:25,fontColor:'#FFFFE0'},
			legend:{
				display:true, position:'bottom',
				labels:{fontColor:'#FFFFE0'}
			},
			layout:{
				padding:{left:0, right:0, bottom:50, top:0}
			}
		}
	});

	var pieChartRev = new Chart(revChart,{
		type:'pie',
		data: {
			labels: listeCatRev,
			datasets: [{
				label: '$',
				data: listeRev,
				backgroundColor: ['red','blue','yellow','cyan','magenta','green','orange','purple','grey','black','pink','white'],
				borderWidth: 1
			}]
		},
		options: {
			title:{display:true, text:'Revenue '+new Date().getFullYear(), fontSize:25,fontColor:'#FFFFE0'},
			legend:{
				display:true, position:'bottom',
				labels:{fontColor:'#FFFFE0'}
			},
			layout:{
				padding:{left:0, right:0, bottom:50, top:0}
			}
		}
	});
	
	var pieChart = new Chart(diaMois1,{
		type:'pie',
		data: {
			labels: listeListeCatMois[1],
			datasets: [{
				label: '$',
				data: listeListeDepMois[1],
				backgroundColor: ['red','blue','yellow','cyan','magenta','green','orange','purple','grey','white','pink','black'],
				borderWidth: 1
			}]
		},
		options: {
			title:{display:true, text:'Dépense janvier '+new Date().getFullYear(), fontSize:25,fontColor:'#FFFFE0'},
			legend:{
				display:true, position:'bottom',
				labels:{fontColor:'#FFFFE0'}
			},
			layout:{
				padding:{left:0, right:0, bottom:50, top:0}
			}
		}
	});
	
	var pieChart = new Chart(diaMois2,{
		type:'pie',
		data: {
			labels: listeListeCatMois[2],
			datasets: [{
				label: '$',
				data: listeListeDepMois[2],
				backgroundColor: ['red','blue','yellow','cyan','magenta','green','orange','purple','grey','white','pink','black'],
				borderWidth: 1
			}]
		},
		options: {
			title:{display:true, text:'Dépense fevrier '+new Date().getFullYear(), fontSize:25,fontColor:'#FFFFE0'},
			legend:{
				display:true, position:'bottom',
				labels:{fontColor:'#FFFFE0'}
			},
			layout:{
				padding:{left:0, right:0, bottom:50, top:0}
			}
		}
	});
	
	var pieChart = new Chart(diaMois3,{
		type:'pie',
		data: {
			labels: listeListeCatMois[3],
			datasets: [{
				label: '$',
				data: listeListeDepMois[3],
				backgroundColor: ['red','blue','yellow','cyan','magenta','green','orange','purple','grey','white','pink','black'],
				borderWidth: 1
			}]
		},
		options: {
			title:{display:true, text:'Dépense mars '+new Date().getFullYear(), fontSize:25,fontColor:'#FFFFE0'},
			legend:{
				display:true, position:'bottom',
				labels:{fontColor:'#FFFFE0'}
			},
			layout:{
				padding:{left:0, right:0, bottom:50, top:0}
			}
		}
	});
	var pieChart = new Chart(diaMois4,{
		type:'pie',
		data: {
			labels: listeListeCatMois[4],
			datasets: [{
				label: '$',
				data: listeListeDepMois[4],
				backgroundColor: ['red','blue','yellow','cyan','magenta','green','orange','purple','grey','white','pink','black'],
				borderWidth: 1
			}]
		},
		options: {
			title:{display:true, text:'Dépense avril '+new Date().getFullYear(), fontSize:25,fontColor:'#FFFFE0'},
			legend:{
				display:true, position:'bottom',
				labels:{fontColor:'#FFFFE0'}
			},
			layout:{
				padding:{left:0, right:0, bottom:50, top:0}
			}
		}
	});
</script>