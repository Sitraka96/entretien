<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="<?php getIcon('favicon.png'); ?>">
    <?php if(App\Core\Conf::online==1){ ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>   
    <?php }else { ?>
    <script src='/assets/js/jquery.min.js' ></script>
    <script src='/assets/js/popper.min.js' ></script>
    <script src='/assets/js/bootstrap.min.js' ></script>
    <?php } 
        if (isset($js)) { JS($js); } 
        $font=(App\Core\Conf::online==1)?'https://fonts.googleapis.com/css?family=Karla':'/assets/css/myfont.css';
    ?>
    <link href="<?= $font ?>" rel="stylesheet">
    <link rel='stylesheet' href='/assets/css/style.min.css'>
    <link rel='stylesheet' href='/assets/css/bootstrap-icons.css'>
    <?php if (isset($css)) { CSS($css);} ?>
    <title><?= $title; ?></title>
    
</head>
<body>



