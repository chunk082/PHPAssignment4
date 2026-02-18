 <?php include 'views/partials/header.php'; ?>

<div class="container mt-4">

    <?php if (!isset($_SESSION['role'])): ?>

        <!-- LOGIN ACCORDION -->
        <div class="card shadow-sm p-4">
            <h3>Main Menu</h3>

            <div class="accordion mt-3" id="loginAccordion">

                <!-- ADMIN -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#adminLogin">
                            Administrator
                        </button>
                    </h2>

                    <div id="adminLogin" class="accordion-collapse collapse"
                        data-bs-parent="#loginAccordion">
                        <div class="accordion-body">

                            <form method="post" action="index.php">
                                <input type="hidden" name="action" value="admin_login">

                                <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- TECHNICIAN -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#techLogin">
                            Technicians
                        </button>
                    </h2>

                    <div id="techLogin" class="accordion-collapse collapse"
                        data-bs-parent="#loginAccordion">
                        <div class="accordion-body">

                            <form method="post" action="index.php">
                                <input type="hidden" name="action" value="tech_login">

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- CUSTOMER -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#customerLogin">
                            Customers
                        </button>
                    </h2>

                    <div id="customerLogin" class="accordion-collapse collapse"
                        data-bs-parent="#loginAccordion">
                        <div class="accordion-body">

                            <form method="post" action="index.php">
                                <input type="hidden" name="action" value="customer_login">

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    <?php else: ?>

        <?php
$role = $_SESSION['role'] ?? null;
$email = $_SESSION['email'] ?? null;
?>

<div class="row">
    <div class="col-md-4">
        <?php include 'views/partials/sidebar.php'; ?>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm p-4">

            <?php if ($role === 'technician'): ?>

                <h4 class="mb-3">Select Incident</h4>

                <?php if (!empty($incidents)): ?>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Date Opened</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($incidents as $incident): ?>
                                <tr>
                                    <td><?= htmlspecialchars($incident['customerID']) ?></td>
                                    <td><?= htmlspecialchars($incident['productCode']) ?></td>
                                    <td><?= htmlspecialchars($incident['dateOpened']) ?></td>
                                    <td>
                                        <a href="index.php?action=update_incident&id=<?= $incident['incidentID'] ?>"
                                           class="btn btn-sm btn-primary">
                                            Select
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php else: ?>

                    <p class="text-muted">
                        There are no open incidents for this technician.
                    </p>

                    <a href="index.php?action=select_incident" class="btn btn-link">
                        Refresh List of Incidents
                    </a>

                <?php endif; ?>

                <hr>

                <?php if ($email): ?>
                    <p class="mb-3">
                        You are logged in as 
                        <strong><?= htmlspecialchars($email) ?></strong>
                    </p>
                <?php endif; ?>

                <a href="index.php?action=tech_logout" class="btn btn-danger">
                    Logout
                </a>

            <?php else: ?>

                <h4 class="mb-3">
                    Welcome, <?= ucfirst($role ?? 'User') ?>!
                </h4>

                <a href="index.php?action=admin_logout" class="btn btn-danger">
                    Logout
                </a>

            <?php endif; ?>

        </div>
    </div>
</div>


    <?php endif; ?>

</div>

<?php include 'views/partials/footer.php'; ?>
