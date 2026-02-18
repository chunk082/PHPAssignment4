<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="container-fluid mt-4 px-4">
    <div class="row">
        <aside class="col-lg-3 col-xl-2 mb-4">
            <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        </aside>

        <main class="col-lg-9 col-xl-10">

            <h2 class="mb-4">Update Incidents</h2>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <!-- Logged In Message -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted">
                    You are logged in as 
                    <strong><?= htmlspecialchars($techEmail ?? '') ?></strong>
                </div>
                <a class="btn btn-outline-secondary btn-sm"
                   href="index.php?action=tech_logout">
                    Logout
                </a>
            </div>

            <!-- SELECT INCIDENT -->
            <div class="card mb-4">
                <div class="card-header">Select Incident</div>
                <div class="card-body">

                    <?php if (empty($incidents)): ?>

                        <div class="alert alert-info mb-0">
                            There are no open incidents assigned to you.
                        </div>

                    <?php else: ?>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Date Opened</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th style="width:120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($incidents as $i): ?>
                                        <tr>
                                            <td><?= htmlspecialchars(($i['firstName'] ?? '') . ' ' . ($i['lastName'] ?? '')) ?></td>
                                            <td><?= htmlspecialchars($i['productCode'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($i['dateOpened'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($i['title'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($i['description'] ?? '') ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-primary"
                                                   href="index.php?action=update_incident&incidentID=<?= (int)$i['incidentID'] ?>">
                                                    Select
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php endif; ?>

                </div>
            </div>

            <!-- UPDATE FORM -->
            <?php if (!empty($selectedIncident)): ?>

                <div class="card">
                    <div class="card-header">Update Incident</div>
                    <div class="card-body">

                        <form method="post" action="index.php">
                            <input type="hidden" name="action" value="save_incident">
                            <input type="hidden" name="incidentID"
                                   value="<?= (int)$selectedIncident['incidentID'] ?>">

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description"
                                          class="form-control"
                                          rows="5"><?= htmlspecialchars($selectedIncident['description'] ?? '') ?></textarea>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="closeIncident"
                                       id="closeIncident"
                                       value="1">
                                <label class="form-check-label"
                                       for="closeIncident">
                                    Close this incident
                                </label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php?action=update_incident"
                                   class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button class="btn btn-primary"
                                        type="submit">
                                    Update Incident
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            <?php endif; ?>

        </main>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
