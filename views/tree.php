<h1><em><?= $start ?></em> is member in these families</h1>

<div class="column-4 items-center">
    <?php foreach($start->families() as $family): ?>
        <div class="column items-center">
            <div class="row">
                <div class="border px-1 py-05"><?= lnk()->tree($family->husband()) ?></div>
                <div class="border px-1 py-05"><?= lnk()->tree($family->wife()) ?></div>
            </div>

            <div class ="row">
                <?php foreach($family->children() as $child): ?>
                    <div class="border px-1 py-05"><?= lnk()->tree($child) ?></div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
</div>
