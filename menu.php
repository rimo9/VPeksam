<h3>Menu</h3>
<?php require_once("functions.php");?>
<ul>
	<?php if($file_name == "home.php"){
		echo "<li>Home Page</li>";
	}else{
		echo '<li><a href="home.php">Home Page</a></li>';}
	?>
	
	<?php if($file_name == "ingredients.php"){
		echo "<li>Koostisosad</li>";
	}else{
		echo '<li><a href="ingredients.php">Koostisosad</a></li>';}
	?>
	
	<?php if($file_name == "recipe.php"){
		echo "<li>Retseptid</li>";
	}else{
		echo '<li><a href="recipe.php">Retseptid</a></li>';}
	?>
</ul>