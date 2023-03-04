<?php
class GestionTables{
    public  static function Ajouter($db,$tableName,$columnsNamee,$columns){
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
            $sql .= ");";
            $results =  $cnxS->query($sql);
            if(!$results){
                echo 'il ya un probleme';
            }
            else{
                echo 'il ya pas un probleme';
            }
    }
    public static function Supprimer($db,$tableName,$cle,$primaryKeyName,$primaryKeyType){
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
    public static  function LoadforeignSelect($primaryKeyName_IdTab,$db,$col){
        include "Connection.php";
        $infos = explode("-",$primaryKeyName_IdTab);
        $sql5 = "SELECT tableName FROM `tables` WHERE id =". $infos[0];
        $results5 =  $cnx->query($sql5);
        $tableName;
        while($row = $results5->fetch_assoc()){
            $tableName = $row['tableName'];
        }
        $cnxS = new mysqli("localhost","root","",$db);
        $sql6 = "SELECT $infos[1] FROM $tableName";
        $results6 =  $cnxS->query($sql6);
        echo "<select name=".$col." class='form-control'>";
        while($row = $results6->fetch_row()){
            echo "<option value='".$row[0]."' >".$row[0]."</option>";
        }
        echo "</select>";
        // echo $sql6;

    }
    public static function CreateForms($idTable,$db){
    include "Connection.php";
        $sql5 = "SELECT * FROM `columns` WHERE idTable =". $idTable;
                                    $results5 =  $cnx->query($sql5);
                                    while($row = $results5->fetch_row()){?>
                                    <tr>
                                            <?php 
                                             if($row[1] == "VARCHAR" || $row[1] == "TEXT"){?>
                                                <td><label for="<?php echo $row[0];?>"><?php echo $row[0];?></label></td>
                                                <?php if($row[5] == 'rien'){?>
                                                    <td><input type="text" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" required></td>   
                                             <?php } 
                                             else { ?> <td><?php  self::LoadforeignSelect($row[5],$db,$row[0]); }?></td> <br>

                                            <?php }
                                            elseif($row[1] == "DATE"){ ?>
                                            <td><label for="<?php echo $row[0];?>"><?php echo $row[0];?></label></td>
                                            <?php if($row[5] == 'rien'){?>
                                            <td><input type="date" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control"required></td>
                                            <?php } else {?> <td><?php  self::LoadforeignSelect($row[5],$db,$row[0]); }?></td> <br>
                                            <?php } 

                                            elseif ($row[1] == "INT" ){?>
                                                <td> <label for="<?php echo $row[0];?>"><?php echo $row[0];?></label></td>
                                                <?php if($row[5] == 'rien'){?>
                                           
                                           <td><input type="number" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" required ></td>
                                           <?php } 
                                           else { ?> <td><?php self::LoadforeignSelect($row[5],$db,$row[0]); }?></td> <br>
                                            
                                            <?php 
                                            }
                                            elseif ( $row[1] == "FLOAT" || $row[1] == "DOUBLE" || $row[1] == "DECIMAL"){?>
                                            <td> <label for="<?php echo $row[0];?>"><?php echo $row[0];?></label></td>
                                            <?php if($row[5] == 'rien'){?>
                                            <td><input type="text" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" pattern = "[+-]?([0-9]*[.])?[0-9]+" required></td>
                                            <?php } else {?><td><?php  self::LoadforeignSelect($row[5],$db,$row[0]); }?></td> <br>
                                                
                                            
                                        <?php } ?> </tr> <?php } ?>
   <?php }
   public static function SideBarButtons(){
    include "Connection.php";
    $sql = "SELECT * FROM `dbs`";
					$results =  $cnx->query($sql);
					while($row = $results->fetch_assoc()){
						$results2 = $cnx->query("SELECT * FROM `tables` WHERE DB = '".$row['Name']."'");
						echo '<li ><a href="#'.$row['Name'].'" id ="'.$row['Name'].'" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">'.$row['Name'].'</a>
						<ul class="collapse list-unstyled" id="'.$row['Name'].'">';
						while($row2 = $results2->fetch_assoc()){
							echo '<li ><a href="index.php?db='.$row['Name'].'&id='.$row2['id'].'">'.$row2['tableName'].'</a></li>';
						}
						echo '</ul></li>';
					}
   }
   public static function LoadColumn($idTable){
        include "Connection.php";
        $sql = "SELECT * FROM `columns` WHERE idTable =". $idTable;
        $results =  $cnx->query($sql);
        while($row = $results->fetch_assoc()){
            ?>
            <tr>
                <td><?php echo $row['Name'] ?></td>
                <td><?php echo ($row['primaryKey'] == 1 ?"Clé primaire" : "Non") ?></td>
                <td><?php echo $row['Type'] ?></td>
                <td><?php echo $row['size'] ?></td>
                <td><?php echo ($row['foreignKey'] == 1 ? "Clé étrangère" : "Non")?></td>
            </tr>
            <?php

        }?>
   <?php }   
   public static function CreateTable($DBs,$table,$colonne,$types,$longueur,$primary){
    include "Connection.php";
    $cnxS = new mysqli("localhost","root","",$DBs);
    $sql1 = "create table $table ( ";
    $found = false;
    for ($i=0; $i < count($colonne); $i++) { 
        if($i != count($colonne) - 1){
        $sql1 .= $colonne[$i]." ".($types[$i] != "VARCHAR" ? $types[$i] : $types[$i] ." (".$longueur[$i] . ")") ;
        if($primary[$i] == 0 ){
            $sql1 .= "";
        }
        elseif($primary[$i] == 1 && $found == false){
            $sql1 .= " primary key ";
            $found = true;
        }
        elseif($primary[$i] == 1 && $found == true)
        {
            $sql1 .= "";
        }
        $sql1 .= ",";
        }
        else{
        $sql1 .= $colonne[$i]." ".($types[$i] != "VARCHAR" ? $types[$i] : $types[$i] ." (".$longueur[$i] . ")") ;
        if($primary[$i] == 0 ){
            $sql1 .= "";
        }
        elseif($primary[$i] == 1 && $found == false){
            $sql1 .= " primary key ";
            $found = true;
        }
        elseif($primary[$i] == 1 && $found == true)
        {
            $sql1 .= "";
        }
         $sql1 .=")ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        }
    }
    if($found == true){
        $res = $cnxS->query($sql1);
        if($res){
           
                $sql2 = "INSERT INTO `tables`(`tableName`, `DB`) VALUES ('$table','$DBs')";
                $cnx->query($sql2);
                
                $sql3 = "SELECT id FROM `tables` ORDER by id asc";
                $results =  $cnx->query($sql3);
                $id ;
                while($row = $results->fetch_assoc()){
                    $id = $row['id'];
                }
                $found2 =false;
                for ($i=0; $i < count($colonne); $i++) {   
                    if($primary[$i] == 1 && $found2 == false){
                        $sql4 = "INSERT INTO `columns`(`Name`, `Type`, `size`, `primaryKey`, `foreignKey`, `idTable`,`primaryTable`) VALUES ('".$colonne[$i]."','".$types[$i]."',".$longueur[$i].",".$primary[$i]." ,0".",".$id.",'rien')";
                        $found2 = true;
                    }
                    else{
                        $sql4 = "INSERT INTO `columns`(`Name`, `Type`, `size`, `primaryKey`, `foreignKey`, `idTable`,`primaryTable`) VALUES ('".$colonne[$i]."','".$types[$i]."',".$longueur[$i].",0,0".",".$id.",'rien')";
    
                    }
                $cnx->query($sql4);
                }  
        }
        else{
            echo "<script>alert('Vous nous pouvez pas creer ce table verifier que le nom que tu as entré  existe deja')</script>";
        }
        
    }
    else{
        echo "<script>alert('Le tableau doit contenir un cle primaire')</script>";
    }
    

       
   } 

   public static function CreateDatabase($db){
    include "Connection.php";
    $sql2 = "create database ".$db;
        $res = $cnx->query($sql2);
        if($res){
            $sql1 = "INSERT INTO `dbs`(`Name`) VALUES ('".$db."')";
            $cnx->query($sql1);
            $sql = "SELECT * FROM `dbs`";
                                $results =  $cnx->query($sql);
                                while($row = $results->fetch_assoc()){
                                    echo "<option value='". $row['Name']."'>".$row['Name']."</option>";
                                }
        }
        
   }
   public static function DropDataBase($db){
    include "Connection.php";
    $sql = "drop database ".$db;
        $cnx->query($sql);
        $sql2 = "delete from dbs where Name = '".$db."'";
        $cnx->query($sql2);
   }
   public static function DropTable($tableinfos){
    include "Connection.php";
    $info = explode("-", $tableinfos);
    $sql = "drop table ".$info[1];
    $cnxS = new mysqli("localhost","root","",$info[2]);
    $result = $cnxS->query($sql);
    if($result){
        $sql2 = "delete from tables where id = ".$info[0];
        $cnx->query($sql2);
    }
   }
}
?>