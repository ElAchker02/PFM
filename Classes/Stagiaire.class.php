<?php
    class Stagiaire extends Personne{
    // include '../Connection.php';

        private $moyenne;
        private $cne;
        function __construct($cne,$nom,$prenom,$dateNaiss,$moyenne) {
            $this->moyenne = $moyenne;
            $this->cne = $cne;
            parent::__construct($nom,$prenom,$dateNaiss);
        }
        public function getMoyenne(){
            return $this->moyenne;
        }
        public function setMoyenne($moyenne){
            $this->moyenne == $moyenne;
            
        }

        //Implements the abstract methodes
        public function Create(){
            $cnx = new mysqli("localhost","root","","gestiondespersonnes");
            $sql = "INSERT INTO `stagiaire`(`cne`, `nom`, `prenom`, `dateNaiss`, `moyenne`) VALUES ('$this->cne','$this->nom','$this->prenom','$this->dateNaiss',$this->moyenne)";
            $cnx->query($sql);
            
        }
        public static function Reserch($cne){
            $cnx = new mysqli("localhost","root","","gestiondespersonnes");
            $sql = "SELECT * FROM `stagiaire` WHERE cne = '$cne'";
            $results =  $cnx->query($sql);
            while($row = $results->fetch_assoc()){
                echo "
                <table>
                <tr>
                    <td>$row[cne]</td>
                    <td>$row[nom]</td>
                    <td>$row[prenom]</td>
                    <td>$row[dateNaiss]</td>
                    <td>$row[moyenne]</td>
                </tr>
                </table>";
            }
        }
        public  static function Update($cne,$colums){
            $cnx = new mysqli("localhost","root","","gestiondespersonnes");
            $sql = "UPDATE `stagiaire` SET`nom`='".$colums['nom']."',`prenom`='".$colums['prenom']."',`dateNaiss`='".$colums['dateNaiss']."',`moyenne`=".$colums['moyenne']." WHERE cne = '$cne'";
            $cnx->query($sql);
        }
        public static function Delete($cne){
            $cnx = new mysqli("localhost","root","","gestiondespersonnes");
            $sql = "DELETE FROM `stagiaire` WHERE cne='$cne'";
            $cnx->query($sql);
        }
    }
?>