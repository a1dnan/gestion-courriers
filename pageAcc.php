<?php

	include "connexion/config.php";
    include "connexion/cn.php";

	$reqCA = "SELECT COUNT(*) AS numberCA from courrier_arrivee";
                $exCA = $conn->prepare($reqCA);
                $exCA->execute();
                $CA=$exCA->fetch(PDO::FETCH_ASSOC);
                $numCA=$CA['numberCA'];

	$reqCDE = "SELECT COUNT(*) AS numberCDE from courrier_depart_ext";
                $exCDE = $conn->prepare($reqCDE);
                $exCDE->execute();
                $CDE=$exCDE->fetch(PDO::FETCH_ASSOC);
                $numCDE=$CDE['numberCDE'];

	$reqCDI = "SELECT COUNT(*) AS numberCDI from courrier_depart_int";
                $exCDI = $conn->prepare($reqCDI);
                $exCDI->execute();
                $CDI=$exCDI->fetch(PDO::FETCH_ASSOC);
                $numCDI=$CDI['numberCDI'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="css/style.css">
	<title>GBO</title>
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
		<nav>
			<i class='bx bx-menu toggle-sidebar' ></i>

			<span class="divider"></span>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
		<div class="info-data">
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $numCA?></h2>
							<p>Courriers arrivées</p>
						</div>
						<i class='bx bx-trending-up icon' ></i>
					</div>
					
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $numCDE?></h2>
							<p>Courriers départs Externe</p>
						</div>
						<i class='bx bx-trending-up icon' ></i>
					</div>
				
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $numCDI?></h2>
							<p>Courriers départs Interne</p>
						</div>
						<i class='bx bx-trending-up icon' ></i>
					</div>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $numCDI+$numCDE+$numCA?></h2>
							<p>Total des courriers</p>
						</div>
						<i class='bx bx-trending-up icon' ></i>
					</div>
				</div>
				
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="js/script.js"></script>
    <script src="js/main.js"></script>
    <script src="js/main2.js"></script>
    <script src="js/main3.js"></script>
    
>
</body>
</html>