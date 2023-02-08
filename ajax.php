<?php
include "Connection.php";
    if(isset($_GET['infos'])){
        if( $_GET['infos'] != 0){
            for ($i=0; $i < $_GET['infos']; $i++) { 
                echo '<tr>
                <td><input type="text" class="form-control" placeholder="Colonne" name="colonne[]"  required></td>
                <td><select name="types[]" id="types">
                    <option value="VARCHAR">VARCHAR</option>
                    <option value="INT">INT</option>
                    <option value="TEXT">TEXT</option>
                    <option value="DATE">DATE</option>
                    <option value="FLOAT">FLOAT</option>
                    <option value="DOUBLE">DOUBLE</option>
                    <option value="REAL">REAL</option>
                    <option value="DECIMAL">DECIMAL</option>
                </select></td>
                <td><input type="number" class="form-control" placeholder="Longueur" min="0" name="longueur[]" id ="longueur" required></td>
                <td><input type="number" class="form-control" placeholder="0 si non 1 si oui" min = "0" max="1" name="primary[]"  required></td>
            </tr>';
            }
            echo '                <tr>
            <td><input type="submit" value="Creer colonnes" name="btnsubmit"  class="btn btn-primary"></td>
        </tr>';
        }
        // <td><input type="number" class="form-control" placeholder="0 si non 1 si oui" min = "0" max="1" name="foreign[]"  required></td>
        

    }
    if(isset($_GET['nomDb'])){
        $sql2 = "create database ".$_GET['nomDb'];
        $cnx->query($sql2);
        $sql1 = "INSERT INTO `dbs`(`Name`) VALUES ('".$_GET['nomDb']."')";
        $cnx->query($sql1);
        $sql = "SELECT * FROM `dbs`";
							$results =  $cnx->query($sql);
							while($row = $results->fetch_assoc()){
                                echo "<option value='". $row['Name']."'>".$row['Name']."</option>";
                            }
    }
    if(isset($_GET['db'])){
        $sql = "drop database ".$_GET['db'];
        $cnx->query($sql);
        $sql2 = "delete from dbs where Name = '".$_GET['db']."'";
        $cnx->query($sql2);
    }
    if(isset($_GET['tableinfos'])){
        $info = explode("-", $_GET['tableinfos']);
        $sql = "drop table ".$info[1];
        $cnxS = new mysqli("localhost","root","",$info[2]);
        $cnxS->query($sql);
        $sql2 = "delete from tables where id = ".$info[0];
        $cnx->query($sql2);
    }
    if(isset($_GET['selectedDb'])){
        $sql = "SELECT `id`, `tableName` FROM `tables` WHERE DB = '".$_GET['selectedDb']."'";
        $result = $cnx->query($sql);
        echo '<option value="" selected disabled></option>';
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['id']."'>".$row['tableName']."</option>";
        }
    }
    if(isset($_GET['selectedtable'])){
        $sql = "SELECT * FROM `columns` WHERE idTable = ".$_GET['selectedtable']."";
        $result = $cnx->query($sql);
        echo '<option value="" selected disabled></option>';
        while($row = $result->fetch_assoc()){
            echo "<option value='".$row['Name']."'>".$row['Name']."</option>";
        }
    }
?>