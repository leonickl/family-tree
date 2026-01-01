<h1><em><?= $start ?></em> is member in these families</h1>

<?php

$spousalFamilies = $start->spousalFamilies();
$childFamilies = $start->childFamilies();

$height = 3;
$width = array_sum($spousalFamilies->map(fn($family) => max(1, count($family->children())))->toArray());

$x = 1;

?>

<div class="family">
    <?php foreach($spousalFamilies as $i => $family): ?>
        <?= view('person', [
            'person' => $start->id() === $family->husband()?->id() ? $family->wife() : $family->husband(),
            'start' => $start,
            'area' => [2, $x + floor(count($family->children()) / 2), 3, $parentEnd = $x + floor(count($family->children()) / 2) + 1],
        ]) ?>

        <?php foreach($family->children() as $j => $child): ?>
            <?= view('person', ['person' => $child, 'start' => $start, 'area' => [3, $x++, 4, $x]]) ?>

            <?php if($j < count($family->children()) - 1): ?>
                <div class="horizontal-connector" style="grid-area: <?= implode(' / ', [3, $x, 4, $x + 1]) ?>"></div>
            <?php endif ?>
        <?php endforeach ?>

        <div class="horizontal-connector" style="grid-area: <?= implode(' / ', [2, $parentEnd ?: $x, 3,
            $x + ($spousalFamilies->keys()->includes($i + 1) ? $spousalFamilies[$i + 1]?->children()->count() ?? 1 : 1)]) ?>"></div>
    <?php endforeach ?>

    <?= view('person', ['person' => $start, 'start' => $start, 'area' => [2,  $x++, 3,$x]]) ?>

    <?php foreach($childFamilies as $family): ?>
        <?php if(count($family->children()) > 1): ?>
            <div class="horizontal-connector" style="grid-area: <?= implode(' / ', [2, $x, 3, $x + 1]) ?>"></div>
        <?php endif ?>

        <?= view('person', [
            'person' => $family->husband(),
            'start' => $start,
            'area' => [1, $x + floor(count($family->children()) / 2) - 1, 2, $x + floor(count($family->children()) / 2)],
        ]) ?>

        <div class="horizontal-connector"
            style="grid-area: <?= implode(' / ', [1, $x + floor(count($family->children()) / 2), 2,
                $x + floor(count($family->children()) / 2) + 1]) ?>">
        </div>

        <?= view('person', [
            'person' => $family->wife(),
            'start' => $start,
            'area' => [1, $x + floor(count($family->children()) / 2), 2, $x + floor(count($family->children()) / 2) + 1],
        ]) ?>

        <?php foreach($family->children()->filter(fn($child) => $child->id() !== $start->id()) as $child): ?>
            <div class="horizontal-connector" style="grid-area: <?= implode(' / ', [2, $x, 3, $x + 1]) ?>"></div>

            <?= view('person', ['person' => $child, 'start' => $start, 'area' => [2, $x++, 3, $x]]) ?>
        <?php endforeach ?>
    <?php endforeach ?>
</div>

<?= $plot ?>

<style>
    .horizontal-connector {
        height: 1px;
        background: var(--text-light);
        position: relative;
        left: -5rem;
        top: 50%;
    }

    .family {
        display: grid;
        grid-template-columns: repeat(<?= $width ?>, min(10rem));
        grid-template-rows: repeat(<?= $height ?>, max-content);
        gap: 1rem;
        width: max-content;
    }

    main {
        width: max-content !important;
        max-width: 100vw !important;
    }
</style>
