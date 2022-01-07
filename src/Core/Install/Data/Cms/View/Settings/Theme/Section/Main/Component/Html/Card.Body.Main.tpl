{{R3M}}
<div class="card-body h-100 card-body-main">
    <h5 class="card-title">{{__(
        $__.module +
        '.' +
        $__.submodule  +
        '.section.' +
        $__.command +
        '.' +
        $__.subcommand|replace:'content':'body' +
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
        $__.subcommand|replace:'content':'body' +
        '.text'
    ))}}
    </p>
</div>