   <meta charset="UTF-8">
   <head><title>Connexion</title></head>
    <body>
		<h3>Connexion</h3>
		<form method="post">
			Identifiant : <input type="text" name="id"/><br/>
			Mot de passe : <input type="password" name="mdp"/><br/>
			<input type="submit" name="valider" value="Connexion"/>
        </form> 
		
		<?php
		if(isset($_POST['valider'])){

			if($_POST['id']=='group20' AND $_POST['mdp']=='mwsVo+5IXq'){
			
				//on se redirige vers le menu
				header('Location: init_table.php',true,301);
			}
			else
				echo "Mot de passe ou identifiant incorrect";
		}
		?>
	</body>