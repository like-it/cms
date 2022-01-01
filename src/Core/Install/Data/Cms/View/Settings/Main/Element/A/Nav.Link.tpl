{R3M}
{{if(!is.empty($a.data.url))}}
<a
    class="{{$a.class}}"
    data-url="{{$a.data.url}}"
    data-frontend-url="{{$a.data.frontend.url}}"
>
    <i class="{{$a.icon.class}}"></i> {{$a.link}}
</a>
{{else}}
<a
    class="{{$a.class}}"
    data-frontend-url="{{$a.data.frontend.url}}"
>
    <i class="{{$a.icon.class}}"></i> {{$a.link}}
</a>
{{/if}}
