<?php
class AdminTransportController{	
	
	public function actionIndex(){
		User::checkAdmin();
		$title = "Вивід вcього транспорту";
		$transports = Transport::getAllTransport();
		$routes = Transport::getAllRoutes();
		$carriages = Transport::getAllTypeCarriage();

		require_once ROOT."/views/admin/AdminTransportIndex.php";
		return true;
	}

	public function actionCreate(){
		User::checkAdmin();
		$title = "Створення нового транспорту";
		$routes = Transport::getAllRoutes();
		$carriages = Transport::getAllTypeCarriage();
        if(isset($_POST['createTransport'])){

            Transport::createTransport(
                $_POST['name'],
                $_POST['description'],
                $_POST['carriage_id'],
                $_POST['route_id']
            );
        }
		require_once ROOT."/views/admin/AdminTransportCreate.php";
		return true;
	}

	public function actionEdit($id){
		User::checkAdmin();
		$transport = Transport::getTrasportById($id);
		$routes = Transport::getAllRoutes();
		$carriages = Transport::getAllTypeCarriage();
		if(isset($_POST['editTransport'])){
			Transport::editTransport(
										$id,
										$_POST['name'],
										$_POST['description'],
										$_POST['carriage_id'],
										$_POST['route_id']
									);
		}
		if(isset($_POST["createTimeStart"])){
			switch($_POST["createTimeStart"]){
				case "timeStartDirect":
					$insert_id = TimeRouteStart::createTimeRouteStart($id,true,false);
					//echo "Створити час відправки за прямим марштутом $insert_id ";
					break;

				case "timeStartRevert":
					$insert_id = TimeRouteStart::createTimeRouteStart($id,false,false);
					//echo "Створити час відправки за зворотнім маршрутом $insert_id";
					break;

				case "timeStartDirectRest":
					$insert_id = TimeRouteStart::createTimeRouteStart($id,true,true);
					//echo "Створити час відправки за прямим марштутом вихідний день $insert_id";
					break;

				case "timeStartRevertRest":
					$insert_id = TimeRouteStart::createTimeRouteStart($id,false,true);
					//echo "Створити час відправки за зворотнім маршрутом вихідний день $insert_id";
					break;
				default:
					break;
			}
		}

		if(isset($_POST["action"])&&$_POST["action"]=="saveTimeRouteStart"){
			if(isset($_POST['time_start'])){
				foreach ($_POST['time_start'] as $key => $oneRow){
					echo "Слід відредагувати запис в базі time_route_start з id ={$key} та записати туди значення  $oneRow<br>";
				}
			}
		}

		$aTimeStartDirect = TimeRouteStart::getTimeRouteStart($id,true,false);
		$aTimeStartRevert = TimeRouteStart::getTimeRouteStart($id,false,false);
		$aTimeStartDirectRest = TimeRouteStart::getTimeRouteStart($id,true,true);
		$aTimeStartRevertRest = TimeRouteStart::getTimeRouteStart($id,false,true);

		$title = "Редагування транспорту";
		require_once ROOT."/views/admin/AdminTransportEdit.php";
		return true;
	}

	public function actionDelete($id){
		User::checkAdmin();
		$title = "Видалення транспорту $id";

		Transport::deleteTransportById($id);
		echo '<script type="text/javascript">
           window.location = "'.LOCALPATH.'/admin/users"
      	</script>';
		require_once ROOT."/views/admin/AdminTransportDelete.php";
		return true;
	}
}

