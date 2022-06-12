{{R3M}}
<td class="icon">
    {{if($node.type==='Dir')}}
        {{if($node.link)}}
        <label for="checkbox-{{$node.uuid}}" title="Directory symbolic link"><i class="fas fa-folder is-link"></i></label>
        {{else}}
        <label for="checkbox-{{$node.uuid}}" title="Directory"><i class="fas fa-folder"></i></label>
        {{/if}}
    {{else}}
        {{if($node.link)}}
        <label for="checkbox-{{$node.uuid}}" title="File symbolic link"><i class="fas fa-file is-link"></i></label>
        {{else}}
        <label for="checkbox-{{$node.uuid}}" title="File"><i class="fas fa-file"></i></label>
        {{/if}}
    {{/if}}
</td>