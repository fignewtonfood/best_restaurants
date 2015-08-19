<?php
    class Restaurant
    {
        private $cuisine_id;
        private $name;
        private $id;

        function __construct($cuis_id, $name, $id = null)
        {
            $this->cuisine_id = $cuis_id;
            $this->name = $name;
            $this->id = $id;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function getName()
        {
            return $this->name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (cuisine_id, name) VALUES ({$this->getCuisineId()}, '{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant){
                $cuisine_id = $restaurant['cuisine_id'];
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $new_rest = new Restaurant($cuisine_id, $name, $id);
                array_push($restaurants, $new_rest);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }


    }
 ?>
