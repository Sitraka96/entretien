<pre>
</pre>
<div class="table-responsive col-12 col-md-8 mt-3">
  <table class="table table-striped table-bordered">
  <caption>Liste des utilisateurs</caption>
  <thead>
  <tr>
    <th scope="col">#</th>
    <th scope="col">Identifiant(s)</th>
    <?php if($_SESSION['type']=='devmaster'){ ?>
    <th scope="col">Mot de passe(s)</th>
    <?php } ?>
    <th scope="col">Nom(s)</th>
    <th scope="col">Prénom(s)</th>
    <th scope="col">Email(s)</th>
    <th scope="col">Type(s)</th>
    <th scope="col" colspan="2">Opérations</th>
  </tr>
  </thead>
  <tbody id="cei">
  <?php 
  foreach ($list as $i => $item) { $k=$i+1;?>
    <tr  data-type=<?= $item['TU_id']; ?> data-row=<?= $k; ?>>
    <th scope="row"><?= $k; ?></th>
    <td id="u<?= $k; ?>"><?= $item['username']; ?></td>
    <?php if($_SESSION['type']=='devmaster'){ ?>
    <td><?= $item['password']; ?></td>
    <?php } ?>
    <td id="n<?= $k ?>"><?= $item['nom']; ?></td>
    <td id="p<?= $k ?>"><?= $item['prenom']; ?></td>
    <td id="e<?= $k ?>"><?= $item['email']; ?></td>
    <td id="t<?= $k ?>"><?= $item['type']; ?></td>
    <td class="align-middle"><button class="btn btn-sm btn-outline-warning btn-edit"><svg width="20" height="20"><use xlink:href="/assets/svg/scrud.svg#edit"></svg></button></td>
    <td class="align-middle"><button class="btn btn-sm btn-outline-danger btn-del"><svg width="20" height="20"><use xlink:href="/assets/svg/scrud.svg#delete"></svg></button></td>
  </tr>
  <?php  } ?> 
 
  </tbody>
  </table>

</div>