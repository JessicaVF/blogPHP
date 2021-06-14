<?php 

require_once "logique.php";
include "../navbar.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

<?php 

if ($isAdmin){


foreach($leResultatDeMaRequete as $post){ ?>
    <h2> Title: <?php echo $post['titre']?></h2>
    <a href ="postUnique.php?postId=<?php echo $post['id'] ?>" class="btn btn-success">Voir l'article</a>
    <br>
    <br>
    <form action method="POST">
        <input type="hidden" name="idPostStatus" value="<?php echo $post['id'] ?>">
        <input type ="hidden" name="status" value= "<?php if($post['publier']){echo 'unpublish';}else{echo 'publish';} ?>">
        <input type="submit" class="btn btn-primary" value="<?php if($post['publier']){echo 'unpublish';}else{echo 'publish';} ?>">
    </form>
        
    <form action="" method="POST">
        <input type="hidden" name="idSuppression" value="<?php echo $post['id'] ?>">
        <input type="submit" class="btn btn-danger" value="Supprimer cet Article" >
    </form>
    <hr>


<?php } ?>
<span class="badge bg-primary">Users</span>
<?php 
    foreach($maRequeteUsersActive as $user){
        if($user['username']!= $_SESSION['username']){
    ?>
    
    <h2> Username: <?php echo $user['username'] ?> </h2>
    <form action="" method="POST">
        <input type="hidden" name="idUserSuppression" value="<?php echo $user['id']?>">
        <input type="submit" class="btn btn-danger" value="supprimer cet user" >
    </form>
    <hr>
<?php }}} else{ ?>


    <p>vous n'etes pas administrateur</p>

<?php }?>


</body>
</html>

















