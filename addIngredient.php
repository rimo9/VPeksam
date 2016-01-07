<?php
	$page_title = "Lisa koostisosa";
	$file_name = "addIngredient.php";

	require_once("header.php");

	//muutujad
	$ingredient = $price = $ingredient_error = $price_error = "";	
	
	if(isset($_POST["create"])){
		//kas on tühi
		if(empty($_POST["ingredient"])){
			//jah oli tühi
			$ingredient_error = "Koostisosa on vajalik";
		}else{
			$ingredient = test_input($_POST["ingredient"]);
		}
			
		//kas on tühi
		if(empty($_POST["price"])){
			//jah oli tühi
			$price_error= "Hind on vajalik";
		}else{
			$price = test_input($_POST["price"]);
		}
		
		//kui errorit ei ole
		if($ingredient_error == "" && $price_error == ""){
				$msg = addIngredient($ingredient, $price);
				if($msg != ""){
					//salvestamine õnnestus, teen väljad tühjaks
					$ingredient = "";
					$price = "";
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

<h2>Lisa uus koostisosa</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="ingredient" >Koostisosa</label><br>
	<input size="20" id="ingredient" name="ingredient" type="text" value="<?=$ingredient; ?>"> <?=$ingredient_error; ?><br><br>
  	<label for="price" >Hind</label><br>
	<input size="20" id="price" name="price" type="number" value="<?=$price; ?>"> <?=$price_error; ?><br><br>
  	<input type="submit" name="create" value="Lisa">
  </form>
<?php require_once("footer.php"); ?>
<!-- Page End -->