<!DOCTYPE html>
<html lang="en">
<?php include 'config.php' ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href=<?=$URLStaticFiles?>vendors/bootstrap/css/bootstrap.min.css>
    <link rel="stylesheet" href=<?=$URLStaticFiles?>css/style.css>
    <link rel="stylesheet" href=<?=$URLStaticFiles?>css/responsive.css>
    <link rel="stylesheet" href=<?=$URLStaticFiles?>css/animation.css>
    <script src="https://kit.fontawesome.com/0c87a70838.js"></script>
</head>
<body>
    <header>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img class ="logo"src=<?=$URLStaticFiles?>images/logo.png></a>
            <div class ="d-md-none mobile" data-toggle="collapse" data-target="#navbarResponsive">
                <div class = 'bg-dark line1' data-toggle="collapse" data-target="#navbarResponsive"></div>
                <div class = 'bg-dark line2' data-toggle="collapse" data-target="#navbarResponsive"></div>
                <div class = 'bg-dark line3' data-toggle="collapse" data-target="#navbarResponsive"></div>

            </div>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Account">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Compare">Compare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Notifs"><img class ="cloche" src=<?=$URLStaticFiles.cloche(); ?>></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </header>
    <section class="pageNotif">
        <div class = "touteLesNotifs">
            <?php afficherNotifs(); ?>
            <div class="infoNotifs">
                <h6>page:</h6>
                <p class = "numPage"> <?php wichPage(); ?> </p>
                <div class = "previousnext">
                    <div class="infoNotifButton pageMoins" name="pageMoins"><h6>Previous Page</h6></div>
                    <div class="infoNotifButton pagePlus"  name="pagePlus"><h6>Next page</h6></div>
                </div>
                <div type ="submit" class="infoNotifButton pageReset"  name="pageReset"><h6>Return Page 1</h6></div>
            </div>
        </div>
    </section>
    <script type='text/javascript' src=<?=$URLStaticFiles?>vendors/jquery/jquery-ui.min.js></script>
    <script type='text/javascript' src=<?=$URLStaticFiles?>js/notifs.js></script>
    <script type='text/javascript' src=<?=$URLStaticFiles?>js/script.js></script>
</body>
</html>