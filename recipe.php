<?php
$page_title = "Retseptid";
$file_name = "recipe.php";
?>
<?php
	//võtame kaasa
	require_once("functions.php");

	//kas kasutaja tahab kustutada, kas aadressi real on ?delete=??
	if(isset($_GET["delete"])){
		deleteRecipe($_GET["delete"]);
	}
	
	$Recipe_list = getRecipeData();
	
?>
<!-- Page Start -->
<?php require_once("header.php"); ?>

<h2>Retseptid</h2>
<table border=1>
	<tr>
		<th>id</th>
		<th>Retsept</th>
	</tr>
	<?php
		//iga massiivis oleva elemendi kohta, masiivi pikkus, $i++ = $i=$i+1
		for($i = 0; $i<count($Recipe_list); $i++){
				echo"<tr>";
				echo"<td>".$Recipe_list[$i]->id."</td>";
				echo"<td>".$Recipe_list[$i]->recipe."</td>";
				echo"<td style='text-align:center'><a href='?delete=".$Recipe_list[$i]->id."'>Eemalda</a></td>";
				echo"<td style='text-align:center'><a href='editRecipe.php?edit=".$Recipe_list[$i]->id."'>Muuda Nime</a></td>";
				echo"<td style='text-align:center'><a href='editRecipeIngredients.php?edit=".$Recipe_list[$i]->id."'>Muuda koostisosi</a></td>";
				echo"</tr>";
		}
	?>
</table>
<td style='text-align:center'><a href='addRecipe.php'>Lisa Retsepti nimi</a></td>

<?php require_once("footer.php"); ?>
<!-- Page End -->