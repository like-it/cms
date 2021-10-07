{import.translation()}
{$meta.author = __('meta.author')}
{$meta.title = __('meta.title')}
{$meta.keywords = __('meta.keywords')}
{$meta.description = __('meta.description')}
{$request = request()}
{dd($request)}
{if(!is.empty($request.section.id))}
{$id = $request.section.id}
{else}
{$id = 'uuid-' + uuid()}
{/if}
{$section.name = $controller.name}