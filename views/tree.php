<h1><em><?= $start ?></em> is member in these families</h1>

<div class="column">
    <?php foreach($start->families() as $family): ?>
        <div><?= $family ?></div>
    <?php endforeach ?>
</div>
