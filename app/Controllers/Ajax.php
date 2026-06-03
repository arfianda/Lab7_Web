<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ArtikelModel;

class Ajax extends Controller
{
    protected $artikelModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
    }

    /**
     * Display AJAX page
     */
    public function index()
    {
        $data = [
            'title' => 'Data Artikel - AJAX',
        ];
        return view('ajax/index', $data);
    }

    /**
     * Get all articles data
     */
    public function getData()
    {
        $articles = $this->artikelModel->findAll();
        return $this->response->setJSON($articles);
    }

    /**
     * Get article by ID
     */
    public function getDetail($id)
    {
        $article = $this->artikelModel->find($id);
        if (!$article) {
            return $this->response->setJSON(['error' => 'Artikel tidak ditemukan'], 404);
        }
        return $this->response->setJSON($article);
    }

    /**
     * Add new article
     */
    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'status' => $this->request->getPost('status'),
                'author' => $this->request->getPost('author'),
            ];

            // Generate slug from judul
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['judul']), '-'));
            $data['slug'] = $slug;

            if ($this->artikelModel->save($data)) {
                $lastId = $this->artikelModel->getInsertID();
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Artikel berhasil ditambahkan',
                    'id' => $lastId
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->artikelModel->errors()
                ], 400);
            }
        }
    }

    /**
     * Update article
     */
    public function update($id)
    {
        if ($this->request->getMethod() === 'post') {
            $article = $this->artikelModel->find($id);
            if (!$article) {
                return $this->response->setJSON(['error' => 'Artikel tidak ditemukan'], 404);
            }

            $data = [
                'id' => $id,
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'status' => $this->request->getPost('status'),
                'author' => $this->request->getPost('author'),
            ];

            // Generate slug from judul
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['judul']), '-'));
            $data['slug'] = $slug;

            if ($this->artikelModel->save($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Artikel berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->artikelModel->errors()
                ], 400);
            }
        }
    }

    /**
     * Delete article
     */
    public function delete($id)
    {
        $article = $this->artikelModel->find($id);
        if (!$article) {
            return $this->response->setJSON(['error' => 'Artikel tidak ditemukan'], 404);
        }

        if ($this->artikelModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Artikel berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus artikel'
            ], 400);
        }
    }
}
