{{R3M}}
<td scope="row" class="icon">
    {{if($node.type==='Dir')}}
    <label for="checkbox-{{$node.uuid}}"><i class="fas fa-folder"></i></label>
    {{else}}
    <label for="checkbox-{{$node.uuid}}"><i class="fas fa-file"></i></label>
    {{/if}}
</td>