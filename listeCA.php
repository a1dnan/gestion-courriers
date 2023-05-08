<?php
    include "connexion/config.php";
    include "connexion/cn.php";

	if(isset($_GET['supprimer']) && isset($_GET['val'])){
        $numCA = $_GET['supprimer'];
        $idExp = $_GET['val'];
        
        $csql = "DELETE FROM affecter WHERE N_ARRIVEE='$numCA'";
        $query = $conn->prepare($csql);
        $query->execute();
        
        $csql3 = "DELETE FROM transmettre WHERE N_ARRIVEE='$numCA'";
        $query3 = $conn->prepare($csql3);
        $query3->execute();

        $csql2 = "DELETE FROM courrier_arrivee WHERE N_ARRIVEE='$numCA'";
        $query2 = $conn->prepare($csql2);
        $query2->execute();

		$csql4 = "DELETE FROM expediteur WHERE ID_EXP='$idExp'";
        $query4 = $conn->prepare($csql4);
        $query4->execute();
        
        
        header('location:listeCA.php');
        };

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
								<h3>Mise à jour des courriers arrivées</h3>
							</div>
		
							
                                
							</div class="table-responsive">
                                    <table id="example" class="table table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    
                                                    <th scope="col">N&#186; d'arrivée</th>
                                                    <th scope="col">Objet</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Expéditeur</th>
                                                    <th scope="col">Adresse</th>
                                                    <th scope="col">Département</th>
                                                    <th scope="col">Personnel</th>
                                                    <th scope="col">Pièce jointe</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <?php
                                                $sql = "SELECT c.N_ARRIVEE,ANNEE,OBJET_ARRIVEE,DATE_ARRIVEE,PIECE_JOINTE_ARRIVEE,c.ID_EXP,NOM_EXP,ADRESSE_EXP,NOM_DEPARTEMENT,NOM_PERSONNEL
                                                from courrier_arrivee c join expediteur e on c.ID_EXP=e.ID_EXP join affecter a on a.N_ARRIVEE=c.N_ARRIVEE JOIN
                                                departement d on d.ID_DEPARTEMENT=a.ID_DEPARTEMENT JOIN personnel p on p.ID_DEPARTEMENT=d.ID_DEPARTEMENT ORDER BY `DATE_ARRIVEE` DESC";
                                                $query = $conn->prepare($sql);
                                                $query->execute();
                                                $row=$query->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($row as $value){
                                                ?>
                                            <tr>
                                                <td><?php echo $value['N_ARRIVEE']."/".$value['ANNEE']?></td>
                                                <td><?php echo $value['OBJET_ARRIVEE']?></td>
                                                <td><?php echo $value['DATE_ARRIVEE']?></td>
                                                <td><?php echo $value['NOM_EXP']?></td>
                                                <td><?php echo $value['ADRESSE_EXP']?></td>
                                                <td><?php echo $value['NOM_DEPARTEMENT']?></td>
                                                <td><?php echo $value['NOM_PERSONNEL']?></td>
                                                <td><a href="pj/CA/<?php echo $value['PIECE_JOINTE_ARRIVEE']?>"><?php echo $value['PIECE_JOINTE_ARRIVEE']?></a></td>
                                                
                                                <td>
                                                    <a href="modifierCA.php?modifier=<?php echo $value['N_ARRIVEE'];?>&val=<?php echo $value['ID_EXP'];?>"><button type="button" class="btn"><i class='bx bxs-edit'></i></button></a>
                                                    <a href="listeCA.php?supprimer=<?php echo $value['N_ARRIVEE'];?>&val=<?php echo $value['ID_EXP'];?>"><button type="button" class="btn"><i class='bx bxs-trash'></i></button></a>
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