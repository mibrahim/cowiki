<?php
function show($variable)
{
    global $Page;
    if (isset($Page[$variable])) echo $Page[$variable];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php show('title') ?>
    <style>
        .ahover:hover {
            background-color: #EEEEFF;
            border-radius: 5px;
        }
    </style>
</head>

<body style='height: 100vh;'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script type="text/javascript" src='https://cdn.tiny.cloud/1/91s8q8hbv0sopgjdkp3xitronizi2ayrccnbd72wmj4mz7w9/tinymce/5/tinymce.min.js' referrerpolicy="origin">
    </script>
    <script type="text/javascript" src='inc/jscripts.js'></script>

    <div class='container-fluid'>
        <div class='row'>
            <div class='col-2 border border-light'>
                <?php show('leftnav'); ?>
            </div>
            <div class='col-10'>
                <form method='post'>
                    <div class="text-center p-1">
                        <?php show('buttons'); ?>
                    </div>
                    <?php show('pageheading'); ?>
                    <div id="basic-conf"><?php show('content'); ?></div>
                    <div><?php show('extracontent'); ?></div>
                </form>
            </div>
        </div>

        <div class='row'>
            <div class='col-12'>
                <br /><br />
                <hr />
                <div class="card">
                    <div class="card-header text-danger">
                        <b> <i class="fas fa-spider"></i> Debug info</b>
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDebug" aria-expanded="false" aria-controls="collapseDebug">Show debug info</button>
                    </div>
                    <div class="collapse" id="collapseDebug">
                        <div class="card-body" style='font-size:0.8em;'>
                            <h5 class="card-title">SQL statements</h5>
                            <tt><?php show('debug'); ?></tt>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>