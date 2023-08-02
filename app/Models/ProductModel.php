<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class ProductModel extends Model
{

    function getAllData() {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        return $builder->get()->getResult();
    }

    function insertData($data) {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->insert($data);
    }

    function updateData($id, $data) {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->where('kode', $id);
        $builder->update($data); 
    }
       

    function showData($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->where('kode_', $id);
        $result = $builder->get()->getRow();
        return $result;
    }

    function deleteData($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->where('kode', $id);
        $builder->delete();
    }
}