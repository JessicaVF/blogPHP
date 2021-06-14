<?php include "logique.php";
include "../navbar.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.css">
</head>
<body>
   

<?php if( isset($_POST['info']) && $_POST['info'] == 'edited' ){?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully edited <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>
    <div class="container mt-5">
      <div class="container">
      <?php
      foreach($leResultatDeMaRequeteArticleUnique as $value){?>
                  <div class="row text-center">
                    <img src="../images/posts/<?php echo $value['image']?>" style= 'width: 20%; margin: 0 40%'>

                    <h2><?php echo $value["titre"];?></h2>
          
                  </div>
                  
                  <div class="text-center">
                      <p><?php echo $value['content'];?></p>
                  </div>            
    </div>
    </div>
    <?php } if($isLoggedIn && $isOwner){ ?>
      
      <div class="row">
            <form action="edition.php" method="post">
              <input type="hidden" name="postId" value="<?php echo $value['id']?>" class="btn btn-primary">
              <input type="submit" value="modify" class="btn btn-primary">
            </form>
      </div>
<?php } ?>

    
<?php foreach($comments as $comment){ ?>
  <div class= "row m-3">
      <div class="badge bg-primary">
        <?php if ($comment['displayName'] != ""){
              echo $comment['displayName'];
        } else{
          echo $comment['username'];
        }?>
      </div>
      <div>
      <?php echo $comment['content'] ?>
      </div>
      <div class= "">
      <?php echo $comment['date'] ?>
      </div>
      <hr>
    </div>
      
  <?php } if($isLoggedIn){ ?> 
  <form method="POST">
    <input type="text" name="commentContent">
    <input type= "hidden" name="authorCommentId" value="<?php echo $_SESSION['userId'] ?>">
    <input type="hidden" name="postId" value="<?php echo $value['id']?>">
    <input type="submit" value="addComment" class="btn btn-primary">
  </form>
  <?php } else{ ?> 
    <p class= "text-warning"> Connect to add a comment</p>
  <?php }?> 
    <div class="row">
    
            <a href="/humanBooster/blogavecsession/blog/" class="btn btn-danger">Retour a l'accueil</a>
    </div>
    
  
    
</body>
</html>