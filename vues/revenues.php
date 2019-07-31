<div id="accueil"> 
	<script language="javascript" src="js/scriptRevenues.js"></script> 
	<?php
	if (!ISSET($_SESSION)) session_start();
	if (ISSET($_REQUEST["global_message"]))$msg="<span class=\"warningMessage\">".$_REQUEST["global_message"]."</span>";
	require_once('./modele/CompteDAO.class.php');
	require_once('./modele/RevenueDAO.class.php');
	require_once('./modele/CategorieDAO.class.php');
	require_once('./modele/classes/Liste.class.php');
	// ----- Initialisation de DAO -----
	$cDao=new CompteDAO();
	$rDao=new RevenueDAO();
	// ----- Initialization des variables -----
	$montant='';
	$nom='';
	$recurence='';
	$date='';
	$idRevenue='';
	$idCompte='';
	$sequence='';
	$rechercheRev='';
	$paraRechercheRev='';
	// ----- Nom des boutons -----
	$btnNom='Ajouter';
	// ----- Variables de selection des combobox -----
	$selectedRecurence="selected=\"selected\"";
	$selectedSequence="selected=\"selected\"";
	$selectedRecherche="selected=\"selected\"";
	// ----- Look des fenetres -----
	$revFormAffiche='none';
	// ----- Nom des actions -----
	$actionRevenue='ajoutRevenue';
	// ----- Verification des informations presentes -----
	if (ISSET($_REQUEST["idRevenue"]))$idRevenue=$_REQUEST["idRevenue"];
	if (ISSET($_REQUEST["montant"]))$montant=$_REQUEST["montant"];
	if (ISSET($_REQUEST["nom"]))$nom=$_REQUEST["nom"];
	if (ISSET($_REQUEST["recurence"]))$recurence=$_REQUEST["recurence"];
	if (ISSET($_REQUEST["date"]))$date=$_REQUEST["date"];
	if (ISSET($_REQUEST["rechercheRev"]))$rechercheRev=$_REQUEST["rechercheRev"];
	if (ISSET($_REQUEST["paraRechercheRev"]))$paraRechercheRev=$_REQUEST["paraRechercheRev"];
	// ----- Verification des informations presentes -----
	if (ISSET($_REQUEST["sequence"]))$_SESSION["sequence"]=$_REQUEST["sequence"];
	$sequence = $_SESSION["sequence"];
	if (ISSET($_REQUEST["idCompte"]))$idCompte=$_REQUEST["idCompte"];
	else{
		$c=$cDao->find($_SESSION["connected"]);
		$idCompte=$c->getId();
	}
	// ---------- Afficher les forms si il y a eu une erreur dans le formulaire ----------
	if (ISSET($_REQUEST["afficherFormRevenue"]))$revFormAffiche='block';
	// ---------- Changer les choses lors des modifivation de champs ----------
	if (ISSET($_REQUEST["actionRevenue"])){
		$btnNom=$_REQUEST["btnNom"]; // Change le nom du bouton pour aller avec l'action
		$actionRevenue=$_REQUEST["actionRevenue"]; // Applique la nouvelle action donner par l'autre action
	}
	?>
	<h2>Vos revenues <?php// echo $_SESSION["nom"];?></h2>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="col-sm-6 col-md-6 col-lg-6">
					<button type="button" onclick="afficherFormRevenue()">Ajouter un revenue...</button>
					<div class="panel panel-default" id="revenueForm" style="display:<?=$revFormAffiche?>">
						<div class="panel-heading">
							<h4>Ajouter un revenue</h4>
						</div>
						<div class="panel-body">
							<form>
								<label for="montant">Montant($) :</label><br /> <input name="montant" type="text" value="<?=$montant?>" size=10/>
								<?php if (ISSET($_REQUEST["field_messages"]["montant"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["montant"]."</span>";
								?>
								<br />
								<label for="nom">Nom :</label><br /> <input name="nom" type="text" value="<?=$nom?>" size=35/>
								<?php if (ISSET($_REQUEST["field_messages"]["nom"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["nom"]."</span>";
								?>
								<br />
								<label for="recurence">Recurence :</label>
								<select name="recurence" value="<?=$recurence?>">
									<option></option>
									<option value="quo" <?php echo ($recurence=="quo")?$selectedRecurence:""?>>Quotidien</option>
									<option value="heb" <?php echo ($recurence=="heb")?$selectedRecurence:""?>>Hebdomadaire</option>
									<option value="men" <?php echo ($recurence=="men")?$selectedRecurence:""?>>Mensuel</option>
									<option value="ann" <?php echo ($recurence=="ann")?$selectedRecurence:""?>>Annuel</option>
								</select>
								<?php if (ISSET($_REQUEST["field_messages"]["recurence"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["recurence"]."</span>";
								?>
								<br />
								<label for="date">Date :</label><input name="date" type="date" value="<?=$date?>" min="2000-01-02" size=45/>
								<?php if (ISSET($_REQUEST["field_messages"]["date"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["date"]."</span>";
								?>
								<br />
								<input name="idRevenue" type="hidden" value="<?=$idRevenue?>"/>
								<input name="idCompte" type="hidden" value="<?=$idCompte?>"/>
								<input name="action" value="<?=$actionRevenue?>" type="hidden" />
								<input value=" <?=$btnNom?> " type="submit" />
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?//===============================================================
	//              		 Barre d'option d'affichage
	?>
		<div class=row>
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div id=paneauSettings>
							<div class="col-sm-4 col-md-4 col-lg-5">
								<form action="" method="post">
								<label>Voir les revenues de </label>
									<select name="sequence" value="<?=$sequence?>">
										<?php
										// Uttilise un operateur ternaire pour determiner quel sequence est
										// selectionner et applique la variable qui contien le parametre pour
										// specifier que l'option est selectionner.
										?>
										<option value="jour" <?php echo ($sequence=="jour")?$selectedSequence:""?>>Aujourd'hui</option>
										<option value="semaine" <?php echo ($sequence=="semaine")?$selectedSequence:""?>>Cette semaine</option>
										<option value="mois" <?php echo ($sequence=="mois")?$selectedSequence:""?>>Ce mois-ci</option>
										<option value="annee" <?php echo ($sequence=="annee")?$selectedSequence:""?>>Cette année</option>
									</select>
									<input name="action" value="revenues" type="hidden" />
									<input value=" GO " type="submit" />
								</form>
							</div>
							<div class="col-sm-8 col-md-8 col-lg-7">
								<form action="" method="post">
									<div id=rechercheRevenue>
										<label for="rechercheRev">Rechercher par </label>
											<select name="paraRechercheRev" value="<?=$paraRechercheRev?>">
												<option value="montant" <?php echo ($paraRechercheRev=="montant")?$selectedRecherche:""?>>Montant</option>
												<option value="nom" <?php echo ($paraRechercheRev=="nom")?$selectedRecherche:""?>>Nom</option>
												<option value="date" <?php echo ($paraRechercheRev=="date")?$selectedRecherche:""?>>Date</option>
												<option value="recurence" <?php echo ($paraRechercheRev=="recurence")?$selectedRecherche:""?>>Récurence</option>
											</select>
										<input name="rechercheRev" type="text" value="<?=$rechercheRev?>" size=20/>
										<input name="action" value="revenues" type="hidden" />
										<input value=" GO " type="submit" />
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<?// Zone pour la notification lors de la suppression?>
			<div style="display:none" id="notificationSuppressionRevenue">
				<div class="panel panel-danger">
				    <div class="panel-heading">
				    	Etes-vous sur de vouloir supprimer ce revenue? 
						<a id="lienSuppressionRevenue" href="?action=supprimerRevenue&numeroRevenue=validerSuppressionRevenue()&numASupprimer=">Oui</a>/<a href=""onclick="annulerSuppressionRevenue()">Non</a>
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="row">
		<?//===============================================================
		//               			Side gauche
		?>
		<div class="col-sm-12 col-md-4 col-lg-4">
			<div class="infoTableau">
				<?//==============================================================
				//          	Tableau des stats de revenue par nom
				?>
				<div class="col-sm-6 col-md-12 col-lg-12">
					<div class="panel panel-default">
					    <div  class="panel-heading">
					    	<h3>
								<a onclick="afficherTableau(1)"><span id="iconeTableau1" class="glyphicon glyphicon-minus" title="Masquer"></span></a>
					    		Revenues par catégorie
					    	</h3>
					    </div>
						<?//========== Affichage des donnees ==========?>
						<div id="tableau1" style="display:block">
				            <table class="table">
					            <thread>
					                <tr class="success">
					                    <th>Nom</th>
					                    <th>Total ($)</th>
					                </tr>
					            </thread>
					            <tbody>
								    <?php
								    $totalNb=0;
								    $totalMontant=0;
								    $totRev=0;
								    // Trouver la liste des nom differents
								    $listeNom=$rDao->findAllNom($idCompte);
								    while($listeNom->next()){
								    	// Trouver le montant total pour chaque nom
								    	$nom=$listeNom->current();
								    	$res=$rDao->findTotalMontantNomSequence($idCompte,$nom[0],$sequence);
								    	if($row=$res->fetch(PDO::FETCH_OBJ))$totRev=$row->montantTot;
								    	$totalMontant+=$totRev;
								    ?>
								    	<tr class="active">
								    		<td><?=$nom[0]?></td>
								    		<?php // Ne pas laisser seulement le signe $ dans la colonne
								    		if($totRev==null)$totRev=0;
								    		?>
								    		<td><?=number_format($totRev,2)."$"?></td>
										</tr>
								   	<?php
								    }
								    ?>
								</tbody>
								<tfoot>
								    <tr class="success">
								    	<td>Total : </td>
								    	<td colspan="2"><?=number_format($totalMontant,2)."$"?> </td>
								    </tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?//===============================================================
			//          	Tableau des revenues des mois precedant
			?>
			<div class="infoTableau">
				<div class="col-sm-6 col-md-12 col-lg-12">
					<div class="panel panel-default">
					    <div  class="panel-heading">
					    	<h3>
								<a onclick="afficherTableau(2)"><span id="iconeTableau2" class="glyphicon glyphicon-minus" title="Masquer"></span></a>
					    		Revenues par catégorie
					    	</h3>
					    </div>
						<?//========== Affichage des donnees ==========?>
						<div id="tableau2" style="display:block">
				            <table class="table">
					            <thread>
					                <tr class="success">
					                    <th>Mois</th>
					                    <th>Total ($)</th>
					                </tr>
					            </thread>
					            <tbody>
								    <?php
								    // Va chercher la somme des revenues pour chaques mois de l<année
								    $mois=array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Décembre");
								    $totalRevenue=0;
								    $totalMois=0;
								    for($i=0;$i<12;$i++){
									    // Aller chercher les montant pour chaque mois
								    	$res=$rDao->findTotalRevenueMois($idCompte,"0".$i+1);
								    	if($row=$res->fetch(PDO::FETCH_OBJ))$totalMois=$row->montantTot;
								    	if(!$totalMois==0){
								    		$totalRevenue+=$totalMois;
										    ?>
									    	<tr class="active">
									    		<td><?=$mois[$i]?></td>
									    		<td><?=$totalMois?></td>
											</tr>
										    <?php
										}
									}
								    ?>
								</tbody>
								<tfoot>
								    <tr class="success">
								    	<td>Total annuel : </td>
								    	<td colspan="2"><?=number_format($totalRevenue,2)."$"?> </td>
								    </tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?//===============================================================
		//          			       Side droit 
		?>
		<div class="col-sm-12 col-md-8 col-lg-8">
			<?php
			//===============================================================
			//              Tableau des revenu V2 avec la barre de nav
			// Sert a verifier quelle est le numero de la page selectionner
			$numPage = 1;
			if(ISSET($_REQUEST["numPage"]))$numPage = $_REQUEST["numPage"];
			// Loader les liste des depenses de celon la page
			$listeRev=$rDao->getPage($idCompte,$numPage,$_SESSION['navig']['taillePage'],$sequence);
			if($rechercheRev!="")$listeRev=$rDao->getPageRecherche($idCompte,$numPage,$_SESSION['navig']['taillePage'],$paraRechercheRev,$rechercheRev);
			//Affichage de la barre de navigation :
			$x = ($numPage-1)*$_SESSION['navig']["taillePage"]+1; 
			$y = ($numPage)*$_SESSION['navig']["taillePage"];
			if ($y > $_SESSION['navig']["nbResultats"])$y = $_SESSION['navig']["nbResultats"];
			?>
			<div class="infoTableau">
				<div class="panel panel-default">
				    <div class="panel-heading">
				    	<div class="col-sm-6 col-md-7 col-lg-7">
							<h3>
								<a onclick="afficherTableau(3)"><span id="iconeTableau3" class="glyphicon glyphicon-minus" title="Masquer"></span></a>
								Vos revenues
							</h3>
						</div>
						<div class="col-sm-3 col-md-5 col-lg-5">
							Resultats <?php echo $x?> &agrave; <?php echo $y?> sur un total de <?php echo $_SESSION['navig']["nbResultats"]?> 
						</div>
					</div>
					<?//========== Affichage des donnees ==========?>
					<div id="tableau3" style="display:block">
			            <table class="table">
				            <thread>
				                <tr class="info">
				                    <th>Montant</th>
				                    <th>Nom</th>
				                    <th>Date</th>
				                    <th>Récurence</th>
				                    <th>Options</th>
				                </tr>
			            	</thread>
			            	<tbody>
							    <?php
							    // Remplir le tableau des revenue avec toutes les depnsees du compte
							    while($listeRev->next()){
							    	$r=$listeRev->current();
							    ?>
							    	<tr class="active">
							    		<td><?=$r->getMontant()?>$</td>
							    		<td><?=$r->getNom()?></td>
							    		<td><?=substr($r->getDate(),0,10)?></td>
							    		<?// Afficher le nom de la categorie selon le id trouver?>
							    		<td>
							    		<?php // Ne pas laisser le champ vide si il n'yu a pas de recurence a la depense
						    			if($r->getRecurence()==null)echo "--";
						    			else echo $r->getRecurence();
							    		?>
							    		</td>
							    		<?// Icone pour supprimer la depense?>
							    		<td>
							    			<a href="?action=modifierRevenue&numeroRevenue=<?=$r->getId()?>"><span class="glyphicon glyphicon-pencil"></span></a>
							    			<a onclick="validerSuppressionRevenue(<?=$r->getId()?>)"><span class="glyphicon glyphicon-trash"></span></a>
							    		</td>
									</tr>
							   	<?php
							    }
							    // ========== Affiche la barre en bas pour choisir la page ==========
								// Affichage du table si il n'y a qune seule page
								if ($_SESSION['navig']["nbPages"]>1){
									?>
									<tr class="info"><td colspan="7" >
									<?php //========== Debut de le ligne 
										// -------- Affiche les fleches
										if ($numPage > 1){
											?>
											<div class="col-sm-2 col-md-2 col-lg-2">
												<a href="./?action=revenues&numPage=1"><b>&lt;&lt;</b></a>
												<a href="./?action=revenues&numPage=<?php echo $numPage-1?>"><b>&lt;</b></a>
											</div>
											<?php
										}
										else{
											?>
											<div class="col-sm-2 col-md-2 col-lg-2">
												<b>&lt;&lt;</b>
												<b>&lt;</b>
											</div>
											<?php
										}
										// --------------------- Affiche les chiffres
										?>
										<div class="col-sm-8 col-md-8 col-lg-8" class="numeroPages">
										<?php
										for ($i=1;$i<=$_SESSION["navig"]["nbPages"];$i++){
										    if ($i==$numPage)echo $i;
										    else echo "<a href=\"./?action=revenues&numPage=".$i."\"> ".$i."</a>";
										}
									    ?>
										</div>
										<?php
										// -------- Affiche les fleches
										if ($numPage < $_SESSION["navig"]["nbPages"]){
											?>
											<div class="col-sm-2 col-md-2 col-lg-2">
												<a href="./?action=revenues&numPage=<?php echo $numPage+1?>"><b>&gt;</b></a>
												<a href="./?action=revenues&numPage=<?php echo $_SESSION["navig"]["nbPages"]?>"><b>&gt;&gt;</b></a>
											</div>
											<?php
										}
										else{
											?>
											<div class="col-sm-2 col-md-2 col-lg-2">
												<b>&gt;</b>
												<b>&gt;&gt;</b>
											</div>
											<?php
										}
									 //========== Fin de le ligne ?>
									</td></tr>
									<?php
									}
								$s = "&numPage=".$numPage;
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>