<?php 

session_start();
if(isset($_POST['logOut'])){
   session_unset();
} 


require_once dirname(__FILE__)."/../authentification/auth.php";
require_once dirname(__FILE__)."/../access/db.php";
$isOwner = false;
    //Suppression d'un article

   if(isset($_POST['idSuppression'])){

      $idASupprimer = $_POST['idSuppression'];

      $maRequeteDeSuppression = "DELETE FROM posts WHERE id=$idASupprimer";

      $maSuppression= mysqli_query($maConnection, $maRequeteDeSuppression);

      if(isset($_GET['admin'])){
         header("Location:admin.php?admin");
      }else{
         header("Location: ../index.php");
      }
    }
   


    // modification d'un article

      if(isset($_POST['titreEdite']) && isset($_POST['texteEdite'])){
         
            $titreEdite = $_POST['titreEdite'];
      
            $texteEdite = $_POST['texteEdite'];

            //on doit refaire passer l'ID par le biais d'un input supplémentaire dans le
            $idArticleAModifier = $_POST['idAModifier'];

               $maRequeteUpdate = "UPDATE posts SET titre  = '$titreEdite', content = '$texteEdite' WHERE id = $idArticleAModifier";

               $monResultat = mysqli_query($maConnection, $maRequeteUpdate);

               header("Location: postUnique.php?postId=$idArticleAModifier&info=edited");

         }






    //creation d'article

    if( isset($_POST['nouveauTitre']) && isset($_POST['nouveauTexte']) ){
            if( $_POST['nouveauTitre'] !== "" && $_POST['nouveauTexte'] !== "" ){
                    $nouveauTitre = $_POST['nouveauTitre'];
                    $nouveauTexte = $_POST['nouveauTexte'];
                    $authorId =  $_POST['author_Id'];
                    $nouveauPhoto = $_FILES['nouveauPhoto'];

                    $maRequete = "INSERT INTO posts(titre, content, author_id, image, publier) VALUES ('$nouveauTitre', '$nouveauTexte', '$authorId', '$nouveauPhoto', 1)";
                     
                     $leResultatDeMonAjoutArticle = mysqli_query($maConnection, $maRequete);
                   
                   
                     // TEST qu ne doit pas etre visible pour les uilisateurs
                     if(!$leResultatDeMonAjoutArticle){
                        die("RAPPORT ERREUR ".mysqli_error($maConnection));
                        
                     } 
                     
                     header("Location: ../index.php?info=added");
                  }
         else{
            
            header("Location: creation.php?info=postIncomplete");
            
         }
           
    }
    
    //effectuer une requete pour un article spécifique:
     if(  isset($_GET['postId']) || isset($_POST['postId']) ){

           if(isset($_GET['postId'])){
              $postId = $_GET['postId'];
           }else{
            $postId = $_POST['postId'];
           } 
           
         $maRequeteArticleUnique = "SELECT * FROM posts WHERE id=$postId";
         $leResultatDeMaRequeteArticleUnique = mysqli_query($maConnection, $maRequeteArticleUnique);
         $comments = getComments($maConnection, $postId);
         if($isLoggedIn){
            if(verifyOwnership($_SESSION['userId'], $postId, $maConnection)){
               $isOwner = true;
            }
         }
           
      }
     //Only mes Posts
     else if(  isset($_GET['mesPosts'])){
      
      $leUserId = $_SESSION['userId'];
      $maRequete = "SELECT * FROM posts WHERE author_Id= $leUserId";

      $leResultatDeMaRequete = mysqli_query($maConnection, $maRequete);


   }
   else{    //effectuer une requete SQL pour récupérer TOUS les posts

      $maRequete = "SELECT * FROM posts";

      $leResultatDeMaRequete = mysqli_query($maConnection, $maRequete);
   }
   // find a single profile base in the author_id
   if(isset($_GET['profile']) && $_GET['profile']!==""){
      
      $leAuthorId = $_GET['profile'];
      $maRequeteProfile= "SELECT * FROM users WHERE Id= $leAuthorId";
      $maRequeteProfileActive = mysqli_query($maConnection, $maRequeteProfile);
   }
   if(isset($_POST['displayNameEdite']) && $_POST['displayNameEdite'] !== "" || isset($_POST['emailEdite']) && $_POST['emailEdite'] !== ""){
      $leId = $_POST['leUserId'];
      if($_POST['displayNameEdite'] !== "" && $_POST['emailEdite'] !== ""){
         $displayName = $_POST['displayNameEdite'];
         $email= $_POST['emailEdite'];
         $maRequeteUpdateProfile = "UPDATE users SET email ='$email', displayName='$displayName' WHERE Id= $leId";
      }
      else if($_POST['displayNameEdite'] !== ""){
         $displayName = $_POST['displayNameEdite'];
         $maRequeteUpdateProfile = "UPDATE users SET displayName='$displayName' WHERE Id= $leId";
      }
      else if($_POST['emailEdite'] !== ""){
         $email= $_POST['emailEdite'];
         $maRequeteUpdateProfile = "UPDATE users SET email='$email' WHERE Id= $leId";
      }
      
      $maRequeteUpdateProfileActive = mysqli_query($maConnection, $maRequeteUpdateProfile);

   }
   if(isset($_FILES['profileImageEdite'])){
      $leId = $_POST['leUserId'];
      $repertoireUpload = "../images/users/";
      $nomTemporaireFichier = $_FILES['profileImageEdite']['tmp_name'];
      var_dump($nomTemporaireFichier);
      $mesInfos = getimagesize($_FILES['profileImageEdite']['tmp_name']);
      //mime is create when you use getimagesize
      $monTableauExtensions = explode("/",$mesInfos['mime']); 
      var_dump($monTableauExtensions);
      $extensionUploadee = $monTableauExtensions[1];
      var_dump($extensionUploadee);
      $unTableau =    explode("\\", $nomTemporaireFichier);
      
      $nomTemporaireSansChemin =  end($unTableau);
      var_dump($nomTemporaireSansChemin);
      $nomFinalDuFichier = $nomTemporaireSansChemin.".".$extensionUploadee;
      $destinationFinale = $repertoireUpload.$nomFinalDuFichier;
      var_dump($destinationFinale);
      if(chekSizeImg($mesInfos)){
         if(move_uploaded_file($nomTemporaireFichier, $destinationFinale)){
            $maRequeteUpdateProfilePhoto = "UPDATE users SET image='$nomFinalDuFichier' WHERE Id= '$leId'";
            $maRequeteUpdateProfilePhotoActive = mysqli_query($maConnection, $maRequeteUpdateProfilePhoto);
            header("Location: profile.php?profile=$leId&info=picUploaded");
         }
      }
   }

   if(isset($_POST['commentContent']) && $_POST['commentContent'] != "" && $isLoggedIn){
      
      $commentContent = $_POST['commentContent'];
      $authorCommentId = $_POST['authorCommentId'];
      $postId = $_POST['postId'];
      $maRequeteAddComment = "INSERT INTO comments(content, author_id, post_id) VALUES('$commentContent', '$authorCommentId', '$postId')";
      if($authorCommentId == $_SESSION['userId']){
         $maRequeteAddCommentActive = mysqli_query($maConnection, $maRequeteAddComment);
         echo mysqli_error($maConnection);
         header("Location: postUnique.php?postId=$postId");
      }
      else{
         echo "error, are you a hacker?";
      }
   }

   //changer le status publish / unpublish de un article - post
   if(isset($_POST['idPostStatus'])&& $_POST['idPostStatus'] != "" ){
      $id = $_POST['idPostStatus'];
      if($_POST['status']=="publish"){
         $status = 1;
      }
      else{
         $status = 0;
      }
      
      $maRequeteChangeStatus = "UPDATE posts SET publier = $status WHERE id = $id";
      $maRequeteChangeStatusActive = mysqli_query($maConnection, $maRequeteChangeStatus);
      if(isset($_GET['admin'])){
         header("Location: admin.php?admin");
      }
      else{
      header("Location: postUnique.php?postId=$id&info=statusChange");
      }
   }
   
