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


    }

 ?>
