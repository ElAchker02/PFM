<?php
			include "Connection.php";
            include "Classes/GestionTables.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Base de données</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="shortcut icon" href="img/L2.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="pt-2 pl-2 pr-2 ">
                <a href="dataBases.php" class="logo"><img src="img/L1.png" class="ml-0 w-100 " alt="Logo"></a>
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


        <div id="content" style="background-color: #eee;">
            <header class=" w-100 pl-4 pt-1 pb-1 mb-2  shadow shadow-sm " style="background-color: #212832;">
                <h3
                    style='color:#00ADB4;margin-bottom:0;height: 60px;display: flex;align-items: center; justify-content:center;'>
                    Base de données</h3>

            </header>
            <div class="container">
                <table class="table table-bordered shadow-lg mt-3 table-sm table-hover table-striped">
                    <thead>
                        <tr style="background-color: #00ADB4; color:white;">
                            <th scope="col">Nom de la base de données</th>
                            <th scope="col">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    GestionTables::LoadDb();
                ?>
                    </tbody>
                </table>
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
</body>

</html>