{cors()}
{$user = authenticate()}
{import.translation()}
{if($user.uuid)}
    {response.json()}
    {block.json()}
        {if(security.is.granted([
            "user" => $user,
            "role" => [ 'ROLE_IS_ADMIN']
        ]))}
            {$json = filesystem.move()}
            {object($json, 'json')}
        {else}
            {http.response.code(401)}
            {literal}{{/literal}
                "error": "Insufficient privileges..."
            {literal}}{/literal}
        {/if}
    {/block.json}
{elseif($user.error)}
    {response.json()}
    {block.json()}
        {http.response.code(401)}
        {object($user, 'json')}
    {/block.json}
{/if}