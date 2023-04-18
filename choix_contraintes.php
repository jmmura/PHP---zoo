	<meta charset="UTF-8">
	<head><title>Affichage des tables</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li>";
		
		//lien vers la sélection d'une nouvelle table
		echo "<li><a href='choix_table.php'>Choisir une nouvelle table</a></li>";
		echo "<br/>";
		
		if(isset($_POST['val_col'])){
			$i=0;
			if(isset($_POST['contraintes'])){
				foreach($_POST['contraintes'] as $valeur){
					//on récupère les colonnes cochées qu'on va stocker dans un tableau
					$colonnes[$i] = $valeur;
					$i = $i + 1;	
				}
			}
			else header('Location: affiche_table.php?table='.$_GET['table'],true,301);	
				
			echo "Vous vous trouvez dans la table ".$_GET['table']." : <br/><br/>";		
			
			//il faut sérialiser le tableau colonnes pour pouvoir le passer dans l'url
			$col_ser = serialize($colonnes);
			
			echo "<form method='post' action='affiche_table.php?colonne=".$col_ser."&table=".$_GET['table']."'>";
				for($i=0; $i<sizeof($colonnes); $i++)
					//créons notre tableau de requêtes
					echo "Entrez votre contrainte pour la colonne '".$colonnes[$i]."' : <input type='text' name='requete[]' /><br/>";
					
				echo "<input type='submit' name='valider' value='Valider' '/>";
			echo "</form>"; 
		}
	?>
	</body>