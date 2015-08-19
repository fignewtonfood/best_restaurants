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
        // protected function tearDown()
        // {
        //     Cuisine::deleteAll();
        // {

        function test_save()
        {
            //Arrange
            $type = "seafood";
            $test_cuisine = new Cuisine($id, $type);

            //Act
            $test_cuisine->save();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_cuisine, $result[0]);
        }

    }
