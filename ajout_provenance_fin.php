	<meta charset="UTF-8">
	<head><title>Ajouter une provenance</title></head>
    <body>
	<?php
		//lien vers le menu
		echo "<li><a href='Menu.php'>Menu</a></li><br/>";

		if(isset($_POST['valider'])){			
			//on se connecte à la base de données
			$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=group20;charset=utf8','group20','mwsVo+5IXq');	
			
			$req = "SELECT DISTINCT(nom_institution) FROM Institution";
			$result = $bdd->query($req);
			
			$i=0;
			while($ligne=$result->fetch()){
				$noms_inst[$i] = $ligne[0];
				$i = $i+1;
			}		
			
			$is_not = 0;
			for($i=0; $i<sizeof($noms_inst); $i++){
				//l'institution existe déjà
				if($noms_inst[$i] == $_POST['institution']){ 
					$is_not = 1;			
					//on insère la provenance dans la base de données
					$insert = "INSERT INTO Provenance VALUES (\"".$_GET['nom_scientifique']."\", \"".$_GET['n_puce']."\", \"".$_POST['institution']."\")";	
					echo $insert;
					$bdd->query($insert);
					echo "<br/> L'animal ainsi que sa provenance ont été inséré dans la base de données avec succès";
					break;
				}
			}
			if($is_not == 0){
				//on remplis les données pour ajouter une institution
				echo "<form method='post' action='ajout_institution_fin.php?nom_institution=".$_POST['institution']."&nom_s=".$_GET['nom_scientifique']."&n_puce=".$_GET['n_puce']."'>";
					echo "rue : <input type='text' name='requete[]' /><br/>"; 
					echo "code postal : <input type='text' name='requete[]' /><br/>"; 
					echo "pays : <input type='text' name='requete[]' /><br/>"; 
					
					echo "<input type='submit' name='valider' value='Ajouter' '/>";
				echo "</form>";
			}
		}
	?>
	</body>