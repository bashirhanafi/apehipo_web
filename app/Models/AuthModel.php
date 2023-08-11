<?php 
namespace App\Models;
 
use CodeIgniter\Model;
 
class AuthModel extends Model
{
    function doLogin($username, $password) {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->select('username, role');
        $builder->where('username', $username);
        $builder->where('password', $password);
        $result = $builder->get()->getRow();
        return $result;
    }

}