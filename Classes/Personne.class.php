<?php
    abstract class Personne{
        protected $nom;
        protected $prenom;
        protected $dateNaiss;
        abstract public function Create();
        abstract static public function Reserch($id);
        abstract static public function Update($id,$columns);
        abstract static public function Delete($id);
        protected function __construct($nom,$prenom,$dateNaiss)
        {
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->dateNaiss = $dateNaiss;
        }
    }
?>