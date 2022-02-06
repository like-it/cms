{{R3M}}
{{$ol.class = 'node-content'}}
<ol
    class="{{$ol.class}}"
    spellcheck="false"
    contenteditable="true"
    data-url="{{server.url('core')}}Source/To/Li"
    data-content="{{request('node.content')}}"
>
    <li>Loading...</li>
</ol>
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/Source.js')}}
{{/script}}