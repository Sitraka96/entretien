<main id="entretien-list" class="overflow-hidden">
    <div class="mb-5">
        <form action="/Entretien" method="post" id="search-form">
            <section class="row">
                <aside class="col-11 col-sm-11 col-md-10 col-lg-10 col-xl-10 mx-auto">
                    <section class="d-flex flex-row flex-lg-row justify-content-between align-items-center">
                        <h2 id="titre" class="text-center m-0">Liste des entretiens</h2>
                        <a href="/Entretien/New" class="floating-btn btn btn-primary rounded-circle bi bi-plus-lg">
                        </a>
                    </section>
                    <hr class="mt-0">
                    <article id="filter">
                        <section class="row">
                            <aside class="col-12 col-lg-3">
                                <div class="form-group">
                                    <select name="AU_id" id="AU_id" class="form-control">
                                        <option value="*">Année universitaire</option>
                                        <?php foreach ($au as $year) { ?>
                                            <option value="<?= $year['idAU'] ?>" <?= $year['idAU'] == $filterData['AU_id'] ? "selected" : "" ?>>
                                                <?= $year['nom_au'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </aside>
                            <aside class="col-12 col-lg-3">
                                <div class="form-group">
                                    <select name="NIV_id" id="NIV_id" class="form-control">
                                        <option value="*">Tous les niveaux</option>
                                        <?php foreach ($niv as $level) { ?>
                                            <option value="<?= $level['idNIV'] ?>" <?= $level['idNIV'] == $filterData['NIV_id'] ? "selected" : "" ?>>
                                                <?= $level['nom_niv'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </aside>
                            <aside class="col-12 col-lg-6">
                                <div class="form-group">
                                    <input type="search" name="q" id="q" value="<?= $filterData['q'] ?>" class="form-control" placeholder="Rechercher par ID ou par noms">
                                </div>
                            </aside>
                            <aside class="col-12 col-lg-3">
                                <div class="form-group">
                                    <label for="REC_id">Recruteur</label>
                                    <select name="REC_id" id="REC_id" class="form-control">
                                        <option value="*">Tous les recruteurs</option>
                                        <?php foreach ($recruteurs as $rec) { ?>
                                            <option value="<?= $rec['idREC'] ?>" <?= $rec['idREC'] == $filterData['REC_id'] ? "selected" : "" ?>>
                                                <span class="text-uppercase"><?= $rec['nom_rec'] ?></span>
                                                <span class="text-capitalize"><?= $rec['prenom_rec'] ?></span>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </aside>
                            <aside class="col-12 col-lg-3">
                                <div class="form-group">
                                    <label for="date_entretien">Date de l'entretien</label>
                                    <input type="date" name="date_entretien" id="date_entretien" class="form-control" value="<?= $filterData['date_entretien'] ?>">
                                </div>
                            </aside>
                        </section>
                        <section class="row">
                            <aside class="col-12 col-lg-5">
                                <div class="form-group input-group">
                                    <label for="favorable" class="input-group-prepend">
                                        <span class="input-group-text border-0 bg-transparent">
                                            RDV
                                        </span>
                                    </label>
                                    <select name="favorable" id="favorable" class="form-control border-0">
                                        <option value="" <?= $filterData['favorable'] == "" ? "selected" : "" ?>>
                                            Récents</option>
                                        <option value="1" <?= $filterData['favorable'] == "1" ? "selected" : "" ?>>
                                            Favorables
                                        </option>
                                        <option value="0" <?= $filterData['favorable'] == "0" ? "selected" : "" ?>>
                                            Défavorables
                                        </option>
                                        <option value="*" <?= $filterData['favorable'] == "*" ? "selected" : "" ?>>
                                            Complets</option>
                                    </select>
                                    <select name="closed" id="closed" class="form-control border-0">
                                        <option value="1" <?= $filterData['closed'] == 1 ? "selected" : "" ?>>
                                            Inscrits
                                        </option>
                                        <option value="0" <?= $filterData['closed'] == 0 ? "selected" : "" ?>>Non
                                            inscrits
                                        </option>
                                    </select>
                                </div>
                            </aside>
                            <aside class="col-12 col-lg-4 ml-auto">
                                <div class="form-group">
                                    <button type="submit" class="submit-btn btn btn-gray ml-auto">
                                        <span class="bi bi-arrow-repeat mr-2"></span>
                                        <span>Filtrer</span>
                                    </button>
                                    <button type="button" class="btn btn-light border ml-auto disabled loading">
                                        <span class="spinner spinner-border spinner-border-sm"></span>
                                    </button>
                                </div>
                            </aside>
                        </section>

                    </article>
                    <table class="table table-striped table-inverse table-responsive-md">
                        <thead class="thead-inverse">
                            <tr>
                                <th></th>
                                <th>
                                    <section class="d-flex justify-content-between">
                                        <span>ID</span>
                                        <?php if ($filterData['orderBy'] == "idENTR:DESC") { ?>
                                            <button type="submit" name="orderBy" value="idENTR:ASC" class="bi bi-sort-numeric-down btn btn-sm border-0"></button>
                                        <?php } else { ?>
                                            <button type="submit" name="orderBy" value="idENTR:DESC" class="bi bi-sort-numeric-down-alt btn btn-sm border-0"></button>
                                        <?php } ?>
                                    </section>
                                </th>
                                <th>
                                    <section class="d-flex justify-content-between">
                                        <span>Noms & Contact</span>
                                        <?php if ($filterData['orderBy'] == "nom:DESC") { ?>
                                            <button type="submit" name="orderBy" value="nom:ASC" class="bi bi-sort-alpha-down btn btn-sm border-0"></button>
                                        <?php } else { ?>
                                            <button type="submit" name="orderBy" value="nom:DESC" class="bi bi-sort-alpha-down-alt btn btn-sm border-0"></button>
                                        <?php } ?>
                                    </section>
                                </th>
                                <th>
                                    <section class="d-flex justify-content-between">
                                        <span>AU</span>
                                        <?php if ($filterData['orderBy'] == "AU_id:DESC") { ?>
                                            <button type="submit" name="orderBy" value="AU_id:ASC" class="bi bi-sort-numeric-down btn btn-sm border-0"></button>
                                        <?php } else { ?>
                                            <button type="submit" name="orderBy" value="AU_id:DESC" class="bi bi-sort-numeric-down-alt btn btn-sm border-0"></button>
                                        <?php } ?>
                                    </section>
                                </th>
                                <th>
                                    <section class="d-flex justify-content-between">
                                        <span>Niveau</span>
                                        <?php if ($filterData['orderBy'] == "NIV_id:DESC") { ?>
                                            <button type="submit" name="orderBy" value="NIV_id:ASC" class="bi bi-sort-numeric-down btn btn-sm border-0"></button>
                                        <?php } else { ?>
                                            <button type="submit" name="orderBy" value="NIV_id:DESC" class="bi bi-sort-numeric-down-alt btn btn-sm border-0"></button>
                                        <?php } ?>
                                    </section>
                                </th>
                                <th>
                                    <section class="d-flex justify-content-between">
                                        <span>Date de l'entretien</span>
                                        <?php if ($filterData['orderBy'] == "date_entretien:DESC") { ?>
                                            <button type="submit" name="orderBy" value="date_entretien:ASC" class="bi bi-sort-numeric-down btn btn-sm border-0"></button>
                                        <?php } else { ?>
                                            <button type="submit" name="orderBy" value="date_entretien:DESC" class="bi bi-sort-numeric-down-alt btn btn-sm border-0"></button>
                                        <?php } ?>
                                    </section>
                                </th>
                                <th colspan="4">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($entretiens as $entretien) { ?>
                                <tr class="entretien">
                                    <td>
                                        <span class="badge <?= $entretien->favorable() ? "badge-success" : ($entretien->defavorable() ? "badge-danger" : "badge-light") ?>">
                                            <?= $entretien->favorable() ? "Favorable" : ($entretien->defavorable() ? "Défavorable" : "Nouveau") ?>
                                        </span>
                                    </td>
                                    <td scope="row"><?= $entretien->idENTR ?></td>
                                    <td>
                                        <ul class="m-0 list-unstyled">
                                            <li><?= $entretien->nom ?></li>
                                            <li><?= $entretien->prenom ?></li>
                                            <li>
                                                <?php foreach ($entretien->getContacts() as $contact) { ?>
                                                    <a href="tel:<?= $contact ?>" class="btn-link">
                                                        <?= $contact ?>
                                                    </a>
                                                <?php } ?>
                                            </li>
                                        </ul>
                                    </td>
                                    <td><?= $entretien->getAu()->nom_au ?></td>
                                    <td><?= $entretien->getNiv()->nom_niv ?></td>
                                    <td><?= $entretien->getDateEntretien()->format("d M Y à H:i") ?></td>
                                    <td>
                                        <a href="/Entretien/View/<?= $entretien->idENTR ?>" class="btn-link bi ">Aperçu</a>
                                    </td>
                                    <td>
                                        <a href="/Entretien/Edit/<?= $entretien->idENTR ?>" class="btn-link bi bi-pen"></a>
                                    </td>
                                    <td align="right">
                                        <?php if ($entretien->signedUp()) { ?>
                                            <span class="text-success">Déjà isncrit</span>
                                        <?php } else { ?>
                                            <?php if ($entretien->favorable()) { ?>
                                                <a href="/Inscription/New/<?= $entretien->idENTR ?>" class="btn-link">
                                                    Inscrire
                                                </a>
                                            <?php } else { ?>
                                                <span class="invisible">Déjà inscrit</span>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </aside>
            </section>
        </form>
    </div>
</main>