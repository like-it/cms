{{R3M}}
{{$pre.id = 'node-' + $request.node.key}}
{{$pre.name = 'node.content'}}
<pre
    id="{{$pre.id}}"
    name="{{$pre.name}}"
    data-content="{{$request.node.content}}"
>
</pre>
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/Source.js')}}
{{/script}}