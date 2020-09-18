<?php
require_once 'vendor/autoload.php'; //cette unclusion doit toujours être la première
require_once 'include/config-mail.php';

// Verified!// on vérifie que POST n'est pas vide
if(!empty($_POST)){

    // possible ici aussi, ici la logique est que ce n'est pas la peine de vérifier les champs si le recaptcha est invalide

    // POST n'est pas vide on vérifie tous les champs
    if(
        isset($_POST['email']) && !empty($_POST['email'])
        && isset($_POST['mess']) && !empty($_POST['mess'])
        && isset($_POST['firstname']) && !empty($_POST['firstname'])
        && isset($_POST['name']) && !empty($_POST['name'])
    ){

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            die('email invalide');
        }

        // la logique ici est de vérifier que les champs sont valides puis de vérifier le captcha 
        $recaptcha = new \ReCaptcha\ReCaptcha('6LcMWsoZAAAAANYm4lxAutURxjuYVB8spdHmdg2G');
        // en local puisque serveur et client sont sur le même ordi, cette variable retournera 127.0.0.1
        // on peut autoriser un nom de domaine directement dans la methodesetExpectedHostname() ici localhost  
        $resp = $recaptcha->setExpectedHostname('localhost')
                          ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        // $_SERVER['REMOTE ADDR] me permet d'obtenir l'adresse IP de l'internaute
        // $_POST['g-recaptcha-response'] contient le résultat du captcha

        $nom = htmlspecialchars($_POST['name']);
        $prenom = htmlspecialchars($_POST['firstname']);
        $email = htmlspecialchars($_POST['email']);
        $mess = htmlspecialchars($_POST['mess']);

        if ($resp->isSuccess()) {
            try{
                // on définit l'expéditeur du mail
                $sendmail->setFrom('moi@me.fr', 'Mon super site');

                // on définit le ou les destinataires
                $sendmail->addAddress($email, $nom);

                // on définit le sujet du mail
                $sendmail->Subject = "Message";

                // on active le HTML
                $sendmail->isHTML();

                // on écrit le contenu du mail en HTML
                $sendmail->Body = "<p>$nom, $mess</p>";
        
                // en texte brut
                $sendmail->AltBody = "$nom, $mess";

                // on envoi le mail
                $sendmail->send();
            }
            catch(Exception $e){
                // ici le mail n'est pas parti
                echo 'Erreur: '. $e->errorMessage();
            }
        }
        else {
            $errors = $resp->getErrorCodes();
            echo "Vous ne pouvez pas avoir accés au site";
        } 
    }
    else{
        // au moins un champ est invalide
        echo "Error ! Vous n'avez pas remplis le formulaire";
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <h1>Contactez vos amis !</h1>
    <div class="soulign">
        <div class="cercle"></div>
        <div class="cercle"></div>
        <div class="cercle"></div>
    </div>
    <form method="POST">
        <div class="col-auto">
            <label for="inlineFormInput">Nom</label>
            <input type="text" class="form-control mb-2" id="inlineFormInput" name="name">
        </div>
        <div class="col-auto">
            <label for="inlineFormInput">Prenom</label>
            <input type="text" class="form-control mb-2" id="inlineFormInput" name="firstname">
        </div>
        <div class="col-auto">
            <label for="inlineFormInputGroupUsername">Email</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
                <input type="text" class="form-control mb-2" id="inlineFormInputGroupUsername" name="email">
            </div>
        </div>
        <div class="col-auto">
            <label for="inlineFormInput">Message</label>
            <textarea name="mess" class="form-control mb-2" id="inlineFormInput"></textarea>
        </div>
        <div class="g-recaptcha" data-sitekey="6LcMWsoZAAAAAOPtbSYcz5dUqEQ8yZFSVbqveXtf"></div>
        <div class="col-auto">
            <button type="submit" class="btn btn-info mb-2">Envoyer</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>