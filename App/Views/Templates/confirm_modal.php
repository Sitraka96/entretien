<div class="modal fade" id="cmodal" tabindex="-1" role="dialog" aria-labelledby="cmodalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Voulez-vous vraiment éxécuter cette action ?</h6>
        <div id="c_txt"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" id="btn_confirm" class="btn btn-primary">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<?php 
if(App\Core\Conf::debug==1){ ?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cmodal" style="position:absolute;bottom:10px;right:10px;">
  Launch
</button>
<?php } ?>
