	<meta charset="UTF-8">
	<head><title>Trier les animaux</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li>";

		//on se connecte à la base de donnée
		$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=group20;charset=utf8','group20','mwsVo+5IXq');
		
		//on fait la requête SQL
		$req = "SELECT nom_scientifique, n_puce, COUNT(DISTINCT n_registre) AS nb_vete FROM Intervention 
				GROUP BY nom_scientifique, n_puce ORDER BY COUNT(DISTINCT n_registre), nom_scientifique, n_puce";
		
		echo "<table>";
			echo "<thead>";
				echo "<tr>";
					//nom des colonnes
					echo "<th> nom scientifique </th>";
					echo "<th> numero de puce </th>";
					echo "<th> nombre de veterinaires differents </th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				
					//les tuples
					$table_final = $bdd->query($req);
					while ($ligne=$table_final->fetch()){
					echo "<tr>";
						for($j=0; $j<3; $j++)
							echo "<td> ".$ligne[$j]." </td>";
					echo "</tr>";
					}
				
			echo "</tbody>";
		echo "</table>";		
	?>
	</body>