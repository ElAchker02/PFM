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

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="shortcut icon" href="img/L2.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>

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
					GestionTables::SideBarButtons((isset($_GET['id']) ? $_GET['id'] : 0));
				?>

                </ul>

                <div class="mb-5">
                </div>

                <div class="footer">

                </div>

            </div>

        </nav>

    
 <div id="content"   style="background-color: #eee;" >
    <header class=" w-100 pl-4 pt-1 pb-1 mb-2  shadow shadow-sm " style="background-color: #212832;" >
 <?php if(isset($_GET['id'])){
                $sql1 = "SELECT tableName FROM `tables` where id =". $_GET['id'];
                $results = $cnx->query($sql1);
                $tableName;
                while($row = $results->fetch_assoc()){
                    $tableName = $row['tableName'];
                }
                echo "<h3 style='color:#00ADB4;margin-bottom:0;height: 70px;display: flex;align-items: center;'>Base de données : ".$_GET['db']." >> Table : ".$tableName."</h3>";

                ?>

</header>
<div class="pl-4 pr-4   pt-2">

            <div class="row">
                
            
                <div class="btn-group ml-3" role="group" aria-label="Basic example">
                <input type="hidden" id="tableId" value="<?php echo $_GET['id']."-".$tableName."-".$_GET['db'];?>">
                <input type="hidden" id="db" value="<?php echo $_GET['db'];?>">
                <button type="button" class="btn btn-secondary" style="border-left: 1px solid white ; border-right: 1px solid white;" id="deleteDB">Supprimer BD</button>
                <button type="button" class="btn btn-secondary" style="border-left: 1px solid white ; border-right: 1px solid white;" id="deleteTab">Supprimer Table</button>
                <a href="addRelations.php?db=<?php echo $_GET['db']."&id=". $_GET['id'] ; ?>"
                        class="btn btn-secondary" target="_blank" style="border-left: 1px solid white ; border-right: 1px solid white;" id="relations">Créer les relations</a>
                        <button type="button" class="btn btn-secondary" style="border-left: 1px solid white ; border-right: 1px solid white;" id="inserer" data-toggle="modal"
                        data-target="#exampleModal">Insérer</button>
            </div>
            </div>
      
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <form action="" method="post">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Insérer</h5>
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
                                <input type="submit" value="Sauvegarder" class="btn btn-success" name="btnSub">
                                <input type="reset" value="Vider" class="btn btn-danger" >
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <table class="table table-bordered shadow-lg mt-5 table-sm table-hover table-striped">
                <thead>
                    <tr style="background-color: #00ADB4; color:white;">
                        <th>Nom du colonne</th>
                        <th>Clé primaire</th>
                        <th>Type</th>
                        <th>Longueur</th>
                        <th>Clé étrangère</th>
                    </tr>
                </thead>
                <tbody>
                  <?php GestionTables::LoadColumn($_GET['id']);?>
	  
                </tbody>
            </table>
            <h4>Enregistrement</h4>

            <table class="table table-bordered shadow-lg mt-3 table-sm table-hover table-striped">
                <thead>
                    <tr style="background-color: #00ADB4; color:white;">
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
                            ?>" class="btn btn-primary" id="Modifier" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                              </svg></a>

                            <a href="Delete.php <?php if($primaryIndex != -1) 
                            {echo "?cle=".$row[$primaryIndex]; 
                            echo "&idTable=".$_GET['id']."&tableName=".$tableName."&db=".$_GET['db']."&primaryName=".$primaryKeyName."&primaryType=".$primaryKeyType ; } 
                            ?>" class="btn btn-danger" id="Supprimer"  ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                          </svg></a></td>
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

    var url = window.location.href;
    var id = url.substring(url.indexOf('=') + 1)
    var idz = id.substring(0,id.indexOf('&'))
    document.getElementById(idz).click();
    </script>

</body>

</html>