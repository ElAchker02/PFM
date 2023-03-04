<?php
include "Connection.php";
include "Classes/GestionTables.php";
$sql = "SELECT * FROM `columns` WHERE idTable =". $_GET['idTable'];
$results =  $cnx->query($sql);
$i = 0;
$colsType = array();
$cols = array();
while ($row = $results->fetch_row()) {
    $cols[$i] = $row[0];
    $colsType[$row[0]] = $row[1];
    $i++;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/L2.png">
    <title><?php echo "Modifier le table ".$_GET['tableName'];?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <header
        style="height: 150px;width: 100%; background-color: #00ADB4;display: flex; justify-content: center; align-items: center;">
        <h1 style="color: white;"><?php echo "Modifier le table ".$_GET['tableName'];?></h1>
    </header>
    <div class="container mt-4 ">



        <form action="" method="post">
            <?php
    GestionTables::CreateForms($_GET['idTable'],$_GET['db']); ?>
            <div class="d-flex justify-content-center align-items-center mt-2">
                <input type="submit" value="Modifier" name="btnsub" class="btn btn-primary  ">
            </div>

            <?php
    $cnxS = new mysqli("localhost","root","",$_GET['db']);
    $sql2 = "SELECT * FROM ".$_GET['tableName'] ." WHERE ".$_GET['primaryName'] ." = ".($_GET['primaryType'] == "VARCHAR" || $_GET['primaryType'] == "DATE" || $_GET['primaryType'] == "TEXT" ? "'". $_GET['cle'] ."'":$_GET['cle']);
    $results2 =  $cnxS->query($sql2);
    $j = 0;
    echo ' <script>';
    while ($row = $results2->fetch_row()) {
        while ($j < $i) {
            echo " document.getElementById('".$cols[$j]."').value = '".$row[$j]."';";
            $j++;
        }
        
    }
    echo ' </script>';
    if(isset($_POST['btnsub'])){
        GestionTables::Modifier($_GET['tableName'],$i,$cols,$colsType,$_GET['primaryName'],$_GET['primaryType'],$_GET['cle'],$cnxS);
        header("location:index.php?db=".$_GET['db']."&id=".$_GET['idTable']);
        exit;
    }
    ?>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
</body>

</html>