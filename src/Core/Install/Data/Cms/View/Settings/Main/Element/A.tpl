{R3M}
{{if(!is.empty($url))}}
<a
    class="nav-link {{$is.active}}"
    data-url="{{$url}}"
    data-frontend-url="{{$frontend.url}}"
>
    <i class="{{$class}}"></i> {{$link}}
</a>
{{else}}
<a
    class="nav-link {{$is.active}}"
    data-frontend-url="{{$frontend.url}}"
>
    <i class="{{$class}}"></i> {{$link}}
</a>
{{/if}}
