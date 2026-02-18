<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Administrators</h4>
    </div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            <a href="index.php?action=manage_products" class="list-group-item list-group-item-action">Manage Products</a>
            <a href="index.php?action=manage_technicians" class="list-group-item list-group-item-action">Manage Technicians</a>
            <a href="index.php?action=manage_customers" class="list-group-item list-group-item-action">Manage Customers</a>
            <a href="index.php?action=create_incident" class="list-group-item list-group-item-action">Create Incident</a>
            <a href="index.php?action=assign_incident" class="list-group-item list-group-item-action">Assign Incident</a>
            <a href="index.php?action=display_incident" class="list-group-item list-group-item-action">Display Incidents</a>
        </div>
    </div>
</div>

<?php endif; ?>


<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'technician'): ?>

<div class="card shadow mb-4">
    <div class="card-header bg-warning">
        <h4 class="mb-0">Technicians</h4>
    </div>
    <div class="card-body">
        <a href="index.php?action=update_incidents" class="list-group-item list-group-item-action">Update Incident</a>
    </div>
</div>

<?php endif; ?>


<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer'): ?>

<div class="card shadow mb-5">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">Customers</h4>
    </div>
    <div class="card-body">
        <a href="index.php?action=register_product" class="list-group-item list-group-item-action">Register Product</a>
    </div>
</div>

<?php endif; ?>

