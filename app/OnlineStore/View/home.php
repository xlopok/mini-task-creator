<?php $this->layout('layout', ['title' => 'Главная']) ?>

<div class="container">
    <div class="row">
        <a href="/login">Login</a>
        <div class="col-md-12">
            <h1>All Tasks</h1>
            <a href="/add" class="btn btn-success">Add Task</a>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($tasks as $task):?>
                    <tr>
                        <td><?= $task['id'];?></td>
                        <td><?= $task['article_name'];?></td>
                        <td>
                            <a href="/show/<?= $task['id'];?>" class="btn btn-info">
                                Show
                            </a>
                            <a href="/edit/<?= $task['id'];?>" class="btn btn-warning">
                                Edit
                            </a>
                            <a onclick="return confirm('are you sure?');" href="/delete/<?= $task['id'];?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach;?>

                </tbody>
            </table>
        </div>
    </div>
</div>