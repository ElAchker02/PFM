<?php
class GestionTables{
    public function Ajouter($db,$tableName,$columnsNamee,$columns){
        $cnxS = new mysqli("localhost","root","",$db);
        $sql = "INSERT INTO $tableName VALUES(";
        for ($i=0; $i < count($columnsNamee); $i++) { 
            if($columns[$columnsNamee[$i]] == "VARCHAR" || $columns[$columnsNamee[$i]] == "TEXT" ||  $columns[$columnsNamee[$i]] == "DATE"){
                if($i == 0){
                    $sql .= "'".$_POST[$columnsNamee[$i]]."'";
                }  
                else{
                    $sql .= ",'".$_POST[$columnsNamee[$i]]."'";
                } 
                
            }
           else{
                if($i == 0){
                    $sql .= $_POST[$columnsNamee[$i]];
                }  
                else{
                    $sql .= ",".$_POST[$columnsNamee[$i]];
                } 
                
            }
        }
            $sql .= ")";
            $results =  $cnxS->query($sql);
            if(!$results){
                echo 'il ya un probleme';
            }
            else{
                echo 'il ya pas un probleme';
            }
    }
    public function Supprimer($db,$tableName,$cle,$primaryKeyName,$primaryKeyType){
        $cnxS = new mysqli("localhost","root","",$db);
        $sql = "DELETE from $tableName where $primaryKeyName =".($primaryKeyType == "VARCHAR" || $primaryKeyType == "DATE" ? "'". $cle ."'":$cle);
        $results =  $cnxS->query($sql);
            if(!$results){
                echo 'il ya un probleme dans la suppression';
            }
            else{
                echo 'il ya pas un probleme dans la suppression';
            }
    }
}
?>