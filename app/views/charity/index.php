<?php foreach($charities as $charity): ?>
    <h1><?=$charity->getName()?></h1>
    <p><?=$charity->getDescription()?></p>
    <hr/>
<?php endforeach;?>