{R3M}
{if(
    request('user.keyId') &&
    request('node.url') &&
    in.array(
        file.extension(request('node.url')),
        [
            'mp3',
            'ogg',
            'wav',
            'mp4',
            'webm'
        ]
    )
    user.keyId()
)}
{response.file()}
{$extension = file.extension(request('node.url'))}
{$contentType = config('contentType.' + $extension)}
{if(!is.empty($contentType))}
{header('Content-Type: ' + $contenType)}
{else}
{header('Content-Type: octet-stream')}
{/if}
{$url = html.specialchars.decode(request('node.url'), ENT_HTML5)}
{header('Content-Length: ' + file.size($url))}
{header('Cache-Control: no-cache')}
{header('Content-Disposition: inline;filename="' + file.basename($url) + '"')}
{header("Content-Transfer-Encoding: binary")}
{filesystem.read()}
{else}
{$user = authenticate()}
{response.file()}
{$extension = file.extension(request('node.url'))}
{$contentType = config('contentType.' + $extension)}
{if(!is.empty($contentType))}
{header('Content-Type: ' + $contenType)}
{else}
{header('Content-Type: octet-stream')}
{/if}
{if(security.is.granted([
"user" => $user,
"role" => [
'ROLE_IS_ADMIN',
'ROLE_IS_USER'
]
]))}
{$url = html.specialchars.decode(request('node.url'), ENT_HTML5)}
{header('Content-length: ' + file.size($url))}
{header('Cache-Control: no-cache')}
{header('Content-Disposition: inline;filename="' + file.basename($url) + '"')}
{header("Content-Transfer-Encoding: binary")}
{filesystem.read($user)}
{/if}
{/if}
