<?php
    require("config.php");
    session_start();
    $action = isset($_GET['action']) ? $_GET['action'] : "";
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $brandid = isset($_SESSION['brandid']) ? $_SESSION['brandid'] : "";

    if ($action != "login" && $action != "logout" && !$username) {
    	login();
    	exit;
    }

    switch($action) {
    	case 'login':
    	    login();
    	    break;
    	case 'logout':
    	    logout();
    	    break;
    	case 'newGood':
    	    newGood();
    	    break;
    	case 'editGood':
    	    editGood();
    	    break;
    	case 'deleteGood':
    	    deleteGood();
    	    break;
    	default:
    	    listGoods();
    }

    function login() {
    	$results = array();
    	$results['pageTitle'] = "Goodslist | New Goods";
        // connectivity to MySQL server
        $db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $databaseConnection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

    	if (isset($_POST['login'])) {
    		// User has posted the login form: attempt to log the user in
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);              
            
            $records = $databaseConnection->prepare('SELECT username, password, brandid FROM pmw_branduser WHERE username = :username');
            $records->bindParam(':username', $username, PDO::PARAM_STR);
            $records->execute();
            $branduserresults = $records->fetch(PDO::FETCH_ASSOC);
            if (count($branduserresults) > 0 && $password == $branduserresults['password']) {
                // Login successful: Create a session and redirect to the admin homepage
                $_SESSION['username'] = $branduserresults['username'];
                $_SESSION['brandid'] = $branduserresults['brandid'];
                header("Location: admin.php");
            } else {
                // Login failed: display an error message to the user
                $results['errorMessage'] = "Incorrect username or password. Please try again.";
                require(TEMPLATE_PATH."/admin/loginForm.php");
            }
    	} else {
    		// User has not posted the login form yet: display the form
    		require(TEMPLATE_PATH."/admin/loginForm.php");
    	}
    }

    function logout() {
    	unset($_SESSION['username']);
        unset($_SESSION['brandid']);
    	header("Location: admin.php");
    }

    function newGood() {
    	$results = array();
    	$results['pageTitle'] = "New Product";
    	$results['formAction'] = "newGood";

    	if (isset($_POST['saveChanges'])) {
    		// User has posted the good edit form: save the new good
    		$good = new Good;
    		$good->storeFormValues($_POST);
    		$good->insert();
            if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                $good->storeUploadedImage($_FILES['image']);
            }
            if (is_uploaded_file($_FILES['tryon_image']['tmp_name'])) {
                $good->storeUploadedTryonImage($_FILES['tryon_image']);
            }
    		header("Location: admin.php?status=changesSaved");
    	} elseif (isset($_POST['cancel'])) {
    		// User has cancelled their edits: return to the good list
    		header("Location: admin.php");
    	} else {
    		// User has not posted the good edit form yet: display the form
    		$results['good'] = new Good;
    		require(TEMPLATE_PATH."/admin/editGood.php");
    	}
    }

    function editGood() {
    	$results = array();
    	$results['pageTitle'] = "Edit Product";
    	$results['formAction'] = "editGood";
        $resultstryon = array();

    	if (isset($_POST['saveChanges'])) {
    		// User has posted the good edit form: save the good changes
    		if (!$good = Good::getById((int)$_POST['goodId'])) {
    			header("Location: admin.php?error=goodNotFound");
    			return;
    		}
    		$good->storeFormValues($_POST);  
            if (isset($_POST['deleteImage']) && $_POST['deleteImage'] == "yes") {
                $good->deleteImages();
            }
            if (isset($_POST['deleteTryonImage']) && $_POST['deleteTryonImage'] == "yes") {
                $good->deleteTryonImages();
            } 
            if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                $good->storeUploadedImage($_FILES['image']);
            }
            if (is_uploaded_file($_FILES['tryon_image']['tmp_name'])) {
                $good->storeUploadedTryonImage($_FILES['tryon_image']);
            }            
            $good->update();
    		header("Location: admin.php?status=changesSaved");
    	} elseif (isset($_POST['cancel'])) {
    		// User has cancelled their edits: return to the good list
    		header("Location: admin.php");
    	} else {
    		// User has not posted the good edit form yet: display the form
    		$results['good'] = Good::getById((int)$_GET['goodId']);

    		require(TEMPLATE_PATH."/admin/editGood.php");
    	}
    }

    function deleteGood() {
    	if (!$good = Good::getById((int)$_GET['goodId'])) {
    		header("Location: admin.php?error=goodNotFound");
    		return;
    	}
        $good->deleteImages();
    	$good->delete();
    	header("Location: admin.php?status=goodDeleted");
    }

    function listGoods() {
    	$results = array();
    	$data = Good::getList();
    	$results['goods'] = $data['results'];
    	$results['totalRows'] = $data['totalRows'];
    	$results['pageTitle'] = "All Goods";

    	if (isset($_GET['error'])) {
    		if ($_GET['error'] == "goodNotFound") {
    			$results['errorMessage'] = "Error: Good not found.";
    		}
    	}

    	if (isset($_GET['status'])) {
    		if ($_GET['status'] == "changesSaved") {
    			$results['statusMessage'] = "Your changes have been saved.";
    		}
    		if ($_GET['status'] == "goodDeleted") {
    			$results['statusMessage'] = "Good deleted.";
    		}
    	}

    	require(TEMPLATE_PATH."/admin/listGoods.php");
    }
?>