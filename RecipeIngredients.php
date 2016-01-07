<?php

	$page_title = "Retsepti koostisosad";
	$file_name = "RecipeIngredients.php";

	//võtame kaasa
	require_once("header.php");
	require_once("RecipeIngredientManager.class.php");
	require_once("database.php");
	if(isset($_GET["edit"])){
		$_SESSION["recipe_id"] = $_GET["edit"];
	}
	//kas kasutaja tahab kustutada, kas aadressi real on ?delete=??
	if(isset($_GET["delete"])){
		deleteRecipeIngredient($_GET["delete"]);
	}
	
	$RecipeIngredientManager = new RecipeIngredientManager($mysqli);
	if(isset($_GET["dropdownselect"])){
		$added_recipe_ingredients = $RecipeIngredientManager->addRecipeIngredient($_GET["dropdownselect"], $_SESSION["recipe_id"]);
	}
	
	$RecipeIngredient_list = getRecipeIngredientData($_SESSION["recipe_id"]);
	
?>

<!-- Page Start -->

<h2>Koostisosad</h2>
<table border=1>
	<tr>
		<th>id</th>
		<th>Koostisosa</th>
	</tr>
	<?php
		//iga massiivis oleva elemendi kohta, masiivi pikkus, $i++ = $i=$i+1
		for($i = 0; $i<count($RecipeIngredient_list); $i++){
				echo"<tr>";
				echo"<td>".$RecipeIngredient_list[$i]->id."</td>";
				echo"<td>".$RecipeIngredient_list[$i]->recipe."</td>";
				echo"<td style='text-align:center'><a href='?delete=".$RecipeIngredient_list[$i]->id."'>Eemalda</a></td>";
				echo"</tr>";
		}
	?>
</table><br>
<h2>Lisa koostisosa</h2>
	<?php if(isset($added_user_interests->error)):?>
	<p style="color:red;"><?=$added_user_interests->error->message;?></p>
	<?php elseif(isset($added_user_interests->success)):?>
	<p style="color:green;"><?=$added_user_interests->success->message;?></p>
	<?php endif;?>
<form>
	<?=$RecipeIngredientManager->createDropdown();?>
	<input type="submit">
</form>

<?php require_once("footer.php"); ?>
<!-- Page End -->