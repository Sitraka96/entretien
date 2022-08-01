<article id="history" class="overflow-hidden">
    <section class="row">
        <aside class="col-11 col-sm-11 col-md-10 col-lg-10 col-xl-10 mx-auto">
            <section class="d-flex flex-row flex-lg-row justify-content-between align-items-center">
                <a href="/Entretien" class="btn-link">
                    <i class="bi bi-arrow-left mr-2"></i>Revenir à l'accueil
                </a>
                <h2 id="titre" class="text-center m-0">
                    <span class="d-block d-lg-none">
                        <span class="bi bi-clock-history"></span>
                    </span>
                    <span class="d-none d-lg-block">
                        Historique
                        <span class="bi bi-clock-history"></span>
                    </span>
                </h2>
            </section>
            <hr class="mt-0">
            <?php if (count($history)) { ?>
                <ul class="timeline">
                    <?php foreach ($history as $key => $event) { ?>
                        <li data-id="<?= $event['id'] ?>" data-action="<?= $event['action'] ?>" class="timeline-li <?= $key % 2 ? 'timeline-inverted' : '' ?>">
                            <div class="timeline-badge">
                                <a><i class="bi bi-circle-fill <?= $key % 2 ? 'invert' : '' ?>"></i></a>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h5 class="mt-2">
                                        <a href="/<?= $event["subject_type"] ?>/Show/<?= $event["subject_id"] ?>" target="_blank" class="">
                                            <?= $event["title"] ?>
                                        </a>
                                    </h5>
                                </div>
                                <div class="card-body timeline-body px-0 pb-0">
                                    <?php switch ($event["action"]) {
                                        case 'UPDATE': ?>
                                            <?php if (count($event["changes"])) { ?>
                                                <ul class="list-group list-unstyled bg-dark text-white">
                                                    <?php foreach ($event["changes"] as $key => $change) { ?>
                                                        <li class="history-change">
                                                            <ul class="list-unstyled">
                                                                <?php foreach ($change as $changeKey => $changeValue) { ?>
                                                                    <li>
                                                                        <label for="<?= $changeKey ?>" class="">
                                                                            <?= $changeValue->name ?> :
                                                                        </label>
                                                                        <code>
                                                                            <q><?= $changeValue->old ?></q>
                                                                            <span>=></span>
                                                                            <q><?= $changeValue->new ?></q>
                                                                        </code>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } else { ?>
                                                <h6 class="text-muted px-3">Aucune modification</h6>
                                            <?php } ?>
                                            <?php break; ?>
                                        <?php
                                        default: ?>
                                            <? # $event["action"]
                                            ?>
                                    <?php break;
                                    } ?>
                                </div>
                                <div class="timeline-footer text-muted">
                                    <p class="text-right">
                                        <?= $event["created_at"]->format("d M Y à H:i") ?>
                                        #<?= $event["id"] ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                    <li class="clearfix no-float"></li>
                </ul>
            <?php } else { ?>
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12 text-center">
                                <figure class="mb-4" style="font-size: 100px;">
                                    <span class="img-fluid bi bi-newspaper"></span>
                                </figure>
                                <h3><strong>Votre historique est vide</strong></h3>
                                <h4>Veuillez revenir plutard :)</h4>
                                <section class="d-flex justify-content-center my-4">
                                    <button type="button" class="btn btn-secondary" onclick="history.back()">
                                        <span class="bi bi-arrow-90deg-left"></span>
                                        <span class="d-none d-lg-inline-block">Retour</span>
                                    </button>
                                    <button type="button" class="btn btn-primary ml-5 ml-lg-5" onclick="window.location.href += ''">
                                        <span class="bi bi-arrow-clockwise"></span>
                                        <span class="d-none d-lg-inline-block">Actualiser</span>
                                    </button>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </aside>
    </section>
</article>