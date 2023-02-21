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
        $sql = "DELETE from $tableName where $primaryKeyName =".($primaryKeyType == "VARCHAR" || $primaryKeyType == "DATE" || $primaryKeyType == "TEXT" ? "'". $cle ."'":$cle);
        $results =  $cnxS->query($sql);
            if(!$results){
                echo 'il ya un probleme dans la suppression';
            }
            else{
                echo 'il ya pas un probleme dans la suppression';
            }
    }
    public static function Modifier($tableName,$i,$cols,$colsType,$primaryKeyName,$primaryKeyType,$cle,$cnxS){
        $sql3 = "update ".$tableName ." set ";
        for ($j=0; $j < $i; $j++) { 
            if($j == $i - 1){
                $sql3 .= $cols[$j] ." = ".($colsType[$cols[$j]] == "VARCHAR" || $colsType[$cols[$j]] == "DATE" || $colsType[$cols[$j]] == "TEXT" ? "'". $_POST[$cols[$j]] ."'" : $_POST[$cols[$j]]);
            }
            else{
                $sql3 .= $cols[$j] ." = ".($colsType[$cols[$j]] == "VARCHAR" || $colsType[$cols[$j]] == "DATE" || $colsType[$cols[$j]] == "TEXT" ? "'". $_POST[$cols[$j]] ."'" : $_POST[$cols[$j]]) ." , ";
            }
        }
        $sql3 .= " Where ".$primaryKeyName ." = ".($primaryKeyType == "VARCHAR" || $primaryKeyType == "DATE" || $primaryKeyType == "TEXT" ? "'". $cle ."'":$cle);
        $results3 =  $cnxS->query($sql3);
        if(!$results3){
            echo "<script>alert('Modification pas faite')</script>";
        }  
    }
    public static function CreateForms($idTable){
    include "Connection.php";
        $sql5 = "SELECT * FROM `columns` WHERE idTable =". $idTable;
                                    $results5 =  $cnx->query($sql5);
                                    while($row = $results5->fetch_row()){?>
                                    <tr>
                                            <?php 
                                             if($row[1] == "VARCHAR" || $row[1] == "TEXT"){?>
                                             <td><label for="<?php echo $row[0];?>"><?php echo $row[0];?></label></td>
                                             <td><input type="text" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" required></td>   
                                            <?php } 
                                            elseif($row[1] == "DATE"){ ?>
                                            <td><label for="<?php echo $row[0];?>"><?php echo $row[0];?></label></td>
                                            <td><input type="date" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control"required></td>
                                            <?php } 
                                            elseif ($row[1] == "INT" ){?>
                                           <td> <label for="<?php echo $row[0];?>"><?php echo $row[0];?></label></td>
                                           <td><input type="number" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" required ></td>
                                            <?php }
                                            elseif ( $row[1] == "FLOAT" || $row[1] == "DOUBLE" || $row[1] == "DECIMAL"){?>
                                            <td> <label for="<?php echo $row[0];?>"><?php echo $row[0];?></label></td>
                                            <td><input type="text" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" pattern = "[+-]?([0-9]*[.])?[0-9]+" required></td>
                                                
                                            
                                        <?php } ?> </tr> <?php } ?>
   <?php }
}
?>