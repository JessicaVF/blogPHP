<?php
    $unHote = "localhost";
    $nomUtilisateurDB = "blogAvance";
    $motDePasseUserDB = "20410953";
    $nomDatabase = "blogavance";

 //Tester la bonne connection à la base
 $maConnection =    mysqli_connect($unHote, $nomUtilisateurDB, $motDePasseUserDB, $nomDatabase);
 if(!$maConnection){

    echo "
    
    <div class='alert alert-dismissible alert-warning'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <h4 class='alert-heading'>Warning!</h4>
      <p class='mb-0'>probleme de connection à la base de données</a>.</p>
    </div>";
    
    die();
    
    }
?>