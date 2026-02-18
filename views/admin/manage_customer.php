<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './db/database.php';
require __DIR__ . '/../../models/country.php';

// Search Function
$search = filter_input(INPUT_GET, 'search');

if ($search) {
    $sql = "SELECT customerID, firstName, lastName, email, phone,
                   address, city, state, postalCode, countryCode
            FROM customers
            WHERE firstName LIKE :search
               OR lastName LIKE :search
               OR email LIKE :search
            ORDER BY lastName, firstName";

    $stmt = $db->prepare($sql);
    $stmt->execute([':search' => "%$search%"]);
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT customerID, firstName, lastName, email, phone,
                   address, city, state, postalCode, countryCode
            FROM customers
            ORDER BY lastName, firstName";

    $customers = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

$countries = Country::getAll();

require __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid mt-4 px-4">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-lg-2">
            <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <main class="col-lg-10">
            <div class="card shadow-sm p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">Customer List</h2>
                    <button class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#addCustomerModal">
                        Add Customer
                    </button>
                </div>

                <!-- Search -->
                <form method="get" class="row g-2 mb-3">
                    <div class="col-md-9">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search customers by name or email"
                               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-secondary w-100">Search</button>
                    </div>
                </form>

                <!-- Customer Table -->
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th style="width:120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($customers)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No customers found.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?= htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']) ?></td>
                                    <td><?= htmlspecialchars($customer['email']) ?></td>
                                    <td><?= htmlspecialchars($customer['phone']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editCustomerModal-<?= $customer['customerID'] ?>">
                                            Modify
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </main>
    </div>
</div>

<!-- Add Customers Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="post"
              action="../../controllers/add_customer.php"
              class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Customer</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input name="firstName" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input name="lastName" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input name="phone" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <input name="address" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input name="city" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input name="state" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Postal Code</label>
                        <input name="postalCode" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Country Code</label>
                        <input name="countryCode" class="form-control">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Save Customer</button>
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>

        </form>
    </div>
</div>

<!-- Edit Customer Modal -->
<?php foreach ($customers as $customer): ?>
<div class="modal fade"
     id="editCustomerModal-<?= $customer['customerID'] ?>"
     tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="post"
              action="../../controllers/update_customer.php"
              class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Modify Customer</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden"
                       name="customerID"
                       value="<?= $customer['customerID'] ?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input name="firstName"
                               class="form-control"
                               value="<?= htmlspecialchars($customer['firstName']) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input name="lastName"
                               class="form-control"
                               value="<?= htmlspecialchars($customer['lastName']) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input name="email"
                               type="email"
                               class="form-control"
                               value="<?= htmlspecialchars($customer['email']) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input name="phone"
                               class="form-control"
                               value="<?= htmlspecialchars($customer['phone']) ?>">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <input name="address"
                               class="form-control"
                               value="<?= htmlspecialchars($customer['address'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input name="city"
                               class="form-control"
                               value="<?= htmlspecialchars($customer['city'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input name="state"
                               class="form-control"
                               value="<?= htmlspecialchars($customer['state'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Postal Code</label>
                        <input name="postalCode"
                               class="form-control"
                               value="<?= htmlspecialchars($customer['postalCode'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
    <label class="form-label">Country</label>
    <select name="countryCode" class="form-select" required>
        <option value="">Select a country</option>

        <?php foreach ($countries as $country): ?>
            <option value="<?= $country['countryCode'] ?>"
                <?= ($country['countryCode'] === ($customer['countryCode'] ?? '')) ? 'selected' : '' ?>>
                <?= htmlspecialchars($country['countryName']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Save Changes</button>
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>

        </form>
    </div>
</div>
<?php endforeach; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
