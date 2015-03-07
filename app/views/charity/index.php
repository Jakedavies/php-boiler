<?php foreach($charities as $charity): ?>
    <h1><a href ="charityid=<?php echo $charity->getid();?>"> <?=$charity->getName()?></a></h1>
    <p><?=$charity->getDescription()?></p>
    <hr/>
<?php endforeach;?>