{R3m}
{{if(!.is.empty($url))}}
<a
    class="nav-link"
    data-url="{{$url}}"
    data-frontend-url="{{$frontend.url}}"
>
    <i class="{{$class}}"></i> {{$link}}
</a>
{{else}}
<a
    class="nav-link"
    data-frontend-url="{{$frontend.url}}"
>
    <i class="{{$class}}"></i> {{$link}}
</a>
{{/if}}
