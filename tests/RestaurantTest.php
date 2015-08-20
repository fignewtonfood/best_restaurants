<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
            Review::deleteAll();
            Cuisine::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $cuisine_id = 1;
            $name = "Burger King";
            $test_rest = new Restaurant($cuisine_id, $name);

            //Act
            $test_rest->save();
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals($test_rest, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name1 = "Burger King";
            $name2 = "Dairy Queen";
            $cuisine_id = 1;
            $test_restaurant1 = new Restaurant($cuisine_id, $name1);
            $test_restaurant1->save();
            $test_restaurant2 = new Restaurant($cuisine_id, $name2);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_restaurant1, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $cuisine_id = 1;
            $name1 = "Burger King";
            $name2 = "Dairy Queen";
            $test_restaurant1 = new Restaurant($cuisine_id, $name1);
            $test_restaurant1->save();
            $test_restaurant2 = new Restaurant($cuisine_id, $name2);
            $test_restaurant2->save();

            //Act
            Restaurant::deleteAll();
            $result = Restaurant::getAll();

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
            $test_restaurant = new Restaurant($cuisine_id, $name);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_find()
        {
            //Arrange
            $type1 = "burger";
            $test_cuisine1 = new Cuisine($type1);
            $test_cuisine1->save();

            $type2 = "Italian";
            $test_cuisine2 = new Cuisine($type2);
            $test_cuisine2->save();

            $name1 = "Burger King";
            $cuisine_id1 = $test_cuisine1->getId();
            $test_restaurant1 = new Restaurant($cuisine_id1, $name1);
            $test_restaurant1->save();

            $name2 = "Olive Garden";
            $cuisine_id2 = $test_cuisine2->getId();
            $test_restaurant2 = new Restaurant($cuisine_id2, $name2);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::find($test_cuisine1->getId());

            //Assert
            $this->assertEquals([$test_restaurant1],$result);
        }

        function test_updateName()
        {
            //Arrange
            $name = "Booger King";
            $test_restaurant = new Restaurant(1, $name);
            $test_restaurant->save();

            $new_name = "Burger King";

            //Act
            $test_restaurant->updateName($new_name);
            $result = $test_restaurant->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_updateCuisineId()
        {
            //Arrange
            $name = "Burger King";
            $cuisine_id = 1;
            $test_restaurant = new Restaurant($cuisine_id, $name);
            $test_restaurant->save();

            $new_cuisine_id = 2;

            //Act
            $test_restaurant->updateCuisineId($new_cuisine_id);
            $result = $test_restaurant->getCuisineId();

            //Assert
            $this->assertEquals($new_cuisine_id, $result);
        }

        function test_deleteOne()
        {
            //Arrange
            $name1 = "Salmon King";
            $test_restaurant1 = new Restaurant(1, $name1);
            $test_restaurant1->save();
            $name2 = "Dairy Queen";
            $test_restaurant2 = new Restaurant(1, $name2);
            $test_restaurant2->save();
            //reviews for test rest 1
            $comment1 = "Great Salmon";
            $rest_id = $test_restaurant1->getId();
            $test_review1 = new Review($rest_id, $comment1);
            $test_review1->save();
            $comment2 = "Terrible Salmon";
            $test_review2 = new Review($rest_id, $comment1);
            $test_review2->save();
            //var_dump($test_review2);
            //reviews for test rest 2
            $comment3 = "Great Dairy!";
            $rest_id2 = $test_restaurant2->getId();
            $test_review3 = new Review($rest_id2, $comment3);
            $test_review3->save();
            $comment4 = "Terrible Dairy!";
            $test_review4 = new Review($rest_id2, $comment4);
            $test_review4->save();
            //var_dump($test_review4);

            //Act
            $test_restaurant1->deleteOne();
            $result1 = Restaurant::getAll();
            $result2 = Review::getAll();
            //var_dump($result2);

            //Assert
            $this->assertEquals([$test_restaurant2], $result1);
            $this->assertEquals([$test_review3, $test_review4], $result2);
        }


    }

 ?>
