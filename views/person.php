<?php if($person?->id() === $start?->id()): ?>
    <div class="px-1 py-05 rounded bg-primary text-center-both" style="grid-area: <?= implode(' / ', $area) ?>; z-index: 10; width: 10rem"><?= $person ?></div>
<?php else: ?>
    <div class="border px-1 py-05 rounded text-center-both"
        style="grid-area: <?= implode(' / ', $area) ?>; background: var(--main-background); z-index: 10; width: 10rem"><?= lnk()->tree($person) ?></div>
<?php endif ?>