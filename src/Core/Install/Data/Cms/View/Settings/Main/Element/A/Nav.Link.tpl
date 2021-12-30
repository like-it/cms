{R3M}
{{if(!is.empty($a.url))}}
<a
    class="nav-link {{$a.is.active}}"
    data-url="{{$a.url}}"
    data-frontend-url="{{$a.frontend.url}}"
>
    <i class="{{$a.class}}"></i> {{$a.link}}
</a>
{{else}}
<a
    class="nav-link {{$a.is.active}}"
    data-frontend-url="{{$a.frontend.url}}"
>
    <i class="{{$a.class}}"></i> {{$a.link}}
</a>
{{/if}}
