<?php
	$page_title = "Lisa Retsept";
	$file_name = "addRecipe.php";

	require_once("header.php");

	//muutujad
	$recipe = $recipe_error = "";	
	
	if(isset($_POST["create"])){
		//kas on t�hi
		if(empty($_POST["recipe"])){
			//jah oli t�hi
			$recipe_error = "Nimi on vajalik";
		}else{
			$recipe = test_input($_POST["recipe"]);
		}
		
		//kui errorit ei ole
		if($recipe_error == "" ){
				$msg = addrecipe($recipe);
				if($msg != ""){
					//salvestamine �nnestus, teen v�ljad t�hjaks
					$recipe = "";
					echo $msg;
				}
		}
	}
	function test_input($data) {
		$data = trim($data);                // v�tab t�hikud, tabid ja enterid �ra
		$data = stripslashes($data);        // v�tab \\ �ra
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