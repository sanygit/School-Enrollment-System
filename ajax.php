<?php

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_settings'){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == 'save_enroll'){
	$save = $crud->save_enroll();
	if($save)
		echo $save;
}
if($action == 'save_level_section'){
	$save = $crud->save_level_section();
	if($save)
		echo $save;
}
if($action == 'save_faculty'){
	$save = $crud->save_faculty();
	if($save)
		echo $save;
}
if($action == 'save_student'){
	$save = $crud->save_student();
	if($save)
		echo $save;
}
if($action == 'save_school_year'){
	$save = $crud->save_school_year();
	if($save)
		echo $save;
}

if($action == 'load_faculty'){
	$list = $crud->load_faculty();
	if($list)
		echo $list;
}
if($action == 'switch_year'){
	$switch = $crud->switch_year();
	if($switch)
		echo $switch;
}
if($action == 'load_student'){
	$list = $crud->load_student();
	if($list)
		echo $list;
}
if($action == 'load_level_section'){
	$list = $crud->load_level_section();
	if($list)
		echo $list;
}
if($action == 'load_school_year'){
	$list = $crud->load_school_year();
	if($list)
		echo $list;
}

if($action == 'remove_level_section'){
	$remove = $crud->remove_level_section();
	if($remove)
		echo $remove;
}
if($action == 'remove_faculty'){
	$remove = $crud->remove_faculty();
	if($remove)
		echo $remove;
}
if($action == 'remove_enroll'){
	$remove = $crud->remove_enroll();
	if($remove)
		echo $remove;
}
if($action == 'remove_school_year'){
	$remove = $crud->remove_school_year();
	if($remove)
		echo $remove;
}
if($action == 'publish_post'){
	$published = $crud->publish_post();
	if($published)
		echo $published;
}
if($action == 'remove_post'){
	$remove = $crud->remove_post();
	if($remove)
		echo $remove;
}
if($action == 'save_post'){
	$save = $crud->save_post();
	if($save)
		echo $save;
}