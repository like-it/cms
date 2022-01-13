{{R3M}}
{{$field = 'method'}}
{{$label = $field|uppercase.first}}
{{$label =  $label + '*'}}
{{$validates = [
'validate_in_list_json',
]}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.class = 'form-control'}}
{{for.each($validates as $validate)}}
    {{if(request.error($field + '.' + $validate) === true)}}
        {{$input.class = 'form-control alert-danger'}}
        {{if(is.empty($request.focus))}}
            {{$request.focus = 'node.' + $field}}
        {{/if}}
    {{/if}}
{{/for.each}}
{{$input.name = 'node.' + $field + '[]'}}
{{$input.url = config('framework.dir.data') + 'Method.json'}}
{{$input.options = json.select($input.url, 'method')}}
<label for="{{$input.id}}">{{$label}}</label><br>
{{if(is.array($input.options) || is.object($input.options))}}
    {{for.each($input.options as $nr => $method)}}
        {{if($nr > 0)}}
            {{$id = $input.id + '-' + $nr}}
        {{else}}
            {{$id = $input.id}}
        {{/if}}
        <input
            type="checkbox"
            id="{{$id}}"
            name="{{$input.name}}"
            value={{$method.name}}
        />
        <label for="{{$id}}" class="checkbox-text">
            {{$method.name}}
        </label>
        <br>
    {{/for.each}}
{{/if}}
<br>