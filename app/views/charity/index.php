<div class="row">
    <div class="col-xs-10 col-sm-8 col-md-6 col-lg-6 col-xs-offset-1 col-sm-offset-2 col-md-offset-3 col-lg-offset-3">
        <form action="/charity" method="GET" class="input-group">
            <input  class="form-control" id="search" name="searchquery" type="text"  placeholder="Search">
            <span class="input-group-btn">
                <button name="charitysearch" class="btn btn-default" type="submit">Search</button>
            </span>
        </form>
    </div>
</div>

<div class="row">
    <?php foreach($charities as $charity): ?>
        <div class="col-md-4">
            <a href="/charity/<?=$charity->getId()?>" class="text_deco">
                <div class="browse-charity-element">
                    <div class="element-mask">
                        <img src="<?=$charity->getPreview()?>" class="browse-charity-image"/>
                        <div class="browse-charity-text">
                            <span><?=$charity->getName()?></span>
                            <hr/>
                            <?=$charity->getDescription()?>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>