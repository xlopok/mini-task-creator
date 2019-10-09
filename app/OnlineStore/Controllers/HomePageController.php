<?php

namespace App\OnlineStore\Controllers;

use App\OnlineStore\Exceptions\InvalidArgumentException;
use App\OnlineStore\Services\Db;
use League\Plates\Engine;

class HomePageController {
    /**
     * @var Engine
     */
    private $view;
    /**
     * @var Db
     */
    private $db;

    /**
     *
     * @param Engine $view
     */

    public function __construct(Engine $view, Db $db)
    {
        $this->view = $view;
        $this->db = $db;
    }

    public function main() {
        $tasksAll = $this->db->getAll('articles');

        // Render a template
        echo $this->view->render('home', ['tasks' => $tasksAll]);
    }

    public function add() {

        if(!empty($_POST)) {

            try {
                $article = $this->db->add('articles', $_POST);
            } catch (InvalidArgumentException $e) {
                echo $this->view->render('create', ['errors'=> $e->getMessage(), 'data' => $_POST]);
                return;
            }


            header("Location: /" );

            exit();
        }
        echo $this->view->render('create', []);
    }

    public function delete($id) {
        $this->db->delete('articles', $id);
        header("Location: /");
    }

    public function show($id)
    {
        $task = $this->db->getById('articles', $id);
//        var_dump($task);die();
        echo $this->view->render('show', ['task' => $task]);
    }

    public function edit($id)
    {

        if(!empty($_POST)) {

            try {
                $article = $this->db->update('articles', $id, $_POST);
            } catch (InvalidArgumentException $e) {
                $task = $this->db->getById('articles', $id);
                echo $this->view->render('edit', ['errors'=> $e->getMessage(), 'task' => $task ]);
                return;
            }


            header("Location: /" );

            exit();
        }

        $task = $this->db->getById('articles', $id);
        echo $this->view->render('edit', ['task' => $task]);
    }


}