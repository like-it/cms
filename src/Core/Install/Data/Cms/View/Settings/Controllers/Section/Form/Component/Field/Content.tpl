{{R3M}}
{{$pre.id = 'node-' + uuid()}}
{{$pre.name = 'node.content'}}
<pre
    id="{{$pre.id}}"
    name="{{$pre.name}}"
>
{{$request.node.content|html.entity.encode}}
</pre>
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/Source.js')}}
{{/script}}