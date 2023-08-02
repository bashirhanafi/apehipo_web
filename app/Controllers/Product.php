<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
use CodeIgniter\HTTP\RequestTrait;

class Product extends ResourceController
{
    use RequestTrait;

    // all users
    public function index()
    {
        $model = new ProductModel();
        $data = $model->getAllData();
        return $this->respond($data);
    }

    public function create()
    {
        $model = new ProductModel();
        $data = [
            'kode' => $this->request->getVar('kode'),
            'nama' => $this->request->getVar('nama'),
            'jenis' => $this->request->getVar('jenis'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'foto' => $this->request->getVar('foto'),
            'id_kebun' => $this->request->getVar('id_kebun'),
        ];
        $model->insertData($data);
        $response = [
            'status' => '201',
            'error' => 'null',
            'message' => [
                'success' => 'Data produk berhasil ditambahkan'
            ]
        ];
        return $this->respondCreated($response);
    }

    public function show($id = null)
    {
        $model = new ProductModel();
        $data = $model->showData($id);
        return $this->respond($data);
        // $data = $model->where('kode_produk', $id)->first();
        // if ($data) {
        //     return $this->respond($data);
        // } else {
        //     return $this->failNotFound("Data tidak ditemukan");
        // }
    }

    public function update($id = null)
    {
        $model = new ProductModel();
        $data = [
            'nama_produk' => $this->request->getRawInput('nama'),
        ];
        $model->updateData($id, $data);
        $response = [
            'status' => $data,
            'error' => null,
            'messages' => [
                'success' => 'Data produk berhasil diubah'
            ]
        ];
        return $this->respondUpdated($response);
    }

    // public function update($id = null)
    // {
    //     $model = new ProductModel();
    //     $data = [
    //         'nama_produk' => $this->request->getVar('nama_produk'),
    //     ];
    //     $model->update($id, $data);
    //     $response = [
    //         'status'   => 200,
    //         'error'    => null,
    //         'messages' => [
    //             'success' => 'Data produk berhasil diubah.'
    //         ]
    //     ];
    //     return $this->respond($response);
    // }

    public function delete($id = null)
    {
        $model = new ProductModel();
        $model->deleteData($id);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data produk berhasil dihapus'
            ]
        ];
        return $this->respondDeleted($response);
    }
}
