<?php
			include "Connection.php";
            include "Classes/GestionTables.php";

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

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
					GestionTables::SideBarButtons();
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

            



            <form action="" method="post">
                <h2>Creer une base de données</h2>
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Base de données" id="dbs">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary mb-2" id="btnDB" type="button">Creer</button>
                    </div>
                </div>
                Base de donnée : <select name="DBs" id="DBs">
                    <?php
							$sql = "SELECT * FROM `dbs`";
							$results =  $cnx->query($sql); ?>
							<?php while($row = $results->fetch_assoc()){
								?>

                    <option value="<?php echo $row['Name']?>"><?php echo $row['Name']?></option>
                    <?php } ?>
                </select>
                <h2>Creer une table</h2>
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Nom du table" id="nomTable"
                            name="nomTable">
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" placeholder="Nombre de colonnes" min="0"
                            id="nbColonnes" value="0">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary mb-2" id="CreateTable" type="button">Creer</button>
                    </div>
                </div>

                <table class="table table-sm mt-4">
                    <thead>
                        <tr>
                            <td>Nom du colonne</td>
                            <td>Type</td>
                            <td>Longueur</td>
                            <td>Clé primaire</td>

                        </tr>
                    </thead>
                    <tbody id="tableBody">

                    </tbody>
                    <?php
                    if(isset($_POST['btnsubmit'])){
                        $table = $_POST['nomTable'];
                        $DBs = $_POST['DBs'];
                        $colonne = $_POST['colonne'];
                        $types = $_POST['types'];
                        $longueur = $_POST['longueur'];
                        $primary = $_POST['primary'];

                        GestionTables::CreateTable($DBs,$table,$colonne,$types,$longueur,$primary);
                   
                       
                    }
                 ?>
                </table>
                
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script>
        
    $(document).ready(function() {
        $("#CreateTable").click(function() {
            var nbCol = $("#nbColonnes").val();
            var nomTable = $("#nomTable").val();
            var nomdb = $("#DBs").val();
            if (nbCol != 0 && nomTable != "") {
                $.get(
                    "ajax.php", {
                        infos: nbCol 
                    },
                    function(data) {
                        $('#tableBody').html(data);
                    }
                );
            }


        })
        $("#btnDB").click(function() {
            var nom = $("#dbs").val();
            if (nom != "") {
                $.get(
                    "ajax.php", {
                        nomDb: nom
                    },
                    function(data) {
                        $('#DBs').html(data);
                    }
                );
            } else {
                alert('Donnez un nom a la base de données');
            }


        })
        $("#types0").change(function() {
            if ($(this).val() != "VARCHAR") {
                $("#longueur0").attr('disabled', 'disabled');
            } else {
                $("#longueur0").removeAttr('disabled');
                alert('hi');
            }
        })
    });
    </script>
    

</body>

</html>