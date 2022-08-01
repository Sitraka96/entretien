<article id="summary" class="overflow-hidden">
    <button class="floating-btn btn btn-primary rounded-circle border bi bi-three-dots-vertical" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    </button>
    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="triggerId">
        <a href="/Etudiant/Show/<?= $etudiant['Nie'] ?>" class="dropdown-item">Voir son dossier complet</a>
        <a href="/Etudiant/Edit/<?= $etudiant['Nie'] ?>" class="dropdown-item">
            Mettre à jour
        </a>
    </div>
    <section class="row">
        <aside class="col-11 col-sm-11 col-md-10 col-lg-10 col-xl-10 mx-auto">
            <section id="main-header" class="d-flex flex-row flex-lg-row justify-content-between align-items-center">
                <a href="/Entretien" class="btn-link">
                    <i class="bi bi-arrow-left mr-2"></i>
                    <span class="d-inline">Revenir</span>
                    <span class="d-none d-lg-inline">à la liste des RDV</span>
                </a>
                <h2 id="titre" class="text-center m-0">
                    <span class="">
                        <span>Résumé</span>
                    </span>
                    <span class="d-none d-lg-inline-block">de l'inscription</span>
                </h2>
            </section>
            <article class="card-header rounded-0 bg-success text-white text-center px-5">
                <h1 class="">Inscription réussie</h1>
            </article>
            <hr class="m-0">
            <div class="card rounded-0 border-top-0 border-bottom-0 mb-5">
                <div class="card-header d-flex flex-column flex-lg-row justify-content-between">
                    <figure class="text-center text-lg-left mr-0 mr-lg-4">
                        <img class="avatar card-img-top img-thumbnail" src="<?= $etudiant["Avatar"] ?>" alt="<?= $etudiant["FullName"] ?>">
                    </figure>
                    <div class="">
                        <div class="form-group">
                            <div>
                                <span class="text-muted">#<?= $etudiant["Nie"] ?></span>
                            </div>
                            <div><?= $etudiant["FullName"] ?> (<?= $etudiant["Age"] ?>)</div>
                            <div><?= $etudiant["FullDatenaiss"] ?></div>
                            <div>
                                <?php foreach ($etudiant["Contacts"] as $contact) { ?>
                                    <a href="tel:<?= $contact ?>" class="btn btn-outline-success border-0">
                                        <span class="bi bi-phone"></span>
                                        <span class="ml-2"><?= $contact ?></span></a>
                                <?php } ?>
                            </div>
                            <div><?= $etudiant["Adresse"] ?></div>
                            <div><?= $etudiant["Email"] ?></div>
                            <div><?= $etudiant["Fb"] ?></div>
                            <div>
                                <label for="" class="text-muted">Nationalité</label>
                                <?= $etudiant["Nat"]["nationalite"] ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <section class="row">
                                <aside class="col">
                                    <label for="" class="text-muted">Bacc : </label>
                                    <?= $etudiant["Ab"]["annee"] ?>
                                </aside>
                                <aside class="col">
                                    <label for="" class="text-muted">Série : </label>
                                    <?= $etudiant["Sb"]["serie"] ?>
                                </aside>
                                <aside class="col">
                                    <?= $etudiant["Mb"]["mention"] ?>
                                </aside>
                            </section>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <label for="" class="text-muted">Recruteur : </label>
                                <?= $etudiant["Rec"]["FullName"] ?>
                            </div>
                            <div class="">
                                <label for="" class="text-muted">Le : </label>
                                <?= $etudiant["DateRec"]->format("d M Y à H:i") ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <label for="" class="text-muted">Les dossiers à fournir : </label>
                            </div>
                            <div class="">
                                <ul class="list-unstyled">
                                    <?php foreach ($dossiers as $dossier) { ?>
                                        <li>
                                            <label for="dossier<?= $dossier['idDOS'] ?>" class="">
                                                <?php if ($inscription["ListDossier"][$dossier["idDOS"]]["isValid"]) { ?>
                                                    <span class="text-success">
                                                        <span class="bi bi-check-all"></span>
                                                        <span class="ml-2"><?= $dossier["nom_dos"] ?></span>
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="text-danger">
                                                        <span class="bi bi-x-lg"></span>
                                                        <span class="ml-2"><?= $dossier["nom_dos"] ?></span>
                                                    </span>
                                                <?php } ?>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="text-muted">Père</label>
                        <div class="text-capitalize"><?= $etudiant["Pere"]["fullName"] ?></div>
                        <div><?= $etudiant["Pere"]["contacte"] ?></div>
                        <div><?= $etudiant["Pere"]["profession"] ?></div>
                        <div><?= $etudiant["Pere"]["email"] ?></div>
                        <div><?= $etudiant["Pere"]["adresse"] ?></div>
                    </div>
                    <div class="form-group">
                        <label class="text-muted">Mère</label>
                        <div class="text-capitalize"><?= $etudiant["Mere"]["fullName"] ?></div>
                        <div><?= $etudiant["Mere"]["contacte"] ?></div>
                        <div><?= $etudiant["Mere"]["profession"] ?></div>
                        <div><?= $etudiant["Mere"]["email"] ?></div>
                        <div><?= $etudiant["Mere"]["adresse"] ?></div>
                    </div>
                </div>
            </div>
        </aside>
    </section>
</article>