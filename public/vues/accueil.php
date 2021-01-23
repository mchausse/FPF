<?php
include_once("./modele/CompteDAO.class.php");
include_once("./modele/CategorieDAO.class.php");
include_once("./modele/DepenseDAO.class.php");

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
$listeDepenses = [["Mon array de depenses","Mon array de depenses"]];
while($listeCat->next()){
    $listeItem=$listeCat->current();
    $item=$listeItem->getNom();
    $idCat=$listeItem->getId();
    $res=$dDao->findTotalMontantSequence($idCompte,$idCat,'annee');
    if($row=$res->fetch(PDO::FETCH_OBJ)){
        // Valider que si le montant est null de mettre un 0
        // autrement ajouter le montant dans le tableau
        if($row->montantTot === null){
            $totDep=0;
        } else {
            // 0 + le montant pour convertir la variable en nombre
            $totDep=0 + $row->montantTot;
        }
    }
    // Ajouter le le montant avec la categorie dans le gros tableau
    array_push($listeDepenses, [$item, $totDep]);
}

// Aller chercher les revenus
$listeItemRev="";
$listeCatRev=$rDao->findAllNom($idCompte);
$listeRevenus = [["Mon array de revenus","Mon array de revenus"]];
while($listeCatRev->next()){
    $listeItemRev=$listeCatRev->current();
    $res=$rDao->findTotalMontantNomSequence($idCompte,$listeItemRev[0],"annee");
    if($row=$res->fetch(PDO::FETCH_OBJ)){
        // Valider que si le montant est null de mettre un 0
        // autrement ajouter le montant dans le tableau
        if($row->montantTot === null){
            $totDep=0;
        } else {
            // 0 + le montant pour convertir la variable en nombre
            $totDep=0 + $row->montantTot;
        }
    }
    // Ajouter le le montant avec la categorie dans le gros tableau
    array_push($listeRevenus, [$listeItemRev[0], $totDep]);
}
?>
<div id="accueil">
    <!-- Message de bienvenue -->
    <h2>
        Page d'accueil - Bonjour <?php echo $_SESSION["nom"]; ?>
    </h2>
    <!-- Diagrammes de l'annee -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="infoTableau">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Dépenses</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section des diagrammes -->
        <div class="row">
            <!-- Diagramme des depenses -->
            <div class="col-sm-5 col-md-5 col-lg-6">
                <div id="diagrameDepensesAnnee"></div>
            </div>
        </div>
        <div class="row">
            <!-- Diagramme des depenses -->
            <div class="col-sm-5 col-md-5 col-lg-6">
                <div id="diagrameDepensesMoisActuel"></div>
            </div>
        </div>
        <!-- fin Section des diagrammes -->
    </div>
    <!-- Fin Diagrammes de l'annee -->
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">


    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChartDepenses);
    // Draw the chart and set the chart values
    function drawChartDepenses() {
        var dataDiagrameDepensesAnnee = google.visualization.arrayToDataTable(<?php echo json_encode($listeDepenses) ?>);
        // Optional; add a title and set the width and height of the chart
        var optionsDiagrameDepensesAnnee = {'title':'Dépenses pour 2019', 'width':450, 'height':300};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('diagrameDepensesAnnee'));
        chart.draw(dataDiagrameDepensesAnnee, optionsDiagrameDepensesAnnee);
    }
    
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChartRevenus);
    // Draw the chart and set the chart values
    function drawChartRevenus() {
        var dataDiagrameDepensesMoisActuel = google.visualization.arrayToDataTable(<?php echo json_encode($listeRevenus) ?>);
        // Optional; add a title and set the width and height of the chart
        var optionsDiagrameDepensesMoisActuel = {'title':'Dépenses pour septembre', 'width':450, 'height':300};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('diagrameDepensesMoisActuel'));
        chart.draw(dataDiagrameDepensesMoisActuel, optionsDiagrameDepensesMoisActuel);
    }
</script>