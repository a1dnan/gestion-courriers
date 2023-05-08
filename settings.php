<?php
    session_start();
    include "connexion/config.php";
	$user=$_SESSION['user'];
    if(isset($_POST['modifier'])){
        $pass = filter_var(htmlentities(md5($_POST['pass']),FILTER_SANITIZE_STRING));
        $nvpass = filter_var(htmlentities(md5($_POST['nvpass']),FILTER_SANITIZE_STRING));
        $cnvpass = filter_var(htmlentities(md5($_POST['cnvpass']),FILTER_SANITIZE_STRING));

        if($pass==null || $nvpass==null || $cnvpass==null ){
            echo "<div class='alert alert-danger almessage' role='alert'>
            Veuillez remplir les champs obligatoires!
            </div>";
        }else{
		$loginsql = "SELECT * FROM utilisateur WHERE NOMUTILISATEUR = :user  AND MOTDEPASSE = :mdps";
		$query = $conn->prepare($loginsql);
		$query->bindParam(':user', $user, PDO::PARAM_STR);
		$query->bindParam(':mdps', $pass, PDO::PARAM_STR);
		$query->execute();
		$num = $query->rowCount();
			if($num == 0){
				echo "<div class='alert alert-danger almessage' role='alert'>
					le mot de passe est incorrect!
					</div>";
			}else{
				if($nvpass!=$cnvpass){
					echo "<div class='alert alert-danger almessage' role='alert'>
					Les mots de passe ne sont pas identiques!
					</div>";
				}else{
					$id=$_SESSION['idC'];
					$depsql = "UPDATE utilisateur SET MOTDEPASSE=:pass WHERE IDCOMPTE='$id'";
						$query = $conn->prepare($depsql);
						$query->bindParam(':pass', $nvpass, PDO::PARAM_STR);
						$query->execute(); 
						echo "<div class='alert alert-success almessage' role='alert'>
						Mot de passe modifié avec succès!
					</div>";
				}
        	}
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
<body>
	
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
								<h2>Paramètres</h2><br>
							</div>

                            <form action="" method="POST">

                            <div class="mb-3">
                                <label>Mot de passe actuel :</label>
                                <input type="password" name="pass" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Nouveau mot de passe :</label>
                                <input type="password" name="nvpass" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label>Confirmer votre mot de passe :</label>
                                <input type="password" name="cnvpass" class="form-control">
                            </div>
        
                                <div class="mb-4">
                                    <button type="submit" name="modifier" class="btn btn-success btn-lg">Modifer</button>
                                    <button type="submit" name="" class="btn btn-danger"><a href="index.php">Annuler</a></button>
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

</body>
</html>