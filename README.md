#donation platform

## Instructions

To use this code do the following

+ install dependencies using composer 
+ allow all ./assets to be routed straight through to their requested path
+ everything else should be routed to index.php

You must also ensure that url rewrite is enabled fir apache for url rerouting to work. 

## Info

This is a typical MVC architecture. Propel ORM is used for models, Klein Router is used for routing. 

All MVC components are in the ./protected folder. 
