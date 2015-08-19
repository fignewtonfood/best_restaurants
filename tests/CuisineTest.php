<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Cuisine.php";
    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $type = "seafood";
            $test_cuisine = new Cuisine($type);

            //Act
            $test_cuisine->save();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $type1 = "seafood";
            $type2 = "Italian";
            $test_cuisine1 = new Cuisine($type1);
            $test_cuisine1->save();
            $test_cuisine2 = new Cuisine($type2);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_cuisine1, $test_cuisine2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $type1 = "seafood";
            $type2 = "Italian";
            $test_cuisine1 = new Cuisine($type1);
            $test_cuisine1->save();
            $test_cuisine2 = new Cuisine($type2);
            $test_cuisine2->save();

            //Act
            Cuisine::deleteAll();

            //Assert
            $result = Cuisine::getAll();
            $this->assertEquals([], $result);
        }
    }
