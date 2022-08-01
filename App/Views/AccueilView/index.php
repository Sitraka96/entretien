<div id="home">
<?php $type=$_SESSION['type'] ?>
    <img id="logo" data-aos="zoom-out" data-aos-duration="2000" src="assets/images/logo-rond.png">
    <div id="ctitre" data-aos="zoom-out" data-aos-duration="2000">
        <h1>Ecole Supérieure de Management et d'Informatique Appliquée</h1>
    </div>
    <div data-aos="fade-up" data-aos-duration="1500">
        <h4>Liberté - Magnanimité - Service</h4>
        
    </div>
</div>
<div id="menu" data-aos="fade-up" data-aos-duration="2500" >
    <?php if ($type !=='guest') { ?>
    <a href="/Inscription" class="menu-item">
        <span>INSCRIPTION</span>
        <div class="cimg">
            <svg><use xlink:href="/assets/svg/menu.svg#register"></svg>
        </div>
    </a>
    <?php } ?>
    <a href="/Etudiant/Listes" class="menu-item" >
        <span>LISTE DES ÉTUDIANTS</span>
        <div class="cimg">
        <svg><use xlink:href="/assets/svg/menu.svg#users"></svg>
        </div>
    </a>
    <?php if ($type !=='guest' && $type !=='job_etudiant') { ?>
    <a href="/Export" class="menu-item">
        <span>EXPORTATION DES DONNÉES</span>
        <div class="cimg">
        <svg><use xlink:href="/assets/svg/menu.svg#download"></svg>
        </div>
    </a>
    <?php } 
    if ($type !=='guest' && $type!=='job_etudiant' && $type!=='standard') { ?>
    <a href="/Utilisateurs" class="menu-item">
        <span>GESTION DES COMPTES</span>
        <div class="cimg">
        <svg><use xlink:href="/assets/svg/menu.svg#users-setting"></svg>
        </div>
    </a>
    <?php } ?>
    
</div>