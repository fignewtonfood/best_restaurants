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

    }

 ?>
