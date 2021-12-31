{R3M}
{{if(!is.empty($a.url))}}
<a
    class="{{$a.class}}"
    data-url="{{$a.url}}"
    data-frontend-url="{{$a.frontend.url}}"
>
    <i class="{{$a.icon.class}}"></i> {{$a.link}}
</a>
{{else}}
<a
    class="{{$a.class}}"
    data-frontend-url="{{$a.frontend.url}}"
>
    <i class="{{$a.icon.class}}"></i> {{$a.link}}
</a>
{{/if}}
