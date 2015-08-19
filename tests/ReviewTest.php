<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Review.php";
    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ReviewTest extends PHPUnit_Framework_TestCase
    {
        // protected function deleteAll()
        // {
        //
        // }

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

    }


?>
