<?php 

require "blog/logique.php";

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.css">
    <link rel="stylesheet" href ="style.css">
</head>
<body>
   

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-tarPOST="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <?php if($isLoggedIn){ ?>
        <li class="nav-item">
          <a class="nav-link active" href="blog/profile.php?profile=<?php echo $_SESSION['userId'] ?>">Profile
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link active" href="index.php?mesPosts"> Mes posts </a>
          
        </li>
        

        <li class="nav-item">
          <a class="nav-link" href="blog/creation.php">Nouveau post</a>
        </li>
        <?php if($isAdmin){?>
        <li class="nav-item"> 
          <a class="nav-link" href="blog/admin.php?admin">Admin</a>
        </li>
      <?php  } ?>
        <?php } ?>
      
      </ul>
      <?php if(!$isLoggedIn && !$modeInscription){ ?>
        <form method="POST" class="d-flex align-items-center">

            <div class="form-group">
                <label for="username">Username</label>

                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
            <label for="password">password</label>

                <input type="password" class="form-control" name="password" required>
            </div>        
        
                <div class="form-group">
                 <input type="submit" value="Log in" class="btn btn-success">
                </div>
        </form>
      

<hr>
        <?php }?>

        <?php if($isLoggedIn){?>



<form method="POST" class="d-flex">
 
  <button type="submit" name="logOut" class="btn btn-secondary my-2 my-sm-0" >Deconnexion</button>
</form>
<?php  }?>


      <?php if(!$modeInscription && !$isLoggedIn){?>



      <form method="POST" class="d-flex">
       
        <button type="submit" name="modeInscription" value="on" class="btn btn-secondary my-2 my-sm-0" type="submit">Inscription</button>
      </form>
      <?php  }?>
    </div>
  </div>
</nav>
<?php if(isset($_GET['info']) && $_GET['info']== "registered"){ ?>

<div class="alert alert-success" role="alert">
Successfully registered !
</div>


<?php }?>
<?php if( isset($_GET['info']) && $_GET['info'] == 'added' ){?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully posted <a href="#" class="alert-link">a new article</a>.
</div>
<?php } ?>
<?php if( isset($_GET['info']) && $_GET['info'] == 'deleted' ){?>

<div class="alert alert-dismissible alert-danger">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully deleted <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>

    <div class="container">
    
    
        <div class="row mt-5">
        <?php if($modeInscription){ ?>
<form method="post">

<div class="form-group">
    <label for="username">Username</label>

    <input type="text" class="form-control" name="usernameSignUp">
</div>
<div class="form-group">
<label for="password">password</label>

    <input type="password" class="form-control" name="passwordSignUp">
</div>  
<div class="form-group">
<label for="passwordRetype">Re-type password</label>

    <input type="password" class="form-control" name="passwordRetypeSignUp">
</div>      

    <div class="form-group">
    <input type="hidden" name="modeInscription" value="on">
     <input type="submit" value="Sign up" class="btn btn-success">
    </div>

</form>
<form method="POST">
<button class="btn btn-primary" name="modeInscription" value="off">Se connecter</button>
</form>
<hr>
<?php }else{ ?>


            <?php //debut de la boucle   
                    
                    foreach($leResultatDeMaRequete as $post){
                      if($post['publier'] || isset($_GET['mesPosts'])){
            ?>

                    <div class="col-4">
                            
                            <div class="card text-white bg-success mb-3" style="max-width: 20rem;">
                            
    
                            <img src="images/posts/<?php echo $post['image']?>">
                            
                            <div class="card-header"><?php echo $post["titre"]; ?></div>
                            <div class="card-body">
                                <h4 class="card-title">Auteur :  <a href ="blog/profile.php?profile=<?php echo $post['author_Id'] ?>" class= 'badge bg-secondary'><?php echo $post["author_Id"] ?> </a></h4>
                                <p class="card-text"><?php echo $post["content"]; ?></p>
                            </div>
                            
                                 <a href ="blog/postUnique.php?postId=<?php echo $post['id'] ?>" class="btn btn-success">Voir l'article</a>

                           
                            </div>
                    
                    
                    </div>
                    
            <?php //fin de la boucle
                         }} ?>


<?php } ?>
        
        </div>
    
    
    
    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>