<?php
//require __DIR__ . '/../../models/incident.php';
//$incidents = Incident::getAll();

require __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid mt-4 px-4">
    <div class="row">

        <!-- This is the sidebar -->
        <aside class="col-lg-3 col-xl-2 mb-4">
            <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        </aside>

        <!-- This is the main content -->
        <main class="col-lg-9 col-xl-10">

            <h2 class="mb-4">Display Incidents</h2>

            <?php if (empty($incidents)) : ?>
                <div class="alert alert-info">
                    No incidents found.
                </div>
            <?php else : ?>

                <div class="card">
                    <div class="card-header">Incident List</div>
                    <div class="card-body table-responsive">

                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Incident ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Technician</th>
                                    <th>Date Opened</th>
                                    <th>Date Closed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($incidents as $incident) : ?>
                                    <tr>
                                        <td><?= $incident['incidentID'] ?></td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $incident['firstName'] . ' ' . $incident['lastName']
                                            ) ?>
                                        </td>

                                        <td><?= htmlspecialchars($incident['productCode']) ?></td>

                                        <td>
                                            <?= $incident['techFirstName']
                                                ? htmlspecialchars($incident['techFirstName'] . ' ' . $incident['techLastName'])
                                                : 'Unassigned'; ?>
                                        </td>

                                        <td><?= $incident['dateOpened'] ?></td>

                                        <td>
                                            <?= $incident['dateClosed'] ?? 'Open' ?>
                                        </td>

                                        <td>
                                            <?php if ($incident['dateClosed'] === null) : ?>
                                               <a href="index.php?action=assign_incident&incidentID=<?= $incident['incidentID'] ?>" class="btn btn-primary">
                                                    Assign
                                                </a>

                                            <?php else : ?>
                                                <span class="text-muted">Closed</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>

                    </div>
                </div>

            <?php endif; ?>

        </main>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
