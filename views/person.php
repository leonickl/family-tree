<?php if($person?->id() === $start?->id()): ?>
    <div class="px-1 py-05 rounded nowrap bg-primary"><?= $person ?></div>
<?php else: ?>
    <div class="border px-1 py-05 rounded nowrap"><?= lnk()->tree($person) ?></div>
<?php endif ?>