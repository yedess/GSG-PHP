<?php
session_start();
date_default_timezone_set('Europe/Paris');
include('/functions.php');
$user = $_SESSION['USER'];
$tothf = 0;
$etp = 0;
$etape = 0;
$kilo = 0;
$km = 0;
$nuite = 0;
$nui = 0;
$repas = 0;
$rep = 0;
$query = "SELECT * FROM visiteur WHERE login = '$user'";
$sth = $conn->prepare($query);
$sth->execute();
$result = $sth->fetchAll();

$query1 = "SELECT * FROM fichefrais F JOIN visiteur V ON F.idVisiteur = V.id WHERE V.login = '$user' AND F.idEtat = 'CR'";
$sth1 = $conn->prepare($query1);
$sth1->execute();
$result1 = $sth1->fetchAll();

$query3 = "SELECT * FROM fraisforfait";
$sth3 = $conn->prepare($query3);
$sth3->execute();
$result3 = $sth3->fetchAll();

foreach ($result3 as $frai => $frais) {
    switch ($frais['id']) {
        case 'ETP':
            $etape = $frais['montant'];
            break;
        case 'ETP':
            $km = $frais['montant'];
            break;
        case 'ETP':
            $nuite = $frais['montant'];
            break;
        case 'ETP':
            $repas = $frais['montant'];
            break;
    }
}

$query2 = "SELECT * FROM visiteur V JOIN  lignefraisforfait LF ON LF.idVisiteur = V.id WHERE V.login = '$user'";
$sth2 = $conn->prepare($query2);
$sth2->execute();
$result2 = $sth2->fetchAll();
foreach ($result2 as $users => $userligne) {
    switch ($userligne['idFraisForfait']) {
        case 'ETP':
            $etp = $userligne['quantite'];
            break;
        case 'ETP':
            $kilo = $userligne['quantite'];
            break;
        case 'ETP':
            $nui = $userligne['quantite'];
            break;
        case 'ETP':
            $rep = $userligne['quantite'];
            break;
    }
}

$query4 = "SELECT * FROM visiteur V JOIN  lignefraishorsforfait LF ON LF.idVisiteur = V.id WHERE V.login = '$user'";
$sth4 = $conn->prepare($query4);
$sth4->execute();
$result4 = $sth4->fetchAll();
foreach ($result4 as $montants => $hf) {
    $tothf = $tothf + $hf['montant'];
}

$total_frais = ($etp * $etape + $kilo * $km + $nuite * $nui + $repas * $rep) + $tothf;

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;
?>
<!DOCTYPE html>
<html>

<head>
    <title>PROFIL</title>
    <link href='home.css' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/angular_material/0.8.3/angular-material.min.css">
</head>

