<?php
	$page_title = "Lisa Retsept";
	$file_name = "addRecipe.php";

	require_once("header.php");

	//muutujad
	$recipe = $recipe_error = "";	
	
	if(isset($_POST["create"])){
		//kas on tühi
		if(empty($_POST["recipe"])){
			//jah oli tühi
			$recipe_error = "Nimi on vajalik";
		}else{
			$recipe = test_input($_POST["recipe"]);
		}
		
		//kui errorit ei ole
		if($recipe_error == "" ){
				$msg = addrecipe($recipe);
				if($msg != ""){
					//salvestamine õnnestus, teen väljad tühjaks
					$recipe = "";
					echo $msg;
				}
		}
	}
	function test_input($data) {
		$data = trim($data);                // võtab tühikud, tabid ja enterid ära
		$data = stripslashes($data);        // võtab \\ ära
		$data = htmlspecialchars($data);    // muudab asjad tekstiks
		return $data;	
	}
?>
<!-- Page Start -->

<h2>Lisa uus Retsept</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="recipe" >Nimi</label><br>
	<input size="20" id="recipe" name="recipe" type="text" value="<?=$recipe; ?>"> <?=$recipe_error; ?><br><br>
  	<input type="submit" name="create" value="Lisa">
  </form>
<?php require_once("footer.php"); ?>
<!-- Page End -->