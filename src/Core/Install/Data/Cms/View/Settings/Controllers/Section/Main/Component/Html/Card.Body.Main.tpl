{{R3M}}
<div class="card-body h-100 card-body-{{$command}}">
    <h5 class="card-title">{{__($__.module + '.' + $__.submodule + '.section.' + $__.command + '.component.html.title')}}</h5>
    <p class="card-text">{{implode("<br>\n", __($__.module + '.' + $__.submodule + '.section.' + $__.command + '.component.html.text'))}}</p>
</div>