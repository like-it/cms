{{R3M}}
{{$__.node = $__.subcommand|replace:'content':'body'}}
<div class="card-body h-100 card-body-main">
    <h5 class="card-title">{{__(
        $__.module +
        '.' +
        $__.submodule  +
        '.section.' +
        $__.command +
        '.' +
        $__.node +
        '.title'
    )}}</h5>
    <p class="card-text">{{implode(
        "<br>\n",
        __(__(
        $__.module +
        '.' +
        $__.submodule  +
        '.section.' +
        $__.command +
        '.' +
        $__.node + 
        '.text'
    ))}}
    </p>
</div>