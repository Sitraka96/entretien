<form action="" method="POST" id="register" class="col-12 col-md-4" >
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
    <label for="nom">Nom(s)</label>
    <input type="text" name="nom" class="form-control" id="nom"  placeholder="nom" required>
  </div>
  <div class="form-group">
    <label for="prenom">Prénom(s)</label>
    <input type="text" name="prenom" class="form-control" id="prenom"  placeholder="prénom" required>
  </div>
  <div class="form-group">
    <label for="username">Nom d'utilisateur ou Pseudo</label>
    <input type="text" name="username" class="form-control" id="username"  placeholder="nom d'utilisateur ou pseudo" required>
  </div>
  <div class="form-group">
    <label for="email">Adresse email</label>
    <input type="email" name="email" class="form-control" id="email"  placeholder="Adresse email">
  </div>
  <div class="form-group">
    <label for="pwd">Mot de passe</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Tapez le mot de passe" required>
  </div>
  <div class="form-group">
    <label for="cpwd">Confirmation</label>
    <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Retapez le mot de passe" required>
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
  <!-- <div class="input-group form-group">
    <div class="custom-file">
      <input type="file" name="photo" class="custom-file-input" id="photo" lang="fr" accept=".jpg,.jpeg,.png">
      <label class="custom-file-label" for="photo" id="photoText">Parcourir</label>
    </div>
  </div> -->
  <div class="form-group">
      <input type="file" name="photo" id="photo">
  </div>
  <div class="d-flex justify-content-center mt-2 mb-4">
    <button type="submit" class="btn btn-outline-primary px-4">valider</button>
  </div>
</form>


