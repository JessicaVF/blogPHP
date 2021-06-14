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
   

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-tarPOST="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="../index.php">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <?php if($isLoggedIn){ ?>
        <li class="nav-item">
        <a class="nav-link active" href="../blog/profile.php?profile=<?php echo $_SESSION['userId'] ?>">Profile
          </a>
          
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="../index.php?mesPosts"> Mes posts </a>
          <!-- <form>
           <input type="submit" name="mesPosts" value= "Mes Posts" class="btn btn-success">
          </form> -->
        </li>
        

        <li class="nav-item">
          <a class="nav-link" href="../blog/creation.php">Nouveau post</a>
        </li>
        <?php if($isAdmin){?>
      <a class="nav-link active" href="blog/blog/admin.php?admin">Admin</a>
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