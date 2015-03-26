<?= gettype($tables) ?>
<?php foreach($tables as $model => $table): ?>
    <div><p><?= $model ?></p></div>
<?php endforeach; ?>