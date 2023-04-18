    <meta charset="UTF-8">
	<head><title>Affichage des tables</title></head>
    <body>
		<?php
			//lien vers le menu
			echo "<li><a href='Menu.php'>Menu</a></li>";
		
			echo "<form method='post' action='choix_table.php'>";
				//on se connecte à la base de données
				$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=group20;charset=utf8','group20','mwsVo+5IXq');
				$result=$bdd->query("show tables");
				
				echo "<p><label>Selectionnez la table : </label>";
				
				//on sélectionne la table parmis celles dans la base de données
				echo "<select name=table>";
					echo "<option value='val'>Choisissez</option>";
					while ($ligne=$result->fetch()){
						echo "<option value='".$ligne[0]."'>".$ligne[0]."</option>";
					}
				echo "</select>";
				echo "<input type='submit' name='valider' value='Valider'/>"; 
			echo "</form>";
		
			//lorsque la table est validée
			if(isset($_POST['valider'])){
				$my_table = $_POST['table'];
				if($my_table != 'val'){
					$column=$bdd->query("show columns from $my_table");
					
					echo "La table sélectionnée est : $my_table<br/><br/>";
					echo "Sélectionnez les colonnes sur lesquelles appliquées des contraintes :";				

					//on choisis les colonnes sur lesquelles on veut des contraintes
					echo "<form method='post' action='choix_contraintes.php?table=".$my_table."' >";
						while($ligne=$column->fetch()){
							echo "<input type='checkbox' name='contraintes[]' value='".$ligne[0]."'>  ".$ligne[0]." ";
						}
						echo "<input type='submit' name='val_col' value='Valider' '/>";
					echo "</form>";
				}
				else header('Location: choix_table.php',true,301); 
			}
		?>
		
	</body>