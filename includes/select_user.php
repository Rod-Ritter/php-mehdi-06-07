<?php

require('inc/pdo.php');
require('inc/function.php');
$title = "Ajouter une bière";
// Traitement PHP
// Formulaire est soumis ???
$success = false;
$errors = array();
if(!empty($_POST['submitted'])) {
    // Faille XSS


    $title = cleanXss('title');
    $content = trim(strip_tags($_POST['content']));
    $mail = trim(strip_tags($_POST['mail']));
    // Validation
    $errors = validText($errors,$title,'title',3,100);
    $errors = validText($errors,$content,'content',10,1000);
    $errors = validEmail($errors, $mail, 'mail');
    // validation de mail
//    if(!empty($mail)) {
//        // if email is valid
//        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
//            $errors['mail'] = 'Veuillez renseigner un email valide';
//        }
//    } else {
//        $errors['mail'] = 'Veuillez renseigner un email';
//    }

    if(count($errors) === 0) {
        // insertion en BDD si aucune error
        $sql = "INSERT INTO beer (title,content,email,created_at) VALUES (:title,:content,:mail,NOW())";
        $query = $pdo->prepare($sql);
        // ATTENTION INJECTION SQL
        $query->bindValue(':title',$title, PDO::PARAM_STR);
        $query->bindValue(':content',$content, PDO::PARAM_STR);
        $query->bindValue(':mail',$mail, PDO::PARAM_STR);
        $query->execute();
        $last_id = $pdo->lastInsertId();
        header('Location: detail-beer.php?id=' . $last_id);
//        $success = true;
    }

//    if(!empty($title)) {
//        if(mb_strlen($title) < 3) {
//            $errors['title'] = 'min 3 caractères';
//        } elseif(mb_strlen($title) >= 100) {
//            $errors['title'] = 'max 100 caractères';
//        } else {
//            // pas d'erreur sur ce champ title
//        }
//    } else{
//        $errors['title'] = 'Veuillez renseigner ce champ';
//    }

    // Validation content
//    if(!empty($content)) {
//        if(mb_strlen($content) < 10) {
//            $errors['content'] = 'min 10 caractères';
//        } elseif(mb_strlen($content) >= 1000) {
//            $errors['content'] = 'max 1000 caractères';
//        } else {
//            // pas d'erreur sur ce champ title
//        }
//    } else{
//        $errors['content'] = 'Veuillez renseigner ce champ';
//    }

}
//debug($_POST);
//debug($errors);

include('inc/header.php'); ?>
    <h1>Ajouter une bière</h1>
    <form action="" method="post" novalidate class="wrap2">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" value="<?php if(!empty($_POST['title'])) { echo $_POST['title']; } ?>">
        <span class="error"><?php if(!empty($errors['title'])) { echo $errors['title']; } ?></span>

        <label for="content">Contenu</label>
        <textarea name="content" id="content" cols="30" rows="10"><?php if(!empty($_POST['content'])) { echo $_POST['content']; } ?></textarea>
        <span class="error"><?php if(!empty($errors['content'])) { echo $errors['content']; } ?></span>

        <label for="mail">E-mail</label>
        <input type="email" name="mail" id="mail" value="<?php if(!empty($_POST['mail'])) { echo $_POST['mail']; } ?>">
        <span class="error"><?php if(!empty($errors['mail'])) { echo $errors['mail']; } ?></span>

        <input type="submit" name="submitted" value="Ajouter une bière">
    </form>
<?php include('inc/footer.php');