{{R3M}}
{{$host.subdomain = host.subdomain()}}
{{$host.domain = host.domain()}}
{{$host.extension = host.extension()}}
{{$trait.subdomain = $host.subdomain|uppercase.first}}
{{$trait.domain = $host.domain|uppercase.first}}
{{$trait.extension = $host.extension|uppercase.first}}
{{$trait.namespace =  $trait.subdomain + '.' + $trait.domain + '.' + $trait.extension}}

{{trait({
"namespace": "{{$trait.namespace}}",
"name": "Node"
})}}
public function host_dir($uuid){
    $object = $this->object();
    $host = $object->data_read($object->config('project.dir.data') . 'Host' . $object->config('extension.json'));
    if($host){
        $node = $host->get($uuid);
        if(
            property_exists($node, 'subdomain') &&
            property_exists($node, 'host') &&
            property_exists($node, 'extension')
        ){
            return
                $object->config('project.dir.host') .
                ucfirst($node->subdomain) .
                '/' .
                ucfirst($node->host) .
                '/' .
                ucfirst($node->extension) .
                '/'
                ;
        }
        else if(
            property_exists($node, 'host') &&
            property_exists($node, 'extension')
        ){
            return
                $object->config('project.dir.host') .
                ucfirst($node->host) .
                '/' .
                ucfirst($node->extension) .
                '/'
                ;
        }
    }
}
{{/trait}}


<td title="{{$node.url}}">
    {{$node.dir.view = $trait.namespace:Node:host.dir($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:''}}
</td>