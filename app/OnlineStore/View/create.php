<?php $this->layout('layout', ['title' => 'Создаем Новый Таск']) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="/">На главную</a>
            <h1>Create Task</h1>
            <?php if(isset($errors)): ?>
                <div style="color: red;"><?= $errors ?></div>
            <?php endif; ?>
            <form action="/add" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="title" value="<?=$data['title'] ?? '' ;?>">
                </div>

                <div class="form-group">
                    <textarea name="content" class="form-control"><?=$data['content'] ?? '' ;?></textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
