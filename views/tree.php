<div class="row end mb desktop-only">
    <a href="/" class="btn nowrap">Home</a>
    <a href="/tree" class="btn nowrap">Start of Tree</a>
    <a href="/tree?start=random " class="btn nowrap">Random</a>
    <a href="/logout?__method=post" class="btn nowrap" style="background-color: red">Logout</a>
</div>

<div class="row mb around mobile-only">
    <a href="/" class="btn nowrap" style="height: 2.2rem">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
            <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
        </svg>
    </a>
    <a href="/tree" class="btn nowrap" style="height: 2.2rem">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z"/>
            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466"/>
        </svg>
    </a>
    <a href="/tree?start=random " class="btn nowrap" style="height: 2.2rem">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shuffle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M0 3.5A.5.5 0 0 1 .5 3H1c2.202 0 3.827 1.24 4.874 2.418.49.552.865 1.102 1.126 1.532.26-.43.636-.98 1.126-1.532C9.173 4.24 10.798 3 13 3v1c-1.798 0-3.173 1.01-4.126 2.082A9.6 9.6 0 0 0 7.556 8a9.6 9.6 0 0 0 1.317 1.918C9.828 10.99 11.204 12 13 12v1c-2.202 0-3.827-1.24-4.874-2.418A10.6 10.6 0 0 1 7 9.05c-.26.43-.636.98-1.126 1.532C4.827 11.76 3.202 13 1 13H.5a.5.5 0 0 1 0-1H1c1.798 0 3.173-1.01 4.126-2.082A9.6 9.6 0 0 0 6.444 8a9.6 9.6 0 0 0-1.317-1.918C4.172 5.01 2.796 4 1 4H.5a.5.5 0 0 1-.5-.5"/>
            <path d="M13 5.466V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m0 9v-3.932a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192"/>
        </svg>
    </a>
    <a href="/logout?__method=post" class="btn nowrap" style="height: 2.2rem; background-color: red">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-right-square" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.854 3.146a.5.5 0 1 0-.708.708L9.243 9.95H6.475a.5.5 0 1 0 0 1h3.975a.5.5 0 0 0 .5-.5V6.475a.5.5 0 1 0-1 0v2.768z"/>
        </svg>
    </a>
</div>

<h1 class="desktop-only">Family tree of <em><?= $start ?></em></h1>
<h1 class="mobile-only"><em><?= $start ?></em></h1>

<div class="column items-center pb-2">
    <?= $plot ?>
</div>

<p class="mt-2">
    To the left of the current person, their partners are shown with the respective children.
    On the right, there are the families where the person stems from (can be multiple). Each of those can have parents and children.
</p>

<style>
    .family {
        display: grid;
        grid-template-columns: repeat(<?= $plot->width ?>, min(var(--column-size)));
        grid-template-rows: repeat(3, max-content);
        gap: var(--gap-size);
        width: max-content;
        max-width: 100%;
        overflow-x: auto;
    }

    .person {
        width: var(--column-size);
    }

    .person-highlight,
    .person-highlight svg {
        color: #f9fafb;
    }

    .horizontal-connector {
        height: 1px;
        background: var(--text-light);
        position: relative;
        left: calc(-1*calc(var(--column-size)/2));
    }

    .horizontal-connector.sibling {
        top: 10%;
    }

    .horizontal-connector.partner {
        top: 90%;
    }

    .vertical-connector {
        width: 1px;
        background: var(--text-light);
        position: relative;
        left: calc(var(--column-size)/2);
        top: 50%;
    }
</style>
