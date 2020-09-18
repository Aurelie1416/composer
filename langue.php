<?php
// permet de récupérer les packages via composer
require_once 'vendor/autoload.php'; //cette unclusion doit toujours être la première

use Stichoza\GoogleTranslate\GoogleTranslate;
if(!empty($_POST)){
    if(isset($_POST['mess']) && !empty($_POST['mess']))
    {
        $mess = strip_tags($_POST['mess']); //retire les balises html et php
        if(isset($_POST['langue']) && !empty($_POST['langue'])){
            $langue = strip_tags($_POST['langue']);
        }
        else{
            $langue = 'en';
        }

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $tr->setSource('fr'); // langue source
        $tr->setSource(); // Detect language automatically
        $tr->setTarget($langue); 
        $messagetranslate = $tr->translate($mess);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Traduire</h1>
    <div class="soulign">
        <div class="cercle"></div>
        <div class="cercle"></div>
        <div class="cercle"></div>
    </div>
    <form method="POST">
        <div class="col-auto">
            <label for="inlineFormInput">Message</label>
            <textarea name="mess" class="form-control mb-2" id="inlineFormInput"><?= (isset($mess)) ? $mess : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Sélectionner votre langue</label>
            <select class="form-control" id="exampleFormControlSelect1" name="langue">
                <option value="de">Allemand</option>
                <option value="en">Anglais</option>
                <option value="ar">Arabe</option>
                <option value="zh">Chinois</option>
                <option value="es">Espagnol</option>
                <option value="fi">Finnois</option>
                <option value="fr">Français</option>
                <option value="it">Italien</option>
                <option value="ja">Japonais</option>
                <option value="no">Norvegien</option>
                <option value="ru">Russe</option>
                <option value="vi">Vietnamien</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-info mb-2">Traduire</button>
        </div>
    </form>

    <?php if(isset($messagetranslate) && !empty($messagetranslate)) : ?>
    <p><?= $messagetranslate ?></p>
    <?php
    endif;
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>