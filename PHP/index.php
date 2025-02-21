<?php
require_once 'Petshop.php';
session_start();

// Inisialisasi Produk
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        new Petshop("001", "Royal Canin Kitten", "Makanan Kucing", 250000, "royal_canin.jpg"),
        new Petshop("002", "Pedigree Beef", "Makanan Anjing", 50000, "pedigree.jpg"),
        new Petshop("003", "Detick", "Obat Anjing", 55000, "detick.jpg"),
    ];
}

$petshop = &$_SESSION['products'];                              // Referensi ke session
$uploadDir = 'uploads/';                                        // Folder upload gambar
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);    // Buat folder jika belum ada

// Function untuk format harga
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Function untuk mendapatkan kategori produk
function getCategories($products) {
    $categories = [];
    foreach ($products as $product) {
        $kategori = $product->get_kategori();
        if (!in_array($kategori, $categories)) {
            $categories[] = $kategori;
        }
    }
    return $categories;
}

$message = '';                          // Pesan notifikasi
$categories = getCategories($petshop);  // Berisi kategori produk yang ada

// Menambahkan produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add'){
    
    // Ambil data dari form
    $newId = $_POST['id'] ?? '';
    $newName = $_POST['nama'] ?? '';
    $newCategory = $_POST['kategori'] ?? '';
    $newPrice = $_POST['harga'] ?? 0;
    $imageName = $_POST['gambar'] ?? 'default.jpg';         

    // Cek apakah ID sudah digunakan
    $idExists = false;
    foreach ($petshop as $product) {
        if ($product->get_ID() === $newId) {
            $idExists = true;
            break;
        }
    }

    if ($idExists) {
        $message = '<div class="alert alert-danger">ID Produk sudah digunakan!</div>';
    } elseif (empty($newId) || empty($newName) || empty($newCategory) || $newPrice <= 0) {  // Cek apakah ada field yang kosong
        $message = '<div class="alert alert-danger">Semua field harus diisi!</div>';
    } else {
        // Jika ada file gambar yang diupload dan tidak error
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $tempFile = $_FILES['gambar']['tmp_name'];                                       // File sementara
            $fileType = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION)); // Mendapatkan ekstensi file
            
            // Jika file gambar valid
            if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
                $imageName = $newId . '_' . time() . '.' . $fileType;   // Nama file baru
                move_uploaded_file($tempFile, $uploadDir . $imageName); // Pindahkan file ke folder uploads (uploads/)
            }
        }
        
        // Tambahkan produk baru ke array
        $petshop[] = new Petshop($newId, $newName, $newCategory, $newPrice, $imageName);
        $message = '<div class="alert alert-success">Produk berhasil ditambahkan!</div>';
        
    }
}

// Edit produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    
    // Ambil data dari form
    $editId = $_POST['edit_id'] ?? '';
    $editName = $_POST['edit_nama'] ?? '';
    $editCategory = $_POST['edit_kategori'] ?? '';
    $editPrice = $_POST['edit_harga'] ?? 0;
    
    if (empty($editId) || empty($editName) || empty($editCategory) || $editPrice <= 0) {    // Cek apakah ada field yang kosong
        $message = '<div class="alert alert-danger">Semua field edit harus diisi!</div>';
    } else {
        foreach ($petshop as $key => $product) {    // Looping untuk mencari produk yang akan diedit
            if ($product->get_ID() === $editId) {

                $imageName = $product->get_gambar();
                if (isset($_FILES['edit_gambar']) && $_FILES['edit_gambar']['error'] === UPLOAD_ERR_OK) {   // Jika ada file gambar yang diupload
                    $tempFile = $_FILES['edit_gambar']['tmp_name'];
                    $fileType = strtolower(pathinfo($_FILES['edit_gambar']['name'], PATHINFO_EXTENSION));
                    
                    // Jika file gambar valid
                    if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $imageName = $editId . '_' . time() . '.' . $fileType;  // Nama file baru
                        move_uploaded_file($tempFile, $uploadDir . $imageName); // Pindahkan file ke folder uploads (uploads/)
                    }
                }
                
                // Update produk
                $petshop[$key]->set_ID($editId);
                $petshop[$key]->set_nama($editName);
                $petshop[$key]->set_kategori($editCategory);
                $petshop[$key]->set_harga($editPrice);
                $petshop[$key]->set_gambar($imageName);

                $message = '<div class="alert alert-success">Produk berhasil diupdate!</div>';
                break;
            }
        }
    }
}

// Hapus produk
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $deleteId = $_GET['id'];
    
    // Looping untuk mencari produk yang akan dihapus
    foreach ($petshop as $key => $product) {
        if ($product->get_ID() === $deleteId) { // Jika produk ditemukan
            if (file_exists($uploadDir . $product->get_gambar())) {
                unlink($uploadDir . $product->get_gambar()); // Hapus gambar produk
            }
            unset($petshop[$key]);
            $petshop = array_values($petshop);  // Reset index array
            $message = '<div class="alert alert-success">Produk berhasil dihapus!</div>';
            break;
        }
    }
}

// Mengambil data produk yang akan diedit untuk ditampilkan di form edit
$editProduct = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $editId = $_GET['id'];
    foreach ($petshop as $product) {
        if ($product->get_ID() === $editId) {
            $editProduct = $product;
            break;
        }
    }
}

