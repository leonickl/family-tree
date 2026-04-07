<div class="row end mb">
    <a href="/" class="btn nowrap">Home</a>
    <a href="/tree?start={{ $person->id }}" class="btn nowrap">Tree</a>
    <a href="/people/{{ $person->id }}/edit" class="btn nowrap">Edit</a>
</div>

<h1>{{ $person->name() }}</h1>

<p>
    <b>Gender:</b> {{ $person->gender() }}
</p>

<p>
    <b>Birth:</b> {{ $person->birth_date ?? '---' }}
        at {{ $person->birth_place ?? '---' }}
</p>

<p>
    <b>Death:</b>

    {{ if: $person->death() }}
        {{ $person->death_date ?? '---' }}
            at {{ $person->death_place ?? '---' }}
    {{ else }}
        <em>alive</em>
    {{ if; }}
</p>

<p>
    <b>Buriage:</b> {{ $person->buriage_date ?? '---' }}
        at {{ $person->buriage_place ?? '---' }}
</p>

<p class="mt-2">
    <b>Families:</b>

    <div class="column w-max-60">
        {{ each: $person->childFamilies() as $family }}
            <div class="ml-2 row items-center between">
                <em>{{ ==$family->name() }}</em>

                <div class="row end">
                    {{ if: $family->husband() === null || $family->wife() === null }}    
                        <a href="/families/{{ $family->id }}/add-parent" class="btn small secondary nowrap">+ Parent</a>
                    {{ if; }}
                    <a href="/families/{{ $family->id }}/add-child" class="btn small secondary nowrap">+ Sibling</a>
                </div>
            </div>
        {{ each; }}

        {{ each: $person->spousalFamilies() as $family }}
            <div class="ml-2 row items-center between">
                <em>{{ ==$family->name() }}</em>

                <div class="row end">
                    {{ if: $family->husband() === null || $family->wife() === null }}
                        <a href="/families/{{ $family->id }}/add-parent" class="btn small secondary nowrap">+ Partner</a>
                    {{ if; }}
                    <a href="/families/{{ $family->id }}/add-child" class="btn small secondary nowrap">+ Child</a>
                </div>
            </div>
        {{ each; }}

        <a href="/families/create-child?person_id={{ $person->id }}" class="btn small secondary nowrap">+ Family as a Child</a>
        <a href="/families/create-spousal?person_id={{ $person->id }}" class="btn small secondary nowrap">+ Family with a Partner</a>
    </div>
</p>

