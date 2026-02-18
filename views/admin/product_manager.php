<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require './db/database.php';

$sql = "SELECT productCode, name, version, releaseDate FROM products";
$products = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require __DIR__ . '/../partials/header.php';


?>

<div class="container-fluid mt-4 px-4">
    <div class="row">

        <!-- This is the sidebar -->
        <aside class="col-lg-3 col-xl-2">
            <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        </aside>

        <!-- Main content of the site -->
        <main class="col-lg-9 col-xl-10">
            <div class="card shadow-sm p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">Product List</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        Add Product
                    </button>

                </div>

                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Product Code</th>
                            <th>Name</th>
                            <th>Version</th>
                            <th>Release Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['productCode']) ?></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= htmlspecialchars($product['version']) ?></td>
                                <td><?= date('Y-m-d', strtotime($product['releaseDate'])) ?></td>
                                <td><form action="../../controllers/delete_product.php" method="post" style="display:inline;">
    <input type="hidden" name="productCode" value="<?= $product['productCode']; ?>">
    <button type="submit" class="btn btn-sm btn-danger">
        <i class="bi bi-trash"></i>
    </button>
</form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </main>

    </div>
</div>

<!-- Added Modal to add the product part of bootstrap -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form action="../../controllers/add_product.php" method="post">

                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Product Code</label>
                        <input type="text" name="productCode" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Version</label>
                        <input type="text" name="version" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Release Date</label>
                        <input type="date" name="releaseDate" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save Product
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<?php require __DIR__ . '/../partials/footer.php'; ?>