// Filter produk berdasarkan nama produk yang dicari
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$filteredProducts = $petshop;
if (!empty($searchQuery)){
    $filteredProducts = array_filter($petshop, function($product) use ($searchQuery){
        return stripos($product->get_nama(), $searchQuery) !== false;   // Cari nama produk yang mengandung string yang dicari
    });
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petshop Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; padding: 15px 0; }
        .product-image { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Menampilkan pesan notifikasi -->
        <?= $message ?> 
        
        <div class="row g-3">
            <!-- Input Form -->
            <div class="col-md-4">
                <?php if (!$editProduct): ?> <!-- Jika tidak sedang edit produk -->
                <!-- Tambah produk form -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Produk
                    </div>
                    <div class="card-body">
                        <form method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add">
                            <div class="mb-2">
                                <label for="id" class="form-label">ID</label>
                                <input type="text" class="form-control" id="id" name="id" required>
                            </div>
                            <div class="mb-2">
                                <label for="nama" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-2">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <!-- Menampilkan daftar kategori produk -->
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category ?>"><?= $category ?></option>
                                    <?php endforeach; ?>
                                    <option value="other">Kategori Baru</option>
                                </select>
                                <div id="newCategoryInput" class="mt-2 d-none">
                                    <input type="text" class="form-control" id="newCategory">
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="harga" class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" id="harga" name="harga" required>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                <!-- Edit Produk Form-->
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <i class="fas fa-edit me-1"></i>Edit Produk
                    </div>
                    <div class="card-body">
                        <form method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="edit_id" value="<?= $editProduct->get_ID() ?>">
                            <div class="mb-2">
                                <label class="form-label">ID</label>
                                <input type="text" class="form-control" value="<?= $editProduct->get_ID() ?>" disabled>
                            </div>
                            <div class="mb-2">
                                <label for="edit_nama" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="edit_nama" name="edit_nama" value="<?= $editProduct->get_nama() ?>" required>
                            </div>
                            <div class="mb-2">
                                <label for="edit_kategori" class="form-label">Kategori</label>
                                <select class="form-select" id="edit_kategori" name="edit_kategori" required>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category ?>" <?= $editProduct->get_kategori() === $category ? 'selected' : '' ?>><?= $category ?></option>
                                    <?php endforeach; ?>
                                    <option value="other">Kategori Baru</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="edit_harga" class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" id="edit_harga" name="edit_harga" value="<?= $editProduct->get_harga() ?>" required>
                            </div>
                            <div class="mb-2">
                                <label for="edit_gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="edit_gambar" name="edit_gambar" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                            </div>
                            <?php if (file_exists($uploadDir . $editProduct->get_gambar())): ?>
                                <div class="text-center mb-3">
                                    <img src="<?= $uploadDir . $editProduct->get_gambar() ?>" alt="Current" style="max-height:80px">
                                </div>
                            <?php endif; ?>
                            <div class="d-flex gap-2">
                                <a href="index.php" class="btn btn-secondary flex-grow-1">Cancel</a>
                                <button type="submit" class="btn btn-primary flex-grow-1">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Produk -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-list me-1"></i>Daftar Produk</span>
                    </div>
                    
                    <!-- Cari Produk Berdasarkan Nama -->
                    <div class="p-2 bg-light border-bottom">
                        <form action="" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama produk..." value="<?= htmlspecialchars($searchQuery) ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <?php if(!empty($searchQuery)): ?>
                            <a href="index.php" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-times"></i>
                            </a>
                            <?php endif; ?>
                        </form>
                    </div>
                    
                    <!-- Tabel List Produk -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($filteredProducts) > 0): ?>
                                    <?php foreach($filteredProducts as $product): ?>
                                    <tr>
                                        <td><?= $product->get_ID() ?></td>
                                        <td>
                                            <?php if(file_exists($uploadDir . $product->get_gambar())): ?>
                                                <img src="<?= $uploadDir . $product->get_gambar() ?>" class="product-image" alt="">
                                            <?php else: ?>
                                                <i class="fas fa-image text-muted"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $product->get_nama() ?></td>
                                        <td><?= $product->get_kategori() ?></td>
                                        <td><?= formatRupiah($product->get_harga()) ?></td>
                                        <td>
                                            <a href="?action=edit&id=<?= $product->get_ID() ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="confirmDelete('<?= $product->get_ID() ?>')" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-3">
                                            <?php if(!empty($searchQuery)): ?>
                                                <div class="alert alert-info mb-0">
                                                    Tidak ada produk dengan nama "<strong><?= htmlspecialchars($searchQuery) ?></strong>"
                                                    <a href="index.php" class="alert-link">Tampilkan semua</a>
                                                </div>
                                            <?php else: ?>
                                                Belum ada produk
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle new category input
        document.querySelector('#kategori')?.addEventListener('change', function(){
            const newCategoryInput = document.getElementById('newCategoryInput');
            if (this.value === 'other') {
                newCategoryInput.classList.remove('d-none');
                document.getElementById('newCategory').addEventListener('input', function() {
                    const categorySelect = document.getElementById('kategori');
                    const option = new Option(this.value, this.value, true, true);
                    categorySelect.add(option);
                });
            } else {
                newCategoryInput.classList.add('d-none');
            }
        });

        function confirmDelete(id) {
            if (confirm('Hapus produk dengan ID: ' + id + '?')) {
                window.location.href = '?action=delete&id=' + id;
            }
        }
    </script>
</body>
</html>