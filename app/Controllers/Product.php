<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
use CodeIgniter\HTTP\RequestTrait;

class Product extends ResourceController
{
    use RequestTrait;

    // protected $table            = 'product';
    // protected $primaryKey       = 'kode';
    // protected $allowedFields    = ['nama', 'jenis', 'harga', 'stok', 'deskripsi', 'foto', "klasifikasi", "status", "id_user"];

    // all users
    public function index()
    {
        $model = new ProductModel();
        $data2 = $model->getDataStatus("tampil", "0001");
        $data3 = $model->getDataStatus("arsip", "0001");
        $response1 = [];
        $response2 = [];
        foreach ($data2 as $row ) {
            $response1[] = array(
                'kode' => $row->kode,
                'nama' => $row->nama,
                'jenis' => $row->jenis,
                'harga' => $row->harga,
                'stok' => $row->stok,
                'deskripsi' => $row->deskripsi,
                'foto' => base_url('gambar/'.$row->foto),
                'klasifikasi' => $row->klasifikasi,
                'status' => $row->status,
                'id_user' => $row->id_user
            );
        }
        foreach ($data3 as $row ) {
            $response2[] = array(
                'kode' => $row->kode,
                'nama' => $row->nama,
                'jenis' => $row->jenis,
                'harga' => $row->harga,
                'stok' => $row->stok,
                'deskripsi' => $row->deskripsi,
                'foto' => base_url('gambar/'.$row->foto),
                'klasifikasi' => $row->klasifikasi,
                'status' => $row->status,
                'id_user' => $row->id_user
            );
        }
        $hasil = [
            'data_tampil' => $response1,
            'data_arsip' => $response2,
        ];

        return $this->respond($hasil);
    }

    public function create()
    {
        $model = new ProductModel();

        // 
        $id_sebelumnya = $model->getLastId();
        $id_selanjutnya = $model->getNextId($id_sebelumnya);
    
        //proses upload
        $gambar = $this->request->getFile('foto');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('gambar', $namaGambar);
        $data = [
            'kode' => $id_selanjutnya,
            'nama' => esc($this->request->getVar('nama')),
            'jenis' => esc($this->request->getVar('jenis')),
            'harga' => esc($this->request->getVar('harga')),
            'stok' => esc($this->request->getVar('stok')),
            'deskripsi' => esc($this->request->getVar('deskripsi')),
            'foto' => $namaGambar,
            'status' => esc($this->request->getVar('status')),
            'id_user' => esc($this->request->getVar('id_user')),
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

        // proses upload gambars
        $gambar = $this->request->getFile('foto');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('gambar', $namaGambar);
        $data = [
            'nama' => $this->request->getVar('nama'),
            'jenis' => $this->request->getVar('jenis'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'klasifikasi' => $this->request->getVar('klasifikasi'),
            'status' => $this->request->getVar('status'),
            'id_user' => $this->request->getVar('id_user'),
            'foto' => $namaGambar,
        ];
        $model->update($id, $data);
        $response = [
            'status' => $data,
            'error' => null,
            'messages' => [
                'success' => 'Data produk berhasil diubah'
            ]
        ];
        return $this->respondUpdated($response);
    }

    public function ubah($id = null) {
        $model = new ProductModel;
        $data = [
            'status' => $this->request->getVar('status')
        ];
        $model->update($id, $data);
        $response= [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data produk berhasil diubah.'
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