<body>
    <div class="container">
        <div class="main-body">
            <div class="headrow gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body header-card">
                            <?php
                            foreach ($result as $row => $user) { ?>
                                <div class='rounded-circle-right'>
                                    <div class='param' onclick="moreinfo()">
                                        <i class="bi bi-gear-fill"></i>
                                    </div>
                                    <img id='pfp' src="./images/profil/<?php echo $user['portrait'] ?>" alt="Admin" class="rounded-circle" width="150">
                                </div>
                                <div id='usr-info' class="user-info card">
                                    <img src="./images/profil/<?php echo $user['portrait'] ?>" alt="Admin" class="rounded-circle" width="150">
                                    <h4><?php echo $_SESSION['USER']; ?></h4>
                                    <?php if ($user['comptable'] == 0) { ?>
                                        <p>Visiteur</p>
                                    <?php } else { ?>
                                        <p>Comptable</p>
                                    <?php } ?>
                                    <p class="email"><?php echo $user['email'] ?></p>
                                    <button class="deco"><a href="logout.php">Déconnexion</a></button>
                                </div>
                                <?php if (is_null($user['portrait'])) { ?>
                                    <img src="images/pfp.png" alt="Admin" class="rounded-circle" width="150">
                                    <?php} else {?>
                                    <img src="/PPE/images/profil/<?php echo $user['portrait'] ?>" alt="Admin" class="rounded-circle rounded-circle-right" width="150">
                            <?php
                                }
                            } ?>
                            <div class="rounded-circle-left">
                                <img src="images/logo.png" alt="Admin" width="150">
                                <h3>GSB FRAIS</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='body-container'>
                <div class="main-menu card">
                    <ul class="menu">
                        <li class="menu-item-normal"><a href="home.php"><i class="bi bi-pencil-square"></i>Saisie FicheFrais</a></li>
                        <li class="menu-item-normal"><a href="home-ligne.php"><i class="bi bi-pencil-square"></i>Saisie ligne Frais</a></li>
                        <li class="menu-item-normal"><a href="home-horsforfait.php"><i class="bi bi-pencil-square"></i>Saisie Frais Hors Forfait</a></li>
                        <li class="menu-item-active"><a href="home-validation.php"><i class="bi bi-file-earmark-check"></i>Validation Fiches</a></li>
                        <li class="menu-item-normal"><a href="consulterfrais.php"><i class="bi bi-file-earmark-spreadsheet-fill"></i>Consulter Frais</a></li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="titre">
                                    <h1>VALIDATION FICHES</h1>
                                    <?php
                                    if ($_GET) {
                                        echo $_GET['feedback'];
                                    } ?>
                                </div>
                                <form class='input-form' method="POST" action="fichefrais.php">
                                    <div class='group'>
                                        <label>Mois :</label>
                                        <select name="mois">
                                            <option disabled selected value> -- Mois -- </option>
                                            <?php foreach ($result1 as $row1 => $month) {
                                                switch ($month['mois']) {
                                                    case 1:
                                                        $moislib = 'JANVIER';
                                                        break;
                                                    case 2:
                                                        $moislib = 'FEVRIER';
                                                        break;
                                                    case 3:
                                                        $moislib = 'MARS';
                                                        break;
                                                    case 4:
                                                        $moislib = 'AVRIL';
                                                        break;
                                                    case 5:
                                                        $moislib = 'MAI';
                                                        break;
                                                    case 6:
                                                        $moislib = 'JUIN';
                                                        break;
                                                    case 7:
                                                        $moislib = 'JUILLET';
                                                        break;
                                                    case 8:
                                                        $moislib = 'AOÛT';
                                                        break;
                                                    case 9:
                                                        $moislib = 'SEPTEMBRE';
                                                        break;
                                                    case 10:
                                                        $moislib = 'OCTOBRE';
                                                        break;
                                                    case 11:
                                                        $moislib = 'NOVEMBRE';
                                                        break;
                                                    case 12:
                                                        $moislib = 'DECEMBRE';
                                                        break;
                                                } ?>
                                                <option value="<?php echo $month['mois'] ?>"> <?php echo $moislib ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class='group'>
                                        <label>MontantValide :</label>
                                        <input value='<?= $total_frais ?>' class="inputs" type="text" name="mtnval" readonly>
                                    </div>
                                    <div class='group'>
                                        <label>Date de modification :</label>
                                        <input value="<?php echo $today; ?>" class="inputs" type="date" name="datemodif">
                                    </div>
                                    <div class='group'>
                                        <label>Etat de la fiche :</label>
                                        <select name="etat" required>
                                            <option disabled selected value> -- Etat -- </option>
                                            <option value="CR">Fiche créée, saisie en cours</option>
                                            <option value="CL">Saisie clôturée</option>
                                            <option value="RB">Remboursé</option>
                                            <option value="VA">Validé et mise en paiement</option>
                                        </select>
                                    </div>
                                    <input class='valider' name="login" type="submit" value="Valider">
                                </form>
                                <!-- <h3 class="radio-title" style="text-decoration: underline;">Situation</h3>
							<label class="radio-label">Enregistré</label><input class="inputs" type="radio" name="situation" checked>
							<label class="radio-label">Remboursé</label><input class="inputs" type="radio" name="situation">
							<label class="radio-label">Validé</label><input class="inputs" type="radio" name="situation"> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>
<script>
    $(function() {
        $('li').css('cursor', 'pointer')

            .click(function() {
                window.location = $('a', this).attr('href');
                return false;
            });
    });

    function moreinfo() {
        var x = document.getElementById("usr-info");
        if (x.style.display && x.style.display !== "none") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }
</script>

</html>