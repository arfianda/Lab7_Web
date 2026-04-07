<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['judul', 'isi', 'gambar', 'status', 'slug', 'author', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'judul'  => 'required|string|min_length[5]|max_length[200]',
        'isi'    => 'required|string|min_length[10]',
        'slug'   => 'required|string|regex_match[/^[a-z0-9\-]+$/]|is_unique[articles.slug,id,{id}]',
        'status' => 'required|in_list[0,1]',
        'author' => 'string|max_length[100]',
    ];

    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul harus diisi',
            'min_length' => 'Judul minimal 5 karakter',
            'max_length' => 'Judul maksimal 200 karakter',
        ],
        'isi' => [
            'required' => 'Isi artikel harus diisi',
            'min_length' => 'Isi minimal 10 karakter',
        ],
        'slug' => [
            'required' => 'Slug harus diisi',
            'regex_match' => 'Slug hanya boleh berisi huruf, angka, dan garis (-)',
            'is_unique' => 'Slug sudah ada, gunakan slug yang berbeda',
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status hanya boleh 0 (Draft) atau 1 (Publish)',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Get published articles
     */
    public function getPublished()
    {
        return $this->where('status', 1)->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Get article by slug
     */
    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Search articles
     */
    public function search($keyword)
    {
        return $this->like('judul', $keyword)
            ->orLike('isi', $keyword)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get paginated articles
     */
    public function getPaginated($perPage = 10)
    {
        return $this->paginate($perPage);
    }

    /**
     * Generate slug from title
     */
    public static function createSlug($judul)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul)));
        return trim($slug, '-');
    }
}
