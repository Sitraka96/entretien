<?php if (isset($alert) && $alert) { ?>
    <article class="alert-container">
        <div class="alert alert-<?= $alert['color']; ?> alert-dismissible fade show shadow" role="alert">
            <?= $alert["message"]; ?>
        </div>
    </article>
<?php } ?>

<main class="edit-entretien overflow-hidden">

    <section class="row">
        <aside class="col-11 col-sm-11 col-md-10 col-lg-10 col-xl-10 mx-auto">

            <div class="mb-5">
                <section class="d-flex flex-row flex-lg-row justify-content-between align-items-center">
                    <a href="/Entretien/View/<?= $entretienId ?>" class="btn-link">
                        <i class="bi bi-arrow-left mr-2"></i>Revenir à l'aperçu
                    </a>
                    <h2 id="titre" class="text-center m-0">RDV #<?= $entretienId ?></h2>
                </section>
                <hr class="mt-0">
                <form action="/Entretien/Update" method="POST" id="entretien-form">

                    <input type="hidden" name="entretienId" value="<?= $entretienId ?>">

                    <div class="bs-stepper">
                        <div class="bs-stepper-header overflow-auto bg-white" role="tablist">
                            <!-- your steps here -->
                            <div class="step" data-target="#basic-infos-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="basic-infos-part" id="basic-infos-part-trigger">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Infos basic</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#background-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="background-part" id="background-part-trigger">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Prés & Background</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#parents-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="parents-part" id="parents-part-trigger">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Parents</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#domain-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="domain-part" id="domain-part-trigger">
                                    <span class="bs-stepper-circle">4</span>
                                    <span class="bs-stepper-label">Motivations</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#notes-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="notes-part" id="notes-part-trigger">
                                    <span class="bs-stepper-circle">5</span>
                                    <span class="bs-stepper-label">Evaluations</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <article id="basic-infos-part" class="content fade" role="tabpanel" aria-labelledby="basic-infos-part-trigger">
                                <section class="row">
                                    <aside class="col-12 col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label for="date_entretien">
                                                Entretien du
                                            </label>
                                            <input type="datetime-local" name="date_entretien" id="date_entretien" class="form-control" value="<?= $date_entretien ?>" disabled>
                                        </div>
                                    </aside>
                                    <aside class="col-5 col-md-2 col-lg-2">
                                        <div class="form-group">
                                            <label for="NIV_id">Niveau</label>
                                            <select name="NIV_id" id="NIV_id" class="form-control" required>
                                                <?php foreach ($niv as $v) { ?>
                                                    <option value="<?= $v['idNIV'] ?>" <?= $v['idNIV'] == $NIV_id ? 'selected' : '' ?>>
                                                        <?= $v['nom_niv'];  ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </aside>
                                    <aside class="col-7 col-md-3 col-lg-3">
                                        <div class="form-group ml-auto">
                                            <label for="AU_id">Année universitaire</label>
                                            <select name="AU_id" id="AU_id" class="form-control" required>
                                                <?php foreach ($au as $v) { ?>
                                                    <option value="<?= $v['idAU'] ?>" <?= $v['idAU'] == $AU_id ? 'selected' : '' ?>>
                                                        <?= $v['nom_au'];  ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-md-6 col-lg-4">
                                        <div class=" form-group">
                                            <label for="REC_id">Recruteur</label>
                                            <select name="REC_id" id="REC_id" class="form-control" required>
                                                <?php foreach ($recruteurs as $recruteur) { ?>
                                                    <option value="<?= $recruteur->idREC; ?>" <?= $recruteur->idREC == $REC_id ? 'selected' : ''; ?>>
                                                        <?= $recruteur->getFullName();  ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </aside>
                                </section>
                                <section class="row">
                                    <aside class="col-12 col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="sexe">Sexe</label>
                                            <select name="sexe" id="sexe" class="form-control" required>
                                                <option value="0" <?= $sexe == 0 ? "selected" : "" ?>>Femme</option>
                                                <option value="1" <?= $sexe == 1 ? "selected" : "" ?>>Homme</option>
                                            </select>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-md-6 col-lg-5 ">
                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" name="nom" id="nom" class="form-control" placeholder="NOM" value="<?= $nom; ?>" required>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="prenom">Prénoms</label>
                                            <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Prénoms" value="<?= $prenom; ?>" required>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="datenaiss">Date de naissance</label>
                                            <input type="date" name="datenaiss" id="datenaiss" min="<?= $oldestDate ?>" max="<?= $now->format("Y-m-d") ?>" class="form-control" value="<?= $datenaiss ?>">
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="lieunaiss">Lieu de naissance</label>
                                            <input type="text" name="lieunaiss" id="lieunaiss" class="form-control" value="<?= $lieunaiss ?>">
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="religion">Religion</label>
                                            <input type="text" name="religion" id="religion" class="form-control" value="<?= $religion ?>">
                                        </div>
                                    </aside>
                                </section>
                                <section class="row">
                                    <aside class="col-12">
                                        <div class="form-group" required>
                                            <label for="contact">Contacte</label>
                                            <section class="row">
                                                <aside class="col-12 col-md-4 col-lg-4">
                                                    <input type="tel" name="contact[]" id="contact0" multiple class="form-control rounded mb-3" placeholder="030 00 000 00" value="<?= $contact0; ?>" required data-max-length="10" data-format-field />
                                                </aside>
                                                <aside class="col-12 col-md-4 col-lg-4">
                                                    <input type="tel" name="contact[]" id="contact1" multiple class="form-control rounded mb-3" placeholder="030 00 000 00" value="<?= $contact1; ?>" data-max-length="10" data-format-field />
                                                </aside>
                                                <aside class="col-12 col-md-4 col-lg-4">
                                                    <input type="tel" name="contact[]" id="contact2" multiple class="form-control rounded mb-3" placeholder="030 00 000 00" value="<?= $contact2; ?>" data-max-length="10" data-format-field />
                                                </aside>
                                            </section>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="adresse">Adresse</label>
                                            <input type="text" name="adresse" id="adresse" class="form-control" value="<?= $adresse ?>">
                                        </div>
                                    </aside>
                                </section>
                            </article>
                            <article id="background-part" class="content fade" role="tabpanel" aria-labelledby="background-part-trigger">
                                <section class="row">
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="presentation_soi">Présentation de soi</label>
                                            <textarea name="presentation_soi" id="presentation_soi" cols="30" rows="4" class="form-control"><?= $presentation_soi ?></textarea>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="comportement">Comportement</label>
                                            <textarea name="comportement" id="comportement" cols="30" rows="4" class="form-control"><?= $comportement ?></textarea>
                                        </div>
                                    </aside>
                                </section>
                                <section class="row">
                                    <aside class="col">
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="fume" id="fume" class="form-check-input" value="1" <?= $fume ? 'checked' : '' ?>>
                                            <label for="fume">Fume</label>
                                        </div>
                                    </aside>
                                    <aside class="col">
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="boit" id="boit" class="form-check-input" value="1" <?= $boit ? 'checked' : '' ?>>
                                            <label for="boit">Boit</label>
                                        </div>
                                    </aside>
                                    <aside class="col">
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="autodidacte" id="autodidacte" value="1" class="form-check-input" <?= $autodidacte ? 'checked' : '' ?>>
                                            <label for="autodidacte">Autodidacte</label>
                                        </div>
                                    </aside>
                                </section>
                                <section class="row">
                                    <aside class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="ecole">Ecole:</label>
                                            <input type="text" name="ecole" id="ecole" class="form-control" value="<?= $ecole ?>">
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="college">Collège:</label>
                                            <input type="text" name="college" id="college" class="form-control" value="<?= $college ?>">
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="lycee">Lycée:</label>
                                            <input type="text" name="lycee" id="lycee" class="form-control" value="<?= $lycee ?>">
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="etablissement">Etablissement d'origine</label>
                                            <input type="text" name="etablissement" id="etablissement" class="form-control" value="<?= $etablissement ?>">
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-3 col-xl-2">
                                        <div class="form-group">
                                            <label for="DO_id">Dernier diplôme</label>
                                            <select name="DO_id" id="DO_id" class="form-control">
                                                <?php foreach ($do as $diplome) { ?>
                                                    <option value="<?= $diplome['idDO'] ?>" <?= $DO_id == $diplome['idDO'] ? "selected" : "" ?>>
                                                        <?= $diplome['diplome'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-3 col-xl-2">
                                        <div class="form-group">
                                            <label for="AB_id">Année du bacc</label>
                                            <select name="AB_id" id="AB_id" class="form-control" required>
                                                <?php foreach ($abs as $ab) { ?>
                                                    <option value="<?= $ab["idAB"] ?>" <?= $AB_id == $ab["idAB"] ? "selected" : "" ?>>
                                                        <?= $ab["annee"] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </aside>
                                    <aside class="col-6 col-lg-3 col-xl-3">
                                        <div class="form-group">
                                            <label for="SB_id">Série</label>
                                            <div class="input-group">
                                                <select name="SB_id" id="SB_id" class="form-control pr-0 col-6 col-lg-4" required data-otherable>
                                                    <?php foreach ($series as $serie) { ?>
                                                        <option value="<?= $serie['idSB'] ?>" <?= $SB_id == $serie['idSB'] ? "selected" : "" ?>><?= $serie['serie'] ?></option>
                                                    <?php } ?>
                                                    <option value="*" label="Autre"></option>
                                                </select>
                                                <input type="text" name="SB_other" id="SB_other" class="form-control col-lg-8" placeholder="Autre série" disabled />
                                            </div>
                                        </div>
                                    </aside>
                                    <aside class="col-6 col-lg-3 col-xl-2">
                                        <div class="form-group">
                                            <label for="MB_id">Mention</label>
                                            <select name="MB_id" id="MB_id" class="form-control">
                                                <?php foreach ($mb as $mention) { ?>
                                                    <option value="<?= $mention['idMB'] ?>" <?= $MB_id == $mention['idMB'] ? "selected" : "" ?>>
                                                        <?= $mention['mention'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </aside>
                                </section>
                                <section class="row">
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="experience">Expérience pro</label>
                                            <textarea name="experience" id="experience" class="form-control"><?= $experience ?></textarea>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="autre">Autres</label>
                                            <textarea name="autre" id="autre" class="form-control"><?= $autre ?></textarea>
                                        </div>
                                    </aside>
                                </section>
                            </article>
                            <article id="parents-part" class="content fade" role="tabpanel" aria-labelledby="parents-part-trigger">
                                <section class="row">
                                    <aside class="col-12 col-lg-2">
                                        <label for="parents">Parents :</label>
                                    </aside>
                                    <aside class="col-12 col-lg-10">
                                        <section class="row">
                                            <aside class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="pere">Père</label>
                                                    <div class="form-group input-group">
                                                        <input type="text" name="nom_pere" id="nom_pere" class="form-control col-8 col-lg-6" placeholder="NOM DU PERE" value="<?= $pere['nom'] ?>">
                                                        <input type="text" name="prenom_pere" id="prenom_pere" class="form-control col-4 col-lg-6" placeholder="Prénoms du père" value="<?= $pere['prenom'] ?>">

                                                    </div>
                                                    <div class="form-group">
                                                        <input type="tel" name="contact_pere" id="contact_pere" class="form-control" placeholder="030 00 000 00" value="<?= $pere['contact'] ?>" data-max-length="10" data-format-field>
                                                    </div>
                                                </div>
                                            </aside>
                                            <aside class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="mere">Mère</label>
                                                    <div class="form-group input-group">
                                                        <input type="text" name="nom_mere" id="nom_mere" class="form-control col-8 col-lg-6" placeholder="NOM DE LA MERE" value="<?= $mere['nom'] ?>">
                                                        <input type="text" name="prenom_mere" id="prenom_mere" class="form-control col-4 col-lg-6" placeholder="Prénoms de la mère" value="<?= $mere['prenom'] ?>">

                                                    </div>
                                                    <div class="form-group">
                                                        <input type="tel" name="contact_mere" id="contact_mere" class="form-control" placeholder="030 00 000 00" value="<?= $mere['contact'] ?>" data-max-length="10" data-format-field>
                                                    </div>
                                                </div>
                                            </aside>
                                            <aside class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="freres">Frères</label>
                                                    <textarea name="freres" id="freres" cols="10" rows="4" class="form-control w-100" placeholder="Tapez ici les informations supplémentaires à propos des frères"><?= $freres ?></textarea>
                                                </div>
                                            </aside>
                                            <aside class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="soeurs">Soeurs</label>
                                                    <textarea name="soeurs" id="soeurs" cols="10" rows="4" class="form-control w-100" placeholder="Tapez ici les informations supplémentaires à propos des soeurs"><?= $soeurs ?></textarea>
                                                </div>
                                            </aside>
                                        </section>
                                    </aside>
                                </section>
                            </article>
                            <article id="domain-part" class="content fade" role="tabpanel" aria-labelledby="domain-part-trigger">
                                <section class="row">
                                    <aside class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="GP_id">Domaine choisi</label>
                                            <select name="GP_id" id="GP_id" class="form-control">
                                                <?php foreach ($fields as $field) { ?>
                                                    <option value="<?= $field["idGP"] ?>" <?= $field["idGP"] == $GP_id ? 'selected' : '' ?>>
                                                        <?= $field["nom_gp"] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="connaissance_esmia">Connaissance ESMIA</label>
                                            <select name="connaissance_esmia" id="connaissance_esmia" class="form-control">
                                                <?php foreach ($connaissances_esmia as $ce) { ?>
                                                    <option value="<?= $ce ?>" <?= $ce == $connaissance_esmia ? 'selected' : '' ?>>
                                                        <?= $ce ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </aside>
                                </section>
                                <section class="row">
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="motivation">Motivation</label>
                                            <textarea name="motivation" id="motivation" rows="4" class="form-control"><?= $motivation ?></textarea>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="attentes">Attentes</label>
                                            <textarea name="attentes" id="attentes" rows="4" class="form-control"><?= $attentes ?></textarea>
                                        </div>
                                    </aside>
                                </section>
                                <section class="row">
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="problemes">Problèmes (santé...)</label>
                                            <textarea name="problemes" id="problemes" rows="4" class="form-control"><?= $problemes ?></textarea>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="vision">Vision</label>
                                            <textarea name="vision" id="vision" rows="4" class="form-control"><?= $vision ?></textarea>
                                        </div>
                                    </aside>
                                </section>
                                <section class="row">
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="projets">Projet pro / perso</label>
                                            <textarea name="projets" id="projets" rows="4" class="form-control"><?= $projets ?></textarea>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="loisirs">Loisirs</label>
                                            <textarea name="loisirs" id="loisirs" rows="4" class="form-control"><?= $loisirs ?></textarea>
                                        </div>
                                    </aside>
                                </section>
                                <section class="row">
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="qualites">Qualités</label>
                                            <textarea name="qualites" id="qualites" rows="4" class="form-control"><?= $qualites ?></textarea>
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="defauts">Défauts</label>
                                            <textarea name="defauts" id="defauts" rows="4" class="form-control"><?= $defauts ?></textarea>
                                        </div>
                                    </aside>
                                </section>
                            </article>
                            <article id="notes-part" class="content fade" role="tabpanel" aria-labelledby="notes-part-trigger">
                                <section class="row">
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="frs">Français <span class="note"><span data-watch="frs"><?= $frs ?></span>/5</span></label>
                                            <input type="range" name="frs" id="frs" min="0" max="5" step="1" class="form-control outline-0" value="<?= $frs ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="info">Info <span class="note"><span data-watch="info"><?= $info ?></span>/5</span></label>
                                            <input type="range" name="info" id="info" min="0" max="5" step="1" class="form-control" value="<?= $info ?>">
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="agl">Anglais <span class="note"><span data-watch="agl"><?= $agl ?></span>/5</span></label>
                                            <input type="range" name="agl" id="agl" min="0" max="5" step="1" class="form-control" value="<?= $agl ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="react">Réactivité <span class="note"><span data-watch="react"><?= $react ?></span>/5</span></label>
                                            <input type="range" name="react" id="react" min="0" max="5" step="1" class="form-control" value="<?= $react ?>">
                                        </div>
                                    </aside>
                                    <aside class="col-12 col-lg-4 ml-auto">
                                        <div class="form-group text-left text-lg-right">
                                            <label for="total">Total</label>
                                            <div>
                                                <svg height="75" width="75">
                                                    <path d="M 0 0 L 0 75 L 75 75 L 75 0 Z" stroke="#007bff" stroke-width="3" fill="none" />
                                                    <path d="M 0 75 L 75 0" stroke="#007bff" stroke-width="2" fill="none" />
                                                    <g fill="black" stroke="none" text-anchor="middle">
                                                        <text x="10" y="10" dx="15" dy="18" data-watch="frs:info:agl:react:+"></text>
                                                        <text x="30" y="30" dx="25" dy="28">20</text>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </aside>
                                </section>
                                <hr class="my-5">
                                <section class="btn-group border w-100 mb-5" role="group" aria-label="">
                                    <label for="favorable_oui" class="btn <?= $favorable ? 'btn-success' : '' ?> rounded-0 m-0">
                                        <input type="radio" name="favorable" id="favorable_oui" value="1" class="d-none" <?= $favorable ? 'checked' : '' ?>>
                                        <label for="favorable_oui" class="m-0">Favorable</label>
                                    </label>
                                    <label for="favorable_non" class="btn <?= $favorable ? '' : 'btn-danger' ?> rounded-0 m-0">
                                        <input type="radio" name="favorable" id="favorable_non" value="" class="d-none" <?= $favorable ? '' : 'checked' ?>>
                                        <label for="favorable_non" class="m-0">Défavorable</label>
                                    </label>
                                </section>
                            </article>
                        </div>
                    </div>
                    <section class="actions bg-white d-flex justify-content-between justify-content-lg-end p-3 p-lg-0 mt-0">
                        <button type="button" id="prev-btn" class="btn btn-light disabled" disabled="disabled">
                            Précédent
                        </button>
                        <button type="button" id="next-btn" class="btn btn-primary disabled ml-4" disabled="disabled">
                            <span class="">
                                Suivant
                            </span>
                        </button>
                        <button type="submit" id="submit-btn" class="floating-btn btn btn-success rounded-circle collapse ml-4">
                            <i class="bi bi-save"></i>
                        </button>
                    </section>
                </form>
            </div>

            <section id="delete" class="mb-5 pb-5">
                <hr class="border-danger my-5">
                <div id="accordianId" role="tablist" aria-multiselectable="true">
                    <div class="card">
                        <div class="card-header bg-danger text-white" role="tab" id="section1HeaderId">
                            <h5 class="mb-0">
                                <button data-toggle="collapse" data-parent="#accordianId" href="#section1ContentId" aria-expanded="true" aria-controls="section1ContentId" class="btn w-100 text-left">
                                    Danger zone
                                </button>
                            </h5>
                        </div>
                        <div id="section1ContentId" class="collapse show in" role="tabpanel" aria-labelledby="section1HeaderId">
                            <div class="card-body">
                                <form action="/Entretien/Delete/<?= $entretienId ?>" method="post" id="delete-form">
                                    <input type="hidden" name="entretienId" value="<?= $entretienId ?>">
                                    <p>
                                        Avant de poursuivre, sachez que la suppression
                                        de ce RDV n'est pas réversible et toutes les données
                                        attachées à celui-ci seront supprimées en même temps
                                    </p>
                                    <div class="form-group">
                                        <label for="confirm-delete">
                                            Si vous voulez quand même poursuivre, veuillez taper 'CONFIRMER'
                                        </label>
                                        <input type="text" name="confirm-delete" id="confirm-delete" data-confirm-value="CONFIRMER" autocomplete="off" class="form-control" placeholder="" minlength="9" maxlength="9">
                                    </div>
                                    <button type="submit" id="delete-submit-btn" class="btn btn-outline-danger border-0 disabled mt-3" disabled>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </aside>
    </section>
</main>