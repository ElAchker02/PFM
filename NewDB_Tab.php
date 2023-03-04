<?php
			include "Connection.php";
            include "Classes/GestionTables.php";

?>
<!doctype html>
<html lang="en">

<head>
    <title>BD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/L2.png">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body style="background-color: #EEEEEE;">

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="pt-2 pl-2 pr-2 ">
                <a href="index.php" class="logo"><img src="img/L1.png" class="ml-0 w-100 " alt="Logo"></a>
            </div>
            <div class="pl-4 pr-4">

                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="NewDB_Tab.php">Nouveau BD & Table</a>
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
        <div id="content" style="background-color: #eee;">
            
            <div id="content" class="">
            <header class=" w-100 pl-4 pt-1 pb-1 mb-2  shadow shadow-sm " style="background-color: #212832;">
                <h3 style='color:#00ADB4;margin-bottom:0;height: 60px;display: flex;align-items: center;'>Gérer la base
                    de données</h3>
            </header>
                <div class="p-3   pt-3">
                    <form action="" method="post">
                        <!-- card1 -->
                        <div class="card shadow shadow-sm mt-4">
                            <h5 class="card-header">Créer une base de donnée</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Base de données" id="dbs">
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-primary mb-2" id="btnDB" type="button">Creer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card 2 -->

                        <div class="card shadow shadow-sm mt-5">
                            <h5 class="card-header">Créer Table</h5>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <label class="input-group-text">Choisir une base de donnée</label>
                                    <select name="DBs" id="DBs" class="form-select">
                                        <?php
							$sql = "SELECT * FROM `dbs`";
							$results =  $cnx->query($sql); ?>
                                        <?php while($row = $results->fetch_assoc()){
								?>

                                        <option value="<?php echo $row['Name']?>"><?php echo $row['Name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Nom du table" id="nomTable"
                                            name="nomTable">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" placeholder="Nombre de colonnes"
                                            min="0" id="nbColonnes" value="0">
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-primary mb-2" id="CreateTable"
                                            type="button">Creer</button>
                                    </div>
                                </div>

                                <div id='tableBody'></div>
                                <?php
                    if(isset($_POST['btnsubmit'])){
                        $table = $_POST['nomTable'];
                        $DBs = $_POST['DBs'];
                        $colonne = $_POST['colonne'];
                        $types = $_POST['types'];
                        $longueur = $_POST['longueur'];
                        $primary = $_POST['primary'];

                        if(GestionTables::CreateTable($DBs,$table,$colonne,$types,$longueur,$primary) == 1){
                            ?>
                                <script>
                                Swal.fire(
                                    "Le tableau est crée avec success",
                                    '',
                                    'success',
                                );
                                </script>
                                <?php } elseif(GestionTables::CreateTable($DBs,$table,$colonne,$types,$longueur,$primary) == 0){?>
                                <script>
                                Swal.fire(
                                    "Le tableau est pas crée",
                                    '',
                                    'error',
                                );
                                </script>
                                <?php }elseif (GestionTables::CreateTable($DBs,$table,$colonne,$types,$longueur,$primary) == 2){
                            ?>
                                <script>
                                Swal.fire(
                                    "Le tableau doit contenir un clé primaire",
                                    '',
                                    'info',
                                );
                                </script>
                                <?php }
                   
                       
                    }
                 ?>


                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
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