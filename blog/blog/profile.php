<?php include "logique.php";
include "../navbar.php";
foreach($maRequeteProfileActive as $value){?>
    <div class="text-center">
    <img src="../images/users/<?php echo $value['image']?>">
    </div>  
    <div class="row text-center">
      <h2>Username: <?php echo $value["username"];?></h2>

    </div>
    
    <div class="text-center">
        <p>Email: <?php echo $value['email'];?></p>
    </div>  
    <?php if ($value['displayName'] !== "") {?>  
    <div class="text-center">
        <p> Display Name: <?php echo $value['displayName'];?></p>
    </div>    
    <?php }?>
    <?php if($isLoggedIn){  
      if ($value['id'] == $_SESSION['userId']){?> 
        <div class="row">
            <form action="editionProfile.php">
              <input type="hidden" name="profile" value="<?php echo $value['id']?>">
              <input type="submit" value="modify" class="btn btn-primary">
            </form>
      </div>
    
    <?php }} ?>        
    
<?php } ?>