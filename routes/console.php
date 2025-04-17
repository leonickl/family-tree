<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('tree:play {file}', function (string $file) {
    tree($file)
        ->people()
        ->map(fn ($item) => (string) $item)
        ->dump();
});

Artisan::command('tree:people {file}', function (string $file) {
    tree($file)
        ->people()
        ->map(fn ($person) => (string) $person)
        ->dump();
});

Artisan::command('tree:families {file}', function (string $file) {
    tree($file)
        ->families()
        ->map(fn ($family) => $family->toArray())
        ->dump();
});
