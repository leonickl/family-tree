<div class="row end mb">
    <a href="/" class="btn nowrap" type="submit">Home</a>
    <a href="/tree?start=<?= $person->id() ?>" class="btn nowrap" type="submit">Tree</a>
    <a href="/tree/people/<?= $person->id() ?>/set-as-start" class="btn nowrap" type="submit">Set as Start</a>
</div>

<h1><?= $person->name() ?></h1>

<p>
    <b>Gender:</b> <?= $person->gender() ?>
</p>

<p>
    <b>Birth:</b> <?= $person->birth_date ?? '---' ?>
        at <?= $person->birth_place ?? '---' ?>
</p>

<p>
    <b>Death:</b>

    <?php if ($person->death()): ?>
        <?= $person->death_date ?? '---' ?>
            at <?= $person->death_place ?? '---' ?>
    <?php else: ?>
        <em>alive</em>
    <?php endif ?>
</p>

<p>
    <b>Buriage:</b> <?= $person->buriage_date ?? '---' ?>
        at <?= $person->buriage_place ?? '---' ?>
</p>
