{cors()}
{$user = authenticate()}
{response.json()}
{if(security.is.granted([
    "user" => $user,
    "role" => [
        'ROLE_IS_ADMIN',
        'ROLE_IS_USER'
    ]
]))}
{filesystem.write($user)}
{else}
{exception.authorization()}
{/if}
