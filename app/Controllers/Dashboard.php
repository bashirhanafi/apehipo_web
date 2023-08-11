<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\DashboardModel;
use CodeIgniter\HTTP\RequestTrait;

class Dashboard extends ResourceController
{
    use RequestTrait;

    // all users
    public function index()
    {
        $model = new DashboardModel();
        $data = $model->getAllData();
        $data1 = $model->getKlasifikasi("penjualan eksklusif");
        $data2 = $model->getKlasifikasi("penjualan terbaik");
        $data3 = $model->getKlasifikasi("sedang laris");
        $x = [
            'semua_produk' => $data,
            'penjualan_eksklusif' => $data1,
            'penjualan_terbaik' => $data2,
            'sedang_laris' => $data3,
        ];
        return $this->respond($x);
    }

    public function create()
    {
        $model = new DashboardModel();
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
        $model = new DashboardModel();
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
        $model = new DashboardModel();
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
    //     $model = new DashboardModel();
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
        $model = new DashboardModel();
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
