<h1><em><?= $start ?></em> is member in these families</h1>

<?php $families = [...$start->childFamilies(), ...$start->spousalFamilies()] ?>

<div class="column-4 items-center">
    <?php foreach($families as $family): ?>
        <div class="column items-center">
            <div class="row">
                <?= view('person', ['person' => $family->husband(), 'start' => $start])->render() ?>
                <?= view('person', ['person' => $family->wife(), 'start' => $start])->render() ?>
            </div>

            <div class ="row">
                <?php foreach($family->children() as $child): ?>
                    <?= view('person', ['person' => $child, 'start' => $start])->render() ?>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
</div>