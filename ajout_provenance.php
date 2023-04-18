	<meta charset="UTF-8">
	<head><title>Ajouter une provenance</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li>";

		if(isset($_POST['valider'])){
			
			if($_POST['provenance'] == 'oui'){
				$nom_scientifique = $_GET['nom_scientifique'];
				$n_puce = $_GET['n_puce_new'];
				
				//on remplis les données pour ajouter une istitution
				echo "<form method='post' action='ajout_provenance_fin.php?nom_scientifique=".$nom_scientifique."&n_puce=".$n_puce."'>";
					echo "nom de l'institution : <input type='text' name='institution' /><br/>";
					
					echo "<input type='submit' name='valider' value='Valider' '/>";
				echo "</form>";
			}
			else
				echo "L'animal a été ajouté avec succès sans provenance";
			
		}
	?>
	</body>