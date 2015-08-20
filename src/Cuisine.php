<?php
    class Cuisine
    {
        private $id;
        private $type;

        function __construct($type, $id = null)
        {
            $this->id = $id;
            $this->type = $type;
        }

        function getType()
        {
            return $this->type;
        }

        function setType($new_type)
        {
            $this->type = $new_type;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisines (type) VALUES ('{$this->getType()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_type)
        {
            $GLOBALS['DB']->exec("UPDATE cuisines SET type = '{$new_type}' WHERE id = {$this->getId()};");
            $this->setType($new_type);
        }

        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines WHERE id = {$this->getId()};");
        }

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines_to_search = Cuisine::getAll();
            foreach($cuisines_to_search as $cuisine){
                $cuisine_id = $cuisine->getId();
                if($cuisine_id=== $search_id){
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $cuisines = array();
            foreach($returned_cuisines as $cuisine){
                $type = $cuisine['type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($type, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines;");
        }
    }
 ?>
