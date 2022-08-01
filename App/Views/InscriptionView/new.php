<?php if (isset($alert) && $alert) { ?>
    <article class="alert-container">
        <?php foreach ($alert["messages"] as $color => $message) { ?>
            <div class="alert alert-<?= $color ?> alert-dismissible fade show shadow" role="alert">
                <?= $message ?>
            </div>
        <?php } ?>
    </article>
<?php } ?>

<main id="inscription-main" class="overflow-hidden">
    <section class="row">
        <aside class="col-11 col-sm-11 col-md-10 col-lg-10 col-xl-10 mx-auto">
            <div class="mb-5">
                <section id="main-header" class="d-flex flex-row flex-lg-row justify-content-between align-items-center">
                    <a href="/Entretien" class="btn-link">
                        <i class="bi bi-arrow-left mr-2"></i>
                        <span class="d-inline">Revenir</span>
                        <span class="d-none d-lg-inline">à la liste</span>
                    </a>
                    <h2 id="titre" class="text-center m-0">
                        <span class="d-block d-lg-none">
                            <span>Inscription</span>
                            <span class="bi bi-plus"></span>
                        </span>
                        <span class="d-none d-lg-block">Nouvelle inscription</span>
                    </h2>
                </section>
                <hr class="m-0">
                <section class="row">
                    <aside class="col-12 col-lg-3 px-0 px-lg-3">
                        <nav id="scroll-menu-nav" class="navbar navbar-light bg-light position-fixed">
                            <nav class="nav nav-pills flex-row flex-lg-column w-100">
                                <h2 class="d-none d-lg-block">Inscription</h2>
                                <a class="nav-link" href="#about-student">Etudiant</a>
                                <a class="nav-link" href="#more-details">
                                    <span class="d-none d-lg-inline">Parcours</span>
                                    <span class="">
                                        #<span data-watch="nie"></span>
                                    </span>
                                </a>
                                <a class="nav-link ml-lg-3" href="#father-section-header">Père</a>
                                <a class="nav-link ml-lg-3" href="#mother-section-header">Mère</a>
                                <a class="nav-link ml-lg-3" href="#tutor-section-header">Tuteur</a>
                                <a class="nav-link" href="#required-documents-header">
                                    <span>Pièces à fournir - </span>
                                    <span data-watch="NIV_id" class=""></span>
                                </a>
                                <hr class="d-none d-lg-block dropdown-divider">
                                <h6 class="d-none d-lg-block text-capitalize text-muted">évaluation <?= $entretien->favorable() ? "Favorable" : "Défavorable" ?></h6>
                                <div class="border rounded text-center px-4 py-3 ml-auto ml-lg-0">
                                    <?= $entretien->getTotal() ?>/20
                                </div>
                            </nav>
                        </nav>
                    </aside>
                    <aside class="col-12 col-lg-9">
                        <!-- <section class="d-flex bg-secondary p-3 position-fixed" style="z-index: 1025;">
                            <button type="button" onclick="document.querySelectorAll('input').forEach((input) => {input.value = ''});" class="btn btn-secondary">Purge</button>
                            <a href="/Inscription/New/<?= $entretienId ?>" class="btn btn-link">New</a>
                            <button type="button" onclick="document.querySelector('form').submit();" class="btn btn-dark">Kill</button>
                        </section> -->
                        <form action="/Inscription/Create/<?= $entretienId ?>" method="post" id="inscription-form" enctype="multipart/form-data">
                            <div id="accordionId" role="tablist" aria-multiselectable="false" class="py-5">
                                <div class="card border-0">
                                    <article id="about-student">
                                        <div class="card-header border-0" role="tab" id="about-student-section-header">
                                            <h5 class="mb-0">
                                                <button type="button" data-toggle="collapse" data-parent="#accordion" data-target="#about-student-section" aria-expanded="true" aria-controls="about-student-section" class="btn w-100">
                                                    Etudiant
                                                </button>
                                            </h5>
                                        </div>
                                        <article id="about-student-section" class="collapse show in pt-3" role="tabpanel" aria-labelledby="about-student-section-header">
                                            <section class="row">
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group d-flex align-items-center align-items-lg-start flex-column">
                                                        <label for="photo">Photo</label>
                                                        <input type="file" name="photo" id="photo" value="<?= $photo ?>" class="form-control form-control-file border p-1 rounded d-none <?= array_key_exists("photo", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>">
                                                        <figure class="m-0">
                                                            <label for="photo">
                                                                <img id="photo-preview" src="<?= $photo ?>" alt="Photo" class="img-thumbnail" />
                                                            </label>
                                                        </figure>
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-8">
                                                    <section class="row">
                                                        <aside class="col col-md-6 col-lg-3 form-group">
                                                            <label for="sexe">Sexe</label>
                                                            <select name="sexe" id="sexe" class="form-control <?= array_key_exists("sexe", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required>
                                                                <option value="0" <?= $sexe == 0 ? "selected" : "" ?>>Femme</option>
                                                                <option value="1" <?= $sexe == 1 ? "selected" : "" ?>>Homme</option>
                                                            </select>
                                                        </aside>
                                                        <aside class="col-12 col-lg-5">
                                                            <div class="form-group" required>
                                                                <label for="nom">Nom</label>
                                                                <input type="text" name="nom" id="nom" value="<?= $nom ?>" class="form-control <?= array_key_exists("nom", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="Nom" minlength="2" maxlength="35">
                                                            </div>
                                                        </aside>
                                                        <aside class="col-12 col-lg-4">
                                                            <div class="form-group" required>
                                                                <label for="prenom">Prénom</label>
                                                                <input type="text" name="prenom" id="prenom" value="<?= $prenom ?>" class="form-control <?= array_key_exists("prenom", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="Prénom" minlength="2" maxlength="35">
                                                            </div>
                                                        </aside>
                                                        <aside class="col-12 col-lg-6 col-xl-6">
                                                            <div class="form-group" required>
                                                                <label for="datenaiss">Date de naissance</label>
                                                                <input type="date" name="datenaiss" id="datenaiss" value="<?= $datenaiss ?>" class="form-control <?= array_key_exists("datenaiss", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required>
                                                            </div>
                                                        </aside>
                                                        <aside class="col-12 col-lg-6 col-xl-6">
                                                            <div class="form-group" required>
                                                                <label for="lieunaiss">Lieu de naissance</label>
                                                                <input type="text" name="lieunaiss" id="lieunaiss" value="<?= $lieunaiss ?>" class="form-control <?= array_key_exists("lieunaiss", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="Lieu de naissance">
                                                            </div>
                                                        </aside>
                                                        <aside class="col-12 col-lg-12">
                                                            <div class="form-group">
                                                                <label for="NAT_id">Nationalité</label>
                                                                <section class="row">
                                                                    <aside class="col-12 col-lg-6">
                                                                        <div class="form-group">
                                                                            <select name="NAT_id" id="NAT_id" class="form-control <?= array_key_exists("NAT_id", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required data-otherable>
                                                                                <?php foreach ($nats as $nat) { ?>
                                                                                    <option value="<?= $nat->idNAT ?>" <?= $NAT_id == $nat->idNAT ? "selected" : "" ?>><?= $nat->nationalite ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                                <option value="*" <?= $NAT_id == "*" ? "selected" : "" ?>>Autre</option>
                                                                            </select>
                                                                        </div>
                                                                    </aside>
                                                                    <aside class="col-12 col-lg-6">
                                                                        <div class="form-group">
                                                                            <input type="text" name="NAT_other" id="NAT_other" class="form-control" placeholder="Autre nationalité" value="<?= $NAT_other ?>" disabled>
                                                                        </div>
                                                                    </aside>
                                                                </section>
                                                            </div>
                                                        </aside>
                                                    </section>
                                                </aside>
                                                <aside class="col-12 col-lg-12">
                                                    <div class="form-group" required>
                                                        <label for="contacte0">Contact</label>
                                                        <section class="row">
                                                            <aside class="col-12 col-lg-4">
                                                                <div class="form-group">
                                                                    <input type="tel" name="contacte[]" id="contacte0" multiple="multiple" value="<?= $contacte0 ?>" class="form-control <?= array_key_exists("contacte", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="030 00 000 00" data-format-field data-max-length="10">
                                                                </div>
                                                            </aside>
                                                            <aside class="col-12 col-lg-4">
                                                                <div class="form-group">
                                                                    <input type="tel" name="contacte[]" id="contacte1" multiple="multiple" value="<?= $contacte1 ?>" class="form-control" placeholder="030 00 000 00" data-format-field data-max-length="10">
                                                                </div>
                                                            </aside>
                                                            <aside class="col-12 col-lg-4">
                                                                <div class="form-group">
                                                                    <input type="tel" name="contacte[]" id="contacte2" multiple="multiple" value="<?= $contacte2 ?>" class="form-control" placeholder="030 00 000 00" data-format-field data-max-length="10">
                                                                </div>
                                                            </aside>
                                                        </section>
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="adresse">Adresse</label>
                                                        <input type="text" name="adresse" id="adresse" value="<?= $adresse ?>" class="form-control" placeholder="Adresse">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" name="email" id="email" value="<?= $email ?>" class="form-control" placeholder="exemple@email.com">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="fb">Fb</label>
                                                        <input type="url" name="fb" id="fb" value="<?= $fb ?>" class="form-control" placeholder="ex: https://facebook.com/esmia">
                                                    </div>
                                                </aside>
                                            </section>
                                        </article>
                                    </article>
                                    <hr class="">
                                    <article id="more-details">
                                        <div class="card-header border-0" role="tab" id="more-details-section-header">
                                            <h5 class="mb-0">
                                                <button type="button" data-toggle="collapse" data-parent="#accordion" data-target="#more-details-section" aria-expanded="true" aria-controls="more-details-section" class="btn w-100">
                                                    Parcours
                                                </button>
                                            </h5>
                                        </div>
                                        <article id="more-details-section" class="collapse show in pt-3" role="tabpanel" aria-labelledby="more-details-section-header">
                                            <section class="row">
                                                <aside class="col-12 col-lg-4 ml-auto">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" name="nie" id="nie" class="form-control border-0" value="<?= $nie ?>" disabled>
                                                            <div class="input-group-append" data-update-nie>
                                                                <div data-nie-loader class="input-group-text border-0">
                                                                    <span class="spinner spinner-grow spinner-grow-sm"></span>
                                                                </div>
                                                                <button type="button" data-update="nie" class="btn input-group-text border-0">
                                                                    <span class="bi bi-arrow-clockwise"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </aside>
                                            </section>
                                            <section class="row">
                                                <aside class="col-12 col-lg-2 col-xl-2">
                                                    <div class="form-group">
                                                        <label for="AB_id">Année du bacc</label>
                                                        <select name="AB_id" id="AB_id" class="form-control <?= array_key_exists("AB_id", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required>
                                                            <?php foreach ($abs as $ab) { ?>
                                                                <option value="<?= $ab->idAB ?>" <?= $AB_id == $ab->idAB ? "selected" : "" ?>>
                                                                    <?= $ab->annee ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="SB_id">Série</label>
                                                        <div class="input-group">
                                                            <select name="SB_id" id="SB_id" class="form-control pr-0 col-5 col-lg-4 <?= array_key_exists("SB_id", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required data-otherable>
                                                                <?php foreach ($sbs as $sb) { ?>
                                                                    <option value="<?= $sb->idSB ?>" <?= $SB_id == $sb->idSB ? "selected" : "" ?>>
                                                                        <?= $sb->serie ?>
                                                                    </option>
                                                                <?php } ?>
                                                                <option value="*" <?= $SB_id == "*" ? "selected" : "" ?>>Autre</option>
                                                            </select>
                                                            <input type="text" name="SB_other" id="SB_other" class="form-control col-7 col-lg-8" placeholder="Autre série" value="<?= $SB_other ?>" disabled>
                                                        </div>
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-3">
                                                    <div class="form-group">
                                                        <label for="MB_id">Mention</label>
                                                        <select name="MB_id" id="MB_id" class="form-control <?= array_key_exists("MB_id", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required>
                                                            <?php foreach ($mbs as $mb) { ?>
                                                                <option value="<?= $mb->idMB ?>" <?= $MB_id == $mb->idMB ? "selected" : "" ?>>
                                                                    <?= $mb->mention ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </aside>
                                            </section>
                                            <section class="row">
                                                <aside class="col-4 col-lg-4 col-xl-2">
                                                    <div class="form-group">
                                                        <label for="session">Session</label>
                                                        <select name="session" id="session" class="form-control" required>
                                                            <?php foreach ($sessions as $s) { ?>
                                                                <option value="<?= $s ?>" <?= $session == $s ? "selected" : "" ?>>
                                                                    <?= $s ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </aside>
                                                <aside class="col-8 col-lg-3 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="AU_id">Année universitaire</label>
                                                        <select data-submitter="Gp" name="AU_id" id="AU_id" class="form-control <?= array_key_exists("AU_id", $inscription->invalidAttributes) ? 'is-invalid' : '' ?>" required>
                                                            <?php foreach ($au as $year) { ?>
                                                                <option value="<?= $year['idAU'] ?>" <?= $year['idAU'] == $AU_id ? "selected" : ""; ?>><?= $year['nom_au'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </aside>
                                                <aside class="col-6 col-lg-3 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="NIV_id">Niveau</label>
                                                        <select data-submitter="Gp:Document" name="NIV_id" id="NIV_id" class="form-control <?= array_key_exists("NIV_id", $inscription->invalidAttributes) ? 'is-invalid' : '' ?>" required>
                                                            <?php foreach ($niv as $level) { ?>
                                                                <option value="<?= $level['idNIV'] ?>" <?= $level['idNIV'] == $NIV_id ? "selected" : ""; ?>>
                                                                    <?= $level['nom_niv'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </aside>
                                                <aside class="col-6 col-lg-3 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="GP_id">Filière</label>
                                                        <select name="GP_id" id="GP_id" class="form-control <?= array_key_exists("GP_id", $inscription->invalidAttributes) ? 'is-invalid' : '' ?>" required>
                                                            <?php foreach ($gps as $field) { ?>
                                                                <option value="<?= $field->idGP ?>" <?= $GP_id == $field->idGP ? "selected" : "" ?>>
                                                                    <?= $field->nom_gp ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="REC_id">Recruteur</label>
                                                        <select name="REC_id" id="REC_id" class="form-control <?= array_key_exists("REC_id", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required data-otherable>
                                                            <?php foreach ($recs as $rec) { ?>
                                                                <option value="<?= $rec->idREC ?>" <?= $REC_id == $rec->idREC ? "selected" : "" ?>>
                                                                    <?= $rec->getFullName() ?></option>
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
                                        </article>
                                    </article>
                                    <hr class="">
                                    <article id="parents">
                                        <div class="card-header border-0" role="tab" id="father-section-header">
                                            <h5 class="mb-0">
                                                <button type="button" data-toggle="collapse" data-parent="#accordion" data-target="#father-section" aria-expanded="true" aria-controls="father-section" class="btn w-100">
                                                    Père
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="father-section" class="collapse show in pt-3" role="tabpanel" aria-labelledby="father-section-header">
                                            <section class="row">
                                                <aside class="col-12 col-lg-6">
                                                    <div class="form-group" required>
                                                        <label for="nom_p" class="">
                                                            <span class="">Nom et prénom du père</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="text" name="nom_p" id="nom_p" value="<?= $nom_p ?>" class="form-control <?= array_key_exists("nom_p", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="Nom">
                                                            <input type="text" name="prenom_p" id="prenom_p" value="<?= $prenom_p ?>" class="form-control <?= array_key_exists("prenom_p", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="Prénom">
                                                        </div>
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4 col-xl-3 ">
                                                    <div class="form-group" required>
                                                        <label for="contacte_p">Son contact</label>
                                                        <input type="tel" name="contacte_p" id="contacte_p" value="<?= $contacte_p ?>" class="form-control <?= array_key_exists("contacte_p", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="030 00 000 00" data-format-field data-max-length="10">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-6 col-xl-3">
                                                    <div class="form-group">
                                                        <label for="email_p">Son email</label>
                                                        <input type="email" name="email_p" id="email_p" value="<?= $email_p ?>" class="form-control" placeholder="exemple@email.com">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="adresse_p">Son adresse</label>
                                                        <input type="text" name="adresse_p" id="adresse_p" value="<?= $adresse_p ?>" class="form-control" placeholder="Adresse du père">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="profession_p">Sa profession</label>
                                                        <input type="text" name="profession_p" id="profession_p" value="<?= $profession_p ?>" class="form-control" placeholder="Profession du père">
                                                    </div>
                                                </aside>
                                            </section>
                                        </div>
                                        <hr class="">
                                        <div class="card-header border-0" role="tab" id="mother-section-header">
                                            <h5 class="mb-0">
                                                <button type="button" data-toggle="collapse" data-parent="#accordion" data-target="#mother-section" aria-expanded="true" aria-controls="mother-section" class="btn w-100">
                                                    Mère
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="mother-section" class="collapse show in pt-3" role="tabpanel" aria-labelledby="mother-section-header">
                                            <section class="row">
                                                <aside class="col-12 col-lg-6">
                                                    <div class="form-group" required>
                                                        <label for="nom_m" class="">
                                                            <span class="">Nom et prénom de la mère</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="text" name="nom_m" id="nom_m" value="<?= $nom_m ?>" class="form-control <?= array_key_exists("nom_p", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="Nom de la mère">
                                                            <input type="text" name="prenom_m" id="prenom_m" value="<?= $prenom_m ?>" class="form-control <?= array_key_exists("prenom_p", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="Prénom de la mère">
                                                        </div>
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4 col-xl-3">
                                                    <div class="form-group" required>
                                                        <label for="contacte_m">Son contact</label>
                                                        <input type="tel" name="contacte_m" id="contacte_m" value="<?= $contacte_m ?>" class="form-control <?= array_key_exists("contacte_p", $etudiant->invalidAttributes) ? 'is-invalid' : '' ?>" required placeholder="030 00 000 00" data-format-field data-max-length="10">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-6 col-xl-3">
                                                    <div class="form-group">
                                                        <label for="email_m">Son email</label>
                                                        <input type="email" name="email_m" id="email_m" value="<?= $email_m ?>" class="form-control" placeholder="exemple@email.com">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="adresse_m">Son adresse</label>
                                                        <input type="text" name="adresse_m" id="adresse_m" value="<?= $adresse_m ?>" class="form-control" placeholder="Adresse de la mère">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="profession_m">Sa profession</label>
                                                        <input type="text" name="profession_m" id="profession_m" value="<?= $profession_m ?>" class="form-control" placeholder="Profession de la mère">
                                                    </div>
                                                </aside>
                                            </section>
                                        </div>
                                        <hr class="">
                                        <div class="card-header border-0" role="tab" id="tutor-section-header">
                                            <h5 class="mb-0">
                                                <button type="button" data-toggle="collapse" data-parent="#accordion" data-target="#tutor-section" aria-expanded="false" aria-controls="tutor-section" class="btn w-100">
                                                    Tuteur
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="tutor-section" class="collapse show in pt-3" role="tabpanel" aria-labelledby="tutor-section-header">
                                            <section class="row">
                                                <aside class="col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="nom_t" class="">
                                                            <span class="">Nom et prénom du tuteur</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="text" name="nom_t" id="nom_t" value="<?= $nom_t ?>" class="form-control" placeholder="Nom du tuteur">
                                                            <input type="text" name="prenom_t" id="prenom_t" value="<?= $prenom_t ?>" class="form-control" placeholder="Prénom du tuteur">
                                                        </div>
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="email_t">Son email</label>
                                                        <input type="email" name="email_t" id="email_t" value="<?= $email_t ?>" class="form-control" placeholder="example@email.com">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="contacte_t">Son contact</label>
                                                        <input type="tel" name="contacte_t" id="contacte_t" value="<?= $contacte_t ?>" class="form-control" placeholder="030 00 000 00" maxlength="10">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="adresse_t">Son adresse</label>
                                                        <input type="text" name="adresse_t" id="adresse_t" value="<?= $adresse_t ?>" class="form-control" placeholder="Adresse du tuteur">
                                                    </div>
                                                </aside>
                                                <aside class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="profession_t">Sa profession</label>
                                                        <input type="text" name="profession_t" id="profession_t" value="<?= $profession_t ?>" class="form-control" placeholder="Profession du tuteur">
                                                    </div>
                                                </aside>
                                            </section>
                                        </div>
                                    </article>
                                    <hr class="">
                                    <div class="card-header border-0" role="tab" id="required-documents-header">
                                        <h5 class="mb-0">
                                            <button type="button" data-toggle="collapse" data-parent="#accordion" data-target="#required-documents" aria-expanded="true" aria-controls="required-documents" class="btn w-100">
                                                Pièces à fournir
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="required-documents" class="collapse show in pt-3" role="tabpanel" aria-labelledby="required-documents-header">
                                        <input type="hidden" name="list_dossier_watcher" id="list_dossier_watcher" class="form-control disabled" disabled data-watch="list_dossiers[ids][]">
                                        <section id="required-documents-list" class="row m-0">
                                            <?php if (count($dossiers)) { ?>
                                                <?php foreach ($dossiers as $dossier) { ?>
                                                    <aside class="dossier-template col-12 col-lg-12">
                                                        <div class="form-group form-check">
                                                            <input type="checkbox" name="list_dossiers[ids][]" id="dossier<?= $dossier->idDOS ?>" value="<?= $dossier->idDOS ?>" <?= in_array($dossier->idDOS, $list_dossiers["ids"]) ? "checked" : "" ?> multiple="true" class="form-check-input">
                                                            <label for="dossier<?= $dossier->idDOS ?>" class="form-check-label"><?= $dossier->nom_dos ?></label>
                                                        </div>
                                                    </aside>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <aside class="col-12">
                                                    <h6 class="text-center text-muted">Aucune pièce à fournir n'a été trouvé</h6>
                                                </aside>
                                            <?php } ?>
                                        </section>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="floating-btn bi bi-save btn btn-success rounded-circle">
                            </button>
                        </form>
                    </aside>
                </section>
            </div>
        </aside>
    </section>
</main>