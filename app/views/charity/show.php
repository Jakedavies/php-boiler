<!-- Temp view to test show method in charity controller-->
<h1> <?=$charity->getName()?></h1>
<p><?=$charity->getDescription()?></p>
<p><img src="<?=$charity->getPreview()?>"></p>

<button type="button" class="btn btn-default" onclick="window.location.href='/charity/<?=$charity->getID()?>/donate'">Donate</button>
<hr/>
