<div class="row end mb">
    <a href="/" class="btn nowrap">Home</a>
    <a href="/tree?start=<?= $person->id() ?>" class="btn nowrap">Tree</a>
    <a href="/tree/people/<?= $person->id() ?>/set-as-start" class="btn nowrap">Set as Start</a>
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

<p class="mt-2">
    <b>Families:</b>

    <div class="column w-max-60">
        <?php foreach ($person->childFamilies() as $family): ?>
            <div class="ml-2 row items-center between">
                <em><?= $family->name() ?></em>

                <div class="row end">
                    <?php if ($family->husband() === null || $family->wife() === null): ?>    
                        <a href="/tree/family/<?= $family->id() ?>/add-parent" class="btn small secondary nowrap">+ Parent</a>
                    <?php endif ?>
                    <a href="/tree/family/<?= $family->id() ?>/add-child" class="btn small secondary nowrap">+ Sibling</a>
                </div>
            </div>
        <?php endforeach ?>

        <?php foreach ($person->spousalFamilies() as $family): ?>
            <div class="ml-2 row items-center between">
                <em><?= $family->name() ?></em>

                <div class="row end">
                    <?php if ($family->husband() === null || $family->wife() === null): ?>   
                        <a href="/tree/family/<?= $family->id() ?>/add-parent" class="btn small secondary nowrap">+ Partner</a>
                    <?php endif ?>
                    <a href="/tree/family/<?= $family->id() ?>/add-child" class="btn small secondary nowrap">+ Child</a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</p>

