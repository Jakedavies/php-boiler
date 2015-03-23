
<div class="jumbotron">
    <h1>Donate</h1>
    <p><?=$charity->getName()?></p>
</div>
<form action="/charity/id/donate" method="post">
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <a class="thumbnail">
          <img src="<?=$charity->getPreview()?>">
        </a>
      </div>
      <div class="col-md-offset-1 col-xs-6 col-md-4">
        <p>Donation Amount</p>
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                <span class="input-group-addon">.00</span>
             </div>
      </div>
    </div>

    <button type="button" class="btn btn-default donate" >Donate</button>
</form>