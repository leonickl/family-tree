<div class="row end mb">
    <a href="/" class="btn" type="submit">Home</a>
    <a href="/trees/<?= $tree ?>" class="btn" type="submit">Start of Tree</a>
    <a href="/trees/<?= $tree ?>?start=random " class="btn" type="submit">Random</a>
    <a href="/logout?__method=post" class="btn" type="submit" style="background-color: red">Logout</a>
</div>

<h1>Family tree of <em><?= $start ?></em></h1>

<div class="column items-center">
    <?= $plot ?>
</div>

<style>
    .horizontal-connector {
        height: 1px;
        background: var(--text-light);
        position: relative;
        left: -5rem;
        top: 50%;
    }

    .vertical-connector {
        width: 1px;
        background: var(--text-light);
        position: relative;
        left: 5rem;
        top: 50%;
    }

    .family {
        display: grid;
        grid-template-columns: repeat(<?= $width ?>, min(10rem));
        grid-template-rows: repeat(<?= $height ?>, max-content);
        gap: 1rem;
        width: max-content;
        max-width: 100%;
        overflow-x: auto;
    }
</style>
