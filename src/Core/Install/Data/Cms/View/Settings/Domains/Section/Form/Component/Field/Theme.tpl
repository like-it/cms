{{R3M}}
{{$field = 'theme'}}
{{$label = $field|uppercase.first}}
{{$label =  $label + '*'}}
{{$validate = 'validate_in_array'}}
{{$select.id = $module + '-' + $submodule + '-' + $field}}
{{if(request.error($field + '.' + $validate) === false)}}
{{$select.class = 'form-control'}}
{{else}}
{{$select.class = 'form-control alert-danger'}}
{{if(is.empty($request.focus))}}
{{$request.focus = 'node.' + $field}}
{{/if}}
{{/if}}
{{$select.name = 'node.' + $field}}
{{$select.selected = request('node.' + $field)}}
{{$select.url = config('project.dir.data') + 'Theme.json'}}
{{$select.options = json.select($select.url, 'theme')}}
<label for="{{$module}}-{{$submodule}}-{{$field}}">{{$label}}</label>
<select
    id="{{$select.id}}"
    class="{{$select.class}}"
    name="{{$select.name}}"
>
    {{for.each($select.options as $value => $option)}}
        {{if($select.selected === $value)}}
            <option value="{{$value}}" selected="selected">{{$option.name}}</option>
        {{else}}
            <option value="{{$value}}">{{$option.name}}</option>
        {{/if}}
    {{/for.each}}
</select>
<br>