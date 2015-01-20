#Hydra
##Control your content

To use hydra, you must apply the following .htaccess rules

+ allow all assets to be routed straight through to their requested path
+ any request that contains the string '.json' must be routed to jsonrequets.php
+ everything else should be routed to index.php

You must also ensure that url rewrite is enabled for apache

### The hydra.php download
The file that is downloaded from hydra.php supports PHP's APC caching module, if APC is not installed caching will be done to a text file.
For high traffic sites it is recommended to enable the APC module for the PHP process.
