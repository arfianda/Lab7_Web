<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class Artikel extends BaseController
{
    protected $artikelModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
    }

    /**
     * PUBLIC SIDE
     */

    /**
     * Display list of published articles
     */
    public function index(): string
    {
        $data = [
            'title' => 'Daftar Artikel',
            'articles' => $this->artikelModel->getPublished(),
        ];

        return view('artikel/public_index', $data);
    }

    /**
     * Display article detail by slug
     */
    public function detail($slug = null): string
    {
        if (!$slug) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        $article = $this->artikelModel->getBySlug($slug);

        if (!$article) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        // Redirect jika draft
        if ($article['status'] == 0) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak dipublikasikan');
        }

        $data = [
            'title' => $article['judul'],
            'article' => $article,
        ];

        return view('artikel/detail', $data);
    }

    /**
     * ADMIN SIDE
     */

    /**
     * Display admin list of articles with AJAX support
     */
    public function adminIndex()
    {
        $title = 'Kelola Artikel';
        $model = new ArtikelModel();
        $q = $this->request->getVar('q') ?? '';
        $page = $this->request->getVar('page') ?? 1;
        $sort = $this->request->getVar('sort') ?? 'created_at';
        $order = $this->request->getVar('order') ?? 'DESC';

        // Validate sort column to prevent SQL injection
        $allowedSortColumns = ['id', 'judul', 'author', 'status', 'created_at'];
        if (!in_array($sort, $allowedSortColumns)) {
            $sort = 'created_at';
        }

        // Validate order
        if (!in_array(strtoupper($order), ['ASC', 'DESC'])) {
            $order = 'DESC';
        }

        $builder = $model->table('articles');

        // Apply search filter
        if ($q != '') {
            $builder->like('judul', $q)->orLike('isi', $q);
        }

        // Apply sorting
        $builder->orderBy($sort, $order);

        // Paginate
        $perPage = 10;
        $artikel = $builder->paginate($perPage, 'default', (int)$page);
        $pager = $model->pager;

        $data = [
            'title' => $title,
            'q' => $q,
            'sort' => $sort,
            'order' => $order,
            'artikel' => $artikel,
            'pager' => $pager
        ];

        // Return JSON for AJAX requests
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        } else {
            // Regular view response
            return view('artikel/admin_index', $data);
        }
    }

    /**
     * Search articles with AJAX support
     */
    public function search()
    {
        $keyword = $this->request->getVar('q') ?? '';
        $page = $this->request->getVar('page') ?? 1;
        $sort = $this->request->getVar('sort') ?? 'created_at';
        $order = $this->request->getVar('order') ?? 'DESC';

        // Validate sort column to prevent SQL injection
        $allowedSortColumns = ['id', 'judul', 'author', 'status', 'created_at'];
        if (!in_array($sort, $allowedSortColumns)) {
            $sort = 'created_at';
        }

        // Validate order
        if (!in_array(strtoupper($order), ['ASC', 'DESC'])) {
            $order = 'DESC';
        }

        $model = new ArtikelModel();
        $builder = $model->table('articles');

        if ($keyword) {
            $builder->like('judul', $keyword)->orLike('isi', $keyword);
        }

        $builder->orderBy($sort, $order);

        $perPage = 10;
        $artikel = $builder->paginate($perPage, 'default', (int)$page);
        $pager = $model->pager;

        $data = [
            'title' => 'Cari Artikel: ' . $keyword,
            'q' => $keyword,
            'sort' => $sort,
            'order' => $order,
            'artikel' => $artikel,
            'pager' => $pager
        ];

        // Return JSON for AJAX requests
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        } else {
            // Regular view response
            return view('artikel/admin_index', $data);
        }
    }

    /**
     * Show add form
     */
    public function add(): string
    {
        $data = [
            'title' => 'Tambah Artikel',
            'validation' => \Config\Services::validation(),
        ];

        return view('artikel/form_add', $data);
    }

    /**
     * Store new article
     */
    public function store()
    {
        // Get form data
        $judul = $this->request->getPost('judul');
        $isi = $this->request->getPost('isi');
        $status = $this->request->getPost('status') ?? 0;
        $author = $this->request->getPost('author');
        $slug = trim($this->request->getPost('slug'));

        // Generate slug if empty
        if (empty($slug) && !empty($judul)) {
            $slug = ArtikelModel::createSlug($judul);
        }

        // Handle image upload
        $gambar = null;
        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file
            if (!$file->getName()) {
                return redirect()->back()->withInput()->with('error', 'File upload gagal');
            }

            $fileName = $file->getRandomName();
            $filePath = ROOTPATH . 'public/uploads/artikel';

            // Ensure directory exists
            if (!is_dir($filePath)) {
                mkdir($filePath, 0755, true);
            }

            // Move file
            try {
                $file->move($filePath, $fileName);
                $gambar = $fileName;
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal upload gambar: ' . $e->getMessage());
            }
        }

        $data = [
            'judul' => $judul,
            'isi' => $isi,
            'slug' => $slug,
            'gambar' => $gambar,
            'status' => $status,
            'author' => $author,
        ];

        // Validate and save
        if (!$this->artikelModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $this->artikelModel->errors());
        }

        try {
            if ($this->artikelModel->insert($data)) {
                return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil ditambahkan');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan artikel: ' . $e->getMessage());
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan artikel');
    }

    /**
     * Show edit form
     */
    public function edit($id = null): string
    {
        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        $article = $this->artikelModel->find($id);

        if (!$article) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Artikel',
            'article' => $article,
            'validation' => \Config\Services::validation(),
        ];

        return view('artikel/form_edit', $data);
    }

    /**
     * Update article
     */
    public function update($id = null)
    {
        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        $article = $this->artikelModel->find($id);

        if (!$article) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        // Get form data
        $judul = $this->request->getPost('judul');
        $isi = $this->request->getPost('isi');
        $status = $this->request->getPost('status') ?? 0;
        $author = $this->request->getPost('author');
        $slug = trim($this->request->getPost('slug'));

        // Generate slug if empty
        if (empty($slug) && !empty($judul)) {
            $slug = ArtikelModel::createSlug($judul);
        }

        // Handle image upload
        $gambar = $article['gambar'];
        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                // Delete old image
                if ($article['gambar'] && file_exists(ROOTPATH . 'public/uploads/artikel/' . $article['gambar'])) {
                    unlink(ROOTPATH . 'public/uploads/artikel/' . $article['gambar']);
                }

                $fileName = $file->getRandomName();
                $filePath = ROOTPATH . 'public/uploads/artikel';

                // Ensure directory exists
                if (!is_dir($filePath)) {
                    mkdir($filePath, 0755, true);
                }

                $file->move($filePath, $fileName);
                $gambar = $fileName;
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal upload gambar: ' . $e->getMessage());
            }
        }

        $data = [
            'id' => $id,
            'judul' => $judul,
            'isi' => $isi,
            'slug' => $slug,
            'gambar' => $gambar,
            'status' => $status,
            'author' => $author,
        ];

        // Validate and update
        if (!$this->artikelModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $this->artikelModel->errors());
        }

        try {
            if ($this->artikelModel->update($id, $data)) {
                return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil diupdate');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate artikel: ' . $e->getMessage());
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengupdate artikel');
    }

    /**
     * Delete article
     */
    public function delete($id = null)
    {
        if (!$id) {
            return redirect()->to('/admin/artikel')->with('error', 'Artikel tidak ditemukan');
        }

        $article = $this->artikelModel->find($id);

        if (!$article) {
            return redirect()->to('/admin/artikel')->with('error', 'Artikel tidak ditemukan');
        }

        // Delete image if exists
        if ($article['gambar'] && file_exists(ROOTPATH . 'public/uploads/artikel/' . $article['gambar'])) {
            unlink(ROOTPATH . 'public/uploads/artikel/' . $article['gambar']);
        }

        if ($this->artikelModel->delete($id)) {
            return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil dihapus');
        }

        return redirect()->to('/admin/artikel')->with('error', 'Gagal menghapus artikel');
    }
}
