<?php
// save_availability.php
include 'db_connection.php'; // Connexion à la base de données

$user_id = $_SESSION['user_id']; // Supposons que l'utilisateur est connecté

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pour un seul slot
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "INSERT INTO availabilities (user_id, day, start_time, end_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $day, $start_time, $end_time);
    $stmt->execute();

    // Pour les autres slots ajoutés
    if (isset($_POST['day[]'])) {
        foreach ($_POST['day[]'] as $index => $additional_day) {
            $additional_start_time = $_POST['start_time[]'][$index];
            $additional_end_time = $_POST['end_time[]'][$index];

            $stmt->bind_param("isss", $user_id, $additional_day, $additional_start_time, $additional_end_time);
            $stmt->execute();
        }
    }

    header('Location: availability_success.php'); // Rediriger après succès
    exit();
}
?>
