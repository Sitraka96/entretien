<div id="feedback" class="fixed-top m-2"></div>
<?php \showFlash(); ?>
<div class="container-fluid">
  <div class="d-flex justify-content-center pt-2 pb-4">
    <button id="btn-insert" class="btn btn-outline-primary px-4">Cliquez pour ajouter un utilisateur</button>
  </div>
  <div class="row p-3 bg-white rounded shadow-sm mb-4  mx-2">

    <?php
    include '_modal_confirm.php';
    include '_form.php';
    include '_list.php';
    ?>

  </div>
</div>