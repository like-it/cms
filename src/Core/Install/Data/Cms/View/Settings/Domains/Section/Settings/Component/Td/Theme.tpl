{{R3M}}
<td>
    {{if(is.empty($themes))}}
        {{$json.url = config('project.dir.data') + 'Theme.json'}}
        {{$themes = json.select($json.url, 'theme')}}
    {{/if}}
    {{for.each($themes as $uuid => $theme)}}
        {{if($uuid === $node.theme)}}
            {{$theme.name}}
        {{/if}}
    {{/for}}
</td>