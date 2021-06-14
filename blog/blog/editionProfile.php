<?php include "logique.php";
include "../navbar.php";

foreach($maRequeteProfileActive as $value){ ?>
<div class="text-center">
    <img src="../images/users/<?php echo $value['image']?>"></div>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name = leUserId value = <?php echo $value['id'] ?>>
    <input class ="form-control" type="file" name="profileImageEdite">
    <input class="form-control btn btn-success" type="submit" value="Enregistrer les modifications du photo">
</form>

<form action="" method="POST">
                    <input type="hidden" name = leUserId value = <?php echo $value['id'] ?>>
                    <input class ="form-control" type="text" name="displayNameEdite" placeholder="Display Name">
                    <input class ="form-control" type="text" name="emailEdite" placeholder="Email">
                    <input class="form-control btn btn-success" type="submit" value="Enregistrer les modifications">
                    
                    </form>
<?php }?>







