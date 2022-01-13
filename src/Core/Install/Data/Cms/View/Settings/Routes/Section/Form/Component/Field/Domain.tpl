{{R3M}}
{{$field = 'domain'}}
{{$label = $field|uppercase.first}}
{{$label =  $label + '*'}}
{{$validates = [
'validate_in_list_json',
]}}
{{$select.id = $module + '-' + $submodule + '-' + $field}}
{{$select.class = 'form-control'}}
{{for.each($validates as $validate)}}
    {{if(request.error($field + '.' + $validate) === true)}}
        {{$select.class = 'form-control alert-danger'}}
        {{if(is.empty($request.focus))}}
            {{$request.focus = 'node.' + $field}}
        {{/if}}
    {{/if}}
{{/for.each}}
{{$select.name = 'node.' + $field}}
{{$select.selected = request('node.' + $field)}}
{{$select.url = config('project.dir.data') + 'Host.json'}}
{{$select.options = json.select($select.url, null)}}
<label for="{{$select.id}}">{{$label}}</label>
<select
    id="{{$select.id}}"
    class="{{$select.class}}"
    name="{{$select.name}}"
>
    {{if(
        is.array($select.options) ||
        is.object($select.options)
    )}}
        {{for.each($select.options as $value => $option)}}
            {{if($select.selected === $value)}}
                <option value="{{$value}}" selected="selected">{{$option.name}}</option>
            {{else}}
                <option value="{{$value}}">{{$option.name}}</option>
            {{/if}}
        {{/for.each}}
    {{/if}}
</select>
<br>