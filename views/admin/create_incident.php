<?php
require_once './db/database.php';
require __DIR__ . '/../partials/header.php';

// This will load the dropdown items.

// Customers
$customers = $db->query("
    SELECT customerID, firstName, lastName
    FROM customers
    ORDER BY lastName
")->fetchAll(PDO::FETCH_ASSOC);

// Products
$products = $db->query("
    SELECT productCode, name
    FROM products
    ORDER BY name
")->fetchAll(PDO::FETCH_ASSOC);

// Technicians
$technicians = $db->query("
    SELECT techID, firstName, lastName
    FROM technicians
    ORDER BY lastName
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid mt-4 px-4">
    <div class="row">

        <!-- This is the sidebar -->
        <div class="col-lg-2">
            <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        </div>

        <!-- Main Content of the site -->
        <main class="col-lg-10">
            <div class="card shadow-sm p-4">

                <h2 class="mb-4">Create Incident</h2>

                <form action="../../controllers/create_incidents.php" method="post">

                    <!-- CUSTOMER -->
                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <select name="customerID" class="form-select" required>
                            <option value="">Select Customer</option>
                            <?php foreach ($customers as $c): ?>
                                <option value="<?= $c['customerID'] ?>">
                                    <?= htmlspecialchars($c['lastName'] . ', ' . $c['firstName']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Product in question -->
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select name="productCode" class="form-select" required>
                            <option value="">Select Product</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['productCode'] ?>">
                                    <?= htmlspecialchars($p['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Assign the technicians -->
                    <div class="mb-3">
                        <label class="form-label">Technician</label>
                        <select name="techID" class="form-select" required>
                            <option value="">Assign Technician</option>
                            <?php foreach ($technicians as $t): ?>
                                <option value="<?= $t['techID'] ?>">
                                    <?= htmlspecialchars($t['lastName'] . ', ' . $t['firstName']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Title of the incicident -->
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            required
                        >
                    </div>

                    <!-- Description of the incident -->
                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                            required
                        ></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Create Incident
                        </button>

                        <a href="display_incident.php" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </main>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
