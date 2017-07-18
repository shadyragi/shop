<?php
class searchcontroller extends controller
{
	public function search()
	{
		$data = [];
		$data["key"] = $_POST['search'];
		$errors = $this->validator->validate($data, [
			"key" => "required|word"
			]);
		if(count($errors) == 0)
		{
			echo "hi there";
			$products = (new product)->search("title", $data["key"]);
			
			return $this->view->render("search.php", $products, $data["key"]);
		}
		print_r($errors);
	}

}

?>