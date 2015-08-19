<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Review.php";
    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ReviewTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Review::deleteAll();
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $rest_id = 1;
            $comment = "This place is great!";
            $test_review = new Review($rest_id, $comment);

            //Act
            $test_review->save();
            $result = Review::getAll();

            //Assert
            $this->assertEquals($test_review, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $rest_id = 1;
            $comment1 = "This place is great!";
            $comment2 = "This place sucks!!!";
            $test_review1 = new Review($rest_id, $comment1);
            $test_review1->save();
            $test_review2 = new Review($rest_id, $comment2);
            $test_review2->save();

            //Act
            $result = Review::getAll();

            //Assert
            $this->assertEquals([$test_review1, $test_review2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $rest_id = 1;
            $comment1 = "This place is great!";
            $comment2 = "This place sucks!!!";
            $test_review1 = new Review($rest_id, $comment1);
            $test_review1->save();
            $test_review2 = new Review($rest_id, $comment2);
            $test_review2->save();

            //Act
            Review::deleteAll();
            $result = Review::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_getId()
        {
            //Arrange
            $type = "burger";
            $test_cuisine = new Cuisine($type);
            $test_cuisine->save();

            $name = "Burger King";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($cuisine_id,$name);
            $test_restaurant->save();

            $comment = "Great burger!";
            $restaurant_id = $test_restaurant->getId();
            $test_review = new Review($restaurant_id, $comment);
            $test_review->save();

            //Act
            $result = $test_review->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }
    }


?>
