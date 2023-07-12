<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My first App MVC</title>
    <link rel="stylesheet" href="/styles/main.css"> <!--à mettre après l'import de bootstrap car BS reset certaines propriétés-->
</head>

<body>
    <? include_once "Layout/header.php"; ?>
    <main>
        <?php include_once "Layout/messages.php"; ?>
        <?= $contenu; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="/js/switchActifArticle.js" defer></script>  <!--defer -> ne bloque pas l'affichage de la page-->
    <script src="/js/inputImage.js" defer></script>
</body>

</html>