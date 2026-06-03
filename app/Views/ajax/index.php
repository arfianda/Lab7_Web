<?= $this->include('template/header'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Data Artikel - AJAX</h1>

            <!-- Form Tambah/Edit Artikel -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" id="formTitle">Tambah Artikel Baru</h5>
                </div>
                <div class="card-body">
                    <form id="artikelForm">
                        <input type="hidden" id="artikelId" value="">

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                            <small class="text-danger" id="error-judul"></small>
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Artikel</label>
                            <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
                            <small class="text-danger" id="error-isi"></small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="author" class="form-label">Penulis</label>
                                    <input type="text" class="form-control" id="author" name="author">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="1">Publish</option>
                                        <option value="0">Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                            <button type="button" class="btn btn-secondary" id="cancelBtn" style="display:none;">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Data Artikel -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Daftar Artikel</h5>
                </div>
                <div class="card-body">
                    <div id="loadingMessage" class="alert alert-info" role="alert" style="display:none;">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        Loading data...
                    </div>

                    <table class="table table-striped table-hover" id="artikelTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Load data saat halaman dimuat
        loadData();

        // Submit form (Tambah/Edit)
        $('#artikelForm').on('submit', function(e) {
            e.preventDefault();
            submitForm();
        });

        // Cancel edit
        $('#cancelBtn').on('click', function() {
            resetForm();
        });

        // Delete artikel
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
                deleteArticle(id);
            }
        });

        // Edit artikel
        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            editArticle(id);
        });
    });

    // Function untuk load data artikel
    function loadData() {
        $('#loadingMessage').show();
        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#loadingMessage').hide();
                let tableBody = '';

                if (data.length === 0) {
                    tableBody = '<tr><td colspan="6" class="text-center">Tidak ada data artikel</td></tr>';
                } else {
                    data.forEach(function(artikel) {
                        const statusBadge = artikel.status == 1 ?
                            '<span class="badge bg-success">Publish</span>' :
                            '<span class="badge bg-warning text-dark">Draft</span>';

                        const createdDate = new Date(artikel.created_at).toLocaleDateString('id-ID');

                        tableBody += `<tr>
                        <td>${artikel.id}</td>
                        <td>${artikel.judul}</td>
                        <td>${artikel.author || '-'}</td>
                        <td>${statusBadge}</td>
                        <td>${createdDate}</td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit" data-id="${artikel.id}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${artikel.id}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>`;
                    });
                }

                $('#artikelTable tbody').html(tableBody);
            },
            error: function(xhr, status, error) {
                $('#loadingMessage').hide();
                console.error('Error loading data:', error);
                alert('Gagal memuat data: ' + error);
            }
        });
    }

    // Function untuk submit form (tambah/edit)
    function submitForm() {
        const id = $('#artikelId').val();
        const formData = {
            judul: $('#judul').val(),
            isi: $('#isi').val(),
            author: $('#author').val(),
            status: $('#status').val()
        };

        const url = id ? "<?= base_url('ajax/update/') ?>" + id : "<?= base_url('ajax/add') ?>";
        const method = id ? 'POST' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    resetForm();
                    loadData();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                const response = xhr.responseJSON;
                if (response && response.errors) {
                    // Tampilkan error validasi
                    Object.keys(response.errors).forEach(function(field) {
                        $('#error-' + field).text(response.errors[field]);
                    });
                }
                console.error('Error submitting form:', error);
            }
        });
    }

    // Function untuk edit artikel
    function editArticle(id) {
        $.ajax({
            url: "<?= base_url('ajax/getDetail/') ?>" + id,
            type: 'GET',
            dataType: 'json',
            success: function(artikel) {
                $('#artikelId').val(artikel.id);
                $('#judul').val(artikel.judul);
                $('#isi').val(artikel.isi);
                $('#author').val(artikel.author);
                $('#status').val(artikel.status);

                $('#formTitle').text('Edit Artikel');
                $('#submitBtn').text('Update');
                $('#cancelBtn').show();

                // Scroll ke form
                $('html, body').animate({
                    scrollTop: $('#artikelForm').offset().top - 100
                }, 800);
            },
            error: function(xhr, status, error) {
                console.error('Error loading artikel:', error);
                alert('Gagal memuat data artikel');
            }
        });
    }

    // Function untuk delete artikel
    function deleteArticle(id) {
        $.ajax({
            url: "<?= base_url('ajax/delete/') ?>" + id,
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    loadData();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error deleting artikel:', error);
                alert('Gagal menghapus artikel: ' + error);
            }
        });
    }

    // Function untuk reset form
    function resetForm() {
        $('#artikelForm')[0].reset();
        $('#artikelId').val('');
        $('#formTitle').text('Tambah Artikel Baru');
        $('#submitBtn').text('Simpan');
        $('#cancelBtn').hide();

        // Clear error messages
        $('#error-judul').text('');
        $('#error-isi').text('');

        // Scroll ke form
        $('html, body').animate({
            scrollTop: $('#artikelForm').offset().top - 100
        }, 800);
    }
</script>

<?= $this->include('template/footer'); ?>