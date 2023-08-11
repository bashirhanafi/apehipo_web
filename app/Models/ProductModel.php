<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class ProductModel extends Model
{

    protected $table      = 'product';
    protected $primaryKey = 'kode';
    protected $allowedFields = ['nama', 'jenis', 'harga', 'stok', 'deskripsi', 'foto', 'klasifikasi', 'status', 'id_user'];



    function getAllData() {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        return $builder->get()->getResult();
    }

    function getDataStatus($status, $id) {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->where('status', $status);
        $builder->where('id_user', $id);
        return $builder->get()->getResult();
    }

    function insertData($data) {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->insert($data);
    }

    function getLastId() {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->select('kode');
        $builder->orderBy('kode', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        if($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row->kode;
        }else {
            return "P0001";
        }
    }

    function getNextId($lastId) {
        $bagianNumerik = intval(substr($lastId, 1)) + 1;
        return "P" . str_pad($bagianNumerik, 3, '0', STR_PAD_LEFT);
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
        $builder->where('kode', $id);
        $result = $builder->get()->getRow();
        return $result;
    }

    function deleteData($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('product');
        $builder->where('kode', $id);
        $builder->delete();
    }

    // function getDataCatalog($id) {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('product');
    //     $builder->join('user', 'user.id_user = product.id_user');
    //     $builder->where('product.id_user', $id);
    //     return $builder->get()->getResult();
    // }
}