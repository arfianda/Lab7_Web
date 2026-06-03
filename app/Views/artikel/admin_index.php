<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="admin-header">
    <h2><?= $title ?? 'Kelola Artikel' ?></h2>
    <a href="<?= base_url('admin/artikel/add') ?>" class="btn btn-primary">+ Tambah Artikel</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Search and Filter Section -->
<div class="search-box">
    <form id="search-form" class="form-inline">
        <input type="text" name="q" id="search-box" value="<?= $q ?? '' ?>"
            placeholder="Cari judul atau isi artikel" class="form-control mr-2">
        <button type="submit" class="btn btn-primary">Cari</button>
        <button type="reset" class="btn btn-secondary ml-2">Reset</button>
    </form>
</div>

<!-- Loading Indicator -->
<div id="loading-indicator" class="loading-indicator" style="display: none;">
    <div class="spinner"></div>
    <p>Memuat data...</p>
</div>

<!-- Article Table Container -->
<div id="article-container">
</div>

<!-- Pagination Container -->
<div id="pagination-container">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const articleContainer = $('#article-container');
        const paginationContainer = $('#pagination-container');
        const searchForm = $('#search-form');
        const searchBox = $('#search-box');
        const loadingIndicator = $('#loading-indicator');

        let currentSort = '<?= $sort ?? 'created_at' ?>';
        let currentOrder = '<?= $order ?? 'DESC' ?>';
        let currentPage = 1;

        // Fetch data from server
        const fetchData = (url) => {
            loadingIndicator.show();
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(data) {
                    renderArticles(data.artikel);
                    renderPagination(data.pager, data.q);
                    currentSort = data.sort;
                    currentOrder = data.order;
                },
                error: function() {
                    articleContainer.html('<div class="alert alert-danger">Gagal memuat data</div>');
                },
                complete: function() {
                    loadingIndicator.hide();
                }
            });
        };

        // Render articles table
        const renderArticles = (articles) => {
            let html = '<div class="table-responsive">';
            html += '<table class="table">';
            html += '<thead><tr>';
            html += '<th><a href="javascript:void(0)" class="sort-link" data-sort="id">No</a></th>';
            html += '<th><a href="javascript:void(0)" class="sort-link" data-sort="judul">Judul</a></th>';
            html += '<th><a href="javascript:void(0)" class="sort-link" data-sort="author">Author</a></th>';
            html += '<th><a href="javascript:void(0)" class="sort-link" data-sort="status">Status</a></th>';
            html += '<th><a href="javascript:void(0)" class="sort-link" data-sort="created_at">Tanggal</a></th>';
            html += '<th>Aksi</th>';
            html += '</tr></thead><tbody>';

            if (articles.length > 0) {
                articles.forEach((article, index) => {
                    const status = article.status == 1 ? 'Publish' : 'Draft';
                    const statusClass = article.status == 1 ? 'badge-success' : 'badge-warning';
                    const date = new Date(article.created_at).toLocaleDateString('id-ID');

                    html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        <b>${escapeHtml(article.judul)}</b>
                        <p><small>${escapeHtml(article.isi.substring(0, 50))}...</small></p>
                    </td>
                    <td>${escapeHtml(article.author || '-')}</td>
                    <td>
                        <span class="badge ${statusClass}">
                            ${status}
                        </span>
                    </td>
                    <td>${date}</td>
                    <td>
                        <a href="/admin/artikel/edit/${article.id}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/admin/artikel/delete/${article.id}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus artikel ini?')">Hapus</a>
                    </td>
                </tr>
                `;
                });
            } else {
                html += '<tr><td colspan="6" class="text-center">Tidak ada artikel</td></tr>';
            }

            html += '</tbody></table></div>';
            articleContainer.html(html);

            // Attach sorting event handlers
            $('.sort-link').on('click', function(e) {
                e.preventDefault();
                const sort = $(this).data('sort');
                const newOrder = (sort === currentSort && currentOrder === 'DESC') ? 'ASC' : 'DESC';
                const q = searchBox.val();
                fetchData(`/admin/artikel?q=${q}&page=1&sort=${sort}&order=${newOrder}`);
            });
        };

        // Render pagination
        const renderPagination = (pager, q) => {
            let html = '<nav><ul class="pagination">';

            pager.links.forEach(link => {
                let url = '#';
                if (link.url) {
                    // Extract page number from URL
                    const urlParams = new URLSearchParams(new URL(link.url, window.location.origin).search);
                    const page = urlParams.get('page') || 1;
                    url = `/admin/artikel?q=${q}&page=${page}&sort=${currentSort}&order=${currentOrder}`;
                }

                const activeClass = link.active ? 'active' : '';
                html += `<li class="page-item ${activeClass}"><a class="page-link" href="javascript:void(0)" data-url="${url}">${link.title}</a></li>`;
            });

            html += '</ul></nav>';
            paginationContainer.html(html);

            // Attach pagination event handlers
            $('.page-link').on('click', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                if (url && url !== '#') {
                    fetchData(url);
                }
            });
        };

        // Escape HTML to prevent XSS
        const escapeHtml = (text) => {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        };

        // Search form submit
        searchForm.on('submit', function(e) {
            e.preventDefault();
            const q = searchBox.val();
            fetchData(`/admin/artikel?q=${q}&page=1`);
        });

        // Reset button
        searchForm.on('reset', function(e) {
            setTimeout(() => {
                fetchData('/admin/artikel');
            }, 50);
        });

        // Initial load
        fetchData('/admin/artikel');
    });
</script>

<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-box {
        margin-bottom: 20px;
    }

    .search-box form {
        display: flex;
        gap: 10px;
    }

    .search-box input {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    /* Loading Indicator */
    .loading-indicator {
        display: none;
        text-align: center;
        padding: 20px;
        background: #f0f8ff;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin: 0 auto 10px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Table */
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        margin-bottom: 20px;
    }

    .table th {
        background: #f5f5f5;
        padding: 12px;
        text-align: left;
        border-bottom: 2px solid #ddd;
        font-weight: bold;
    }

    .table th a {
        color: #0066cc;
        text-decoration: none;
        cursor: pointer;
    }

    .table th a:hover {
        text-decoration: underline;
    }

    .table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    .table tr:hover {
        background: #f9f9f9;
    }

    .table p {
        margin: 5px 0 0 0;
        color: #666;
    }

    /* Badge */
    .badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        color: white;
    }

    .badge-success {
        background: #28a745;
    }

    .badge-warning {
        background: #ffc107;
        color: #333;
    }

    /* Buttons */
    .btn {
        display: inline-block;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
        margin-right: 5px;
    }

    .btn-primary {
        background: #0066cc;
        color: white;
    }

    .btn-primary:hover {
        background: #004ba3;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .btn-sm {
        padding: 4px 12px;
        font-size: 12px;
    }

    .btn-warning {
        background: #ffc107;
        color: #333;
    }

    .btn-warning:hover {
        background: #e0a800;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    /* Pagination */
    .pagination {
        list-style: none;
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .page-item {
        display: inline-block;
    }

    .page-link {
        display: block;
        padding: 8px 12px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #0066cc;
        text-decoration: none;
        cursor: pointer;
    }

    .page-link:hover {
        background: #f0f0f0;
    }

    .page-item.active .page-link {
        background: #0066cc;
        color: white;
        border-color: #0066cc;
    }

    /* Alerts */
    .alert {
        padding: 12px 16px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .text-center {
        text-align: center;
    }

    .mr-2 {
        margin-right: 10px;
    }

    .ml-2 {
        margin-left: 10px;
    }

    .form-control {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-inline {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
</style>

<?= $this->endSection() ?>