<?php

//fetch_second_level_category.php

include "connexion/cn.php";

if(isset($_POST["selected"]))
{
 $id = join("','", $_POST["selected"]);
 $query = "
 SELECT * from personnel WHERE ID_DEPARTEMENT IN ('".$id."')
 ";
 $statement = $dbh->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  $output .= '<option value="'.$row["ID_PERSONNEL"].'">'.$row["NOM_PERSONNEL"].'</option>';
 }
 echo $output;
}

?>

