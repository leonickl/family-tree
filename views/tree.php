<h1><em><?= $start ?></em> is member in these families</h1>

<?php $families = [...$start->childFamilies(), ...$start->spousalFamilies()] ?>

<div class="column-4 items-center">
    <?php foreach($families as $family): ?>
        <div class="column items-center">
            <div class="row">
                <div class="border px-1 py-05 rounded"><?= lnk()->tree($family->husband()) ?></div>
                <div class="border px-1 py-05 rounded"><?= lnk()->tree($family->wife()) ?></div>
            </div>

            <div class ="row">
                <?php foreach($family->children() as $child): ?>
                    <div class="border px-1 py-05 rounded"><?= lnk()->tree($child) ?></div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
</div>