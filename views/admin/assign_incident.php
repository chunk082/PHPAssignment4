<?php
// Enable error reporting during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../partials/header.php';

$incidentID = filter_input(INPUT_GET, 'incidentID', FILTER_VALIDATE_INT)
           ?? filter_input(INPUT_POST, 'incidentID', FILTER_VALIDATE_INT);

$error_message   = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $incidentID) {
    $techID = filter_input(INPUT_POST, 'techID', FILTER_VALIDATE_INT);
    $closeIncident = isset($_POST['closeIncident']) ? date('Y-m-d H:i:s') : null;

    if (!$techID || $techID <= 0) {
        $error_message = "Please select a technician.";
    } else {
        // Use the new method we just added
        $updated = Incident::assign($incidentID, $techID, $closeIncident);

        if ($updated) {
            $success_message = "This incident was assigned to a technician.";
        } else {
            $error_message = "Failed to assign technician. Please try again.";
        }
    }
}

$incident    = null;
$technicians = [];

if ($incidentID) {
    $incident = Incident::getByID($incidentID);

    if (!$incident) {
        $error_message = "Incident #$incidentID not found.";
    } else {
        $technicians = Technician::getAll();
    }
} else {
    $error_message = "No incident selected.";
}
?>

<div class="container-fluid mt-4 px-4">
    <div class="row">
        <aside class="col-lg-3 col-xl-2 mb-4">
            <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        </aside>

        <main class="col-lg-9 col-xl-10">
            <h2 class="mb-4">Assign Incident</h2>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success_message) ?>
                </div>
                <p>
                    <a href="display_incident.php" class="btn btn-outline-primary">
                        Select Another Incident
                    </a>
                </p>

            <?php else: ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <?php if ($incident && is_array($incident)): ?>
                    <!-- Incident Details -->
                    <div class="card mb-4">
                        <div class="card-header">Incident Details</div>
                        <div class="card-body">
                            <p><strong>Incident ID:</strong> <?= htmlspecialchars($incident['incidentID']) ?></p>
                            <p><strong>Title:</strong> <?= htmlspecialchars($incident['title'] ?? '—') ?></p>
                            <p><strong>Description:</strong><br>
                                <?= nl2br(htmlspecialchars($incident['description'] ?? 'No description')) ?>
                            </p>
                            <p><strong>Date Opened:</strong> <?= htmlspecialchars($incident['dateOpened'] ?? '—') ?></p>
                            <p><strong>Date Closed:</strong>
                                <?= $incident['dateClosed'] ? htmlspecialchars($incident['dateClosed']) : 'Open' ?>
                            </p>
                        </div>
                    </div>

                    <!-- Assign Form -->
                    <div class="card">
                        <div class="card-header">Assign Technician</div>
                        <div class="card-body">
                            <form method="post" action="">
                                <input type="hidden" name="incidentID" value="<?= htmlspecialchars($incident['incidentID']) ?>">

                                <div class="mb-3">
                                    <label for="techID" class="form-label">Technician</label>
                                    <select name="techID" id="techID" class="form-select" required>
                                        <option value="">-- Select Technician --</option>
                                        <?php foreach ($technicians as $tech): ?>
                                            <option value="<?= $tech['techID'] ?>"
                                                <?= ($incident['techID'] ?? 0) == $tech['techID'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($tech['firstName'] . ' ' . $tech['lastName']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="closeIncident" id="closeIncident" value="1"
                                        <?= $incident['dateClosed'] ? 'checked disabled' : '' ?>>
                                    <label class="form-check-label" for="closeIncident">
                                        Close this incident
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="display_incident.php" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        Save Incident
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="alert alert-warning">
                        Cannot load incident details. Please go back and try again.
                    </div>
                    <a href="display_incident.php" class="btn btn-secondary">Back to Incidents</a>
                <?php endif; ?>

            <?php endif; ?>
        </main>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>