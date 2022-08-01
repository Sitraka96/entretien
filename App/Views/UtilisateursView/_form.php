<form action="/Utilisateurs/check" method="POST" id="register" class="col-12 col-md-4" >
  <?php getToken() ?>
  <input type="hidden" id="form_type" name="form_type" value="insert">
  <input type="hidden" id="opk" name="opk">
  <div class="d-flex justify-content-center my-4">
    <div><i class="fal fa-4x fa-users-cog"></i></div>
  </div>
  <div class="form-group">
    <p class="h5 text-center">Gestion des utilisateurs</p>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-prepend">
        <div class="input-group-text">Nom<span class="ml-2 text-danger">*</span></div>
      </div>
      <input type="text" name="nom" class="form-control" id="nom"  required>
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-prepend">
        <div class="input-group-text">Prénom(s)<span class="ml-2 text-danger">*</span></div>
      </div>
      <input type="text" name="prenom" class="form-control" id="prenom" required>
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-prepend">
        <div class="input-group-text">Nom d'utilisateur<span class="ml-2 text-danger">*</span></div>
      </div>
      <input type="text" name="username" class="form-control" id="username"  required>
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-prepend">
        <div class="input-group-text">Email<span class="ml-2 text-danger">*</span></div>
      </div>
      <input type="email" name="email" class="form-control" id="email" required>
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-prepend">
        <div class="input-group-text">Mot de passe<span class="ml-2 text-danger">*</span></div>
      </div>
      <input type="password" name="password" class="form-control" id="password" required>
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-prepend">
        <div class="input-group-text">Confirmation<span class="ml-2 text-danger">*</span></div>
      </div>
      <input type="password" name="cpassword" class="form-control" id="cpassword" required>
    </div>
  </div>
  <div class="input-group form-group">
    <div class="input-group-prepend">
      <span class="input-group-text" >Type<em class="text-warning pl-1">*</em></span>
    </div>
    <select name="TU_id" id="type_user" class="form-control" required>
    <?php isset($types)?$this->showOPT($types,'idTU','type_tu'):$this->showUptOPT($users['TU_id'],$types,'idTU','type_tu') ?>
    </select>
  </div>

  <!-- PHOTO -->
  <div class="input-group form-group">
    <div class="custom-file">
      <input type="file" name="photo" class="custom-file-input" id="photo" lang="fr" accept=".jpg,.jpeg,.png">
      <label class="custom-file-label" for="photo" id="photoText">Parcourir</label>
    </div>
  </div>
 
  <div class="d-flex justify-content-center mt-2 mb-4">
    <button type="submit" class="btn btn-outline-primary px-4">valider</button>
  </div>
</form>


