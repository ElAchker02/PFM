<?php
        // include '../Connection.php';
    class Formateur extends Personne{
        private $matricule;
        private $dateEmbauche;
        private $specialite;
        function __construct($nom,$prenom,$dateNaiss,$matricule,$DateEmbauche,$Specialite) {
            $this->matricule = $matricule;
            $this->dateEmbauche = $DateEmbauche;
            $this->specialite = $Specialite;
            parent::__construct($nom,$prenom,$dateNaiss);
        }
        public function getMatricule(){
            return $this->matricule;
        }
        public function setMatricule($matricule){
            $this->matricule == $matricule;
        }

        public function getDateEmbauche(){
            return $this->dateEmbauche;
        }
        public function setDateEmbauche($dateEmbauche){
            $this->dateEmbauche == $dateEmbauche;
        }

        public function getSpecialite(){
            return $this->specialite;
        }
        public function setSpecialite($specialite){
            $this->specialite == $specialite;
        }

        //Implements the abstract methodes
        public function Create(){
            $cnx = new mysqli("localhost","root","","gestiondespersonnes");
            $sql = "INSERT INTO `formateurs`(`matricule`, `nom`, `prenom`, `dateNaiss`, `dateEmbauche`, `specialite`) VALUES ($this->matricule,'$this->nom','$this->prenom','$this->dateNaiss','$this->dateEmbauche',' $this->specialite ')";
            $cnx->query($sql);
        }
        public static function Reserch($mat){
            $cnx = new mysqli("localhost","root","","gestiondespersonnes");
            $sql = "SELECT * FROM `formateurs` WHERE matricule = $mat";
            $results =  $cnx->query($sql);
            while($row = $results->fetch_assoc()){
                echo "
                <table>
                <tr>
                    <td>$row[matricule]</td>
                    <td>$row[nom]</td>
                    <td>$row[prenom]</td>
                    <td>$row[dateNaiss]</td>
                    <td>$row[dateEmbauche]</td>
                    <td>$row[specialite]</td>
                </tr>
                </table>";
            }
        }
        public static function Update($mat,$colums){
            $cnx = new mysqli("localhost","root","","gestiondespersonnes");
            $sql = "UPDATE `formateurs` SET`nom`='".$colums['nom']."',`prenom`='".$colums['prenom']."',`dateNaiss`='".$colums['dateNaiss']."',`dateEmbauche` = '".$colums['dateEmbauche']."',`specialite` = '".$colums['specialite']."' WHERE matricule = $mat";
            $cnx->query($sql);
        }
        public static function Delete($mat){
            $cnx = new mysqli("localhost","root","","gestiondespersonnes");
            $sql = "DELETE FROM `formateurs` WHERE matricule=$mat";
            $cnx->query($sql);
        }
    }
?>