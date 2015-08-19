<?php
    class Cuisine
    {
        private $id;
        private $type;

        function __construct($id = null, $type)
        {
            $this->id = $id;
            $this->type = $type;
        }

        static function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisines (type) VALUES ('{$this->getType()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $cuisines = array();
            foreach($returned_cuisines as $cuisine){
                $type = $cuisine['type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($id, $type);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }
    }
 ?>
