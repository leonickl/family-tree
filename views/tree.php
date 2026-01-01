<h1><em><?= $start ?></em> is member in these families</h1>

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
