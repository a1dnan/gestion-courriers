<?php
    include "connexion/config.php";
	include "connexion/cn.php";
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
			<div class="data">
				<div class="content-data">
					<div class="details">
						<div class="recentOrders">
							<div class="cardHeader">
								<h3>Liste des expéditeurs</h3>
								
							</div>
		
							</div class="table-responsive">
                                    <table id="example" class="table table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    
                                                    <th scope="col">Nom </th>
                                                    <th scope="col">Adresse</th>
                                                    <th scope="col">Tele</th>
                                                    <th scope="col">Fax</th>
                                                    <th scope="col">Modifier</th>
                                                
                                                </tr>
                                            </thead>

                                            <?php 
                                $sql = "SELECT * FROM expediteur";
                                $exp = $conn->prepare($sql);
                                $exp->execute();
                                $tabExp=$exp->fetchAll(PDO::FETCH_ASSOC);
                                foreach($tabExp as $value){
                                ?>
                                <tr>
                                    <td><?php echo $value['NOM_EXP']?></td>
                                    <td><?php echo $value['ADRESSE_EXP']?></td>
                                    <td><?php echo $value['TEL_EXP']?></td>
                                    <td><?php echo $value['FAX_EXP']?></td>
									<td>
                                        <a href="modifierExp.php?modifier=<?php echo $value['ID_EXP']; ?>"><button type="button" class="btn"><i class='bx bxs-edit'></i></button></a>
                                    </td>  
                                </tr>
                                <?php }?>
                                                
                                        </table>
                                    </div>
                            </div>
                                
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
    <script src="js/main.js"></script>
    <script src="js/main2.js"></script>
    <script src="js/main3.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

</body>
</html>