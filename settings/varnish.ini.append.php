<?php /* #?ini charset="utf-8"?

[General]
# 7 days
LogsExpiryTime=604800
# List of used Varnish servers
VarnishServers[]
VarnishServers[]=node1
VarnishServers[]=node2

[VarnishServer_node1]
Host=varnish1
Port=6082
Timeout=10
SecretFile=/etc/varnish/secret1

[VarnishServer_node2]
Host=varnish2
Port=6082
Timeout=10
SecretFile=/etc/varnish/secret2

[VarnishServers]
Host=localhost
Port=6082
Timeout=10

[AdditionalClearCacheHandler]
Callback=nxcVarnishClearType::getNodeIDs

*/ ?>
