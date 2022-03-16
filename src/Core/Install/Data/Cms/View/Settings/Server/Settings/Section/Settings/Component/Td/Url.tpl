{{R3M}}
<td title="{{$node.url}}">
    {{$node.dir.root = config('project.dir.public')}}
    {{$node.url|replace:$node.dir.root:''}}
</td>