	<meta charset="UTF-8">
	<head><title>Affichage des tables</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li>";
		
		//lien vers la sélection d'une nouvelle table
		echo "<li><a href='choix_table.php'>Choisir une nouvelle table</a></li>";
		echo "<br/>";
		
		if(isset($_POST['valider'])){
			$i=0;
			if(isset($_POST['requete'])){
				foreach($_POST['requete'] as $valeur){
					$requetes[$i] = $valeur;
					$i = $i + 1;
				}
			}
		}
		//on récupère notre tableau colonnes
		if(isset($_POST['requete']))
			$colonnes = unserialize($_GET['colonne']);
		$my_table = $_GET['table'];		
		
		//on affiche le texte sur le site
		if(isset($_POST['requete'])){
			echo "Affichons la table '".$my_table."' avec la contrainte ";
			if(sizeof($colonnes) != 1){
				for($i=0; $i<sizeof($colonnes)-1; $i++)
					echo "de '".$requetes[$i]."' sur la colonne '".$colonnes[$i]."', ";
			echo "et de '".$requetes[sizeof($colonnes)-1]."' sur la colonne '".$colonnes[sizeof($colonnes)-1]."'.<br/><br/>";
			}
			else echo "de '".$requetes[sizeof($colonnes)-1]."' sur la colonne '".$colonnes[sizeof($colonnes)-1]."'.<br/><br/>";
		}
		else echo "Affichons la table '".$my_table."' sans contraintes<br/><br/>";
			
		//établissons notre requête SQL
		if(isset($_POST['requete'])){
			$req = "SELECT * FROM ".$my_table." WHERE ";
			for($i=0; $i<sizeof($colonnes); $i++){
				$colonne = $colonnes[$i];
				$contrainte = $requetes[$i];

				//si ce n'est pas un int
				if(!is_int($contrainte))
					$req .= "".$colonne."=\"".$contrainte."\"";
				else
				$req .= "".$colonne."=".$contrainte."";
			
				if($i!=sizeof($colonnes)-1)
					$req .= " AND ";
			}
		}
		else $req = "SELECT * FROM ".$my_table."";
		
		echo $req;
		echo "<br/><br/>";
		
		//on se connecte à la base de données
		$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=group20;charset=utf8','group20','mwsVo+5IXq');
		
		//on cherche le nombre de colonnes qu'il y a dans notre table
		$column=$bdd->query("show columns from $my_table");
		$nb_col=0;
		while($ligne=$column->fetch()){
			$nb_col = $nb_col+1;
		}		
		
		//on effectue la requête correspondante aux entrées de l'utilisateur 
		$table_final = $bdd->query($req);
		echo "<table>";
			echo "<thead>";
				echo "<tr>";
					//nom des colonnes
					$column=$bdd->query("show columns from $my_table");
					while($ligne=$column->fetch()){
						echo "<th> ".$ligne[0]." </th>";
					}
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				
					//les tuples
					$table_final = $bdd->query($req);
					while ($ligne=$table_final->fetch()){
					echo "<tr>";
						for($j=0; $j<$nb_col; $j++)
							echo "<td>".$ligne[$j]." </td>";
						
					echo "</tr>";
					}
				
			echo "</tbody>";
		echo "</table>";		
		
	?>
	</body>