//change photo article post

if(isset($_FILES['postImageEdite'])){
   $leId = $_POST['lePostId'];
   $repertoireUpload = "../images/posts/";
   $nomTemporaireFichier = $_FILES['postImageEdite']['tmp_name'];
   var_dump($nomTemporaireFichier);
   $mesInfos = getimagesize($_FILES['postImageEdite']['tmp_name']);
   //mime is create when you use getimagesize
   $monTableauExtensions = explode("/",$mesInfos['mime']); 
   var_dump($monTableauExtensions);
   $extensionUploadee = $monTableauExtensions[1];
   var_dump($extensionUploadee);
   $unTableau =    explode("\\", $nomTemporaireFichier);
   
   $nomTemporaireSansChemin =  end($unTableau);
   var_dump($nomTemporaireSansChemin);
   $nomFinalDuFichier = $nomTemporaireSansChemin.".".$extensionUploadee;
   $destinationFinale = $repertoireUpload.$nomFinalDuFichier;
   var_dump($destinationFinale);
   if(chekSizeImg($mesInfos)){
      if(move_uploaded_file($nomTemporaireFichier, $destinationFinale)){
         $maRequeteUpdatePostPhoto = "UPDATE posts SET image='$nomFinalDuFichier' WHERE Id= '$leId'";
         $maRequeteUpdatePostPhotoActive = mysqli_query($maConnection, $maRequeteUpdatePostPhoto);
         header("Location: postUnique.php?postId=$leId&info=edited");
      }
   }
}

