<?php

session_start();
if (isset($_SESSION['pseudo'])) 
{
    header('location:http://localhost/projets/emploi/accueil.php');
}else 
{
    


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>gestion emploi</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <script src='main.js'></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <?php
    // include "inc/header.php";
    require_once "src/db.php";
    global $error;

    if(isset($_POST['valider']))

    {   
       $error= array();
        $repass=htmlspecialchars($_POST['repassword']);
    

        if (isset($_POST['pseudo']) && !empty($_POST['pseudo'])) 
            {
                if (strlen($_POST['pseudo'])>=4) 
                {
                    
                
                    $pseudo=htmlspecialchars($_POST['pseudo']);
                    setcookie('pseudo',$pseudo,time()+300, null, null, false, true);
                    if (isset($_POST['firstName']) && !empty($_POST['firstName']) )
                    {
                       $firstName=htmlspecialchars($_POST["firstName"]);
                       setcookie('firstName',$firstName,time()+300, null, null, false, true);
                       if (isset($_POST['lastName']) && !empty($_POST['lastName']) )
                       {
                            $lastName=htmlspecialchars($_POST["lastName"]);
                            setcookie('lastName',$lastName ,time()+300, null, null, false, true);
                            if (isset($_POST['email']) && !empty($_POST['email']) )
                            {
                                    $email=htmlspecialchars($_POST["email"]);
                                    if (filter_var($email,FILTER_VALIDATE_EMAIL)) 
                                    {
                                        setcookie('email',$email ,time()+300, null, null, false, true);
                                        if (isset($_POST['password']) && !empty($_POST['password']))
                                        {
                                            if (strlen($_POST['password'])>=6) 
                                            {
                                                

                                                 if (isset($_POST['repassword']) && !empty($_POST['repassword']))
                                                     {
                                                        $pass=htmlspecialchars($_POST['password']);
                                                        $repass=htmlspecialchars($_POST['repassword']);
                                                        $hash=password_hash($pass, PASSWORD_DEFAULT);
                                                        if(password_verify($repass, $hash))
                                                        {   
                                                            $req=$bdd->query('SELECT pseudo FROM etudiant ');
                                                             while ($donnees=$req->fetch()) 
                                                             {
                                                                if ($donnees['pseudo']==$pseudo) 
                                                                {
                                                                    $error='Le pseudo est dèja utilisé par un membre. <br>
                                                                    Veuillez choisir un autre ';
                                                                }
                                                             }
                                                            $ajout=$bdd->prepare('INSERT INTO etudiant(pseudo,firstName,lastName,email,password) VALUES(?,?,?,?,?)');
                                                            $ajout->execute($pseudo,$firstName,$lastName,$email,$password) || die('nous n\'avons pas pu vous inscrire');
                                                            $_SESSION['pseudo']=$pseudo;
                                                            $_SESSION['firstName']=$firstName;
                                                            $_SESSION['lastName']=$lastName;
                                                            $_SESSION['nouveau']=true;
                                                            header('location:http://localhost/projets/emploi/accueil.php');
                                                        }else
                                                        {
                                                            $error='les mots de passe doivent etre identiques';
                                                            
                                                        }

                                                     }else
                                                     {
                                                        $error='veuillez répéter le mot de passe  svp!';
                                                        

                                                     }
                                            }else
                                            {
                                                $error='le mot de passe doit contenir au minimum 6 charactéres';
                                                 
                                            }
                                                   
                                        }else
                                        {
                                            $error='le mot de passe  est obligatoire, veuillez le renseigner svp!';
                                            
                                        }
                                        
                                    }else
                                    {
                                        $error='veuillez renseigner une adresse mail valide svp!';
                                       
                                    }
                            }else
                            {
                                $error="l'adresse mail est obligatoire, veuillez le renseigner svp!";
                               
                            }


                       }else
                       {
                        $error='le nom  est obligatoire, veuillez le renseigner svp!';
                       
                       }
                    }else
                    {
                        $error='le prénom  est obligatoire, veuillez le renseigner svp!';
                        
                    }
               }else
               {
                 $error='le Pseudo doit contenir au minimum 4 charactéres';
                 
               }
           }else
           {
             $error='le pseudo est obligatoire, veuillez le renseigner svp!';
             echo "<p>".$error."</p>";
             
           }
       }
    }
       ?>
        <div class="container">
        <form method="post" action="">

                <div id="heading">
                    <p>Inscription</p>
                    <fieldset class="alert alert danger"><?php
                    if (isset($_GET["error"])) 
                    {
                        
                           echo "<p>".$error."</p>";
                            
                        
                    }
                    
                    
                    ?></fieldset>
                </div>
                  <div id="content">
                    
                <label for="pseudo">Pseudo</label><br><input type="text" name="pseudo" placeholder="Entrez votre pseudo" <?php if (isset($_COOKIES['pseudo'])):echo "value=".$pseudo; ?>
                    
                    <?php endif ?> ></input>
                <label for="firstName">Prénom</label><br><input type="text"placeholder="Entrer votre  prénom" id="firstName" name="firstName" <?php if (isset($_COOKIES['firstName'])):echo "value=".$firstName; ?>
                    
                    <?php endif ?> ></input><br>
                <label for="lastName">Nom</label><br><input type="text"placeholder="Entrer votre  prénom" id="firstName" name="firstName" <?php if (isset($_COOKIES['lastName'])):echo "value=".$lastName; ?>
                    
                    <?php endif ?>  ></input><br>
                 <label for="email">Email</label><br><input type="email"placeholder="Entrer votre adresse mail" id="email" name="email" <?php if (isset($_COOKIES['email'])):echo "value=".$email; ?>
                    
                    <?php endif ?>  ></input><br>
                 <label for="password">Mot de passe</label><br><input type="password"placeholder="Entrer votre mot de passe" id="password" name="password"   ></input>
                 <label for="password">Repetez le Mot de passe</label><br><input type="password"placeholder="Entrer votre mot de passe" id="repassword" name="repassword"   ></input>
                </div>
                
                <div id="footer">
                     <p>Déja membre?<a  href="index.php">&nbsp; Se connecter</a></p>
                  

                     <button id="valider" name="valider">S'inscrire</button>
                    
                </div>
   </form>
    </div>
</body>
<?php}?>

    //    include "inc/footer.php";
    
  
   
