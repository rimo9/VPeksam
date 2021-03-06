<?php
	$page_title = "Koostisosad";
	$file_name = "ingredients.php";

	//võtame kaasa
	require_once("header.php");

	//kas kasutaja tahab kustutada, kas aadressi real on ?delete=??
	if(isset($_GET["delete"])){
		deleteIngredient($_GET["delete"]);
	}
	
	$Ingredient_list = getIngredientData();
	
?>
<!-- Page Start -->

<h2>Koostisosad</h2>
<table border=1>
	<tr>
		<th>id</th>
		<th>Koostisosa</th>
		<th>hind</th>
	</tr>
	<?php
		//iga massiivis oleva elemendi kohta, masiivi pikkus, $i++ = $i=$i+1
		for($i = 0; $i<count($Ingredient_list); $i++){
				echo"<tr>";
				echo"<td>".$Ingredient_list[$i]->id."</td>";
				echo"<td>".$Ingredient_list[$i]->ingredient."</td>";
				echo"<td>".$Ingredient_list[$i]->price."</td>";
				echo"<td style='text-align:center'><a href='?delete=".$Ingredient_list[$i]->id."'>Eemalda</a></td>";
				echo"<td style='text-align:center'><a href='edit.php?edit=".$Ingredient_list[$i]->id."'>Muuda</a></td>";
				echo"</tr>";
		}
	?>
</table>
<td style='text-align:center'><a href='addIngredient.php'>Lisa koostisosi</a></td>

<?php require_once("footer.php"); ?>
<!-- Page End -->