
<?php require "logique.php";
include "../navbar.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouveau post</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.css">

</head>
<body>

            <div class="container">
                <div class="">
                <?php
    foreach($leResultatDeMaRequeteArticleUnique as $value){ ?>
      

                    <img src="../images/posts/<?php echo $value['image']?>" style= 'width: 20%; margin: 0 40%'>
                    <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name = lePostId value = <?php echo $value['id'] ?>>
                    <input class ="form-control" type="file" name="postImageEdite">
                    <input class="form-control btn btn-success" type="submit" value="Enregistrer les modifications du photo">
                </form>
                    
                    
                    
                    
                    <form action="" method="POST">

                    <input type="hidden" name="idAModifier" value="<?php echo $value['id'] ?>">
                    <input type="hidden" name="postId" value="<?php echo $value['id'] ?>">

                   
                    <input class="form-control" type="text" name="titreEdite" id="" value="<?php echo $value['titre'] ?>" placeholder="votre titre">
                    <textarea class="form-control" name="texteEdite" id="" cols="30" rows="10" placeholder="votre texte"><?php echo $value['content'] ?></textarea>
                    <input class="form-control btn btn-success" type="submit" value="Enregistrer les modifications">
                        
                  
                    
                    </form>
                    <?php }?>


<form action="" method="POST">
<input type="hidden" name="idSuppression" value="<?php echo $value['id'] ?>">

<div class="row">

<input type="submit" class="btn btn-danger" value="Supprimer cet Article" >

</div>

</form>
<div>
    <form action method="POST">
        <input type="hidden" name="idPostStatus" value="<?php echo $value['id'] ?>">
        <input type ="hidden" name="status" value= "<?php if($value['publier']){echo 'unpublish';}else{echo 'publish';} ?>">
        <input type="submit" class="btn btn-primary" value="<?php if($value['publier']){echo 'unpublish';}else{echo 'publish';} ?>">
    </form>
</div>                               
</div>
</div>

</body>
</html>