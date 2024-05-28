<?php
// Connexion à la base de données
$servername = "172.19.6.10";
$username = "root";
$password = "sn";
$dbname = "Karting";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Requête SQL pour récupérer les données nécessaires
$sql = "SELECT k.NumeroSerie AS KartNumber, k.LapTime AS LapTime, pt.ToursEffectues AS LapCount, p.Nom AS NomPilote, p.Prenom AS PrenomPilote, dt.Timestamp AS LastUpdateTime
    FROM karts k
    JOIN participation pt ON k.KartID = pt.KartID
    JOIN pilotes p ON pt.PiloteID = p.PiloteID
    JOIN donneestempsreel dt ON k.KartID = dt.KartID
    ORDER BY dt.Timestamp DESC
    LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Récupérer les données de la première ligne
    $row = $result->fetch_assoc();
    $kartNumber = $row['KartNumber'];
    $lapTime = $row['LapTime'];
    $lapCount = $row['LapCount'];
    $nomPilote = $row['NomPilote'];
    $prenomPilote = $row['PrenomPilote'];
    $lastUpdateTime = $row['LastUpdateTime'];

    // Afficher les données récupérées
    echo "Numéro de série du kart : " . $kartNumber . "<br>";
    echo "Temps par tour : " . $lapTime . "<br>";
    echo "Nombre de tours effectués : " . $lapCount . "<br>";
    echo "Nom du pilote : " . $nomPilote . "<br>";
    echo "Prénom du pilote : " . $prenomPilote . "<br>";
    echo "Dernière mise à jour : " . $lastUpdateTime . "<br>";
} else {
    echo "Aucune donnée trouvée dans la base de données.";
}

// Fermer la connexion
$conn->close();
?>
