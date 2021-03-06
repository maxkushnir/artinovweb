<?php
class AdminArticleController {
	
	public function actionIndex(){
		User::checkAdmin();
		$title = "Вивід всіх статей";
		$articles = Article::getAllArticles();
		require_once ROOT."/views/admin/AdminArticleIndex.php";
		return true;
	}

	public function actionCreate(){
		User::checkAdmin();
		$title = "Створення статті";
		if(isset($_POST['createArticle'])){

			//ДЗ виправити предачу данних в метод createStation
			// Не передавати масив $_POST на пряму, поробити перевірки на вхідні дані
			// Створити масив $errors в який записувати всі помилки
			// У відображенні AdminStationCreate перед формою зробити перевірку чи цей масив є пустим і якщо не пустий то списком вивести всі помилки
			// $arrayArticle = [];

			Article::createArticle(
									$_POST['name'],
									$_POST['description'],
									$_POST['context'],
									$_POST['user_id'],
									$_POST['category_id'],
									$_POST['time_create']
								);
		}
		require_once ROOT."/views/admin/AdminArticleCreate.php";
		return true;
	}

	public function actionEdit($id){
		User::checkAdmin();
		if(isset($_POST['editArticle'])){
			Article::editArticle(
									$id,
									$_POST['name'],
									$_POST['description'],
									$_POST['context'],
									$_POST['user_id'],
									$_POST['category_id'],
									$_POST['time_edit']
								);
		}

		$title = "Редагування статті";
		$article = Article::getArticleById($id);
		require_once ROOT."/views/admin/AdminArticleEdit.php";
		return true;
	}

	public function actionDelete($id){
		User::checkAdmin();
		$title = "Видалення статті $id";

		Article::deleteArticleById($id);
		header("Location: ".LOCALPATH."admin/article");
		require_once ROOT."/views/admin/AdminArticleDelete.php";
		return true;
	}
}