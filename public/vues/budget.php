<div id="accueil">
	<div class="row">
		<?php
		if (!ISSET($_SESSION)) session_start();
		if (ISSET($_REQUEST["global_message"]))$msg="<span class=\"warningMessage\">".$_REQUEST["global_message"]."</span>";
		require_once('./modele/CompteDAO.class.php');
		require_once('./modele/DepenseDAO.class.php');
		require_once('./modele/CategorieDAO.class.php');
		require_once('./modele/RevenueDAO.class.php');
		require_once('./modele/classes/Liste.class.php');

		$cDao= new CompteDAO();
		$catDao=new CategorieDAO();
		$dDao=new DepenseDAO();
		$rDao=new RevenueDAO();
		$c=$cDao->find($_SESSION["connected"]);
		$idCompte=$c->getId();
		$config =$c->getConfig();
		$sequenceDefault="mois";
		$btnSubmit="Commencer votre budget";
		
		if($config == 1){
			$compteur=0;
			?>
			<script>
				var checkBox=[] ;
				var listeIdCat=[] ;
			</script>
			<h2>Configuration de votre budget </h2>

			<div class="infoTableau">
				<div class="panel panel-default">
				    <div class="panel-heading">
				    		<h3>Choisir les catégorie de dépense obligatoires</h3>
				    </div>
					<div id="checkBudget">
						<form action="" method="post">
							<?php
							$listeCat=$catDao->findAll($idCompte);
							while($listeCat->next()){
								$cat=$listeCat->current();
								?>
								<label class="container"><?=$cat->getNom()?>
								<input type="checkbox" id="<?=$compteur?>" value="<?=$cat->getId()?>" onchange="check()">
								<span class="checkmark"></span>
								</label>
								<?php
								$compteur++;
								}
							?>
							<input name="categorie" value="" type="hidden" />
							<input name="valConfig" value="0" type="hidden" />
							<input name="action" value="budgetConfiguration" type="hidden" />
							<input value=" <?=$btnSubmit?> " type="submit"/>
						</form>
					</div>
				</div>
			</div>
		<?php
		}
		?>

		<script>
		var i;
		var compteurPhp=<?php echo json_encode($compteur)?>;
		for(i=0;i<compteurPhp;i++){
			checkBox.push(document.getElementById(i));
		}
		</script>

		<?php 
		if($config == 0){
			$strIdCategorie =$c->getIdCategorieConfig();
			$listeIdCat = explode(',',$strIdCategorie);
			$limit = count($listeIdCat);
			?>
			<h2>Votre budget <?php echo $_SESSION["nom"]; ?></h2>
			<div class="col-sm-6 col-md-6 col-lg-6">
				<table class="table">
					<tbody>
						<tr class="warning">
							<th>Dépense obligatoire</th>
							<th>Ce Mois-ci</th>
							<th title="La moyenne est effectuée sur les dépenses des 4 derniers mois">Moyenne</th>
						</tr>
						<?php 
						$montantTot=0;
						$moyenneTot=0;
						$montantTotOb=0;
						$montantOb=0;
						$moyenneOb=0;
						for($i=0;$i<$limit;$i++){ ?>
							<tr class="active">
								<?php
								$idCat=$listeIdCat[$i];
								$cat=$catDao->find($idCompte,$idCat);
					
								$catDepenseMois=$dDao->findTotalMontantSequence($idCompte,$idCat,$sequenceDefault);
								if($row=$catDepenseMois->fetch(PDO::FETCH_OBJ))$montantDepTot=$row->montantTot;
					
								$montantOb=$montantDepTot;
								$montantTot+=$montantOb;
								$montantTotOb+=$montantOb;
					
								$catDepenseQuatreMois=$dDao->findTotalMontantQMois($idCompte,$idCat);
								if($row=$catDepenseQuatreMois->fetch(PDO::FETCH_OBJ))$montantQuatreDepTot=$row->montantTot;
					
								$moyenneOb=$montantQuatreDepTot/4;
								$moyenneTot+=$moyenneOb;
					
								?>
								<td><?=$cat->getNom()?></td>
								<td><?=number_format($montantOb,2)."$"?></td>
								<td><?=number_format($moyenneOb,2)."$"?></td>
							</tr>
						<?php
						}
						?>
						<tr class="warning">
							<th>Dépense optionnelle</th>
							<th>Ce Mois-ci</th>
							<th title="La moyenne est effectuée sur les dépenses des 4 derniers mois">Moyenne</th>
						</tr>
						<?php
						$montantOp=0;
						$montantTotOp=0;
						$moyenneOp=0;
						$condition=false;
						$listeCat=$catDao->findAll($idCompte);
						while($listeCat->next()){ 
							?>
							<tr class="active">
								<?php
								$cat=$listeCat->current();
								$idCat=$cat->getId();
							
								$catDepenseMois=$dDao->findTotalMontantSequence($idCompte,$idCat,$sequenceDefault);
								if($row=$catDepenseMois->fetch(PDO::FETCH_OBJ))$montantDepTot=$row->montantTot;
								$montantOp=$montantDepTot;
							
								$catDepenseQuatreMois=$dDao->findTotalMontantQMois($idCompte,$idCat);
								if($row=$catDepenseQuatreMois->fetch(PDO::FETCH_OBJ))$montantQuatreDepTotOp=$row->montantTot;
								$moyenneOp=$montantQuatreDepTotOp/4;
					
									for($i=0;$i<$limit;$i++){
									$idOblig=$listeIdCat[$i];
										if($idCat==$idOblig && $condition==false){
											$condition=true;
										}
								
									}
								if($condition==false){ ?>
									<td><?=$cat->getNom()?></td>
									<td><?=number_format($montantOp,2)."$"?></td>
									<td><?=number_format($moyenneOp,2)."$"?></td>
									<?php		
									$montantTot+=$montantOp;
									$montantTotOp+=$montantOp;
									$moyenneTot+=$moyenneOp;
								}
								?>
							</tr>
							<?php
							$condition=false;
						}
				
		?>
						<tr class="warning">
							<th>Total :</th>
							<th><?=number_format($montantTot,2)."$"?></th>
							<th><?=number_format($moyenneTot,2)."$"?></th>
						</tr>	  
					</tbody>
				</table>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6">
				<table class="table">
					<tbody>
						<tr class="success">
							<th>Mois du revenue</th>
							<th>Montant</th>
						</tr>
						<?php 
						$totalRevenueQ=0;
						for($i=1;$i<=4;$i++){
							?>
							<tr class="active">
								<?php
								$revenueMoisNom=$rDao->findNomRevenuMois($idCompte,$i);
								if($row=$revenueMoisNom->fetch(PDO::FETCH_OBJ))$moisNom=$row->NM;
								$revenueMoisAnt=$rDao->findTotalRevenuMois($idCompte,$i);
								if($row=$revenueMoisAnt->fetch(PDO::FETCH_OBJ))$revenue=$row->MR;
								$totalRevenueQ+=$revenue;
								?>
								<td><?=$moisNom?></td>
								<td><?=number_format($revenue,2)."$"?></td>
							</tr>
						<?php
						}
						$moyenneRevenue=$totalRevenueQ/4;
						//Calcul pourcentage
						$pourcentageOb=($montantTotOb*100)/$montantTot;
						$pourcentageOp=($montantTotOp*100)/$montantTot;
						$pourcentageOb=number_format($pourcentageOb,0)."%";
						$pourcentageOp=number_format($pourcentageOp,0)."%";
						?>
						<tr class="success">
							<th>Moyenne :</th>
							<th><?=number_format($moyenneRevenue,2)."$"?></th>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div id="panel" class="container">
					<div class="panel panel-info">
						<div class="panel-heading">Final</div>
						<div class="panel-body">
							<p>Les dépenses obligatoires constituent <?=$pourcentageOb;?> de vos dépenses</p>
							<p>Les dépenses optionnelles constituent <?=$pourcentageOp;?> de vos dépenses</p>
						</div>
					</div>
				</div>
			</div>
		<?php 
		} 
		?>
	</div>
</div>

<script>
function check() {
  var i;
  for(i=0;i<checkBox.length;i++){
  if (checkBox[i].checked == true && !inArray(checkBox[i].value,listeIdCat)){
	listeIdCat.push(checkBox[i].value);
	document.getElementsByName("categorie")[0].value = listeIdCat.join();
  } 
  if (checkBox[i].checked == false && inArray(checkBox[i].value,listeIdCat)){
	isValue(checkBox[i].value,listeIdCat); 
	document.getElementsByName("categorie")[0].value = listeIdCat.join();
  }
  }
}

function inArray(id,liste)
{
    var compteur=liste.length;
    for(var i=0;i<compteur;i++)
    {
        if(liste[i]==id){
			return true;
			}
    }
	return false;
}

function isValue(id,liste)
{
    var compteur=liste.length;
    for(var i=0;i<compteur;i++)
    {
        if(liste[i]==id){
			liste.splice(i,1);
			}
    }
	return;
	 
}
</script>