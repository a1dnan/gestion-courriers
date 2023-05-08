<?php
include "connexion/config.php";
include "connexion/cn.php";
if(!empty($_POST["id"])) 
{
$id=$_POST["id"];
$sql=$dbh->prepare("SELECT * FROM personnel WHERE ID_DEPARTEMENT=:id");
$sql->execute(array(':id' => $id));	
?>
<?php
while($row =$sql->fetch())
{
?>
<option value="<?php echo $row["ID_PERSONNEL"]; ?>"><?php echo $row["NOM_PERSONNEL"]; ?></option>
<?php
}
}
?>
