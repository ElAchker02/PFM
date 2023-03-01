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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
           
            <div class="p-4 pt-5">
                <h1><a href="index.php" class="logo">PFM</a></h1>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="NewDB_Tab.php">Nouveau base de données & Nouveau tableau</a>
                    </li>
                    <?php GestionTables::SideBarButtons();?>

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
                    <a href="addRelations.php?db=<?php echo $_GET['db']."&id=". $_GET['id'] ; ?>"
                        class="btn btn-secondary" target="_blank" id="relations">Creer les relation</a>

                </div>
                <div class="col-sm">
                    <button type="button" class="btn btn-success" id="inserer" data-toggle="modal"
                        data-target="#exampleModal">Inserer des enregistrement</button>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <form action="" method="post">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table>
                                <?php GestionTables::CreateForms($_GET['id'],$_GET['db']);?>
                                    </table>
                                
                            </div>
                            <div class="modal-footer">
                                <input type="submit" value="Sauvegarder" class="btn btn-secondary" name="btnSub">
                                <input type="reset" value="Vider" class="btn btn-secondary" >
                            </div>
                        </div>
                    </div>
                </form>

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
                  <?php GestionTables::LoadColumn($_GET['id']);?>
	  
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
                        $primaryIndex =-1;
                        $primaryKeyName ;
                        $primaryKeyType ;
                        $columns =array();
                        $columnsNamee = array();
                        $k =0;
                        while($row = $results->fetch_row()){
                            
                            if($row[3] == 1){
                                $primaryIndex = $i;
                                $primaryKeyName = $row[0];
                                $primaryKeyType = $row[1];
                            }
                            $columns[$row[0]] = $row[1];
                            $columnsNamee[$k] = $row[0];
                            $i++;
                            $k++;
                            ?>
                        <th><?php echo $row[0]; ?></th>
                        <?php } ?>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        // echo $primaryIndex;
                        $cnxS = new mysqli("localhost","root","",$_GET['db']);
                        $sql = "SELECT * FROM $tableName";
                        $results =  $cnxS->query($sql);
                        if($results){
                            
                        while($row = $results->fetch_row()){?>
                    <tr>
                        <?php 
                            for($j = 0 ; $j< $i;$j++){?>
                        <td><?php echo $row[$j];?></td>
                        <?php }
                            ?>
                            <td><a href="Modifier.php<?php if($primaryIndex != -1) 
                            {echo "?cle=".$row[$primaryIndex]; 
                                echo "&idTable=".$_GET['id']."&tableName=".$tableName."&db=".$_GET['db']."&primaryName=".$primaryKeyName."&primaryType=".$primaryKeyType ;  } 
                            ?>" class="btn btn-success" id="Modifier" target="_blank">Modifier</a>

                            <a href="Delete.php <?php if($primaryIndex != -1) 
                            {echo "?cle=".$row[$primaryIndex]; 
                            echo "&idTable=".$_GET['id']."&tableName=".$tableName."&db=".$_GET['db']."&primaryName=".$primaryKeyName."&primaryType=".$primaryKeyType ; } 
                            ?>" class="btn btn-danger" id="Supprimer" target="_blank" >Supprimer</a></td>
                    </tr>

                    <?php } }?>
                </tbody>
            </table>
            <?php }  ?>
            <?php 
                if(isset($_POST['btnSub'])){
                    GestionTables::Ajouter($_GET['db'],$tableName,$columnsNamee,$columns);
                }
            ?>

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