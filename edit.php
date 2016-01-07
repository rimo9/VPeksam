<?php
	require_once("functions.php");
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		updateIngredient($_POST["id"],$_POST["ingredient"],$_POST["price"]);
	}
	if(!isset($_GET["edit"])){
		//kui aadressi real ei ole ?edit=, suuname table lehele
		header("location: ingredients.php");
	}else{
		//küsime andmebaasist andmed id järgi
		$ingredient_object = getSingleIngredientData($_GET["edit"]);
		//var_dump($ingredient_object);
	}
	//id mida muudame
	//echo $_GET["edit"];
	//vaja saada kätte kõige uuemad andmed id kohta
	
?>

<h2>Change Post</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>">
  	<label for="ingredient" >Koostisosa</label><br>
	<input id="ingredient" name="ingredient" type="text" value="<?=$ingredient_object->ingredient;?>"><br><br>
  	<label for="price">Hind</label><br>
	<input id="price" name="price" type="number" value="<?=$ingredient_object->price;?>"<br><br>
  	<input type="submit" name="update" value="Salvesta">
  </form>