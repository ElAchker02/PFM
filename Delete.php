<?php
    include "Classes/GestionTables.php";
    if(isset($_GET['db']) && isset($_GET['tableName']) && isset($_GET['cle']) && isset($_GET['primaryName']) && isset($_GET['primaryType']) && isset($_GET['idTable'])){
        GestionTables::Supprimer($_GET['db'],$_GET['tableName'],$_GET['cle'],$_GET['primaryName'],$_GET['primaryType']);
        header("location: /PFM1/index.php?db=".$_GET['db']."&id=".$_GET['idTable']);
        exit;  
    }
    

?>