<?php $this->layout('layout', ['title' => 'Показ статьи']) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="/">На главную</a>
            <h1><?= $task['article_name'];?></h1>
<p>
    <?= $task['article_text'];?>
</p>

<p>
    Добавлена: <?= $task['created_at'];?>
</p>
</div>
</div>
</div>