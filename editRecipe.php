<?php
	require_once("functions.php");
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		updaterecipeName($_POST["id"],$_POST["recipe"]);
	}
	if(!isset($_GET["edit"])){
		//kui aadressi real ei ole ?edit=, suuname table lehele
		header("location: recipe.php");
	}else{
		//küsime andmebaasist andmed id järgi
		$recipe_object = getSingleRecipeData($_GET["edit"]);
		//var_dump($recipe_object);
	}
	//id mida muudame
	//echo $_GET["edit"];
	//vaja saada kätte kõige uuemad andmed id kohta
	
?>

<h2>Change Post</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>">
  	<label for="recipe" >Nimi</label><br>
	<input id="recipe" name="recipe" type="text" value="<?=$recipe_object->recipe;?>"><br><br>
  	<input type="submit" name="update" value="Salvesta">
  </form>