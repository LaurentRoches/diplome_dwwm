<?php
// save_availability.php
include 'db_connection.php'; // Connexion à la base de données

$id_user = $_SESSION['id_user']; // Supposons que l'utilisateur est connecté

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pour un seul slot
    $jour = $_POST['jour'];
    $time_debut = $_POST['time_debut'];
    $time_fin = $_POST['time_fin'];

    $sql = "INSERT INTO disponibilite (id_user, jour, time_debut, time_fin) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $id_user, $jour, $time_debut, $time_fin);
    $stmt->execute();

    // Pour les autres slots ajoutés
    if (isset($_POST['jour[]'])) {
        foreach ($_POST['jour[]'] as $index => $additional_jour) {
            $additional_time_debut = $_POST['time_debut[]'][$index];
            $additional_time_fin = $_POST['time_fin[]'][$index];

            $stmt->bind_param("isss", $id_user, $additional_jour, $additional_time_debut, $additional_time_fin);
            $stmt->execute();
        }
    }

    header('Location: availability_success.php'); // Rediriger après succès
    exit();
}
?>
