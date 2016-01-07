<?php
class RecipeIngredientManager{
	private $connection;
	function __construct($mysqli){
		$this->connection=$mysqli;
	}
	/*function addIngredient($ingredient_name, $recipe_id){
		$response=new StdClass();
		$stmt=$this->connection->prepare("SELECT koostisosa FROM retsept_koos JOIN retsept_koostiososad ON retsept_koostiososad.id = retsept_koos.koostisosa_id WHERE koostisosa = ? AND retseptinimi_id = ?");
		$stmt->bind_param("si", $ingredient_name, $recipe_id);
		$stmt->execute();
		if($stmt->fetch()){
			$error=new StdClass();
			$error->id=0;
			$error->message="koostisosa juba olemas";
			$response->error=$error;
			return $response;
		}
		$stmt->close();
		$stmt=$this->connection->prepare("INSERT INTO interests (name) VALUES (?)");
		$stmt->bind_param("s", $new_interest);
		if($stmt->execute()){
			$success=new StdClass();
			$success->message="Successfully added new interest";
			$response->success=$success;
		}else{
			$error=new StdClass();
			$error->id=1;
			$error->message="Something broke";
			$response->error=$error;
		}
		$stmt->close();
		return $response;
	}*/
	function createDropdown(){
		$html = '';
		$html.='<select name="dropdownselect">';
		$stmt=$this->connection->prepare("SELECT id, koostisosa from retsept_koostiososad");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		while($stmt->fetch()){
			$html.='<option value="'.$id.'">'.$name.'</option>';
		}
		$stmt->close();
		$html.='</select>';
		return $html;
	}
	//olemas
	function addRecipeIngredient($new_ingredient_id, $recipe_id){
		$response=new StdClass();
		$stmt=$this->connection->prepare("SELECT koostisosa_id FROM retsept_koos WHERE koostisosa_id = ? AND retseptinimi_id = ?");
		$stmt->bind_param("ii", $new_ingredient_id, $recipe_id);
		$stmt->execute();
		if($stmt->fetch()){
			$error=new StdClass();
			$error->id=0;
			$error->message="Koostisosa juba listis olemas";
			$response->error=$error;
			return $response;
		}
		$stmt->close();
		$stmt=$this->connection->prepare("INSERT INTO retsept_koos (koostisosa_id, retseptinimi_id) VALUES (?, ?)");
		$stmt->bind_param("ii", $new_ingredient_id, $recipe_id);
		if($stmt->execute()){
			$success=new StdClass();
			$success->message="Edukalt lisatud uus koostisosa";
			$response->success=$success;
		}else{
			$error=new StdClass();
			$error->id=1;
			$error->message="Midagi läks katki";
			$response->error=$error;
		}
		$stmt->close();
		return $response;
	}
	function getUserInterests($user_id){
		$html='';
		$stmt=$this->connection->prepare("SELECT interests.name FROM user_interests INNER JOIN interests ON user_interests.interests_id = interests.id WHERE user_interests.user_id = ?");
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($name);
		$stmt->execute();
		while($stmt->fetch()){
			$html.=$name." ";
		}
		$stmt->close();
		return $html;
	}
}?>