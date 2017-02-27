<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Category.php";
    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Category::deleteAll();
          Task::deleteAll();
        }
        function test_getName()
        {
            //Arrange
            $name = "Work stuff";
            $test_Category = new Category($name);
            //Act
            $result = $test_Category->getName();
            //Assert
            $this->assertEquals($name, $result);
        }
        function test_getId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);
            //Act
            $result = $test_Category->getId();
            //Assert
            $this->assertEquals(true, is_numeric($result));
        }
        function test_save()
        {
            //Arrange
            $name = "Work stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            //Act
            $result = Category::getAll();
            //Assert
            $this->assertEquals($test_Category, $result[0]);
        }
        function test_getAll()
        {
            //Arrange
            $name = "Work stuff";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();
            //Act
            $result = Category::getAll();
            //Assert
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }
        function test_deleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();
            //Act
            Category::deleteAll();
            $result = Category::getAll();
            //Assert
            $this->assertEquals([], $result);
        }
        function test_find()
        {
            //Arrange
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();
            //Act
            $result = Category::find($test_Category->getId());
            //Assert
            $this->assertEquals($test_Category, $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $new_name = "Home stuff";

            //Act
            $test_category->update($new_name);

            //Assert
            $this->assertEquals("Home stuff", $test_category->getName());
        }

        function testDeleteCategory()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Home stuff";
            $id = 2;
            $test_category2 = new Category($name2, $id);
            $test_category2->save();

            //Act
            $test_category->delete();

            //Assert
            $this->assertEquals([$test_category2], Category::getAll());
        }

        // function testDeleteCategoryTasks()
        // {
        //     //Arrange
        //     $name = "Work stuff";
        //     $id = 1;
        //     $test_category = new Category($name, $id);
        //     $test_category->save();
        //
        //     $description = "Build website";
        //     $category_id = $test_category->getId();
        //     $test_task = new Task($description, $id);
        //     $test_task->save();
        //
        //
        //     //Act
        //     $test_category->delete();
        //
        //     //Assert
        //     $this->assertEquals([], Task::getAll());
        // }

        function testAddTask()
        {
          //Arrange
          $name = "Work Stuff";
          $id = 1;
          $test_category =  new Category($name, $id);
          $test_category->save();

          $description = "File reports";
          $id2 = 2;
          $test_task = new Task($description, $id2);
          $test_task->save();

          //Act
          $test_category->addTask($test_task);

          //Assert
          $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function testGetTasks()
        {
          $name = "Home Stuff";
          $id = 1;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "Wash the dog";
          $id2 = 2;
          $test_task = new Task($description, $id2);
          $test_task->save();

          $description2 = "Take out the trash";
          $id3 = 3;
          $test_task2 = new Task($description2, $id3);
          $test_task2->save();

          //Act
          $test_category->addTask($test_task);
          $test_category->addTask($test_task2);

          //Assert
          $this->assertEquals($test_category->getTasks(), [$test_task, $test_task2]);
        }
    }
?>
