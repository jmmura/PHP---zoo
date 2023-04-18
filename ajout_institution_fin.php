	<meta charset="UTF-8">
	<head><title>Ajouter une institution</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li>";

		if(isset($_POST['valider'])){
			$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=group20;charset=utf8','group20','mwsVo+5IXq');
			
			if(isset($_POST['requete'])){
				$i=0;
				foreach($_POST['requete'] as $valeur){					
					$requetes[$i] = $valeur;				
					$i= $i + 1;
				}
			}
			
			//on crée notre requête
			$insert = "INSERT INTO Institution VALUES (\"".$_GET['nom_institution']."\", ";	
			$i=0;
			while($i<sizeof($requetes)-1){
				if($requetes[$i] == "val")
					$insert .= "\"\"";
				else $insert .= "\"".$requetes[$i]."\", ";
				
				$i = $i+1;
			}
			$insert .= "\"".$requetes[$i]."\")";
			
			//on insère l'instituion dans la base de données
			echo $insert;
			echo "<br/>";
			$bdd->query($insert);
			
			//on insère la provenance dans la base de données
			$insert = "INSERT INTO Provenance VALUES (\"".$_GET['nom_s']."\", \"".$_GET['n_puce']."\", \"".$_GET['nom_institution']."\")";	
			echo $insert;
			$bdd->query($insert);
			echo "<br/>L'animal ainsi que sa provenance et l'institution ont été inséré dans la base de données avec succès <br/>";
			
		}
	?>
	</body>