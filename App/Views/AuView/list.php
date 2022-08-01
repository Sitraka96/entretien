<div class="table-responsive col-12 col-md-8 mt-3">
  <table class="table table-sm table-striped table-bordered">
    <caption>Liste des utilisateurs</caption>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Identifiant(s)</th>
        <th scope="col">Nom(s)</th>
        <th scope="col">Prénom(s)</th>
        <th scope="col">Email(s)</th>
        <th scope="col">Type(s)</th>
        <th scope="col" colspan="2">Opérations</th>
      </tr>
    </thead>
    <tbody id="cei">
      <?php for ($i = 0; $i < count($list); $i++) { ?>
        <tr>
          <th scope="row" data-type="<?= $list[$i]['TU_id']; ?>"><?= $i + 1; ?></th>
          <td><?= $list[$i]['username']; ?></td>
          <td><?= $list[$i]['nom']; ?></td>
          <td><?= $list[$i]['prenom']; ?></td>
          <td><?= $list[$i]['email']; ?></td>
          <td><?= $list[$i]['type']; ?></td>
          <td><button class="btn btn-sm btn-outline-warning btn-edit"><i class="fal fa-user-edit"></i></button></td>
          <td><button class="btn btn-sm btn-outline-danger btn-del"><i class="fal fa-user-times"></i></button></td>
        </tr>
      <?php  } ?>





    </tbody>
  </table>

</div>