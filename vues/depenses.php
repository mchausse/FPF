<div id="accueil">
    <script language="javascript" src="js/scriptDepenses.js"></script> 
    <?php
    if (!ISSET($_SESSION)) session_start();
    if (ISSET($_REQUEST["global_message"]))$msg="<span class=\"warningMessage\">".$_REQUEST["global_message"]."</span>";
    require_once('./modele/CompteDAO.class.php');
    require_once('./modele/DepenseDAO.class.php');
    require_once('./modele/CategorieDAO.class.php');
    require_once('./modele/classes/Liste.class.php');
    // ----- Initialisation de DAO -----
    $cDao=new CompteDAO();
    $catDao=new CategorieDAO();
    $dDao=new DepenseDAO();
    // ----- Initialization des variables ----
    $montant="";
    $nom="";
    $recurence="";
    $note="";
    $remboursable=0;
    $personne="";
    $date="";
    $idCompte="";
    $idCategorie="";
    $idDepense='';
    $nomCat="";
    $sequence="";
    $rechercheDep="";
    $paraRechercheDep="";
    $idASupprimmer="";
    $numPage=1;
    // ----- Nom des boutons -----
    $btnNom="Ajouter";// Bouton submit dans le formulaire des depenses
    $btnCategorie="OK";// Bouton submit dans le formulaire de categorie
    // ----- Variables de selection des combobox -----
    $selectedSequence="selected=\"selected\"";
    $selectedRecherche="selected=\"selected\"";
    $selectedCategorie="selected=\"selected\"";
    $selectedRecurence="selected=\"selected\"";
    // ----- Look des fenetres -----
    $depFormAffiche="none";
    $catFormAffiche="none";
    // ----- Nom des actions -----
    $actionDepense="ajoutDepense"; // Action par default du bouton 
    $actionCategorie="ajoutCategorie";
    // ----- Verification des informations presentes -----
    if (ISSET($_REQUEST["montant"]))$montant=$_REQUEST["montant"];
    if (ISSET($_REQUEST["nom"]))$nom=$_REQUEST["nom"];
    if (ISSET($_REQUEST["recurence"]))$recurence=$_REQUEST["recurence"];
    if (ISSET($_REQUEST["note"]))$note=$_REQUEST["note"];
    if (ISSET($_REQUEST["remboursable"]))$remboursable=$_REQUEST["remboursable"];
    if (ISSET($_REQUEST["personne"]))$personne=$_REQUEST["personne"];
    if (ISSET($_REQUEST["date"]))$date=$_REQUEST["date"];
    if (ISSET($_REQUEST['idDepense']))$idDepense=$_REQUEST['idDepense'];
    if (ISSET($_REQUEST["idCategorie"]))$idCategorie=$_REQUEST["idCategorie"];
    if (ISSET($_REQUEST["idCompte"]))$idCompte=$_REQUEST["idCompte"];
    else{
            $c=$cDao->find($_SESSION["connected"]);
            $idCompte=$c->getId();
    }
    if (ISSET($_REQUEST["nomCat"]))$nomCat=$_REQUEST["nomCat"];
    if (ISSET($_REQUEST["sequence"]))$_SESSION["sequence"]=$_REQUEST["sequence"];
    $sequence=$_SESSION["sequence"];
    if (ISSET($_REQUEST["rechercheDep"]))$rechercheDep=$_REQUEST["rechercheDep"];
    if (ISSET($_REQUEST["paraRechercheDep"]))$paraRechercheDep=$_REQUEST["paraRechercheDep"];
    // ---------- Afficher les forms si il y a eu une erreur dans le formulaire ----------
    if (ISSET($_REQUEST["afficherFormDepense"]))$depFormAffiche='block';
    if (ISSET($_REQUEST["afficherFormCategorie"]))$catFormAffiche='block';
    // ---------- Changer les choses lors des modifivation de champs ----------
    if (ISSET($_REQUEST["actionDepense"])){
            $btnNom=$_REQUEST["btnNom"]; // Change le nom du bouton pour aller avec l'action
            $actionDepense=$_REQUEST["actionDepense"]; // Applique la nouvelle action donner par l'autre action
    }
    if (ISSET($_REQUEST["actionCategorie"])){
            $btnCategorie=$_REQUEST["btnCategorie"]; // Change le nom du bouton pour aller avec l'action
            $actionCategorie=$_REQUEST["actionCategorie"]; // Applique la nouvelle action donner par l'autre action
    }
    ?>
    <h2>Vos dépenses <?php// echo $_SESSION["nom"]; ?></h2>
    <div class="row"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <button type="button" onclick="afficherFormDepense()">Ajouter une dépense...</button>
                    <div class="panel panel-default" id="depenseForm" style="display:<?=$depFormAffiche?>">
                        <div class="panel-heading">
                            <h4>Information de la dépense</h4>
                        </div>
                        <div class="panel-body">
                            <form action="" method="post">
                                <label for="montant">Montant($) :</label><br /> <input name="montant" type="text" value="<?=$montant?>" size=10/>
                                <?php if (ISSET($_REQUEST["field_messages"]["montant"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["montant"]."</span>";
                                ?>
                                <br />
                                <label for="nom">Nom :</label><br /> <input name="nom" type="text" value="<?=$nom?>" size=45/>
                                <?php if (ISSET($_REQUEST["field_messages"]["nom"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["nom"]."</span>";
                                ?>
                                <br />
                                <label for="idCategorie">Categorie :</label>
                                <select name="idCategorie" value="<?=$idCategorie?>">
                                <?php
                                $catListe=$catDao->findAll($idCompte);
                            while($catListe->next()){
                                $cat=$catListe->current();
                                ?>
                                        <option <?php echo ($idCategorie==$cat->getId())?$selectedCategorie:""?>><?=$cat->getNom()?></option>
                                <?php
                                }
                                ?>
                                </select>
                                <?php if (ISSET($_REQUEST["field_messages"]["idCategorie"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["idCategorie"]."</span>";
                                ?>
                                <br />
                                <label for="recurence">Recurence :</label>
                                <select name="recurence" value="<?=$recurence?>">
                                    <option value="" <?php echo ($recurence=="")?$selectedRecurence:""?>></option>
                                    <option value="quo" <?php echo ($recurence=="quo")?$selectedRecurence:""?>>Quotidien</option>
                                    <option value="heb" <?php echo ($recurence=="heb")?$selectedRecurence:""?>>Hebdomadaire</option>
                                    <option value="men" <?php echo ($recurence=="men")?$selectedRecurence:""?>>Mensuel</option>
                                    <option value="ann" <?php echo ($recurence=="ann")?$selectedRecurence:""?>>Annuel</option>
                                </select>
                                <?php if (ISSET($_REQUEST["field_messages"]["recurence"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["recurence"]."</span>";
                                ?>
                                <br />
                                <label for="note">Note :</label><br /><input name="note" type="text" value="<?=$note?>" size=45/>
                                <?php if (ISSET($_REQUEST["field_messages"]["note"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["note"]."</span>";
                                ?>
                                <br />
                                <label for="remboursable">Remboursable : </label><input name="remboursable" id="checkBoxRembours" type="checkbox" value="<?=$remboursable?>" onclick="showPersonne()" <?=($remboursable==1)?"checked=\"checked\"":""?>>
                                <label  id="lblPersonne" for="personne" style="display:none">Nom de la personne :</label> <input name="personne" type="text" value="<?=$personne?>" size=45 id="txtbxPersonne" style="display:none"/>
                                <?php if (ISSET($_REQUEST["field_messages"]["personne"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["personne"]."</span>";
                                ?>
                                <br />
                                <label for="date">Date :</label><input name="date" type="date" value="<?=$date?>" min="2000-01-02" size=45/>
                                <?php if (ISSET($_REQUEST["field_messages"]["date"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["date"]."</span>";
                                ?>
                                <br />
                                <input name="idDepense" type="hidden" value="<?=$idDepense?>"/>
                                <input name="idCompte" type="hidden" value="<?=$idCompte?>"/>
                                <input name="action" value="<?=$actionDepense?>" type="hidden" />
                                <input value=" <?=$btnNom?> " type="submit" />
                            </form>
                        </div>
                    </div> 
                </div>
                <?//===============================================================
                //                 Formulaire d'ajout d'une categorie
                ?>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <button type="button" onclick="afficherFormCategorie()">Ajouter une catégorie...</button>
                    <div class="panel panel-default" id="categorieForm" style="display:<?=$catFormAffiche?>">
                        <div class="panel-heading">
                            <h4>Nom de la catégorie</h4>
                        </div>
                        <div class="panel-body">
                            <form action="" method="post">
                                <label for="nomCat">Nom :</label><br /><input name="nomCat" type="text" value="<?=$nomCat?>" size=45/>
                                <br />
                                <?php if (ISSET($_REQUEST["field_messages"]["nomCat"])) echo "<span class=\"warningMessage\">".$_REQUEST["field_messages"]["nomCat"]."</span>";
                                ?>
                                <input name="idCompte" type="hidden" value="<?=$idCompte?>"/>
                                <input name="idCategorie" type="hidden" value="<?=$idCategorie?>"/>
                                <input name="action" value="<?=$actionCategorie?>" type="hidden" />
                                <input value=" <?=$btnCategorie?> " type="submit" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?//==============================================================
    //              		 Barre d'option d'affichage
    ?>
    <div class=row>
            <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                    <div id=paneauSettings>
                                            <div class="col-sm-4 col-md-4 col-lg-5">
                                                    <form action="" method="post">
                                                            <label>Voir les dépenses de </label>
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
                                                            <input name="action" value="depenses" type="hidden" />
                                                            <input value=" GO " type="submit" />
                                                    </form>
                                            </div>
                                            <div class="col-sm-8 col-md-8 col-lg-7">
                                                    <form action="" method="post">
                                                            <div id=rechercheDepense>
                                                                    <label for="rechercheDep">Rechercher par </label>
                                                                            <select name="paraRechercheDep" value="<?=$paraRechercheDep?>">
                                                                                    <option value="montant" <?php echo ($paraRechercheDep=="montant")?$selectedRecherche:""?>>Montant</option>
                                                                                    <option value="nom" <?php echo ($paraRechercheDep=="nom")?$selectedRecherche:""?>>Nom</option>
                                                                                    <option value="date" <?php echo ($paraRechercheDep=="date")?$selectedRecherche:""?>>Date</option>
                                                                            </select>
                                                                    <input name="rechercheDep" type="text" value="<?=$rechercheDep?>" size=20/>
                                                                    <input name="action" value="depenses" type="hidden" />
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
                    <div style="display:none" id="notificationSuppressionDepense">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    Etes-vous sur de vouloir supprimer cette dépense? 
                                            <a id="lienSuppressionDepense" href="?action=supprimerDepense&numeroDepense=validerSuppressionDepense()&numASupprimer=">Oui</a>/<a href="" onclick="annulerSuppressionDepense()">Non</a>
                                    </div>
                            </div>
                    </div>
            </div>
    </div>
    <div class="row">
            <?//===============================================================
            //               			Side gauche
            ?>
            <div class="col-sm-12 col-md-12 col-lg-5">
                    <?//===============================================================
                    //          	Tableau des stats de depense par categorie
                    ?>
                    <?// Zone pour la notification lors de la suppression?>
                    <div style="display:none" id="notificationSuppressionCategorie">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    Etes-vous sur de vouloir supprimer cette catégorie? <br />
                                    Toutes les dépense de cette catégorie seront supprimer!
                                            <a id="lienSuppressionCategorie" href="?action=supprimerCategorie&numeroCategorie=validerSuppressionCategorie()&numASupprimer=">Oui</a>/<a href=""onclick="annulerSuppressionCategorie()">Non</a>
                                    </div>
                            </div>
                    </div>
                    <div class="infoTableau">
                            <div class="col-sm-12 col-md-7 col-lg-12">
                                    <div class="panel panel-default">
                                        <div  class="panel-heading">
                                            <h3>
                                                            <a onclick="afficherTableau(3)"><span id="iconeTableau3" class="glyphicon glyphicon-minus" title="Masquer"></span></a>
                                                    Dépenses par catégorie
                                            </h3>
                                        </div>
                                            <?//========== Affichage des donnees ==========?>
                                            <div id="tableau3" style="display:block">
                                    <table class="table">
                                                <thead>
                                                    <tr class="success">
                                                        <th>Catégorie</th>
                                                        <th>Nombre</th>
                                                        <th>Total ($)</th>
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                                <?php
                                                                // Afficher toutes les categorie et les statistiques de celle-ci
                                                                $totalNb=0;
                                                                $totalMontant=0;
                                                                $listeCat=$catDao->findAll($idCompte);
                                                                while($listeCat->next()){
                                                                    // Nombre de depense par categorie
                                                                    $cat=$listeCat->current();
                                                                    $res=$dDao->findNbDepCatSequence($idCompte,$cat->getId(),$sequence);
                                                                    if($row=$res->fetch(PDO::FETCH_OBJ))$nbDep=$row->NB;
                                                                    $totalNb+=$nbDep;
                                                                    // Total des depenses par categorie
                                                                    $res=$dDao->findTotalMontantSequence($idCompte,$cat->getId(),$sequence);
                                                                    if($row=$res->fetch(PDO::FETCH_OBJ))$totDep=$row->montantTot;
                                                                    $totalMontant+=$totDep;
                                                                ?>
                                                                    <tr class="active">
                                                                            <td><?=$cat->getNom()?></td>
                                                                            <td><?=$nbDep?></td>
                                                                            <?php // Ne pas laisser seulement le signe $ dans la colonne
                                                                            if($totDep==null)$totDep=0;
                                                                            ?>
                                                                            <td><?=number_format($totDep,2)."$"?></td>
                                                                            <td>
                                                                                    <a href="?action=modifierCategorie&numeroCategorie=<?=$cat->getId()?>"><span class="glyphicon glyphicon-pencil" title="Modifier"></span></a>
                                                                                    <a onclick="validerSuppressionCategorie(<?=$cat->getId()?>)"><span class="glyphicon glyphicon-trash" title="Supprimer"></span></a>
                                                                            </td>
                                                                            </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <tr class="success">
                                                                    <td>TOTAL : </td>
                                                                    <td><?=$totalNb?></td>
                                                                    <td colspan="2"><?=number_format($totalMontant,2)."$"?> </td>
                                                                </tr>
                                                            </tbody>
                                                    </table>
                                            </div>
                                    </div>
                            </div>
                    </div>
                    <?//===============================================================
                    //          		Tableau des depenses recurentes	
                    ?>
                    <div class="infoTableau">
                            <div class="col-sm-12 col-md-4 col-lg-12">
                                    <div class="panel panel-default">
                                        <div  class="panel-heading">
                                            <h3>
                                                            <a onclick="afficherTableau(4)"><span id="iconeTableau4" class="glyphicon glyphicon-minus" title="Masquer"></span></a>
                                                    Dépenses mensuelles
                                            </h3>
                                        </div>
                                            <?//========== Affichage des donnees ==========?>
                                            <div id="tableau4" style="display:block">
                                        <table class="table">
                                                <thead>
                                                    <tr class="success">
                                                        <th>Nom</th>
                                                        <th>Rec</th>
                                                        <th>Montant($)</th>
                                                        <th>$ par mois</th>
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                                <?php
                                                                $totalParMoisRec=0; //Total par mois de touts les depenses rec
                                                                $parMoisRec=0;		// Cout par mois d'une depense
                                                                // Afficher toutes les depenses recurentes
                                                                $listeDepRec=$dDao->findAllRecurentes($idCompte);
                                                                while($listeDepRec->next()){
                                                                    $depRec=$listeDepRec->current(); // Assigner la depense dans une variable
                                                                    if($depRec->getRecurence()=='men')$parMoisRec=$depRec->getMontant();
                                                                    else{
                                                                            if($depRec->getRecurence()=='quo')$parMoisRec=$depRec->getMontant()*30;
                                                                            if($depRec->getRecurence()=='heb')$parMoisRec=$depRec->getMontant()*4;
                                                                            if($depRec->getRecurence()=='ann')$parMoisRec=$depRec->getMontant()/12;
                                                                        }
                                                                    $totalParMoisRec+=$parMoisRec;// Ajouter le montant au total
                                                                ?>
                                                                    <tr class="active">
                                                                            <td><?=$depRec->getNom()?></td>
                                                                            <td><?=$depRec->getRecurence()?></td>
                                                                            <?php // Ne pas laisser seulement le signe $ dans la colonne
                                                                            if($totDep==null)$totDep=0;
                                                                            ?>
                                                                            <td><?=number_format($depRec->getMontant(),2)."$"?></td>
                                                                            <td><?=number_format($parMoisRec,2)."$"?></td>
                                                                            <td>
                                                                                            <a href="?action=modifierDepense&numeroDepense=<?=$depRec->getId()?>"><span class="glyphicon glyphicon-pencil" title="Modifier"></span></a>
                                                                                            <a onclick="validerSuppressionDepense(<?=$depRec->getId()?>)"><span class="glyphicon glyphicon-trash" title="Supprimer"></span></a>
                                                                            </td>
                                                                            </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <tr class="success">
                                                                    <td colspan="3">TOTAL : </td>
                                                                    <td><?=number_format($totalParMoisRec,2)."$"?></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                    </table>
                                            </div>
                                    </div>
                            </div>
                    </div>
                    <?//===============================================================
                    //          	Tableau du montant des depenses par mois
                    ?>
                    <div class="infoTableau">
                            <div class="col-sm-12 col-md-4 col-lg-12">
                                    <div class="panel panel-default">
                                        <div  class="panel-heading">
                                            <h3>
                                                            <a onclick="afficherTableau(5)"><span id="iconeTableau5" class="glyphicon glyphicon-minus" title="Masquer"></span></a>
                                                    Total par mois
                                            </h3>
                                        </div>
                                            <?//========== Affichage des donnees ==========?>
                                            <div id="tableau5" style="display:block">
                                        <table class="table">
                                                <thead>
                                                    <tr class="success">
                                                        <th>Mois</th>
                                                        <th>Montant($)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                                    $mois=array("Janvier","Fevirer","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre");
                                                                        $totalDepense=0;
                                                                        $totalMois=0;
                                                                        for($i=0;$i<12;$i++){
                                                                                // Aller chercher les montant pour chaque mois
                                                                            $res=$dDao->findTotalDepenseMois($idCompte,"0".$i+1);
                                                                            if($row=$res->fetch(PDO::FETCH_OBJ))$totalMois=$row->montantTot;
                                                                            if(!$totalMois==0){
                                                                                    $totalDepense+=$totalMois;
                                                                                        ?>
                                                                                    <tr class="active">
                                                                                            <td><?=$mois[$i]?></td>
                                                                                            <td><?=$totalMois."$"?></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                    }
                                                                            }
                                                            ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="success">
                                                            <td>Total de l'année :</td>
                                                            <td><?=$totalDepense."$"?></td>
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
            <div class="col-sm-12 col-md-12 col-lg-7">
                    <?php
                    //===============================================================
                    //              Tableau des depenses V2 avec la barre de nav
                    // Sert a verifier quelle est le numero de la page selectionner
                    $numPage = 1;
                    if (ISSET($_REQUEST["numPage"]))$numPage = $_REQUEST["numPage"];
                    // Loader les liste des depenses de selon la page
                    $listeDep=$dDao->getPage($idCompte,$numPage,$_SESSION['navig']['taillePage'],$sequence);
                    if($rechercheDep!="")$listeDep=$dDao->getPageRecherche($idCompte,$numPage,$_SESSION['navig']['taillePage'],$paraRechercheDep,$rechercheDep);
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
                                                            <a onclick="afficherTableau(1)"><span id="iconeTableau1" class="glyphicon glyphicon-minus" title="Masquer"></span></a>
                                                            Vos dépenses
                                                    </h3>
                                            </div>
                                            <div class="col-sm-3 col-md-5 col-lg-5">
                                                            Résultats <?php echo $x?> &agrave; <?php echo $y?> sur un total de <?php echo $_SESSION['navig']["nbResultats"]?> 
                                            </div>
                                    </div>
                                    <?//========== Affichage des donnees ==========?>
                                    <div id="tableau1" style="display:block">
                                <table class="table">
                                        <thead>
                                            <tr class="info">
                                                <th>Montant</th>
                                                <th>Nom</th>
                                                <th>Date</th>
                                                <th>Catégorie</th>
                                                <th>Note</th>
                                                <th>Récurence</th>
                                                <th>Options</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                                        <?php
                                                        // Remplir le tableau des depenses avec toutes les depnsees du compte
                                                        while($listeDep->next()){
                                                            $d=$listeDep->current();
                                                        ?>
                                                            <tr class="active">
                                                                    <td><?=$d->getMontant()?>$</td>
                                                                    <td><?=$d->getNom()?></td>
                                                                    <td><?=substr($d->getDate(),0,10)?></td>
                                                                    <?// Afficher le nom de la categorie selon le id trouver?>
                                                                    <td><?=$catDao->find($idCompte,$d->getIdCategorie())->getNom()?></td>
                                                                    <td><?php // Verification de la longueur de la note. Si elle est trop grande, on la trim et la met dans le titre
                                                                                            // Pour que lors du survol de la note, elle apparesse au complet
                                                                            if(strlen($d->getNote())>12){
                                                                            ?>
                                                                                    <span title="<?=$d->getNote()?>">
                                                                                            <?=substr($d->getNote(),0,10)."..."?>
                                                                                    </span>
                                                                            <?php
                                                                            }else echo $d->getNote();
                                                                            ?>
                                                                    </td>
                                                                    <td>
                                                                    <?php // Ne pas laisser le champ vide si il n'yu a pas de recurence a la depense
                                                                    if($d->getRecurence()==null)echo "--";
                                                                    else echo $d->getRecurence();
                                                                    ?>
                                                                    </td>
                                                                    <?// Icone pour supprimer la depense?>
                                                                    <td>
                                                                            <a href="?action=modifierDepense&numeroDepense=<?=$d->getId()?>"><span class="glyphicon glyphicon-pencil" title="Modifier"></span></a>
                                                                            <a onclick="validerSuppressionDepense(<?=$d->getId()?>)"><span class="glyphicon glyphicon-trash" title="Supprimer"></span></a>
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
                                                                                            <a href="./?action=depenses&numPage=1"><b>&lt;&lt;</b></a>
                                                                                            <a href="./?action=depenses&numPage=<?php echo $numPage-1?>"><b>&lt;</b></a>
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
                                                                                if ($i == $numPage)echo $i;
                                                                                else echo "<a href=\"./?action=depenses&numPage=".$i."\"> ".$i."</a>";
                                                                            }
                                                                        ?>
                                                                            </div>
                                                                            <?php
                                                                            // -------- Affiche les fleches
                                                                            if ($numPage < $_SESSION["navig"]["nbPages"]){
                                                                                    ?>
                                                                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                                                                            <a href="./?action=depenses&numPage=<?php echo $numPage+1?>"><b>&gt;</b></a>
                                                                                            <a href="./?action=depenses&numPage=<?php echo $_SESSION["navig"]["nbPages"]?>"><b>&gt;&gt;</b></a>
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
            <div class="col-sm-12 col-md-12 col-lg-7">
                    <?//========== Titre du tableau ==========?>
                    <div class="infoTableau">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                            <h3>
                                                    <a onclick="afficherTableau(6)"><span id="iconeTableau6" class="glyphicon glyphicon-minus" title="Masquer"></span></a>
                                                    Vos dépenses remboursables
                                            </h3>
                                    </div>
                                    <?//========== Affichage des donnees ==========?>
                                    <div id="tableau6" style="display:block">
                                <table class="table">
                                        <thead>
                                            <tr class="info">
                                                <th>Montant</th>
                                                <th>Nom</th>
                                                <th>Date</th>
                                                <th>Personne</th>
                                                <th>Options</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                                        $listeDepRem=$dDao->findAllRemboursables($idCompte);
                                                        while($listeDepRem->next()){
                                                            $depRem=$listeDepRem->current(); // Assigner la depense dans une variable
                                                            ?>
                                                            <tr class="active">
                                                                    <td><?=$depRem->getMontant()?></td>
                                                                    <td><?=$depRem->getNom()?></td>
                                                                    <td><?=substr($depRem->getDate(),0,10)?></td>
                                                                    <td><?=$depRem->getNomPersonne()?></td>
                                                                    <td>
                                                                                    <a href="?action=rembourserDepense&numeroCompte=<?=$idCompte?>&numeroDepense=<?=$depRem->getId()?>"><span class="glyphicon glyphicon-ok" title="Remboursée"></span></a>
                                                                                    <a href="?action=modifierDepense&numeroDepense=<?=$depRem->getId()?>"><span class="glyphicon glyphicon-pencil" title="Modifier"></span></a>
                                                                                    <a onclick="validerSuppressionDepense(<?=$depRem->getId()?>)"><span class="glyphicon glyphicon-trash" title="Supprimer"></span></a>
                                                                    </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                            </div>
                    </div>
            </div>
        </div>
    </div>
</div>