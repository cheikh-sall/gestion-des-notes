



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
    require_once "src/db.php";

    if(isset($_POST['validation']))

    {
        if (!empty($_POST['email']) && !empty($_POST['password']) ) 
        {
            $email=htmlspecialchars($_POST['email']);
            $pass=htmlspecialchars($_POST['password']);
            $req=$bdd->prepare("SELECT email,password FROM users where email=? AND password=? ");
            $req->execute($email,$password);
            $result=$req->fetch();
            if (!$result)
             {
                header("location:http://localhost/projets/emploi/index.php?error=1&type=EP");
             }else
             {
                session_start();
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['pseudo'] = $name;
                header("location:http://localhost/projets/emploi/accueil.php");
                
             }
        }
    }
    ?>
   
    <div class="container">
        <form method="POST" action="">

                <div id="heading">
                    <p>Veuillez entrer vos informations d'indentification</p>
                </div>
                <div id="content">
                    
                <label for="pseudo">Pseudo</label><br><input type="text" name="pseudo" placeholder="Entrez votre pseudo" ></input>
                <label for="firstName">prénom</label><br><input type="text"placeholder="Entrer votre  prénom" id="firstName" name="firstName"  ></input><br>
                 <label for="email">Email</label><br><input type="email"placeholder="Entrer votre adresse mail" id="email" name="email"  ></input><br>
                 <label for="password">Mot de passe</label><br><input type="password"placeholder="Entrer votre mot de passe" id="password" name="password"   ></input>
                </div>
                <div id="footer">
                     <p>Pas encore membre?<a  href="register.php">&nbsp; S'inscrire</a></p>
                     <!-- <p><a href="index.php">deja inscrit se connecter?</a><p> -->

                     <button id="validation" name="validation">Se connecter</button>
                     <!-- <input type="submit" name="connexion_submit" value="se connecter"> <br><br> -->
                     <span id="getError"><p>
                         <?php
                         
                         if (isset($_GET['error'])) 
                         {
                            
                         }
                         ?>
     
                </p></span>
                </div>
   </form>
    </div>
</body>
