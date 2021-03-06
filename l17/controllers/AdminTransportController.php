<?php
require_once ROOT."/models/Transport.php";
class AdminTransportController{
	function __construct(){}
	
	public function actionIndex(){
		$title = "Вивід вcього транспорту";
		$transports = Transport::getAllTransport();
		$routes = Transport::getAllRoutes();
		$carriages = Transport::getAllTypeCarriage();

		require_once ROOT."/views/admin/AdminTransportIndex.php";
		return true;
	}

	public function actionCreate(){
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

		$title = "Редагування транспорту";
		require_once ROOT."/views/admin/AdminTransportEdit.php";
		return true;
	}

	public function actionDelete($id){
		$title = "Видалення транспорту $id";

		Transport::deleteTransportById($id);
		echo '<script type="text/javascript">
           window.location = "'.LOCALPATH.'/admin/users"
      	</script>';
		require_once ROOT."/views/admin/AdminTransportDelete.php";
		return true;
	}
}

