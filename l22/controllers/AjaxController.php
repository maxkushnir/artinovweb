<?php
class AjaxController{
	
	public function actionIndex(){
		
		if(isset($_POST['action'])&&($_POST['action']=="moreNews")){
			$this->actionMoreNews($_POST['startFrom']);
		}

		if(isset($_POST['action'])&&($_POST['action']=="delete")){
			$this->actionDelete($_POST["nameModel"],$_POST["id"]);
		}

		if(isset($_POST['action'])&&($_POST['action']=="routeStation")){
			echo json_encode(Route::getStationCoordinateRouteById($_POST['id']));
		}

		if(isset($_POST['action'])&&($_POST['action']=="routeStationInfo")){
			echo json_encode(Route::routeStationInfo($_POST['id']));
		}

		if(isset($_POST['action'])&&($_POST['action']=="getAllStationsForMap")){
			echo json_encode(Station::getAllStationsForMap());
		}


		return true;
	}

	private function actionDelete($nameModel,$id){
		
		switch ($nameModel) {
			case 'station':
				Station::deleteStationById($id);
				break;

			case 'transport':
				Transport::deleteTransportById($id);
				break;

			case 'route':
				Route::deleteRouteById($id);
				break;

			case 'category':
				Category::deleteCategoryById($id);
				break;

			case 'typeCarriage':
				TypeCarriage::deleteTypeCarriageById($id);
				break;

			case 'user':
				User::deleteUserById($id);
				break;

			case 'article':
				Article::deleteArticleById($id);
				break;

			case 'images':
				Resource::deleteResourceById($id);
				break;
			
			default:
				echo 0;
				break;
		}
	}

	private function actionMoreNews($startFrom){
		$archiveNews = Article::getAllArticlesPagination($startFrom);
		$images = Resource::getAllResourcesTypeImg();
		foreach ($archiveNews as $key => $news) {
			foreach ($images as $keyz => $image) {
				if($image['id'] == $news['resources_id']) $archiveNews[$key]['resources_id'] = $image['name'];
			}
		}
		echo json_encode($archiveNews);
	}
}

