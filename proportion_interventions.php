	<meta charset="UTF-8">
	<head><title>Proportion d'interventions</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li>";

		//on se connecte à la base de donnée
		$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=group20;charset=utf8','group20','mwsVo+5IXq');
		
		//on prend tous les noms d'espèces qui existent dans la BDD pour effectuer une requete par espèce
		$req = "SELECT nom_scientifique FROM Espece";
		$nom_scientifique = $bdd->query($req);
		$i=0;
		$nb_animaux_ko=0;
		while($ligne = $nom_scientifique->fetch()){
			$req = "SELECT COUNT(n_puce) AS animaux_ko
			FROM ((SELECT n_enclos, climat
				FROM Enclos) AS enclos_bis
				NATURAL JOIN
				(SELECT nom_scientifique, n_puce, n_enclos
				FROM Animal
				WHERE nom_scientifique=\"".$ligne[0]."\") AS animal_bis
				NATURAL JOIN
				(SELECT DISTINCT(n_intervention), nom_scientifique, n_puce
				FROM Intervention
				WHERE nom_scientifique=\"".$ligne[0]."\") AS intervention_bis)
			WHERE climat NOT IN (
				SELECT DISTINCT(nom_climat)
				FROM Climat
				WHERE nom_scientifique=\"".$ligne[0]."\")";
			$animaux_ko_dans_espece = $bdd->query($req);
			$ajout = $animaux_ko_dans_espece->fetch();
			$nb_animaux_ko = $nb_animaux_ko + $ajout[0];
			$i = $i+1;
		}

		$req = "SELECT COUNT(n_intervention) AS nb_interventions FROM Intervention";
		$resultat = $bdd->query($req);
		$nb_interventions = $resultat->fetch();
		$proportion = $nb_animaux_ko / $nb_interventions[0];
		
		//on affiche le résultat
		echo "La proportion d'interventions effectuées sur des animaux présents dans un enclos dont le climat 
				ne correspond pas à l'un de ceux supportés par son espèce est de : ".$proportion." .<br/>";	
		$proportion = $proportion*100;
		echo "<br/> Soit ".$proportion." %.<br/>";
	?>
	</body>