<?php if (isset($alert) && $alert) { ?>
    <article class="alert-container">
        <?php foreach ($alert["messages"] as $color => $message) { ?>
            <div class="alert alert-<?= $color ?> alert-dismissible fade show shadow" role="alert">
                <?= $message ?>
            </div>
        <?php } ?>
    </article>
<?php } ?>

<main id="new-interview" class="overflow-hidden">
    <section class="row">
        <aside class="col-11 col-sm-11 col-md-10 col-lg-10 col-xl-10 mx-auto">
            <div class="mb-5">
                <section class="d-flex flex-row flex-lg-row justify-content-between align-items-center">
                    <a href="/Entretien" class="btn-link">
                        <i class="bi bi-arrow-left mr-2"></i>Revenir à la liste
                    </a>
                    <h2 id="titre" class="text-center m-0">
                        <span class="d-block d-lg-none">
                            <span>RDV</span>
                            <span class="bi bi-plus"></span>
                        </span>
                        <span class="d-none d-lg-block">Nouveau RDV</span>
                    </h2>
                </section>
                <hr class="mt-0">
                <div class="">
                    <form action="/Entretien/Create" method="post">

                        <section class="row">
                            <aside class="col-12 col-md-4">
                                <div class="form-group" required>
                                    <label for="date_entretien">
                                        Entretien du
                                    </label>
                                    <input type="datetime-local" name="date_entretien" id="date_entretien" class="form-control" value="<?= $date_entretien; ?>" min="<?= $todayDateTime; ?>" autofocus required>
                                </div>
                            </aside>
                            <aside class="col-5 col-md-2 form-group" required>
                                <label for="niv">Niveau</label>
                                <select name="NIV_id" id="niv" class="form-control" required>
                                    <?php foreach ($niv as $v) { ?>
                                        <option value="<?= $v['idNIV']; ?>" <?= $v['idNIV'] == $NIV_id ? 'selected' : ''; ?>>
                                            <?= $v['nom_niv'];  ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </aside>
                            <aside class="col-7 col-md-3 form-group ml-auto" required>
                                <label for="au">Année universitaire</label>
                                <select name="AU_id" id="au" class="form-control" required>
                                    <?php foreach ($au as $v) { ?>
                                        <option value="<?= $v['idAU']; ?>" <?= $v['idAU'] == $AU_id ? 'selected' : ''; ?>>
                                            <?= $v['nom_au'];  ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </aside>
                        </section>
                        <section class="row">
                            <aside class="col-12 col-md-6 col-lg-3 form-group" required>
                                <label for="sexe">Sexe</label>
                                <select name="sexe" id="sexe" class="form-control" required>
                                    <option value="0" <?= $sexe == 0 ? "selected" : "" ?>>Femme</option>
                                    <option value="1" <?= $sexe == 1 ? "selected" : "" ?>>Homme</option>
                                </select>
                            </aside>
                            <aside class="col-12 col-md-6 col-lg-5 form-group" required>
                                <label for="nom">Nom</label>
                                <input type="text" name="nom" id="nom" class="form-control <?= ($alert && $invalidField == 'nom') ? 'is-invalid' : ''; ?>" placeholder="Doe" value="<?= $nom; ?>" required>
                            </aside>
                            <aside class="col-12 col-md-6 col-lg-4 form-group" required>
                                <label for="prenom">Prénoms</label>
                                <input type="text" name="prenom" id="prenom" class="form-control <?= ($alert && $invalidField == 'prenom') ? 'is-invalid' : ''; ?>" placeholder="John" value="<?= $prenom; ?>" required>
                            </aside>
                            <aside class="col-12 col-md-6 form-group" required>
                                <label for="datenaiss">Date de naissance</label>
                                <input type="date" name="datenaiss" id="datenaiss" class="form-control" value="<?= $datenaiss; ?>" min="<?= $oldestDate ?>" max="<?= $newestDate ?>" required>
                            </aside>
                            <aside class="col-12 col-md-6 form-group" required>
                                <label for="contact">Contact</label>
                                <input type="tel" name="contact" id="contact" class="form-control" placeholder="030 00 000 00" value="<?= $contact; ?>" data-max-length="10" required data-format-field>
                            </aside>
                            <aside class="col-12 col-lg-5">
                                <div class="form-group" required>
                                    <label for="REC_id">Recruteur</label>
                                    <select name="REC_id" id="REC_id" class="form-control <?= array_key_exists("REC_id", $entretien->invalidAttributes) ? 'is-invalid' : '' ?>" required data-otherable>
                                        <?php foreach ($recruteurs as $recruteur) { ?>
                                            <option value="<?= $recruteur->idREC ?>" <?= $REC_id == $recruteur->idREC ? "selected" : "" ?>>
                                                <?= $recruteur->getFullName() ?></option>
                                        <?php } ?>
                                        <option value="*" <?= $REC_id == "*" ? "selected" : "" ?>>Autre</option>
                                    </select>
                                </div>
                            </aside>
                            <aside class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label for="REC_other">Autre recruteur</label>
                                    <section class="row">
                                        <aside class="form-group col-12 col-lg-2">
                                            <select name="sexe_rec" id="REC_other_sexe" class="form-control" required disabled>
                                                <option value="0" <?= $sexe_rec == 0 ? "selected" : "" ?>>Mme</option>
                                                <option value="1" <?= $sexe_rec == 1 ? "selected" : "" ?>>Mr</option>
                                            </select>
                                        </aside>
                                        <aside class="form-group col-12 col-lg-5">
                                            <input type="text" name="nom_rec" id="REC_other_lastName" value="<?= $nom_rec ?>" class="form-control" placeholder="NOM du recruteur" disabled>
                                        </aside>
                                        <aside class="form-group col-12 col-lg-5">
                                            <input type="text" name="prenom_rec" id="REC_other_firstName" value="<?= $prenom_rec ?>" class="form-control" placeholder="Prénom(s) du recruteur" disabled>
                                        </aside>
                                    </section>
                                </div>
                            </aside>
                        </section>
                        <section class="row">
                            <aside class="col-12">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="allow_same_date" id="allow_same_date" class="form-check-input" <?= $allow_same_date ? 'checked' : ''; ?>>
                                    <label for="allow_same_date" class="form-check-label">Autoriser même date</label>
                                </div>
                            </aside>
                            <aside class="col-12">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="allow_same_person" id="allow_same_person" class="form-check-input" <?= $allow_same_person ? 'checked' : ''; ?>>
                                    <label for="allow_same_person" class="form-check-label">Autoriser la même
                                        personne</label>
                                </div>
                            </aside>
                        </section>
                        <button type="submit" class="btn btn-success floating-btn rounded-circle">
                            <i class="bi bi-save"></i>
                        </button>
                        <!-- <button type="submit" class="btn btn-primary d-block ml-auto">
                            <i class="bi bi-save mr-2"></i>Sauvegarder
                        </button> -->
                    </form>

                </div>
            </div>
        </aside>
    </section>
</main>