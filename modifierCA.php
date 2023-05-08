<?php
    include "connexion/config.php";
    include "connexion/cn.php";
    $nca = $_GET['modifier'];
    $idExp = $_GET['val'];
    if(isset($_POST['modifierCA'])){
        $num = $_POST['narrive'];
        $annee = $_POST['annee'];
        $objet =  $_POST['objet'];
        $date = $_POST['date'];
        $reponse = $_POST['reponse'];
        $exp = $_POST['exp'];
        $departement = $_POST['departement'];
        $personne = $_POST['personnel'];
        $adresseExp = $_POST['adresseE'];
        $teleExp = $_POST['teleE'];
        $faxExp = $_POST['faxE'];
        $pj = $_FILES['pj']['name'];
        $pj_tmp_name = $_FILES['pj']['tmp_name'];
        $pj_folder = 'pj/CA/'.$pj;

    

        if($num==null || $annee==null || $objet==null || $date==null || $reponse==null || $exp==null || $departement==null){
            echo "<div class='alert alert-danger almessage' role='alert'>
            Veuillez remplir les champs obligatoires!
             </div>";
        }else{
            $esql = "UPDATE expediteur SET NOM_EXP=:nexp ,ADRESSE_EXP=:adresseE,TEL_EXP=:teleE,FAX_EXP=:faxE WHERE ID_EXP='$idExp'";
                $query1 = $conn->prepare($esql);
                $query1->bindParam(':nexp', $exp, PDO::PARAM_STR);
                $query1->bindParam(':adresseE', $adresseExp, PDO::PARAM_STR);
                $query1->bindParam(':teleE', $teleExp, PDO::PARAM_STR);
                $query1->bindParam(':faxE', $faxExp, PDO::PARAM_STR);
                $query1->execute();
                

            $csql = "UPDATE courrier_arrivee SET N_ARRIVEE=:narrivee ,ID_EXP=:idexp ,ANNEE=:annee ,OBJET_ARRIVEE=:objet ,DATE_ARRIVEE=:datea ,PIECE_JOINTE_ARRIVEE=:pj ,REPONSE=:reponse WHERE N_ARRIVEE='$nca'";
                $query2 = $conn->prepare($csql);
                $query2->bindParam(':narrivee', $num, PDO::PARAM_INT);
                $query2->bindParam(':idexp', $idExp, PDO::PARAM_INT);
                $query2->bindParam(':annee', $annee, PDO::PARAM_STR);
                $query2->bindParam(':objet', $objet, PDO::PARAM_STR);
                $query2->bindParam(':datea', $date, PDO::PARAM_STR);
                $query2->bindParam(':pj', $pj, PDO::PARAM_STR);
                $query2->bindParam(':reponse', $reponse, PDO::PARAM_STR);
                $query2->execute();

                move_uploaded_file($pj_tmp_name, $pj_folder);

            foreach($departement as $dep){
                $affsql = "UPDATE affecter SET N_ARRIVEE=:narrivee ,ID_DEPARTEMENT=:iddep WHERE N_ARRIVEE='$nca'";
                    $query3 = $conn->prepare($affsql);
                    $query3->bindParam(':narrivee', $num, PDO::PARAM_INT);
                    $query3->bindParam(':iddep', $dep, PDO::PARAM_INT);
                    $query3->execute();

            }
            foreach($personne as $pers){
                $transsql = "UPDATE transmettre SET ID_PERSONNEL=:idprs ,N_ARRIVEE=:narrivee WHERE N_ARRIVEE='$nca'";
                    $query4 = $conn->prepare($transsql);
                    $query4->bindParam(':idprs', $pers, PDO::PARAM_INT);
                    $query4->bindParam(':narrivee', $num, PDO::PARAM_INT);
                    $query4->execute();
                    }
                echo "<div class='alert alert-success almessage' role='alert'>
                Courrier modifié avec succès!
            </div>";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/select.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    
    
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
	<title>Gestion de bureau d'ordre</title>
</head>
<body onload="myFunction()">
	
	<!-- SIDEBAR -->
    <section id="sidebar">
		<a href="#" class="brand"><img src="image/logo.png" width="55" height="55" style="margin-top:20px;"><span>Gestion de Bureau d'Ordre</span></a>
		<ul class="side-menu">
			<li><a href="pageAcc.php" class="active"><i class='bx bxs-dashboard icon' ></i>Page d'accueil</a></li>
			
			<li>
				<a href="#"><i class='bx bx-envelope icon' ></i>Ajout d'un Courrier<i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="courrierA.php">Arrivée</a></li>
					<li><a href="courrierDepartEx.php">Départ externe</a></li>
					<li><a href="courrierDepartIn.php">Départ interne</a></li>
				</ul>
			</li>
			<li><a href="expediteur.php"><i class='bx bx-send icon' ></i>Expéditeur</a></li>
			<li><a href="destinataire.php"><i class='bx bx-envelope-open icon' ></i>Destinataire</a></li>
			<li><a href="departement.php"><i class='bx bx-briefcase-alt-2 icon' ></i>Département</a></li>
			<li><a href="personnel.php"><i class='bx bxs-user-pin icon' ></i>Personnel</a></li>
			
			<li>
				<a href="#"><i class='bx bxs-notepad icon' ></i>Edition <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="filtreCA.php">Arrivée</a></li>
					<li><a href="filtreCD.php">Départ</a></li>

				</ul>
			</li>
            <li>
				<a href="#"><i class='bx bx-list-plus icon' ></i>Mise à jour<i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="listeCA.php">Arrivée</a></li>
					<li><a href="listeCDE.php">Départ Externe</a></li>
					<li><a href="listeCDI.php">Départ Interne</a></li>

				</ul>
			</li>
			<?php
			session_start();
			if($_SESSION['typeC']=='admin'){
			?>
			<li><a href="gestionU.php"><i class='bx bxs-user-pin icon' ></i>Gestion des utilisateurs</a></li>
			<?php }?>
			<li><a href="settings.php"><i class='bx bx-cog icon'></i>Paramètres</a></li>
			<li><a href="deconn.php"><i class='bx bx-log-out icon' ></i> Déconnexion</a></li>
			
			
			
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->

		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="data">
				<div class="content-data">
					<div class="details">
						<div class="recentOrders">
							<div class="cardHeader">
								<h2>Modification d'un courrier arrivée</h2><br>
							</div>
		
                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                    <?php
                                        $reqCA = "SELECT * from courrier_arrivee WHERE N_ARRIVEE='$nca'";
                                        $exCA = $conn->prepare($reqCA);
                                        $exCA->execute();
                                        $ca=$exCA->fetchAll(PDO::FETCH_ASSOC);
                                foreach($ca as $value){  
                                    ?>
                                <div class="row g-5 mb-3">
                                    <div class="col">
                                        <label>N&#186; d'arrivée *</label>
                                        <input type="text" value="<?php echo $value['N_ARRIVEE']?>" name="narrive" class="form-control" readonly>
                                    </div>
                                    
                                    <div class="col">
                                        <label>Annee *</label>
                                        <input type="text" value="<?php echo $value['ANNEE']?>" id="ann" name="annee" class="form-control" readonly>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label>Objet *</label>
                                    <textarea class="form-control" value="<?php echo $value['OBJET_ARRIVEE']?>" name="objet" rows="3"></textarea>
                                </div>
                                <div class="row g-5 mb-3">
                                    <div class="col">
                                        <label>Date d'arrivée *</label>
                                        <input type="date" value="<?php echo $value['DATE_ARRIVEE']?>" name="date" class="form-control">
                                    </div>
                                <?php }?>
                                    <div class="col">
                                        <label ></label><br>
                                        <input type="radio" name="reponse" value="Avec Reponse">
                                        <label>Avec Réponse</label><br>
                                        <input type="radio" name="reponse" value="Sans Reponse">
                                        <label>Sans Réponse</label><br>
                                    </div>
                                </div>
                                <?php 
                                $sql = "SELECT * FROM expediteur where Id_EXP = '$idExp'";
                                $exp = $conn->prepare($sql);
                                $exp->execute();
                                $tabExp=$exp->fetchAll(PDO::FETCH_ASSOC);
                                foreach($tabExp as $value){
                                ?>
                                <div class="mb-3">
                                    <label>Expéditeur *</label>
                                    <input type="text" name="exp" value="<?php echo $value['NOM_EXP']?>" class="form-control">
                                </div>
                                
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <label for="">Département *</label>
                                    <select name="departement[]" multiple id="departement" class="form-control" >
    
                                    <!--- Fetching States--->
                                    <?php
                                    $sql="SELECT * FROM departement";
                                    $stmt=$dbh->query($sql);
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    while($row =$stmt->fetch()) { 
                                    ?>
                                    <option value="<?php echo $row['ID_DEPARTEMENT'];?>"><?php echo $row['NOM_DEPARTEMENT'];?></option>
                                    <?php }?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="">Personnel *</label>
                                    <select name="personnel[]" id="personnel" multiple class="form-control">
                                        
                                    </select>
                                </div>
                            </div>
                                <div class="mb-3">
                                    <label>Adresse expéditeur </label>
                                    <input type="text" name="adresseE" value="<?php echo $value['ADRESSE_EXP']?>" class="form-control">
                                </div>
                                <div class="row g-3 mb-3">
                                        <div class="col">
                                            <label>N&#186; tele </label>
                                            <input type="text" name="teleE" value="<?php echo $value['TEL_EXP']?>" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label>Fax </label>
                                            <input type="text" name="faxE" value="<?php echo $value['FAX_EXP']?>" class="form-control">
                                        </div>
                                </div>
                                <?php }?>
                                <div class="mb-5 w-50">
                                    <label>Pièce jointe </label>
                                    <input type="file" name="pj" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <button type="submit" name="modifierCA" class="btn btn-success btn-lg">Modifier</button>
                                    <button type="submit" name="" class="btn btn-danger"><a href="listeCA.php">Annuler</a></button>
                                </div>
                            </form>
						</div>
		
						<!-- ================= New Customers ================ -->
					  
					</div>

				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function myFunction() {
            const d = new Date();
            let year = d.getFullYear();
         document.getElementById("ann").defaultValue = year;
        }
    </script>
    <script>
        $(document).ready(function(){

        $('#departement').multiselect({
        nonSelectedText:'Sélectionner un département',
        buttonWidth:'400px',
        onChange:function(option, checked){
        $('#personnel').html('');
        $('#personnel').multiselect('rebuild');
        var selected = this.$select.val();
        if(selected.length > 0)
        {
        $.ajax({
            url:"fetchMultiSelect.php",
            method:"POST",
            data:{selected:selected},
            success:function(data)
            {
            $('#personnel').html(data);
            $('#personnel').multiselect('rebuild');
            }
        })
        }
        }
        });

        $('#personnel').multiselect({
        nonSelectedText: 'Sélectionner un personnel',
        buttonWidth:'400px',
        });

        });
</script>
</body>
</html>