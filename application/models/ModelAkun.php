<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelAkun extends CI_Model {

  function login($username, $password){
 
 
		$sql = "SELECT User.id_user, role, nama, status_user, keterangan FROM User, LoginInfo WHERE username=? AND password=? AND LoginInfo.id_user=User.id_user";
		$query = $this->db->query($sql, array($username, $password));
		$response = $query->row_array();
		if (isset($response))
		{
			$response['result'] = 'OK';
		}else{
			$response = array();
			$response['result'] = 'FAIL';
			$response['errorMessage'] = 'Username atau password salah';
		}
		return $response;
  }

}