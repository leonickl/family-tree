<h1>Welcome to Family Tree</h1>

<?php foreach($trees as $tree): ?>
    <p><a href="/trees/<?= $tree ?>"><?= $tree ?></a></p>
<?php endforeach ?>
