<?php
	//Kõik AB'iga seotud
	
	//ühenduse loomiseks kasutajaga
	require_once("../../configglobal.php");
	$database = "if15_rimo";

	//pamene sessioni käima, saame kasutada $_SESSION muutujaid
	session_start();
	
	function addIngredient ($ingredient, $price){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO retsept_koostiososad (koostisosa, hind) VALUES (?, ?)");
		$stmt->bind_param("si", $ingredient, $price);
		$message = "";
		if($stmt->execute()){
			//kui sisestus AB'i õnnestus
			$message = "Koostisosa on lisatud";
		}else{
			//kui midagi läks sisestuse käigus katki
			echo $stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $message;
	}
	function getIngredientData(){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, koostisosa, hind FROM retsept_koostiososad WHERE deleted IS NULL");
		$stmt->bind_result($id, $ingredient, $price);
		$stmt->execute();
		
		//tühi masiiv kus hoiame objekte(1rida andmeid)
		$array = array();
		//tee tsüklit nii palju kordi kui saad ab'st ühe rea andmeid
		while($stmt->fetch()){
			//loon objekti
			$ingredients = new StdClass();
			$ingredients->id = $id;
			$ingredients->ingredient = $ingredient;
			$ingredients->price = $price;
			array_push($array, $ingredients);
		}
		$stmt->close();
		$mysqli->close();
		return $array;
	}
	function deleteIngredient($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE retsept_koostiososad SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			//kui on edukas
			header("Location: ingredients.php");
		}
		$stmt->close();
		$mysqli->close();
	}
	function updateIngredient($id, $ingredient, $price){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE retsept_koostiososad SET koostisosa = ?, hind= ? WHERE id = ?");
		$stmt->bind_param("ssi", $ingredient, $price, $id);
		//kas õnnestus salvestada
		if($stmt->execute()){
			//echo("success");
		}else{	
		}
		$stmt->close();
		$mysqli->close();
	}
	function getSingleIngredientData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT koostisosa, hind FROM retsept_koostiososad WHERE id = ? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($ingredient, $price);
		$stmt->execute();
		$ingredients = new Stdclass();
		if($stmt->fetch()){
			$ingredients->ingredient = $ingredient;
			$ingredients->price = $price;
		}else{
			//ei saanud andmeid kätte, sellist id'd ei ole või on kustutatud
			header("Location: ingredients.php");
			//echo("test");
		}
		return $ingredients;
		
		$stmt->close();
		$mysqli->close();
	}
	function getRecipeData(){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, nimi FROM retsept_retseptinimi WHERE deleted IS NULL");
		$stmt->bind_result($id, $recipe_name);
		$stmt->execute();
		
		//tühi masiiv kus hoiame objekte(1rida andmeid)
		$array = array();
		//tee tsüklit nii palju kordi kui saad ab'st ühe rea andmeid
		while($stmt->fetch()){
			//loon objekti
			$recipe = new StdClass();
			$recipe->id = $id;
			$recipe->recipe = $recipe_name;
			array_push($array, $recipe);
		}
		$stmt->close();
		$mysqli->close();
		return $array;
	}
	function deleteRecipe($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE retsept_retseptinimi SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			//kui on edukas
			header("Location: recipe.php");
		}
		$stmt->close();
		$mysqli->close();
	}
	function updateRecipeName($id, $recipe){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE retsept_retseptinimi SET nimi = ? WHERE id = ?");
		$stmt->bind_param("si", $recipe, $id);
		//kas õnnestus salvestada
		if($stmt->execute()){
			//echo("success");
		}else{	
		}
		$stmt->close();
		$mysqli->close();
	}
	function getSingleRecipeData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT nimi FROM retsept_retseptinimi WHERE id = ? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($recipe_name);
		$stmt->execute();
		$recipe = new Stdclass();
		if($stmt->fetch()){
			$recipe->recipe = $recipe_name;
		}else{
			//ei saanud andmeid kätte, sellist id'd ei ole või on kustutatud
			header("Location: recipe.php");
			//echo("test");
		}
		return $recipe;
		
		$stmt->close();
		$mysqli->close();
	}
	function addrecipe ($recipe_name){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO retsept_retseptinimi (nimi) VALUES (?)");
		$stmt->bind_param("s", $recipe_name);
		$message = "";
		if($stmt->execute()){
			//kui sisestus AB'i õnnestus
			$message = "Retseptinimi on lisatud";
		}else{
			//kui midagi läks sisestuse käigus katki
			echo $stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $message;
	}
	function getRecipeIngredientData($recipe_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT retsept_koostiososad.id, koostisosa FROM retsept_koos JOIN retsept_koostiososad ON retsept_koostiososad.id = retsept_koos.koostisosa_id WHERE retsept_koos.deleted IS NULL AND retseptinimi_id = ?");
		$stmt->bind_param("i", $recipe_id);
		$stmt->bind_result($id, $ingredient_name);
		$stmt->execute();
		
		//tühi masiiv kus hoiame objekte(1rida andmeid)
		$array = array();
		//tee tsüklit nii palju kordi kui saad ab'st ühe rea andmeid
		while($stmt->fetch()){
			//loon objekti
			$recipe = new StdClass();
			$recipe->id = $id;
			$recipe->recipe = $ingredient_name;
			array_push($array, $recipe);
		}
		$stmt->close();
		$mysqli->close();
		return $array;
	}
	function deleteRecipeIngredient($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE retsept_koos SET deleted=NOW() WHERE koostisosa_id=? AND retseptinimi_id = ?");
		$stmt->bind_param("ii", $id, $_SESSION["recipe_id"]);
		if($stmt->execute()){
			//kui on edukas
			header("Location: RecipeIngredients.php");
		}
		$stmt->close();
		$mysqli->close();
	}
?>