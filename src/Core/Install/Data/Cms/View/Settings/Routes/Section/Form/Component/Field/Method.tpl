{{R3M}}
{{$field = 'method[]'}}
{{$label = 'Method*'}}
{{$validates = [
'validate_in_list_json',
]}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.class = 'form-check-input'}}
{{for.each($validates as $validate)}}
    {{if(request.error($field + '.' + $validate) === true)}}
        {{$input.class = 'form-check-input alert-danger'}}
        {{if(is.empty($request.focus))}}
            {{$request.focus = 'node.' + $field}}
        {{/if}}
    {{/if}}
{{/for.each}}
{{$input.name = 'node.' + $field}}
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
        {{if(
        is.array($request.node.method) &&
        in.array(
            $method.name,
            $request.node.method
        ))}}
           {{$input.checked = 'checked="checked"'}}
       {{else}}
            {{$input.checked = ''}}
        {{/if}}
        <input
            type="checkbox"
            class="{{$input.class}}"
            id="{{$id}}"
            name="{{$input.name}}"
            value={{$method.name}}
            {{$input.checked}}
        />
        <label for="{{$id}}" class="checkbox-text">
            {{$method.name}}
        </label>
        <br>
    {{/for.each}}
{{/if}}
<br>