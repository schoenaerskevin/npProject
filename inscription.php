<?php
include 'dbreq.php';
 //definition variable
if(isset($_POST['forminscription'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   $droit = htmlspecialchars($_POST['droit']);

   
   if(!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['mdp']) && !empty($_POST['mdp2']) ) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM user WHERE mail = ?");
               $reqmail->execute(array($mail));
               $reqpseudo = $bdd->prepare("SELECT * FROM user WHERE pseudo = ?");
               $reqpseudo->execute(array($pseudo));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $pseudoexist = $reqpseudo->rowCount();
                      if($pseudoexist== 0){
                     
                     //inscrit mdp table mdp
                     $insertmbr1 = $bdd->prepare("INSERT INTO mdp(mdp) VALUES(?)");
                     $insertmbr1->execute(array( $mdp));
                     // inscrit pseudo,mail,droit dans table user
                     $insertmbr2 = $bdd->prepare("INSERT INTO user(pseudo,mail) VALUES(?,?)");                     
                     $insertmbr2->execute(array($pseudo,$mail));
                     

                     $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                  } else {
                     $erreur = "nom d'utilisateur deja existant !";
                  }
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}


?>





		
               
            <form method="POST" action="">
						<div class="input-group mb-1">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
                     <input type="text" placeholder="Username" class="form-control input_user" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" /> 
                  </div>
                  
						<div class="input-group mb-1">
							<div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
							</div>
                     <input type="email" placeholder="Email"    class="form-control input_user" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                  </div>
                  
                  <div class="input-group mb-1">
							<div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
							</div>
                     <input type="email" placeholder="Email Confirmation" class="form-control input_user" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                  </div>

                  <div class="input-group mb-1">
							<div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
                     <input type="password"    class="form-control input_user" placeholder="Password" id="mdp" name="mdp" />
						</div>

                  <div class="input-group mb-1">
							<div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
                     <input type="password"    class="form-control input_user" placeholder="Password Confirmation" id="mdp2" name="mdp2" />
                  </div>
                  
                  
                  

							<div class="d-flex justify-content-center login_container">
                        <button type="submit" name="forminscription" class="btn login_btn">Submit</button>
                      </div>
                      <div class="mt-1">
					<div style="color:black" class="d-flex justify-content-center links">
                  Already have an account? <a href="index.php" class="ml-2">Sign In</a>
                  
               </div>
  
            </div>
            <div class="text-center" >
						<?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
               </form>
				</div>
		
			</div>
		</div>
   </div>
   
  
