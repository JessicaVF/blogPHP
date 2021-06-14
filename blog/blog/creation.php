
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
            <?php if(isset($_GET['info']) && $_GET['info']="postIncomplete"){
                echo "Fill all the form";
            } ?>
            <div class="container">
                
                    <form action="logique.php" method="POST" enctype="multipart/form-data">
                    <input class ="form-control" type="file" name="nouveauPhoto">
                    <input class="form-control" type="text" name="nouveauTitre" id="" placeholder="votre titre">
                    <textarea class="form-control" name="nouveauTexte" id="" cols="30" rows="10" placeholder="votre texte"></textarea>
                    <input class="form-control" type="hidden" name ="author_Id" value =<?php echo $_SESSION['userId']?>>
                    <input class="form-control btn btn-success" type="submit" value="Poster">
                        
                    
                    
                    </form>


               
            </div>


</body>
</html>