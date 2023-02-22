<?php
include "Connection.php";
include "Classes/GestionTables.php";
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
                <td><input type="number" class="form-control" placeholder="Longueur" min="0" name="longueur[]" id ="longueur" value="0" required></td>
                <td><input type="number" class="form-control" placeholder="0 si non 1 si oui" min = "0" max="1" name="primary[]" value="0" required></td>
            </tr>';
            }
            echo '                <tr>
            <td><input type="submit" value="Creer colonnes" name="btnsubmit"  class="btn btn-primary"></td>
        </tr>';
        }
        

    }
    if(isset($_GET['nomDb'])){
        GestionTables::CreateDatabase($_GET['nomDb']);
    }
    if(isset($_GET['db'])){
        GestionTables::DropDataBase($_GET['db']);
    }
    if(isset($_GET['tableinfos'])){
        GestionTables::DropTable($_GET['tableinfos']);
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