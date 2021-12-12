{cors()}
{$user = authenticate()}
{import.translation()}
{if($user.uuid)}
    {response.json()}
    {block.json()}
        {$json = filesystem.delete($user)}
        {object($json, 'json')}
    {/block.json}
{elseif($user.error)}
    {response.json()}
    {block.json()}
        {object($user, 'json')}
    {/block.json}
{/if}