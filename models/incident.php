<?php
require_once __DIR__ . '/../db/database.php';

class Incident
{
    // Get all the incidents
    public static function getAll() {
    global $db;

    $query = "
        SELECT 
            i.incidentID,
            i.productCode,
            i.dateOpened,
            i.dateClosed,

            c.firstName,
            c.lastName,

            t.firstName AS techFirstName,
            t.lastName AS techLastName

        FROM incidents i
        JOIN customers c 
            ON i.customerID = c.customerID

        LEFT JOIN technicians t 
            ON i.techID = t.techID

        ORDER BY i.incidentID DESC
    ";

    return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

    // Assign the incident
    public static function getByID($incidentID)
    {
        global $db;

        $sql = "
            SELECT 
                i.incidentID,
                i.customerID,
                i.productCode,
                i.techID,
                i.dateOpened,
                i.dateClosed,
                i.title,
                i.description,

                c.firstName,
                c.lastName

                FROM incidents i
                JOIN customers c ON i.customerID = c.customerID
                WHERE i.incidentID = :incidentID
            ";

        $stmt = $db->prepare($sql);
            $stmt->execute([
            ':incidentID' => $incidentID
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public static function assign($incidentID, $techID, $dateClosed = null)
{
    global $db;

    // check incident exists
    $check = $db->prepare("SELECT techID, dateClosed FROM incidents WHERE incidentID = :id");
    $check->execute([':id' => $incidentID]);
    $current = $check->fetch(PDO::FETCH_ASSOC);

    if (!$current) return false;

    // If tech is the same and we aren't closing, it's still "successful"
    $sameTech = ((int)$current['techID'] === (int)$techID);
    $closing  = ($dateClosed !== null);

    // If nothing would change, treat as success
    if ($sameTech && !$closing) {
        return true;
    }

    $sql = "UPDATE incidents SET techID = :techID";
    $params = [':techID' => $techID, ':incidentID' => $incidentID];

    if ($closing) {
        $sql .= ", dateClosed = :dateClosed";
        $params[':dateClosed'] = $dateClosed;
    }

    $sql .= " WHERE incidentID = :incidentID";

    $stmt = $db->prepare($sql);
    return $stmt->execute($params); // <-- key change
}

    // create the new incidnets
    public static function create(
        $customerID,
        $productCode,
        $techID,
        $title,
        $description
    ) {
        global $db;

        $sql = "INSERT INTO incidents
                (customerID, productCode, techID, dateOpened, title, description)
                VALUES
                (:customerID, :productCode, :techID, NOW(), :title, :description)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':customerID'  => $customerID,
            ':productCode' => $productCode,
            ':techID'      => $techID,
            ':title'       => $title,
            ':description' => $description
        ]);
    }

    // Close Incidents 
    public static function close($incidentID)
    {
        global $db;

        $sql = "UPDATE incidents
                SET dateClosed = NOW()
                WHERE incidentID = :incidentID";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':incidentID' => $incidentID
        ]);
    }

    //getOpenIncidents for the technicians

public static function getOpenByTechnician($techID)
{
    global $db;

    $sql = "
        SELECT i.*, c.firstName, c.lastName
        FROM incidents i
        JOIN customers c ON i.customerID = c.customerID
        WHERE i.techID = :techID
          AND i.dateClosed IS NULL
        ORDER BY i.dateOpened
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute([':techID' => $techID]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function updateDescription($incidentID, $description)
{
    global $db;

    $sql = "UPDATE incidents
            SET description = :description
            WHERE incidentID = :incidentID";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':description' => $description,
        ':incidentID'  => $incidentID
    ]);

    return $stmt->rowCount() >= 0;
}

}