// get all users for the admin
if(isset($_GET['admin'])){
   $maRequeteUsers = "SELECT * FROM users";
   $maRequeteUsersActive = mysqli_query($maConnection, $maRequeteUsers);
}
//delete user with admin
if(isset($_POST['idUserSuppression']) && $_POST['idUserSuppression'] != "" && $isAdmin){
   $userId = $_POST['idUserSuppression'];
   $maRequeteDelUser = "DELETE FROM users WHERE id = $userId";
   $maRequeteDelUserActive = mysqli_query($maConnection, $maRequeteDelUser);
   header("Location:admin.php?admin");
}
















function verifyOwnership($userId, $postId, $maConnection){
   $maRequeteDeVerification = "SELECT * FROM posts WHERE id = '$postId'";



               $resultatRequeteVerification = mysqli_query($maConnection, $maRequeteDeVerification);

               foreach($resultatRequeteVerification as $value){
                  $authorId = $value['author_Id'];

               }

               $ownerVerified = false;

               if($userId == $authorId){

                  $ownerVerified = true;
               }
               if($ownerVerified){

                  return true;
               }else{
   
                  return false;
               }
}
function chekSizeImg($mesInfos){
   $photo = false;
   $hauteurMax = 720;
   $largeurMax = 900;
   $tailleMax = 3000000;
   $maLargeur = $mesInfos[0];
   $maHauteur = $mesInfos[1];
   $maTaille = $_FILES['profileImageEdite']['size'];
   if($maTaille <= $tailleMax){
      if($maLargeur <= $largeurMax && $maHauteur <= $hauteurMax){
         $photo = true;
      }
   }
   return $photo;
}
function getComments($maConnection, $postId){

   $maRequeteComments = "SELECT comments.content, comments.date, users.displayName, users.username 
   FROM comments 
   INNER JOIN users
   ON comments.author_id = users.id
   WHERE comments.post_id = '$postId'";
   $maRequeteCommentsActive = mysqli_query($maConnection, $maRequeteComments);
   return $maRequeteCommentsActive;
}



?>