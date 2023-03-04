<?php
			include "Connection.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer les relations</title>
    <link rel="shortcut icon" href="img/L2.png">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>
    <header
        style="height: 150px;width: 100%; background-color: #00ADB4;display: flex; justify-content: center; align-items: center;">
        <h1 style="color: white;">Créer les relations</h1>
    </header>
    <div class="container mt-4 ">

        <form action="" method="post">
            <table class="table table-sm table-bordered">
                <tr>
                    <th>Propriétés du constraint</th>
                    <th>Collonne</th>
                    <th>Base de données</th>
                    <th>Table</th>
                    <th>Collonne</th>
                </tr>
                <tr>
                    <td><input type="text" name="ConstName" id="" class="form-control" placeholder="Nom du constraint"
                            required>
                        ON DELETE <select name="Delete" id="" required>
                            <option value="" selected></option>
                            <option value="CASCADE">CASCADE</option>
                            <option value="SET NULL">SET NULL</option>
                            <option value="RESTRICT">RESTRICT</option>
                        </select>
                        ON UPDATE <select name="Update" id="" required>
                            <option value="" selected></option>
                            <option value="CASCADE">CASCADE</option>
                            <option value="SET NULL">SET NULL</option>
                            <option value="RESTRICT">RESTRICT</option>
                        </select></td>

                    <td><select name="col1" id="" required>
                            <option value="" selected disabled></option>
                            <?php
                
                $sql = "SELECT `Name` FROM `columns` WHERE idTable = ".$_GET['id'];
                $results = $cnx->query($sql); 
                while($row = $results->fetch_assoc()){?>
                            <option value="<?php echo $row['Name'];?>"><?php echo $row['Name'];?></option>
                            <?php }
            ?>
                        </select></td>
                    <td>

                        <select name="dbs" id="dbs" required>
                            <option value="" selected disabled></option>

                            <?php
                
                $sql2 = "SELECT * FROM `dbs`";
                $results2 = $cnx->query($sql2); 
                while($row = $results2->fetch_assoc()){?>
                            <option value="<?php echo $row['Name'];?>"><?php echo $row['Name'];?></option>
                            <?php }
            ?>
                        </select>
                    </td>
                    <td>
                        <select name="tables" id="tables" required>
                        </select>
                    </td>
                    <td>
                        <select name="col2" id="col2" required>
                        </select>
                    </td>
                </tr>

            </table>
            <div class="d-flex justify-content-center align-items-center mt-2">
                <input type="submit" class="btn btn-primary" value="Sauvegarder" name="save">
            </div>
        </form>
        <?php
            if(isset($_POST['save'])){
                $Constraint = $_POST['ConstName'];
                $col1 = $_POST['col1'];
                $col2 = $_POST['col2'];
                $tablePere = $_POST['tables'];
                $db =$_POST['dbs'];
                $DeleteCascade = $_POST['Delete'];
                $UpdateCascade = $_POST['Update'];

                $sql1 = "SELECT tableName FROM `tables` where id =". $_GET['id'];
                $results = $cnx->query($sql1);
                $tableName;
                while($row = $results->fetch_assoc()){
                    $tableName = $row['tableName'];
                }

                $sql3 = "SELECT tableName FROM `tables` where id =". $tablePere ;
                $results2 = $cnx->query($sql3);
                $tableName2;
                while($row2 = $results2->fetch_assoc()){
                    $tableName2 = $row2['tableName'];
                }

                $sql2 = "ALTER TABLE $tableName
                ADD CONSTRAINT $Constraint
                FOREIGN KEY ($col1) REFERENCES $tableName2($col2) ";
                if($DeleteCascade != ""){
                    $sql2 .= "ON DELETE $DeleteCascade  ";
                }
                if($UpdateCascade != ""){
                    $sql2 .= "ON UPDATE $UpdateCascade ";
                }
                $cnxS = new mysqli("localhost","root","",$db);
                $cnxS->query($sql2);
                $sql3 = "update columns set foreignKey = 1 where Name = '".$col1."' and idTable =". $_GET['id'];
                $cnx->query($sql3);
                $sql4 = "update columns set primaryTable = '$tablePere-$col2' where Name = '".$col1."' and idTable =". $_GET['id'];
                $cnx->query($sql4);

            }   
                
            ?>
    </div>
    <!-- <script src="js/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <!-- <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script> -->


    <script>
    $(document).ready(function() {
        $("#dbs").change(function() {
            var selectedDb = $(this).val();
            $.get("ajax.php", {
                selectedDb: selectedDb
            }, function(data) {
                $("#tables").html(data)
            });
        })
        $("#tables").change(function() {
            var selectedtable = $(this).val();
            $.get("ajax.php", {
                selectedtable: selectedtable
            }, function(data) {
                $("#col2").html(data)
            });
        })
    })
    </script>
</body>

</html>