{R3M}
{{import.translation()}}
{{$meta.author = __('meta.author')}}
{{$meta.title = __('meta.title')}}
{{$meta.keywords = __('meta.keywords')}}
{{$meta.description = __('meta.description')}}
{{$request = request()}}
{{$test = 2 * ((2 * (3 * 2 + 2)) - 2) - 1}}

{{logger.warning('test', [$test])}}