<?php

    require("config.php");
    $action = isset($_GET['action']) ? $_GET['action'] : "";

    switch($action) {
    	case 'goodslist':
    	    goodslist();
    	    break;
    	case 'viewGood':
    	    viewGood();
    	    break;
    	default:
    	    homepage();
    }

    function goodslist() {
    	$results = array();
    	$data = Good::getList();
    	$results['goods'] = $data['results'];
    	$results['totalRows'] = $data['totalRows'];
    	$results['pageTitle'] = "Goodslist | New Goods";
    	require(TEMPLATE_PATH."/goodslist.php");
    }

    function viewGood() {
    	if (!isset($_GET['goodId']) || !$_GET['goodId']) {
    		homepage();
    		return;
    	}
    	$results = array();
    	$results['good'] = Good::getById((int)$_GET['goodId']);
    	$results['pageTitle'] = $results['good']->title." | New Goods";
    	require(TEMPLATE_PATH."/viewGood.php");
    }

    function homepage() {
    	$results = array();
    	$data = Good::getList(HOMEPAGE_NUM_GOODS);
    	$results['goods'] = $data['results'];
    	$results['totalRows'] = $data['totalRows'];
    	$results['pageTitle'] = "New Goods";
    	require(TEMPLATE_PATH."/homepage.php");
    }

?>