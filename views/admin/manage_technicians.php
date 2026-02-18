<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require './db/database.php';

// Fetch the technicians
$sql = "SELECT techID, firstName, lastName, email, phone FROM technicians
        ORDER BY lastName";
$technicians = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid mt-4 px-4">
    <div class="row">

        <!-- This is the sidebar -->
        <div class="col-lg-3 col-xl-2">
            <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        </div>

        <!-- Thisis the main content -->
        <main class="col-lg-9 col-xl-10">
            <div class="card shadow-sm p-4 ">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">Technician List</h2>
                    <button class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#addTechnicianModal">
                        Add Technician
                    </button>
                </div>

                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($technicians)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    No technicians found.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($technicians as $tech): ?>
                                <tr>
                                    <td><?= htmlspecialchars($tech['firstName'] . ' ' . $tech['lastName']) ?></td>
                                    <td><?= htmlspecialchars($tech['email']) ?></td>
                                    <td><?= htmlspecialchars($tech['phone']) ?></td>
                                    <td>
    <form action="../../controllers/delete_technicians.php" method="post" style="display:inline;">
        <input type="hidden" name="techID" value="<?= $tech['techID']; ?>">
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="bi bi-trash"></i>
        </button>
    </form>
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


<!-- Added Modal for the Technicians -->
<div class="modal fade" id="addTechnicianModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="../../controllers/add_technicians.php" class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Technician</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstName" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastName" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    Save Technician
                </button>
            </div>

        </form>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
