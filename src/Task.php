<?php
    class Task
    {
        private $description;
        private $id;
        private $category_id;
        function __construct($description, $id = null, $category_id)
        {
            $this->description = $description;
            $this->id = $id;
            $this->category_id = $category_id;
        }
        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }
        function getDescription()
        {
            return $this->description;
        }
        function getCategoryId()
        {
            return $this->category_id;
        }
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO tasks (description, category_id) VALUES ('{$this->getDescription()}', {$this->getCategoryId()})");
            $this->id = $GLOBALS['DB']->lastInsertId();
            // may need to add ; outside of closing curly bracket after "get Category"
        }
        static function getAll()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            $tasks = array();
            foreach($returned_tasks as $task) {
                $description = $task['description'];
                $id = $task['id'];
                $category_id = $task['category_id'];
                $new_task = new Task($description, $id, $category_id);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM tasks;");
        }
        function getId()
        {
            return $this->id;
        }

        function update($new_description)
        {
            $GLOBALS['DB']->exec("UPDATE tasks SET description = '{$new_description}' WHERE id = {$this->getId()};");
            $this->setDescription($new_description);
        }
        
        static function find($search_id)
        {
            $found_task = null;
            $tasks = Task::getAll();
            foreach($tasks as $task){
                $task_id = $task->getId();
                if($task_id == $search_id) {
                    $found_task = $task;
                }
            }
            return $found_task;
        }
    }
?>
