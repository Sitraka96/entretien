<article id="about-student" class="overflow-hidden">
    <button class="floating-btn btn btn-primary rounded-circle border bi bi-three-dots-vertical" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    </button>
    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="triggerId">
        <a href="/Etudiant/Edit/<?= $etudiant['Nie'] ?>" class="dropdown-item text-capitalize">
            éditer le profil étudiant
        </a>
        <hr class="dropdown-divider">
        <a href="/Etudiant/Edit/<?= $etudiant['Nie'] ?>#required-documents-header" class="dropdown-item text-capitalize">
            éditer sa fiche de contrôle
        </a>
        <?php if ($entretien) { ?>
            <hr class="dropdown-divider">
            <a href="/Entretien/View/<?= $entretien->idENTR ?>" class="dropdown-item text-capitalize">
                Revoir l'entretien
            </a>
            <a href="/Entretien/Edit/<?= $entretien->idENTR ?>" class="dropdown-item text-capitalize">
                éditer l'entretien
            </a>
        <?php } ?>
    </div>
    <section class="row">
        <aside class="col-11 col-sm-11 col-md-10 col-lg-10 col-xl-10 mx-auto">
            <section id="main-header" class="d-flex flex-row flex-lg-row justify-content-between align-items-center">
                <a href="/Etudiant/Listes" class="btn-link">
                    <i class="bi bi-arrow-left mr-2"></i>
                    <span class="d-inline">Revenir</span>
                    <span class="d-none d-lg-inline">à la liste des étudiants</span>
                </a>
                <h2 id="titre" class="text-center m-0">
                    <span class="">#<?= $etudiant["Nie"] ?></span>
                </h2>
            </section>
            <hr class="m-0">
            <div class="card rounded-0 border-0 py-5">
                <section class="row flex-column flex-lg-row m-0">
                    <aside class="col-12 col-lg-3">
                        <article class="position-xl-fixed">
                            <figure class="text-center text-lg-left">
                                <img class="avatar img-thumbnail border-0" src="<?= $etudiant["Avatar"] ?>" alt="<?= $etudiant["FullName"] ?>">
                            </figure>
                            <div class="">
                                <div class="form-group">
                                    <span class="text-muted">#<?= $etudiant["Nie"] ?></span>
                                </div>
                                <div class="form-group"><?= $etudiant["FullName"] ?> (<?= $etudiant["Age"] ?>)</div>
                                <div class="form-group"><?= $etudiant["FullDatenaiss"] ?></div>
                                <div class="form-group d-flex flex-column">
                                    <?php foreach ($etudiant["Contacts"] as $contact) { ?>
                                        <a href="tel:<?= $contact ?>" class="btn btn-outline-success border-0 text-left">
                                            <span class="bi bi-phone"></span>
                                            <span class="ml-1"><?= $contact ?></span></a>
                                    <?php } ?>
                                </div>
                                <div class="form-group"><?= $etudiant["Adresse"] ?></div>
                                <div class="form-group"><?= $etudiant["Email"] ?></div>
                                <div class="form-group"><?= $etudiant["Fb"] ?></div>
                                <div class="form-group">
                                    <label for="" class="text-muted">Nationalité</label>
                                    <?= $etudiant["Nat"]["nationalite"] ?>
                                </div>
                            </div>
                        </article>
                    </aside>
                    <aside class="col-12 col-lg-9">
                        <section class="row">
                            <aside class="col-12 col-lg-8 col-xl-9">
                                <div class="flag-card flag-card-left">
                                    <div class="flag-card-header">
                                        <h5 class="flag-card-title">entretien</h5>
                                    </div>
                                    <div class="flag-card-body">
                                        <?php if ($entretien) { ?>
                                            <div class="form-group">
                                                <div class="">
                                                    <label for="" class="text-muted">Du : </label>
                                                    <?= $etudiant["DateRec"]->format("d M Y à H:i") ?>
                                                </div>
                                                <div class="">
                                                    <label for="" class="text-muted">Recruteur : </label>
                                                    <?= $etudiant["Rec"]["FullName"] ?>
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
                                            <hr>
                                            <div class="form-group">
                                                <label for="" class="text-muted text-capitalize">établissement d'origine : </label>
                                                <?= $entretien->getEtablissement() ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="text-muted text-capitalize">Religon : </label>
                                                <?= $entretien->getReligion() ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="text-muted text-capitalize">Dernier diplôme : </label>
                                                <?= $entretien->getDiplome()->diplome ?>
                                            </div>
                                        <?php } else { ?>
                                            <div><span class="text-muted">Aucun entretien</span></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </aside>
                            <aside class="col-12 col-lg-4 col-xl-3">
                                <section class="d-flex flex-column flex-lg-column flex-xl-column justify-content-between">
                                    <div class="form-group">
                                        <label class="text-muted">Père</label>
                                        <div class="text-capitalize"><?= $etudiant["Pere"]["fullName"] ?></div>
                                        <div>
                                            <a href="tel:<?= $etudiant["Pere"]["contacte"] ?>" class="btn btn-outline-success border-0">
                                                <span class="bi bi-phone"></span>
                                                <span class="ml-1"><?= $etudiant["Pere"]["contacte"] ?></span>
                                            </a>
                                        </div>
                                        <div><?= $etudiant["Pere"]["profession"] ?></div>
                                        <div><?= $etudiant["Pere"]["email"] ?></div>
                                        <div><?= $etudiant["Pere"]["adresse"] ?></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted">Mère</label>
                                        <div class="text-capitalize"><?= $etudiant["Mere"]["fullName"] ?></div>
                                        <div>
                                            <a href="tel:<?= $etudiant["Mere"]["contacte"] ?>" class="btn btn-outline-success border-0">
                                                <span class="bi bi-phone"></span>
                                                <span class="ml-1"><?= $etudiant["Mere"]["contacte"] ?></span>
                                            </a>
                                        </div>
                                        <div><?= $etudiant["Mere"]["profession"] ?></div>
                                        <div><?= $etudiant["Mere"]["email"] ?></div>
                                        <div><?= $etudiant["Mere"]["adresse"] ?></div>
                                    </div>
                                </section>
                            </aside>
                            <aside class="col-12 col-lg-8 col-xl-9">
                                <div class="flag-card flag-card-left">
                                    <div class="flag-card-header">
                                        <h5 class="flag-card-title">Inscription</h5>
                                    </div>
                                    <div class="flag-card-body">
                                        <section class="">
                                            <div class="form-group">
                                                <span class="text-muted">Date d'inscription : </span>
                                                <span><?= $inscription["DateInscr"]->format("d M Y à H:i") ?></span>
                                            </div>
                                            <div class="form-group">
                                                <span class="text-muted">Niveau : </span>
                                                <span><?= $inscription["Niv"]->nom_niv ?></span>
                                            </div>
                                            <div class="form-group">
                                                <span class="text-muted">Parcours : </span>
                                                <span><?= $inscription["Gp"]->nom_gp ?></span>
                                            </div>
                                            <div class="form-group">
                                                <span class="text-muted">Année universitaire : </span>
                                                <span><?= $inscription["Au"]->nom_au ?></span>
                                            </div>
                                        </section>
                                        <section class="d-flex justify-content-between">
                                            <div class="small">
                                                <span class="text-muted">N° Matricule : </span>
                                                <span><?= $inscription["num_matr"] ?></span>
                                            </div>
                                            <div class="small">
                                                <span class="text-muted">Etudiant : </span>
                                                <span><?= $inscription["ETUDIANT_nie"] ?></span>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </aside>
                            <aside class="col-12 ml-auto">
                                <article class="">
                                    <div class="flag-card flag-card-top">
                                        <div class="flag-card-header">
                                            <h5 class="flag-card-title">
                                                <section class="row">
                                                    <aside class="col-12 col-sm-8">
                                                        FICHE DE CONTRÔLE (<?= $inscription["Au"]->nom_au ?>)
                                                    </aside>
                                                    <aside class="col-12 col-sm-4">SPDE : _______</aside>
                                                </section>
                                            </h5>
                                        </div>
                                        <div class="flag-card-body p-0">
                                            <table class="table table-striped table-responsive-md">
                                                <thead>
                                                    <tr>
                                                        <th>Etat</th>
                                                        <th>Pièces</th>
                                                        <th>Observations</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($dossiers as $dossier) { ?>
                                                        <?php if (array_key_exists($dossier["idDOS"], $inscription["ListDossier"])) { ?>
                                                            <tr>
                                                                <td>
                                                                    <?php if ($inscription["ListDossier"][$dossier["idDOS"]]["isValid"]) { ?>
                                                                        <span class="text-success">
                                                                            <span class="bi bi-check-all"></span>
                                                                        </span>
                                                                    <?php } else { ?>
                                                                        <span class="text-danger">
                                                                            <span class="bi bi-x-lg"></span>
                                                                        </span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <span class=""><?= $dossier["nom_dos"] ?></span>
                                                                </td>
                                                                <td>
                                                                    <p><?= $inscription["ListDossier"][$dossier["idDOS"]]["observation"] ?></p>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </article>
                            </aside>
                        </section>
                    </aside>
                </section>
            </div>
        </aside>
    </section>
</article>