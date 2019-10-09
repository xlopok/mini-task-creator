<?php $this->layout('layout', ['title' => 'Редактируем таск']) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="/">На главную</a>
            <?php if(isset($errors)): ?>
                <div style="color: red;"><?= $errors ?></div>
            <?php endif; ?>
            <h1>Edit Task</h1>
            <form action="/edit/<?= $task['id'];?>" method="post">

                <div class="form-group">
                    <input type="text" name="title" class="form-control" value="<?= $task['article_name'];?>">
                </div>

                <div class="form-group">
                    <textarea name="content" class="form-control"><?= $task['article_text'];?></textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-warning" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>