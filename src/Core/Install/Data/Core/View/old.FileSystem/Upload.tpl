{cors()}
{$user = authenticate()}
{if(security.is.granted([
    "user" => $user,
    "role" => [
        'ROLE_IS_ADMIN',
        'ROLE_IS_USER'
    ]
]))}
{filesystem.upload($user)}
{else}
{http.response.code(403)}
Error in authentication...
{/if}
