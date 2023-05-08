<?php
    include "connexion/config.php";
    include "connexion/cn.php";
    if(isset($_POST['ajouterCDE'])){
        $num = $_POST['ndepart'];
        $annee = $_POST['annee'];
        $objet =  $_POST['objet'];
        $date = $_POST['date'];
        $reponse = $_POST['reponse'];
        $destinataire = $_POST['des'];
        $departement = $_POST['departement'];
        $personne = $_POST['personnel'];
        $adresseDes = $_POST['adresseD'];
        $teleDes = $_POST['teleD'];
        $faxDes = $_POST['faxD'];
        $pj = $_FILES['pj']['name'];
        $pj_tmp_name = $_FILES['pj']['tmp_name'];
        $pj_folder = 'pj/CDE/'.$pj;

    

        if($num==null || $annee==null || $objet==null || $date==null || $reponse==null || $destinataire==null || $departement==null){
            echo "<div class='alert alert-danger almessage' role='alert'>
            Veuillez remplir les champs obligatoires!".$dep."
             </div>";
        }else{
            $esql = "INSERT INTO destinataire (NOM_DES,ADRESSE_DES,TEL_DES,FAX_DES)
                VALUES( :ndes, :adresseD, :teleD, :faxD)";
                $query1 = $conn->prepare($esql);
                $query1->bindParam(':ndes', $destinataire, PDO::PARAM_STR);
                $query1->bindParam(':adresseD', $adresseDes, PDO::PARAM_STR);
                $query1->bindParam(':teleD', $teleDes, PDO::PARAM_STR);
                $query1->bindParam(':faxD', $faxDes, PDO::PARAM_STR);
                $query1->execute();
                
            //Destinataire
                $reqDes = "SELECT ID_DES from destinataire where NOM_DES=:ndes";
                $exDes = $conn->prepare($reqDes);
                $exDes->bindParam(':ndes', $destinataire, PDO::PARAM_STR);
                $exDes->execute();
                $tabDES=$exDes->fetch(PDO::FETCH_ASSOC);
                $idDes=$tabDES['ID_DES'];

    
                $csql = "INSERT INTO courrier_depart_ext (N_DEPART_EXT,ID_DEPARTEMENT,ID_DES,ANNEE,OBJET_DEPART_EXT,DATE_DEPART_EXT,PIECE_JOINTE_DEPART_EXT,REPONSE)
                    VALUES( :ndepart, :iddep, :iddes, :annee, :objet, :dated, :pj, :reponse)";
                    $query = $conn->prepare($csql);
                    $query->bindParam(':ndepart', $num, PDO::PARAM_INT);
                    $query->bindParam(':iddep', $departement, PDO::PARAM_INT);
                    $query->bindParam(':iddes', $idDes, PDO::PARAM_INT);
                    $query->bindParam(':annee', $annee, PDO::PARAM_STR);
                    $query->bindParam(':objet', $objet, PDO::PARAM_STR);
                    $query->bindParam(':dated', $date, PDO::PARAM_STR);
                    $query->bindParam(':pj', $pj, PDO::PARAM_STR);
                    $query->bindParam(':reponse', $reponse, PDO::PARAM_STR);
                    $query->execute();

                    move_uploaded_file($pj_tmp_name, $pj_folder);

                foreach($personne as $pers){
                    $transsql = "INSERT INTO transmettre2 (N_DEPART_EXT,ID_PERSONNEL)
                        VALUES(:ndepart, :idper)";
                        $query4 = $conn->prepare($transsql);
                        $query4->bindParam(':ndepart', $num, PDO::PARAM_INT);
                        $query4->bindParam(':idper', $pers, PDO::PARAM_INT);
                        $query4->execute();
                }
                
                    // $transsql = "INSERT INTO transmettre2 (N_DEPART_EXT,ID_PERSONNEL)
                    //     VALUES(:ndepart, :idper)";
                    //     $query4 = $conn->prepare($transsql);
                    //     $query4->bindParam(':ndepart', $num, PDO::PARAM_INT);
                    //     $query4->bindParam(':idper', $personne, PDO::PARAM_INT);
                    //     $query4->execute();
                

                echo "<div class='alert alert-success almessage' role='alert'>
                Courrier ajouté avec succès!
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    
    
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
	<title>AdminSite</title>
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
								<h2>Courrier départ externe</h2><br>
							</div>
		
                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

                            <div class="row g-5 mb-3">
                                    <?php
                                        $reqExp = "SELECT N_DEPART_EXT from courrier_depart_ext ORDER BY N_DEPART_EXT desc LIMIT 1";
                                        $exExp = $conn->prepare($reqExp);
                                        $exExp->execute();
                                        $tabExp=$exExp->fetch(PDO::FETCH_ASSOC);
                                        $ndepartExt=$tabExp['N_DEPART_EXT'];
                                        $ndepartExt++;     
                                    ?>
                                <div class="col">
                                    <label>N&#186; départ *</label>
                                    <input type="text" value="<?php echo $ndepartExt?>" name="ndepart" class="form-control" readonly>
                                </div>
                                <div class="col">
                                    <label>Annee *</label>
                                    <input type="text" id="ann" name="annee" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Objet *</label>
                                <textarea class="form-control" name="objet" rows="3"></textarea>
                            </div>
                            <div class="row g-5 mb-3">
                                <div class="col">
                                    <label>Date de départ *</label>
                                    <input type="date" name="date" class="form-control">
                                </div>
                                
                                <div class="col">
                                    <label >Réponse *</label><br>
                                    <input type="radio" name="reponse" value="Oui">
                                    <label>Oui</label><br>
                                    <input type="radio" name="reponse" value="Non">
                                    <label>Non</label><br>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Destinataire *</label>
                                <input type="text" name="des" class="form-control">
                                
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <label for="">Département *</label>
                                    <select onChange="getP(this.value);" name="departement" id="departement" class="form-control" >
                                    <option value="" selected disabled hidden>Sélectionner un département</option>
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
                                    <select name="personnel[]"  id="personnel" class="form-control">
                                        <option value="" selected disabled hidden>Sélectionner un personnel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Adresse destinataire :</label>
                                <input type="text" name="adresseD" class="form-control">
                            </div>
                            <div class="row g-3 mb-3">
                                    <div class="col">
                                        <label>N&#186; tele :</label>
                                        <input type="text" name="teleD" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label>Fax :</label>
                                        <input type="text" name="faxD" class="form-control">
                                    </div>
                            </div>
                            <div class="mb-4 w-50">
                                <label>Pièce jointe :</label>
                                <input type="file" name="pj" class="form-control">
                            </div>
                            <div class="mb-4">
                                    <button type="submit" name="ajouterCDE" class="btn btn-success btn-lg">Ajouter</button>
                                    <button type="submit" name="" class="btn btn-danger"><a href="courrierDepartEx.php">Annuler</a></button>
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
        function getP(val) {
            $.ajax({
            type: "POST",
            url: "fetchSelect.php",
            data:'id='+val,
            success: function(data){
                $("#personnel").html(data);
            }
            });
        }
    </script>
   
</body>
</html>