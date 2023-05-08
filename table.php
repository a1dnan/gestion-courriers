<?php
include "connexion/config.php";
include "connexion/cn.php";
require('TCPDF/tcpdf.php');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
}
if(isset($_POST['filtrerCA'])){
        
    $dateD = $_POST['dateD'];
    $dateF= $_POST['dateF'];
    $annee= $_POST['annee'];
    $departement= $_POST['departement'];

    if(!empty($dateD) && !empty($dateF) && !empty($annee) && !empty($departement)){
        $req = "SELECT c.N_ARRIVEE,ANNEE,OBJET_ARRIVEE,DATE_ARRIVEE,PIECE_JOINTE_ARRIVEE,NOM_EXP,ADRESSE_EXP,NOM_DEPARTEMENT,NOM_PERSONNEL
                from courrier_arrivee c join expediteur e on c.ID_EXP=e.ID_EXP join affecter a on a.N_ARRIVEE=c.N_ARRIVEE JOIN
                departement d on d.ID_DEPARTEMENT=a.ID_DEPARTEMENT JOIN personnel p on p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE
                ANNEE=:annee AND NOM_DEPARTEMENT=:ndep AND DATE_ARRIVEE BETWEEN :dateD AND :dateF ORDER BY N_ARRIVEE";
        $query = $conn->prepare($req);
        $query->bindParam(':annee', $annee, PDO::PARAM_STR);
        $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
        $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
        $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
        $query->execute();
        
    }else if(!empty($dateD) && !empty($dateF) && !empty($departement)){
        $req = "SELECT c.N_ARRIVEE,ANNEE,OBJET_ARRIVEE,DATE_ARRIVEE,PIECE_JOINTE_ARRIVEE,NOM_EXP,ADRESSE_EXP,NOM_DEPARTEMENT,NOM_PERSONNEL 
                from courrier_arrivee c join expediteur e on c.ID_EXP=e.ID_EXP join affecter a on a.N_ARRIVEE=c.N_ARRIVEE JOIN departement d on 
                d.ID_DEPARTEMENT=a.ID_DEPARTEMENT JOIN personnel p on p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE NOM_DEPARTEMENT=:ndep AND DATE_ARRIVEE BETWEEN :dateD AND :dateF ORDER BY N_ARRIVEE";
        $query = $conn->prepare($req);
        $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
        $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
        $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
        $query->execute();
        
    }else if(!empty($dateD) && !empty($dateF)){
        $req = "SELECT c.N_ARRIVEE,ANNEE,OBJET_ARRIVEE,DATE_ARRIVEE,PIECE_JOINTE_ARRIVEE,NOM_EXP,ADRESSE_EXP,NOM_DEPARTEMENT,NOM_PERSONNEL 
                from courrier_arrivee c join expediteur e on c.ID_EXP=e.ID_EXP join affecter a on a.N_ARRIVEE=c.N_ARRIVEE JOIN departement d on 
                d.ID_DEPARTEMENT=a.ID_DEPARTEMENT JOIN personnel p on p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE DATE_ARRIVEE BETWEEN :dateD AND :dateF ORDER BY N_ARRIVEE";
        $query = $conn->prepare($req);
        $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
        $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
        $query->execute();
        
    }else if(!empty($annee) && !empty($departement)){
        $req = "SELECT c.N_ARRIVEE,ANNEE,OBJET_ARRIVEE,DATE_ARRIVEE,PIECE_JOINTE_ARRIVEE,NOM_EXP,ADRESSE_EXP,NOM_DEPARTEMENT,NOM_PERSONNEL from
                courrier_arrivee c join expediteur e on c.ID_EXP=e.ID_EXP join affecter a on a.N_ARRIVEE=c.N_ARRIVEE JOIN departement d on 
                d.ID_DEPARTEMENT=a.ID_DEPARTEMENT JOIN personnel p on p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE ANNEE=:annee AND NOM_DEPARTEMENT=:ndep ORDER BY N_ARRIVEE";
        $query = $conn->prepare($req);
        $query->bindParam(':annee', $annee, PDO::PARAM_STR);
        $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
        $query->execute();
        
    }else if(!empty($annee)){
        $req = "SELECT c.N_ARRIVEE,ANNEE,OBJET_ARRIVEE,DATE_ARRIVEE,PIECE_JOINTE_ARRIVEE,NOM_EXP,ADRESSE_EXP,NOM_DEPARTEMENT,NOM_PERSONNEL from 
                courrier_arrivee c join expediteur e on c.ID_EXP=e.ID_EXP join affecter a on a.N_ARRIVEE=c.N_ARRIVEE JOIN departement d on 
                d.ID_DEPARTEMENT=a.ID_DEPARTEMENT JOIN personnel p on p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE ANNEE=:annee ORDER BY N_ARRIVEE";
        $query = $conn->prepare($req);
        $query->bindParam(':annee', $annee, PDO::PARAM_STR);
        $query->execute();
        
    }else if(!empty($departement)){
        $req = "SELECT c.N_ARRIVEE,ANNEE,OBJET_ARRIVEE,DATE_ARRIVEE,PIECE_JOINTE_ARRIVEE,NOM_EXP,ADRESSE_EXP,NOM_DEPARTEMENT,NOM_PERSONNEL from
                courrier_arrivee c join expediteur e on c.ID_EXP=e.ID_EXP join affecter a on a.N_ARRIVEE=c.N_ARRIVEE JOIN departement d on 
                d.ID_DEPARTEMENT=a.ID_DEPARTEMENT JOIN personnel p on p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE NOM_DEPARTEMENT=:ndep ORDER BY N_ARRIVEE";
        $query = $conn->prepare($req);
        $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
        $query->execute();
        
    }else if(!empty($dateD) && !empty($dateF) && !empty($departement)){
        $req = "SELECT c.N_ARRIVEE,ANNEE,OBJET_ARRIVEE,DATE_ARRIVEE,PIECE_JOINTE_ARRIVEE,NOM_EXP,ADRESSE_EXP,NOM_DEPARTEMENT,NOM_PERSONNEL 
                from courrier_arrivee c join expediteur e on c.ID_EXP=e.ID_EXP join affecter a on a.N_ARRIVEE=c.N_ARRIVEE JOIN departement d on 
                d.ID_DEPARTEMENT=a.ID_DEPARTEMENT JOIN personnel p on p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE NOM_DEPARTEMENT=:ndep AND DATE_ARRIVEE BETWEEN :dateD AND :dateF ORDER BY N_ARRIVEE";
        $query = $conn->prepare($req);
        $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
        $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
        $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
        $query->execute();
        
    }else{
        $req = "SELECT c.N_ARRIVEE,ANNEE,OBJET_ARRIVEE,DATE_ARRIVEE,PIECE_JOINTE_ARRIVEE,NOM_EXP,ADRESSE_EXP,NOM_DEPARTEMENT,NOM_PERSONNEL
                from courrier_arrivee c join expediteur e on c.ID_EXP=e.ID_EXP join affecter a on a.N_ARRIVEE=c.N_ARRIVEE JOIN
                departement d on d.ID_DEPARTEMENT=a.ID_DEPARTEMENT JOIN personnel p on p.ID_DEPARTEMENT=d.ID_DEPARTEMENT ORDER BY N_ARRIVEE";
        $query = $conn->prepare($req);
        $query->execute();
    }
            $pdf = new MYPDF();
            

            // Add new pages
            $pdf->AddPage('L','A4',0);

            // Set font-family and font-size.
            $pdf->SetFont('Times','',12);

            // GFG logo image
            //$pdf->Image('image/logo.png', 10, 8, 20);
            
            // GFG logo image
            //$pdf->Image('image/logo.png', 270, 8, 20);
            
            // Set font-family and font-size
            $pdf->SetFont('Times','B',20);

            // $pdf->Image('image/im.png',10,10,189);          
            // Move to the right
            $pdf->Cell(80);
            $pdf->Ln(10);
            // Set the title of pages.
            $pdf->Cell(280, 20, 'Liste des courries arrivées', 0, 2, 'C');
            $pdf->Ln(10);
            $pdf->SetFont('dejavusans', '', 10);
            $html="<table>
            <tr>
                <th>Nº d'arrivée</th>
                <th>Objet</th>
                <th>Date</th>
                <th>Expediteur</th>
                <th>Adresse</th>
                <th>Département</th>
                <th>Personnel</th>
                <th>Pièce jointe</th>
            </tr>";
            while($value=$query->fetch(PDO::FETCH_OBJ)) { 
            $html .="<tr>
                <td>".$value->N_ARRIVEE.'/'.$value->ANNEE."</td>
                <td>".$value->OBJET_ARRIVEE."</td>
                <td>".$value->DATE_ARRIVEE."</td>
                <td>".$value->NOM_EXP."</td>
                <td>".$value->ADRESSE_EXP."</td>
                <td>".$value->NOM_DEPARTEMENT."</td>
                <td>".$value->NOM_PERSONNEL."</td>
                <td><a href=\"pj/CA/$value->PIECE_JOINTE_ARRIVEE\">".$value->PIECE_JOINTE_ARRIVEE."</a></td>
            </tr>";
            }
            $html .="</table>
            <style>
            table{
                border-collapse: collapse;
                width: 790px;
            }
            th,td{
                border: 1px solid #888;
                height: 30px;
                
            }
            table tr th{
                background-color: #fff;
                color: black;
                font-weight: bolder;
                height: 30px;
                text-align: center;
                line-height: 1.8;
            }
            table tr td a{
                color: rgb(157, 157, 247);
                text-decoration: none;
            }
            </style>";

        $pdf->WriteHTMLCell(192,0,9,'',$html,0);


        $pdf->Output();

}
if(isset($_POST['filtrerCD'])){
    
    $dateD = $_POST['dateD'];
    $dateF= $_POST['dateF'];
    $annee= $_POST['annee'];
    $departement= $_POST['departement'];
    $typeCD= $_POST['typeCD'];
    
    if($typeCD=='CDE'){
    
        if(!empty($dateD) && !empty($dateF) && !empty($annee) && !empty($departement)){
            $req = "SELECT N_DEPART_EXT,ANNEE,OBJET_DEPART_EXT,DATE_DEPART_EXT,PIECE_JOINTE_DEPART_EXT,NOM_DES,
            ADRESSE_DES,NOM_DEPARTEMENT,NOM_PERSONNEL from courrier_depart_ext c join destinataire ds on
            c.ID_DES=ds.ID_DES join departement d on d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join personnel p on
            p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE
            ANNEE=:annee AND NOM_DEPARTEMENT=:ndep AND DATE_DEPART_EXT BETWEEN :dateD AND :dateF ORDER BY N_DEPART_EXT";
            $query = $conn->prepare($req);
            $query->bindParam(':annee', $annee, PDO::PARAM_STR);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
            $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($dateD) && !empty($dateF) && !empty($departement)){
            $req = "SELECT N_DEPART_EXT,ANNEE,OBJET_DEPART_EXT,DATE_DEPART_EXT,PIECE_JOINTE_DEPART_EXT,NOM_DES,
            ADRESSE_DES,NOM_DEPARTEMENT,NOM_PERSONNEL from courrier_depart_ext c join destinataire ds on
            c.ID_DES=ds.ID_DES join departement d on d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join personnel p on
            p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE NOM_DEPARTEMENT=:ndep AND DATE_DEPART_EXT BETWEEN :dateD AND :dateF ORDER BY N_DEPART_EXT";
            $query = $conn->prepare($req);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
            $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($dateD) && !empty($dateF)){
            $req = "SELECT N_DEPART_EXT,ANNEE,OBJET_DEPART_EXT,DATE_DEPART_EXT,PIECE_JOINTE_DEPART_EXT,NOM_DES,
            ADRESSE_DES,NOM_DEPARTEMENT,NOM_PERSONNEL from courrier_depart_ext c join destinataire ds on
            c.ID_DES=ds.ID_DES join departement d on d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join personnel p on
            p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE DATE_DEPART_EXT BETWEEN :dateD AND :dateF ORDER BY N_DEPART_EXT";
            $query = $conn->prepare($req);
            $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
            $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($annee) && !empty($departement)){
            $req = "SELECT N_DEPART_EXT,ANNEE,OBJET_DEPART_EXT,DATE_DEPART_EXT,PIECE_JOINTE_DEPART_EXT,NOM_DES,
            ADRESSE_DES,NOM_DEPARTEMENT,NOM_PERSONNEL from courrier_depart_ext c join destinataire ds on
            c.ID_DES=ds.ID_DES join departement d on d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join personnel p on
            p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE ANNEE=:annee AND NOM_DEPARTEMENT=:ndep ORDER BY N_DEPART_EXT";
            $query = $conn->prepare($req);
            $query->bindParam(':annee', $annee, PDO::PARAM_STR);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($annee)){
            $req = "SELECT N_DEPART_EXT,ANNEE,OBJET_DEPART_EXT,DATE_DEPART_EXT,PIECE_JOINTE_DEPART_EXT,NOM_DES,
            ADRESSE_DES,NOM_DEPARTEMENT,NOM_PERSONNEL from courrier_depart_ext c join destinataire ds on
            c.ID_DES=ds.ID_DES join departement d on d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join personnel p on
            p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE ANNEE=:annee ORDER BY N_DEPART_EXT";
            $query = $conn->prepare($req);
            $query->bindParam(':annee', $annee, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($departement)){
            $req = "SELECT N_DEPART_EXT,ANNEE,OBJET_DEPART_EXT,DATE_DEPART_EXT,PIECE_JOINTE_DEPART_EXT,NOM_DES,
            ADRESSE_DES,NOM_DEPARTEMENT,NOM_PERSONNEL from courrier_depart_ext c join destinataire ds on
            c.ID_DES=ds.ID_DES join departement d on d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join personnel p on
            p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE NOM_DEPARTEMENT=:ndep ORDER BY N_DEPART_EXT";
            $query = $conn->prepare($req);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($dateD) && !empty($dateF) && !empty($departement)){
            $req = "SELECT N_DEPART_EXT,ANNEE,OBJET_DEPART_EXT,DATE_DEPART_EXT,PIECE_JOINTE_DEPART_EXT,NOM_DES,
            ADRESSE_DES,NOM_DEPARTEMENT,NOM_PERSONNEL from courrier_depart_ext c join destinataire ds on
            c.ID_DES=ds.ID_DES join departement d on d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join personnel p on
            p.ID_DEPARTEMENT=d.ID_DEPARTEMENT WHERE NOM_DEPARTEMENT=:ndep AND DATE_DEPART_EXT BETWEEN :dateD AND :dateF ORDER BY N_DEPART_EXT";
            $query = $conn->prepare($req);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
            $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
            $query->execute();
            
        }else{
            $req = "SELECT N_DEPART_EXT,ANNEE,OBJET_DEPART_EXT,DATE_DEPART_EXT,PIECE_JOINTE_DEPART_EXT,NOM_DES,
            ADRESSE_DES,NOM_DEPARTEMENT,NOM_PERSONNEL from courrier_depart_ext c join destinataire ds on
            c.ID_DES=ds.ID_DES join departement d on d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join personnel p on
            p.ID_DEPARTEMENT=d.ID_DEPARTEMENT ORDER BY N_DEPART_EXT";
            $query = $conn->prepare($req);

            $query->execute();

        }

        $pdf = new MYPDF();
            

            // Add new pages
            $pdf->AddPage('L','A4',0);

            // Set font-family and font-size.
            $pdf->SetFont('Times','',12);

            // GFG logo image
            $pdf->Image('image/logo.png', 10, 8, 20);
            
            // GFG logo image
            $pdf->Image('image/logo.png', 270, 8, 20);
            
            // Set font-family and font-size
            $pdf->SetFont('Times','B',20);

            // $pdf->Image('image/im.png',10,10,189);          
            // Move to the right
            $pdf->Cell(80);
            $pdf->Ln(10);
            // Set the title of pages.
            $pdf->Cell(280, 20, 'Liste des courries départs externe', 0, 2, 'C');
            $pdf->Ln(10);
            $pdf->SetFont('dejavusans', '', 10);
            $html="<table>
            <tr>
                <th>Nº départ</th>
                <th>Objet</th>
                <th>Date</th>
                <th>Destinataire</th>
                <th>Adresse</th>
                <th>Département</th>
                <th>Personnel</th>
                <th>Pièce jointe</th>
            </tr>";
            while($value=$query->fetch(PDO::FETCH_OBJ)) { 
            $html .="<tr>
                <td>".$value->N_DEPART_EXT.'/'.$value->ANNEE."</td>
                <td>".$value->OBJET_DEPART_EXT."</td>
                <td>".$value->DATE_DEPART_EXT."</td>
                <td>".$value->NOM_DES."</td>
                <td>".$value->ADRESSE_DES."</td>
                <td>".$value->NOM_DEPARTEMENT."</td>
                <td>".$value->NOM_PERSONNEL."</td>
                <td><a href=\"pj/CDE/$value->PIECE_JOINTE_DEPART_EXT\">".$value->PIECE_JOINTE_DEPART_EXT."</a></td>
            </tr>";
            }
            $html .="</table>
            <style>
            table{
                border-collapse: collapse;
                width: 790px;
            }
            th,td{
                border: 1px solid #888;
                height: 30px;
                
            }
            table tr th{
                background-color: #fff;
                color: black;
                font-weight: bolder;
                height: 30px;
                text-align: center;
                line-height: 1.8;

            }
            </style>";
            $pdf->WriteHTMLCell(192,0,9,'',$html,0);


            $pdf->Output();


    }
    if($typeCD=='CDI'){
        if(!empty($dateD) && !empty($dateF) && !empty($annee) && !empty($departement)){
            $req = "SELECT c.N_DEPART_INT,c.ANNEE,c.OBJET_DAPART_INT,c.DATE_DEPART_INT,c.PIECE_JOINTE_DEPART_INT,d.nom_departement,p.nom_personnel,
            (SELECT nom_personnel from personnel WHERE id_personnel = r.ID_PERSONNEL) AS NOM_PERSONNEL_RECEPTEUR,
            (SELECT nom_departement FROM departement d JOIN personnel p on d.ID_DEPARTEMENT=p.ID_DEPARTEMENT WHERE
            NOM_PERSONNEL=NOM_PERSONNEL_RECEPTEUR) AS NOM_DEPARTEMENT_RECEPTEUR from courrier_depart_int c JOIN departement d ON d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join
            transmettre3 t on t.N_DEPART_INT=c.N_DEPART_INT JOIN personnel p ON p.ID_PERSONNEL=t.ID_PERSONNEL JOIN recevoir_interne r on r.N_DEPART_INT=c.N_DEPART_INT WHERE
            ANNEE=:annee AND NOM_DEPARTEMENT=:ndep AND DATE_DEPART_INT BETWEEN :dateD AND :dateF ORDER BY N_DEPART_INT";
            $query = $conn->prepare($req);
            $query->bindParam(':annee', $annee, PDO::PARAM_STR);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
            $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($dateD) && !empty($dateF) && !empty($departement)){
            $req = "SELECT c.N_DEPART_INT,c.ANNEE,c.OBJET_DAPART_INT,c.DATE_DEPART_INT,c.PIECE_JOINTE_DEPART_INT,d.nom_departement,p.nom_personnel,
            (SELECT nom_personnel from personnel WHERE id_personnel = r.ID_PERSONNEL) AS NOM_PERSONNEL_RECEPTEUR,
            (SELECT nom_departement FROM departement d JOIN personnel p on d.ID_DEPARTEMENT=p.ID_DEPARTEMENT WHERE
            NOM_PERSONNEL=NOM_PERSONNEL_RECEPTEUR) AS NOM_DEPARTEMENT_RECEPTEUR from courrier_depart_int c JOIN departement d ON d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join
            transmettre3 t on t.N_DEPART_INT=c.N_DEPART_INT JOIN personnel p ON p.ID_PERSONNEL=t.ID_PERSONNEL JOIN recevoir_interne r on r.N_DEPART_INT=c.N_DEPART_INT
            WHERE NOM_DEPARTEMENT=:ndep AND DATE_DEPART_INT BETWEEN :dateD AND :dateF ORDER BY N_DEPART_INT";
            $query = $conn->prepare($req);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
            $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($dateD) && !empty($dateF)){
            $req = "SELECT c.N_DEPART_INT,c.ANNEE,c.OBJET_DAPART_INT,c.DATE_DEPART_INT,c.PIECE_JOINTE_DEPART_INT,d.nom_departement,p.nom_personnel,
            (SELECT nom_personnel from personnel WHERE id_personnel = r.ID_PERSONNEL) AS NOM_PERSONNEL_RECEPTEUR,
            (SELECT nom_departement FROM departement d JOIN personnel p on d.ID_DEPARTEMENT=p.ID_DEPARTEMENT WHERE
            NOM_PERSONNEL=NOM_PERSONNEL_RECEPTEUR) AS NOM_DEPARTEMENT_RECEPTEUR from courrier_depart_int c JOIN departement d ON d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join
            transmettre3 t on t.N_DEPART_INT=c.N_DEPART_INT JOIN personnel p ON p.ID_PERSONNEL=t.ID_PERSONNEL JOIN recevoir_interne r on r.N_DEPART_INT=c.N_DEPART_INT
            WHERE DATE_DEPART_INT BETWEEN :dateD AND :dateF ORDER BY N_DEPART_INT";
            $query = $conn->prepare($req);
            $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
            $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($annee) && !empty($departement)){
            $req = "SELECT c.N_DEPART_INT,c.ANNEE,c.OBJET_DAPART_INT,c.DATE_DEPART_INT,c.PIECE_JOINTE_DEPART_INT,d.nom_departement,p.nom_personnel,
            (SELECT nom_personnel from personnel WHERE id_personnel = r.ID_PERSONNEL) AS NOM_PERSONNEL_RECEPTEUR,
            (SELECT nom_departement FROM departement d JOIN personnel p on d.ID_DEPARTEMENT=p.ID_DEPARTEMENT WHERE
            NOM_PERSONNEL=NOM_PERSONNEL_RECEPTEUR) AS NOM_DEPARTEMENT_RECEPTEUR from courrier_depart_int c JOIN departement d ON d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join
            transmettre3 t on t.N_DEPART_INT=c.N_DEPART_INT JOIN personnel p ON p.ID_PERSONNEL=t.ID_PERSONNEL JOIN recevoir_interne r on r.N_DEPART_INT=c.N_DEPART_INT
            WHERE ANNEE=:annee AND NOM_DEPARTEMENT=:ndep ORDER BY N_DEPART_INT";
            $query = $conn->prepare($req);
            $query->bindParam(':annee', $annee, PDO::PARAM_STR);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($annee)){
            $req = "SELECT c.N_DEPART_INT,c.ANNEE,c.OBJET_DAPART_INT,c.DATE_DEPART_INT,c.PIECE_JOINTE_DEPART_INT,d.nom_departement,p.nom_personnel,
            (SELECT nom_personnel from personnel WHERE id_personnel = r.ID_PERSONNEL) AS NOM_PERSONNEL_RECEPTEUR,
            (SELECT nom_departement FROM departement d JOIN personnel p on d.ID_DEPARTEMENT=p.ID_DEPARTEMENT WHERE
            NOM_PERSONNEL=NOM_PERSONNEL_RECEPTEUR) AS NOM_DEPARTEMENT_RECEPTEUR from courrier_depart_int c JOIN departement d ON d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join
            transmettre3 t on t.N_DEPART_INT=c.N_DEPART_INT JOIN personnel p ON p.ID_PERSONNEL=t.ID_PERSONNEL JOIN recevoir_interne r on r.N_DEPART_INT=c.N_DEPART_INT
            WHERE ANNEE=:annee ORDER BY N_DEPART_INT";
            $query = $conn->prepare($req);
            $query->bindParam(':annee', $annee, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($departement)){
            $req = "SELECT c.N_DEPART_INT,c.ANNEE,c.OBJET_DAPART_INT,c.DATE_DEPART_INT,c.PIECE_JOINTE_DEPART_INT,d.nom_departement,p.nom_personnel,
            (SELECT nom_personnel from personnel WHERE id_personnel = r.ID_PERSONNEL) AS NOM_PERSONNEL_RECEPTEUR,
            (SELECT nom_departement FROM departement d JOIN personnel p on d.ID_DEPARTEMENT=p.ID_DEPARTEMENT WHERE
            NOM_PERSONNEL=NOM_PERSONNEL_RECEPTEUR) AS NOM_DEPARTEMENT_RECEPTEUR from courrier_depart_int c JOIN departement d ON d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join
            transmettre3 t on t.N_DEPART_INT=c.N_DEPART_INT JOIN personnel p ON p.ID_PERSONNEL=t.ID_PERSONNEL JOIN recevoir_interne r on r.N_DEPART_INT=c.N_DEPART_INT
            WHERE NOM_DEPARTEMENT=:ndep ORDER BY N_DEPART_INT";
            $query = $conn->prepare($req);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->execute();
            
        }else if(!empty($dateD) && !empty($dateF) && !empty($departement)){
            $req = "SELECT c.N_DEPART_INT,c.ANNEE,c.OBJET_DAPART_INT,c.DATE_DEPART_INT,c.PIECE_JOINTE_DEPART_INT,d.nom_departement,p.nom_personnel,
            (SELECT nom_personnel from personnel WHERE id_personnel = r.ID_PERSONNEL) AS NOM_PERSONNEL_RECEPTEUR,
            (SELECT nom_departement FROM departement d JOIN personnel p on d.ID_DEPARTEMENT=p.ID_DEPARTEMENT WHERE
            NOM_PERSONNEL=NOM_PERSONNEL_RECEPTEUR) AS NOM_DEPARTEMENT_RECEPTEUR from courrier_depart_int c JOIN departement d ON d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join
            transmettre3 t on t.N_DEPART_INT=c.N_DEPART_INT JOIN personnel p ON p.ID_PERSONNEL=t.ID_PERSONNEL JOIN recevoir_interne r on r.N_DEPART_INT=c.N_DEPART_INT
            WHERE NOM_DEPARTEMENT=:ndep AND DATE_DEPART_INT BETWEEN :dateD AND :dateF ORDER BY N_DEPART_INT";
            $query = $conn->prepare($req);
            $query->bindParam(':ndep', $departement, PDO::PARAM_STR);
            $query->bindParam(':dateD', $dateD, PDO::PARAM_STR);
            $query->bindParam(':dateF', $dateF, PDO::PARAM_STR);
            $query->execute();
            
        }else{
            $req = "SELECT c.N_DEPART_INT,c.ANNEE,c.OBJET_DAPART_INT,c.DATE_DEPART_INT,c.PIECE_JOINTE_DEPART_INT,d.nom_departement,p.nom_personnel,
            (SELECT nom_personnel from personnel WHERE id_personnel = r.ID_PERSONNEL) AS NOM_PERSONNEL_RECEPTEUR,
            (SELECT nom_departement FROM departement d JOIN personnel p on d.ID_DEPARTEMENT=p.ID_DEPARTEMENT WHERE
            NOM_PERSONNEL=NOM_PERSONNEL_RECEPTEUR) AS NOM_DEPARTEMENT_RECEPTEUR from courrier_depart_int c JOIN departement d ON d.ID_DEPARTEMENT=c.ID_DEPARTEMENT join
            transmettre3 t on t.N_DEPART_INT=c.N_DEPART_INT JOIN personnel p ON p.ID_PERSONNEL=t.ID_PERSONNEL JOIN recevoir_interne r on r.N_DEPART_INT=c.N_DEPART_INT ORDER BY N_DEPART_INT";
            $query = $conn->prepare($req);
            $query->execute();

        }
        $pdf = new MYPDF();
            

            // Add new pages
            $pdf->AddPage('L','A4',0);

            // Set font-family and font-size.
            $pdf->SetFont('Times','',12);

            // GFG logo image
            $pdf->Image('image/logo.png', 10, 8, 20);
            
            // GFG logo image
            $pdf->Image('image/logo.png', 270, 8, 20);
            
            // Set font-family and font-size
            $pdf->SetFont('Times','B',20);

            // $pdf->Image('image/im.png',10,10,189);          
            // Move to the right
            $pdf->Cell(80);
            $pdf->Ln(10);
            // Set the title of pages.
            $pdf->Cell(280, 20, 'Liste des courries départs interne', 0, 2, 'C');
    
            
            $pdf->Ln(10);
            $pdf->SetFont('dejavusans', '', 10);
            $html="<table>
            <tr>
                <th>Nº départ</th>
                <th>Objet</th>
                <th>Date</th>
                <th>Département emetteur</th>
                <th>Personnel emetteur</th>
                <th>Département recepteur</th>
                <th>Personnel recepteur</th>
                <th>Pièce jointe</th>
            </tr>";
            while($value=$query->fetch(PDO::FETCH_OBJ)) { 
            $html .="<tr>
                <td>".$value->N_DEPART_INT.'/'.$value->ANNEE."</td>
                <td>".$value->OBJET_DAPART_INT."</td>
                <td>".$value->DATE_DEPART_INT."</td>
                <td>".$value->nom_departement."</td>
                <td>".$value->nom_personnel."</td>
                <td>".$value->NOM_DEPARTEMENT_RECEPTEUR."</td>
                <td>".$value->NOM_PERSONNEL_RECEPTEUR."</td>
                <td><a href=\"pj/CDI/$value->PIECE_JOINTE_DEPART_INT\" target=\"_blank\">".$value->PIECE_JOINTE_DEPART_INT."</a></td>
            </tr>";
            }
            $html .="</table>
            <style>
            table{
                border-collapse: collapse;
                width: 790px;
            }
            th,td{
                border: 1px solid #888;
                height: 32px;
                
            }
            table tr th{
                background-color: #fff;
                color: black;
                font-weight: bolder;
                height: 32px;
                text-align: center;
                line-height: 1.8;

            }
            </style>";

        $pdf->WriteHTMLCell(192,0,9,'',$html,0);


        $pdf->Output();
    }
}



?>