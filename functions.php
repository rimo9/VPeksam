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
?>