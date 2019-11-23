<?php

require_once(ENTITIES_DIR . "User.php");


function escape($search)
{
	$search = get_instance()->db->escape($search);
	$search = substr($search, 1, strlen($search)-2);
	return $search;
}

function isLoggedIn(){
	return get_instance()->session->userdata("idUser");
}

function cekRole($role){
	return get_instance()->session->userdata("role")==$role;
}

function isAdmin(){
	return cekRole(User::ADMIN);
}

function isDosen(){
	return cekRole(User::DOSEN);
}

function isPenilai(){
	return cekRole(User::PENILAI) || isDosen();
}

?>