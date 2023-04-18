	<meta charset="UTF-8">
	<head><title>Ajouter un animal</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li>";
		
		if(isset($_POST['valider'])){	
			if(isset($_POST['requete'])){
				$i=0;
				foreach($_POST['requete'] as $valeur){
					if(empty($valeur) || $valeur == "val")
						header('Location: ajout_animal.php',true,301);
					
					$requetes[$i] = $valeur;				
					$i= $i + 1;
				}
			}
			else
				header('Location: ajout_animal.php',true,301);
			
			//on se connecte à la base de donnée
			$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=group20;charset=utf8','group20','mwsVo+5IXq');

			//on prend le nouveau numéro de puce
			$result=$bdd->query("SELECT MAX(n_puce) FROM Animal WHERE nom_scientifique = \"".$requetes[0]."\"");
			
			while($ligne=$result->fetch())
				$n_puce_new = $ligne[0] + 1;
			
			//on fais la requête pour pouvoir ajouter un animal dans la base de données 
			$insert = "INSERT INTO Animal VALUES (\"".$requetes[0]."\", \"".$n_puce_new."\", \"".$requetes[1]."\", 
			\"".$requetes[2]."\", \"".$requetes[3]."/".$requetes[4]."/".$requetes[5]."\", \"".$requetes[6]."\")";

			echo $insert;
			echo "<br/>";
			
			//on fais la requête pour prendre les noms de climat correspondant au nom scientifique de l'animal
			$req = "SELECT DISTINCT(nom_climat) FROM Climat WHERE nom_scientifique = \"".$requetes[0]."\"";
			$result = $bdd->query($req);
			
			$j=0;
			while($ligne=$result->fetch()){
				$nom_climat[$j] = $ligne[0];
				$j = $j+1;
			}
			
			//on fais la requête pour prendre le climat de l'enclos
			$req = "SELECT climat FROM Enclos WHERE n_enclos = \"".$requetes[$i]."\"";
			$result = $bdd->query($req);
			while($ligne=$result->fetch())
				$climat_enclos = $ligne[0];
			
			//on comapre si le climat de l'enclos correspond à un des climats de l'espèce de l'animal
			$is_not = 0;
			for($i=0; $i<sizeof($nom_climat); $i++){
				if($nom_climat[$i] == $climat_enclos){
					$is_not = 1;
					break;
				}
			}
			if($is_not == 0)
				echo "<br/>Attention, le climat de l'enclos ne correspond pas à un des climats de l'espèce de l'animal<br/>";
			
			//on insère dans la base de données
			$bdd->query($insert);	
			
			//on demande si on veut ajouter la provenance
			echo "Voulez-vous ajouter la provenance de l'animal dans la base de données?";
			echo "<form method='post' action='ajout_provenance.php?nom_scientifique=".$requetes[0]."&n_puce_new=".$n_puce_new."'>";
				echo "<input type = 'radio' name = 'provenance' value = 'oui' checked = 'checked' /> Oui";
				echo "<input type = 'radio' name = 'provenance' value = 'non' /> Non ";
				
				echo "<input type='submit' name='valider' value='Valider' '/> ";
			echo "</form>";
				
		}
	?>
	</body>