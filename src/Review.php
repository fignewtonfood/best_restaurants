<?php
    class Review
    {
        private $restaurant_id;
        private $comment;
        private $id;

        function __construct($rest_id, $comment, $id = null)
        {
            $this->restaurant_id = $rest_id;
            $this->comment = $comment;
            $this->id = $id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO reviews (restaurant_id, comment) VALUES ({$this->getRestId()}, '{$this->getComment()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function getComment()
        {
            return $this->comment;
        }

        function getRestId()
        {
            return $this->restaurant_id;
        }

        static function getAll()
        {
            $returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews;");
            $reviews = array();
            foreach($returned_reviews as $review){
                $comment = $review['comment'];
                $restaurant_id = $review['restaurant_id'];
                $id = $review['id'];
                $new_review = new Review($restaurant_id, $comment, $id);
                array_push($reviews, $new_review);
            }
            return $reviews;
        }
    }



 ?>
