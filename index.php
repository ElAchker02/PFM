<?php
			include "Connection.php";

?>
<!doctype html>
<html lang="en">

<head>
    <title>Sidebar 02</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <div class="p-4 pt-5">
                <h1><a href="index.php" class="logo">PFM</a></h1>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="NewDB_Tab.php">Nouveau base de données & Nouveau tableau</a>
                    </li>
                    <?php
					$sql = "SELECT * FROM `dbs`";
					$results =  $cnx->query($sql);
					while($row = $results->fetch_assoc()){
						$results2 = $cnx->query("SELECT * FROM `tables` WHERE DB = '".$row['Name']."'");
						echo '<li ><a href="#'.$row['Name'].'" id ="'.$row['Name'].'" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">'.$row['Name'].'</a>
						<ul class="collapse list-unstyled" id="'.$row['Name'].'">';
						while($row2 = $results2->fetch_assoc()){
							echo '<li><a href="index.php?db='.$row['Name'].'&id='.$row2['id'].'">'.$row2['tableName'].'</a></li>';
						}
						echo '</ul></li>';
					}
				?>

                </ul>

                <div class="mb-5">
                </div>

                <div class="footer">

                </div>

            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <?php if(isset($_GET['id'])){
                $sql1 = "SELECT tableName FROM `tables` where id =". $_GET['id'];
                $results = $cnx->query($sql1);
                $tableName;
                while($row = $results->fetch_assoc()){
                    $tableName = $row['tableName'];
                }
                echo "<h4>Base de données : ".$_GET['db']." --> Table : ".$tableName."</h4>";

                ?>

            <div class="row">
                <input type="hidden" id="tableId" value="<?php echo $_GET['id']."-".$tableName."-".$_GET['db'];?>">
                <input type="hidden" id="db" value="<?php echo $_GET['db'];?>">
                <div class="col-sm">
                    <button type="button" class="btn btn-danger" id="deleteDB">Supprimer La base de données</button>
                </div>
                <div class="col-sm">
                    <button type="button" class="btn btn-danger" id="deleteTab">Supprimmer la table</button>
                </div>
                <div class="col-sm">
                    <a href="addRelations.php?db=<?php echo $_GET['db']."&id=". $_GET['id'] ; ?>" class="btn btn-secondary" target="_blank" id="relations">Creer les relation</a>

                </div>
                <div class="col-sm">
                    <button type="button" class="btn btn-success" id="inserer">Inserer des enregistrement</button>
                </div>
            </div>
            <table class="table table-sm mt-5">
                <thead>
                    <tr>
                        <td>Nom du colonne</td>
                        <td>Clé primaire</td>
                        <td>Type</td>
                        <td>Longueur</td>
                        <td>Clé étrangère</td>
                    </tr>
                </thead>
                <tbody>
                    <?php

				$sql = "SELECT * FROM `columns` WHERE idTable =". $_GET['id'];
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

			}
	  ?>
                </tbody>

            </table>
            <h4>Enregistrement</h4>

            <table class="table table-sm mt-3">
                <thead>
                    <tr>
                        <?php 
                        $sql = "SELECT * FROM `columns` WHERE idTable =". $_GET['id'];
                        $results =  $cnx->query($sql);
                        $i = 0;
                        while($row = $results->fetch_row()){
                            $i++;
                            ?>
                        <th><?php echo $row[0]; ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        
                        $cnxS = new mysqli("localhost","root","",$_GET['db']);
                        $sql = "SELECT * FROM $tableName";
                        $results =  $cnxS->query($sql);
                        
                        while($row = $results->fetch_row()){?>
                        <tr>    
                            <?php 
                            for($j = 0 ; $j< $i;$j++){?>
                                <td><?php echo $row[$j];?></td>
                           <?php }
                            ?>
                        </tr>
                           
                           <?php } ?>
                </tbody>
            </table>
            <?php }  ?>

        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    $(document).ready(function() {
        $("#deleteDB").click(function() {
            var database = $("#db").val();
            $.get(
                "ajax.php", {
                    db: database
                },
                function(data) {

                }
            );
        })
        $("#deleteTab").click(function() {
            var tabInfos = $("#tableId").val();
            $.get(
                "ajax.php", {
                    tableinfos: tabInfos
                },
                function(data) {

                }
            );
        })
    })
    </script>

</body>

</html>