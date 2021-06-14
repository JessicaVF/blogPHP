<?php 


// on verifie que POST a bien été initialisée aux bons indexs
//on verifie qu'aucune des deux chaines de caractere n'est "" 

//on interroge la base de données : y a-t-il un username correspondant dans la table users ?

//si oui, est-ce que le mot de passe est le mme que celui entré
                //si oui  =   isLoggedIn devient true
  
// echo "login fonctionnel";
        //verifier si le formulaire a été envoyé
    if (isset($_POST['username']) && isset($_POST['password'])){
            //est-ce qu'on a bien rempli le formulaire avant de l'envoyer
           $usernameEntre = $_POST['username'];
            $passwordEntre = $_POST['password'];

            if( $usernameEntre != "" && $passwordEntre !=""){
                require_once dirname(__FILE__)."/../access/db.php";
        
                    // mysqli_real_escape_string

                $usernameEntreFiltre = mysqli_real_escape_string($maConnection, $usernameEntre );



                $maRequete = "SELECT * FROM users WHERE username = '$usernameEntreFiltre'";

                

                $leResultatDeMaRequeteLogin = mysqli_query($maConnection, $maRequete);
                    if(  $leResultatDeMaRequeteLogin->num_rows == 1){


                       foreach( $leResultatDeMaRequeteLogin as $value){
                                                      
                                $vraiMotDePasse =  $value['password'];
                                $userId = $value['id'];
                                $role = $value['role'];
                                $username = $value['username'];
                                
                       }
                       require_once dirname(__FILE__)."/../access/salt.php";
                        if( md5($passwordEntre).md5($salt) == $vraiMotDePasse  ){

                            // echo "bon mot de passe";
                            $isLoggedIn = true;
                           
                            $_SESSION['userId'] = $userId;
                            $_SESSION['username'] = $username;
                            
                            echo "LOGGED IN";
                            if($role == 'admin'){
                                echo "admin in";
                                $isAdmin = true;
                                $_SESSION['role'] = 'admin';
                            }
                            else{
                                echo "pas admin";
                            }


                        }else{
                            echo "mauvais mot de passe, $usernameEntre + ";
                            echo $passwordEntre;
                        }

                    }else{
                        echo "username inexistant dans la DB";
                    }


            }else{

                echo "Veuillez entrer un username et un password";
            }


    }





?>