<main class="view-entretien overflow-hidden">

    <section class="row">
        <aside class="col-11 col-sm-11 col-md-10 col-lg-8 col-xl-10 mx-auto">
            <?php if (isset($entretien) && $entretien) { ?>

                <section id="ticket-section" style="display: none;">
                    <aside class="col-12 col-sm-6 col-md-4 col-lg-5 col-xl-4 mt-3 mr-auto mx-lg-auto">
                        <div class="card rounded-0 border-0 shadow">
                            <div class="card-header border-0 rounded-0">
                                <h5 class="card-title m-0 d-flex">
                                    <span class="text-muted small">
                                        <?php if ($entretien->unfinished()) { ?>
                                            Entretien le
                                        <?php } else if ($entretien->favorable()) { ?>
                                            Favorable
                                        <?php } else if ($entretien->defavorable()) { ?>
                                            Défavorable
                                        <?php } ?>

                                    </span>
                                    <div class="ml-auto text-right">
                                        <?php if ($entretien->unfinished()) { ?>
                                            <span>
                                                <?= $entretien->getDateEntretien()->format("d M Y à H:i") ?>
                                            </span>
                                        <?php } else if ($entretien->favorable()) { ?>
                                            <span class="bi bi-check-circle text-success"></span>
                                        <?php } else if ($entretien->defavorable()) { ?>
                                            <span class="bi bi-x-circle text-danger"></span>
                                        <?php } ?>
                                    </div>
                                </h5>
                            </div>
                            <div class="card-body rounded-0">
                                <p class="card-text">
                                <ul class="list-unstyled">
                                    <li>
                                        <span class="text-capitalize"><?= $entretien->getName() ?></span>
                                    </li>
                                    <li>
                                        <span class="text-muted small">Contact :</span>
                                        <?php foreach ($entretien->getContacts() as $contact) { ?>
                                            / <a href="tel:<?= $contact ?>" class="btn-link"><?= $contact ?></a>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <span class="text-muted small">Rec : </span>
                                        <span><?= $entretien->getRecruteur()->getFullName() ?></span>
                                    </li>
                                </ul>
                                </p>
                                <hr>
                                <section class="row">
                                    <aside class="col-8">
                                        <h6>ESMIA</h6>
                                        <p class="text-muted small">
                                            <span class="bi bi-pin-map-fill"></span>
                                            <span>Maison Jean XXIII - Lot III E 58 Mahamasina Sud</span>
                                        </p>
                                        <ul class="text-muted small list-unstyled m-0">
                                            <li>
                                                <a href="http://www.esmia-mada.com" target="_blank" rel="noopener noreferrer" class="btn-link"></a>
                                            </li>
                                            <li>
                                                <a href="mailto:contact@esmia-mada.com" class="btn-link">contact@esmia-mada.com</a>
                                            </li>
                                            <li>
                                                <a href="https://facebook.com/esmia" target="_blank" rel="noopener noreferrer" class="btn-link">
                                                    facebook.com/esmia
                                                </a>
                                            </li>
                                        </ul>
                                    </aside>
                                    <aside class="col-4 text-right d-flex justify-content-between flex-column">
                                        <aside>
                                            <div class="text-muted small">
                                                <a href="tel:0342041362">034 20 413 62</a>
                                            </div>
                                            <div class="text-muted small">
                                                <a href="tel:0344894662">034 48 946 62</a>
                                            </div>
                                        </aside>
                                        <aside>
                                            <small class="text-muted small">RDV#<?= $entretien->getSecureId() ?></small>
                                        </aside>
                                    </aside>
                                </section>
                            </div>
                        </div>
                    </aside>
                </section>

                <section class="d-flex flex-row flex-lg-row justify-content-between align-items-center">
                    <a href="/Entretien" class="btn-link">
                        <i class="bi bi-arrow-left mr-2"></i>Revenir à la liste
                    </a>
                    <h2 id="titre" class="text-center m-0">RDV #<?= $entretienId ?></h2>
                </section>
                <div class="">
                    <button class="floating-btn btn btn-primary rounded-circle border bi bi-three-dots-vertical" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="triggerId">
                        <?php if ($entretien->isNew()) { ?>

                            <a href="/Entretien/Edit/<?= $entretienId ?>" class="btn bg-warning rounded-0 text-white dropdown-item">
                                Démarrer l'entretien
                            </a>

                        <?php } else if ($entretien->signedUp()) { ?>

                            <section class="dropdown-item d-flex justify-content-between text-success">
                                <span>Déjà inscrit</span>
                                <span class="bi bi-check-all"></span>
                            </section>

                        <?php } else if ($entretien->favorable()) { ?>

                            <a href="/Inscription/New/<?= $entretienId ?>" class="dropdown-item">
                                <section class="d-flex justify-content-between">
                                    <span>Inscrire</span>
                                    <span class="bi bi-plus-circle"></span>
                                </section>
                            </a>

                        <?php } else if ($entretien->defavorable()) { ?>

                            <section class="dropdown-item d-flex justify-content-between text-danger">
                                <span>Défavorable</span>
                            </section>

                        <?php } ?>

                        <div class="dropdown-divider"></div>
                        <button href="/Entretien/Print/<?= $entretienId ?>" class="print-btn dropdown-item">
                            Imprimer
                        </button>
                        <a href="/Entretien/Edit/<?= $entretienId ?>" class="dropdown-item">
                            Editer
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="/Entretien/Edit/<?= $entretienId ?>#delete" class="dropdown-item text-danger">
                            Supprimer
                        </a>
                    </div>
                </div>

                <article class="border mb-3">
                    <h2 class="text-center">
                        ESMIA (<?= $entretien->getAu()->nom_au ?>)
                    </h2>
                </article>

                <article class="border py-3 px-2 mb-3">
                    <section class="row">
                        <aside class="col-12 col-lg-6">
                            <section class="d-flex justify-content-between">
                                <aside>
                                    <label for="date_entretien" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Entretien du
                                        :</label>
                                    <span class="text-muted">
                                        <?= $entretien
                                            ->getDateEntretien()
                                            ->format('D d M Y à H:i') ?>
                                    </span>
                                </aside>
                                <aside>
                                    <label for="NIV_id" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Niveau
                                        :</label>
                                    <span class="text-muted">
                                        <?= $entretien->getNiv()->nom_niv ?>
                                    </span>
                                </aside>
                            </section>
                        </aside>
                        <aside class="col-12 col-lg-6">
                            <section class="d-flex justify-content-start">
                                <aside>
                                    <label for="contact" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Téléphone
                                        :</label>
                                    <span class="text-muted">
                                        <?php foreach ($entretien->getContacts() as $contact) { ?>
                                            / <a href="tel:<?= $contact ?>" class="btn-link"><?= $contact ?></a>
                                        <?php } ?>
                                    </span>
                                </aside>
                            </section>
                        </aside>
                    </section>
                    <section class="row">
                        <aside class="col-6 col-lg-6">
                            <label for="nom" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">NOM :</label>
                            <span class="text-muted">
                                <?= $entretien->getNom() ?>
                            </span>
                        </aside>
                        <aside class="col-6 col-lg-6">
                            <label for="prenom" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Prénoms :</label>
                            <span class="text-muted">
                                <?= $entretien->getPrenom() ?>
                            </span>
                        </aside>
                    </section>
                    <section class="row">
                        <aside class="col-12 col-lg-6">
                            <label for="datenaiss" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Date de naissance
                                :</label>
                            <span class="text-muted">
                                <?= $entretien->getDatenaiss()->format('d M Y') ?>
                            </span>
                        </aside>
                        <aside class="col-12 col-lg-6">
                            <label for="religion" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Religion :</label>
                            <span class="text-muted">
                                <?= $entretien->getReligion() ?>
                            </span>
                        </aside>
                    </section>
                    <section class="row">
                        <aside class="col-12 col-lg-6">
                            <label for="etablissement" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Etablissement
                                d'origine
                                :</label>
                            <span class="text-muted">
                                <?= $entretien->getEtablissement() ?>
                            </span>
                        </aside>
                        <aside class="col-12 col-lg-6">
                            <section class="d-flex justify-content-between">
                                <aside>
                                    <label for="diplome" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Dernier
                                        diplôme
                                        :</label>
                                    <span class="text-muted">
                                        <?= $entretien->getDiplome()->diplome ?>
                                    </span>
                                </aside>
                                <aside>
                                    <label for="mention" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Mention
                                        :</label>
                                    <span class="text-muted">
                                        <?= $entretien->getMention() ?>
                                    </span>
                                </aside>
                                <aside>
                                    <label for="serie" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Série
                                        :</label>
                                    <span class="text-muted">
                                        <?= $entretien->getSerie() ?>
                                    </span>
                                </aside>
                            </section>
                        </aside>
                    </section>
                </article>

                <article class="border py-3 px-2 mb-3">
                    <section class="row">
                        <aside class="col-12 col-lg-3">
                            <label for="presentation" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Présentation de
                                soi
                                :</label>
                        </aside>
                        <aside class="col-12 col-lg-9">
                            <p class="text-muted">
                                <?= $entretien->getPresentation() ?>
                            </p>
                        </aside>
                    </section>
                    <section class="row">
                        <aside class="col-12 col-lg-3">
                            <label for="comportement" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Comportement
                                :</label>
                        </aside>
                        <aside class="col-12 col-lg-3">
                            <p class="text-muted">
                                <?= $entretien->getComportement() ?>
                            </p>
                        </aside>
                        <aside class="col-12 col-lg-6">
                            <section class="d-flex justify-content-between">
                                <aside>
                                    <label for="fume" class="badge <?= $entretien->fumeur ? 'badge-warning' : 'badge-success'; ?> rounded-pill small d-block d-lg-inline px-2 py-1 mb-0 mt-3 mb-lg-2 mt-lg-0">
                                        <span class=""><?= $entretien->fumeur() ?></span>
                                    </label>
                                </aside>
                                <aside>
                                    <label for="boit" class="badge <?= $entretien->buveur ? 'badge-warning' : 'badge-success'; ?> rounded-pill small d-block d-lg-inline px-2 py-1 mb-0 mt-3 mb-lg-2 mt-lg-0">
                                        <span class=""><?= $entretien->buveur() ?></span>
                                    </label>
                                </aside>
                                <aside>
                                    <label for="autodidacte" class="badge <?= $entretien->autodidacte ? 'badge-success' : 'badge-warning'; ?> rounded-pill small d-block d-lg-inline px-2 py-1 mb-0 mt-3 mb-lg-2 mt-lg-0 ">
                                        <span class=""><?= $entretien->autodidacte() ?></span>
                                    </label>
                                </aside>
                            </section>
                        </aside>
                    </section>
                    <hr class="">
                    <article class="py-3">
                        <section class="row">
                            <aside class="col-12 col-lg-3">
                                <label for="background" class="text-center text-lg-left d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Autres
                                    Background
                                    :</label>
                            </aside>
                            <aside class="col-12 col-lg-3">
                                <label for="ecole" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Ecole :</label>
                                <span class="text-muted">
                                    <?= $entretien->getEcole() ?>
                                </span>
                            </aside>
                            <aside class="col-12 col-lg-3">
                                <label for="college" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Collège :</label>
                                <span class="text-muted">
                                    <?= $entretien->getCollege() ?>
                                </span>
                            </aside>
                            <aside class="col-12 col-lg-3">
                                <label for="lycee" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Lycée :</label>
                                <span class="text-muted">
                                    <?= $entretien->getLycee() ?>
                                </span>
                            </aside>
                        </section>
                        <section class="row">
                            <aside class="col-12 col-lg-3">
                                <label for="experience_pro" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Expérience
                                    pro
                                    :</label>
                            </aside>
                            <aside class="col-12 col-lg-3">
                                <p class="text-muted">
                                    <?= $entretien->getExperience() ?>
                                </p>
                            </aside>
                            <aside class="col-12 col-lg-6">
                                <label for="autres" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Autres :</label>
                                <p class="text-muted">
                                    <?= $entretien->getAutre() ?>
                                </p>
                            </aside>
                        </section>
                    </article>
                    <article class="border-top px-2 py-3">
                        <section class="row">
                            <aside class="col-12 col-lg-3">
                                <label for="parents" class="text-center text-lg-left d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Parents
                                    :</label>
                            </aside>
                            <aside class="col-12 col-lg-9">
                                <section class="row">
                                    <aside class="col-12 col-lg-3">
                                        <label for="pere" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Père
                                            :</label>
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="text-muted">
                                                    <span class="text-uppercase">
                                                        <?= $entretien->getPere()['nom'] ?>
                                                    </span>
                                                    <span class="text-capitalize">
                                                        <?= $entretien->getPere()['prenom'] ?>
                                                    </span>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="text-muted">
                                                    <?= $entretien->getPere()['profession'] ?>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="text-muted">
                                                    <a href="tel:<?= $entretien->getPere()['contact'] ?>" class="btn-link"><?= $entretien->getPere()['contact'] ?></a>
                                                </span>
                                            </li>
                                        </ul>
                                    </aside>
                                    <aside class="col-12 col-lg-3">
                                        <label for="mere" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Mère
                                            :</label>
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="text-muted">
                                                    <span class="text-uppercase">
                                                        <?= $entretien->getMere()['nom'] ?>
                                                    </span>
                                                    <span class="text-capitalize">
                                                        <?= $entretien->getMere()['prenom'] ?>
                                                    </span>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="text-muted">
                                                    <?= $entretien->getMere()['profession'] ?>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="text-muted">
                                                    <a href="tel:<?= $entretien->getMere()['contact'] ?>" class="btn-link"><?= $entretien->getMere()['contact'] ?></a>
                                                </span>
                                            </li>
                                        </ul>
                                    </aside>
                                    <aside class="col-12 col-lg-3">
                                        <label for="freres" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Frères
                                            :</label>
                                        <ul class="list-unstyled">
                                            <?php foreach ($entretien->getFreres()['array']
                                                as $frere) { ?>
                                                <li>
                                                    <span class="text-muted">
                                                        <?= $frere ?>
                                                    </span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </aside>
                                    <aside class="col-12 col-lg-3">
                                        <label for="soeurs" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Soeurs
                                            :</label>
                                        <ul class="list-unstyled">
                                            <?php foreach ($entretien->getSoeurs()['array']
                                                as $soeur) { ?>
                                                <li>
                                                    <span class="text-muted">
                                                        <?= $soeur ?>
                                                    </span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </aside>
                                </section>
                            </aside>
                        </section>
                    </article>
                </article>

                <article class="border py-3 px-2 mb-3">
                    <section class="row">
                        <aside class="col-12 col-lg-3">
                            <label for="domaine" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Domaine souhaité
                                :</label>
                        </aside>
                        <aside class="col">
                            <span class="text-muted">
                                <?= $entretien->getDomaineSouhaite() ?>
                            </span>
                        </aside>
                    </section>
                    <section class="row">
                        <aside class="col-12 col-lg-3">
                            <label for="connaissance_esmia" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Connaissance ESMIA
                                :</label>
                        </aside>
                        <aside class="col">
                            <span class="text-uppercase text-muted">
                                <?= $entretien->getConnaissanceEsmia() ?>
                            </span>
                        </aside>
                    </section>
                    <section class="row">
                        <aside class="col-12 col-lg-3">
                            <label for="motivations" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Motivations
                                :</label>
                        </aside>
                        <aside class="col-12 col-lg-3">
                            <span class="text-muted">
                                <?= $entretien->getMotivation() ?>
                            </span>
                        </aside>
                        <aside class="col-12 col-lg-6">
                            <label for="attentes" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Attentes :</label>
                            <p class="text-muted">
                                <?= $entretien->getAttentes() ?>
                            </p>
                        </aside>
                    </section>
                    <section class="row">
                        <aside class="col-12 col-lg-3">
                            <label for="problemes" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Problèmes (<b class="">santé...</b>) :</label>
                        </aside>
                        <aside class="col-12 col-lg-3">
                            <p class="text-muted">
                                <?= $entretien->getProblem() ?>
                            </p>
                        </aside>
                        <aside class="col-12 col-lg-6">
                            <label for="vision" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Vision :</label>
                            <p class="text-muted">
                                <?= $entretien->getVision() ?>
                            </p>
                        </aside>
                    </section>
                    <section class="row">
                        <aside class="col-12 col-lg-3">
                            <label for="projets" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Projet pro / perso
                                :</label>
                        </aside>
                        <aside class="col-12 col-lg-3">
                            <p class="text-muted">
                                <?= $entretien->getProjets() ?>
                            </p>
                        </aside>
                        <aside class="col-12 col-lg-6">
                            <label for="loisirs" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Loisirs :</label>
                            <p class="text-muted">
                                <?= $entretien->getLoisirs() ?>
                            </p>
                        </aside>
                    </section>
                    <section class="row">
                        <aside class="col-12 col-lg-3">
                            <label for="qualites" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Qualités :</label>
                        </aside>
                        <aside class="col-12 col-lg-3">
                            <p class="text-muted">
                                <?= $entretien->getQualites() ?>
                            </p>
                        </aside>
                        <aside class="col-12 col-lg-6">
                            <label for="defauts" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">Défauts :</label>
                            <p class="text-muted">
                                <?= $entretien->getDefauts() ?>
                            </p>
                        </aside>
                    </section>
                </article>

                <article class="border py-3 px-2 mb-3">
                    <section class="row">
                        <aside class="col-12 col-lg-6">
                            <section class="d-flex flex-row flex-lg-column justify-content-between">
                                <aside class="d-flex align-items-baseline">
                                    <label for="frs" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">
                                        Français
                                        :</label>
                                    <span class="ml-2">
                                        <?= $entretien->getFrs() ?>/5
                                    </span>
                                </aside>
                                <aside class="d-flex align-items-baseline">
                                    <label for="info" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">
                                        Info
                                        :</label>
                                    <span class="ml-2">
                                        <?= $entretien->getInfo() ?>/5
                                    </span>
                                </aside>
                            </section>
                        </aside>
                        <aside class="col-12 col-lg-6">
                            <section class="row">
                                <aside class="col-12 col-lg-9">
                                    <section class="d-flex flex-row flex-lg-column justify-content-between">
                                        <aside class="d-flex align-items-baseline">
                                            <label for="agl" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">
                                                Anglais
                                                :</label>
                                            <span class="ml-2">
                                                <?= $entretien->getAgl() ?>/5
                                            </span>
                                        </aside>
                                        <aside class="d-flex align-items-baseline">
                                            <label for="react" class="d-block d-lg-inline mb-0 mt-3 mb-lg-2 mt-lg-0">
                                                Réaction
                                                :</label>
                                            <span class="ml-2">
                                                <?= $entretien->getReact() ?>/5
                                            </span>
                                        </aside>
                                    </section>
                                </aside>
                                <aside class="col-12 col-lg-3 border-left">
                                    <aside class="d-flex align-items-center justify-content-center justify-content-lg-left h-100 my-3 my-lg-0">
                                        <label for="total" class="m-0">
                                            TOTAL
                                            :</label><span class="ml-2">
                                            <?= $entretien->getTotal() ?>/20
                                        </span>
                                    </aside>
                                </aside>
                            </section>
                        </aside>
                    </section>
                    <article class="border-top <?= $entretien->favorable()
                                                    ? 'bg-success text-white'
                                                    : ($entretien->defavorable() ? 'bg-danger text-white' : 'bg-light text-dark') ?>">
                        <section class="row">
                            <aside class="col-12">
                                <section class="d-flex align-items-baseline justify-content-center p-2">
                                    <span class="ml-2">
                                        <?php if ($entretien->favorable()) { ?>
                                            Favorable
                                        <?php } else if ($entretien->defavorable()) { ?>
                                            Défavorable
                                        <?php } else { ?>
                                            RDV à venir
                                        <?php } ?>
                                    </span>
                                </section>
                            </aside>
                        </section>
                    </article>
                </article>

            <?php } else { ?>
                <center class="">
                    <h2>
                        La fiche N°<?= $entretienId ?> est introuvable.
                    </h2>
                    <p>
                        Vérifiez bien le numéro d'identification de la fiche. <br>
                        Si le numéro est correcte donc cette fiche est introuvable car elle a été supprimé.
                        <i class="bi bi-home"></i>
                    </p>
                </center>
            <?php } ?>
        </aside>
    </section>

</main>