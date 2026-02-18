<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="container-fluid mt-4 px-4">
    <div class="row">

        <aside class="col-lg-3 col-xl-2 mb-4">
            <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        </aside>

        <main class="col-lg-9 col-xl-10">

            <h2 class="mb-4">Register Product</h2>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    <?= $success_message ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">Register Product</div>
                <div class="card-body">

                    <form method="post" action="index.php">
                        <input type="hidden" name="action" value="register_product">

                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            <div class="form-control bg-light">
                                <?= htmlspecialchars(($customer['firstName'] ?? '') . ' ' . ($customer['lastName'] ?? '')) ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product</label>
                            <select name="productCode" class="form-select" required>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= htmlspecialchars($product['productCode']) ?>">
                                        <?= htmlspecialchars($product['name'] . ' ' . $product['version']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button class="btn btn-primary">
                            Register Product
                        </button>
                    </form>

                </div>
            </div>

        </main>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
