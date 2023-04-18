	<meta charset="UTF-8">
	<head><title>Trouver les techniciens</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li>";

		//on se connecte à la base de donnée
		$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=group20;charset=utf8','group20','mwsVo+5IXq');
		
		//on fait la requête SQL
		$req = "SELECT n_registre FROM Entretien GROUP BY n_registre HAVING COUNT(DISTINCT n_enclos) = (SELECT COUNT(DISTINCT n_enclos) FROM Enclos)";
		
		$my_table = $bdd->query($req);
		//on affiche le résultat
		echo "<table>";
			echo "<thead>";
				echo "<tr>";
					//nom des colonnes
					echo "<th> numéro du registre (correspondant a un technicien qui a travaillé dans tout les enclos) </th>";

				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				
					//les tuples
					$table_final = $bdd->query($req);
					while ($ligne=$table_final->fetch()){
					echo "<tr>";
						for($j=0; $j<1; $j++)
							echo "<td> ".$ligne[$j]." </td>";
					echo "</tr>";
					}
								
			echo "</tbody>";
		echo "</table>";		
	?>
	</body>