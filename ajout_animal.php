	<meta charset="UTF-8">
	<head><title>Ajouter un animal</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li>";		
		
		//on remplis les données pour ajouter un animal
		echo "<form method='post' action='ajout_animal_fin.php'>";
			$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=group20;charset=utf8','group20','mwsVo+5IXq');
			$result=$bdd->query("SELECT DISTINCT(nom_scientifique) FROM Espece");
			
			echo "Nom scientifique de l'animal : ";
			echo "<select name=requete[]>";
				echo "<option value='val'>Choisissez</option>";
				while ($ligne=$result->fetch()){
					echo "<option value='".$ligne[0]."'>".$ligne[0]."</option>";
				}
			echo "</select>";
			echo "<br/>";
			echo "taille : <input type='text' name='requete[]' /><br/>"; 
			echo "sexe : <select name='requete[]'>";
				echo "<option value='val'>Choisissez</option>";
				echo "<option value='F'>F</option>";
				echo "<option value='M'>M</option>";
			echo "</select>";
			echo "<br/>"; 
			echo "date de naissance : ";
			echo "<select name='requete[]'>"; 
				echo "<option value='val'>Jour</option>";
				for($i=1; $i<=31 ;$i++)
					echo "<option value=".$i.">".$i."</option>";
			echo "</select>";
			echo "<select name='requete[]'>"; 
				echo "<option value='val'>Mois</option>";
				for($i=1; $i<=12 ;$i++)
					echo "<option value=".$i.">".$i."</option>";
			echo "</select>";
			echo "<select name='requete[]'>"; 
				echo "<option value='val'>Annee</option>";
				for($i=2000; $i<=2018 ;$i++)
					echo "<option value=".$i.">".$i."</option>";
			echo "</select><br/>";
			
			echo "numéro d'enclos : ";
				
			$result=$bdd->query("SELECT DISTINCT(n_enclos) FROM Enclos");
				
			echo "<select name=requete[]>";
			echo "<option value='val'>Choisissez</option>";
				while ($ligne=$result->fetch()){
					echo "<option value='".$ligne[0]."'>".$ligne[0]."</option>";
				}
			echo "</select>";
			echo "<br/><br/>";
				
			echo "<input type='submit' name='valider' value='Ajouter' '/>";
				
		echo "</form>";	
	?>
	</body>