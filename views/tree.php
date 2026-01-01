<h1><em><?= $start ?></em> is member in these families</h1>

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
        width: 100%;
        overflow-x: auto;
    }
</style>
