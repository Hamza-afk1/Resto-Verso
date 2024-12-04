<?php
// Inclusion de la connexion à la base de données
require 'ConnexionDb.php';

// Requête SQL pour récupérer les événements réservés
$sql = "SELECT `id`, `nom`, `date` FROM `evenment` ORDER BY `date` ASC";

// Exécution de la requête
$result = $conn->query($sql);

// Vérification si la requête a renvoyé des résultats
if ($result && $result->num_rows > 0) {
    // Récupère toutes les lignes sous forme de tableau associatif
    $evenements_reserves = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $evenements_reserves = [];
}

$conn->close(); // Fermeture de la connexion à la base de données
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Événements Réservés</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        header {
            background-color: rgb(13, 110, 253);
            margin-bottom: 4rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #fff;
            padding: 12px;
            margin-left: 1rem;
            font-size: 3rem;
            border-radius: 8px 8px 0 0;
            font-family: 'Times New Roman', Times, serif;
        }

        .add-new {
            width: max-content;
            margin: 10px 0;
            background-color: rgb(13, 110, 253);
            text-decoration: none;
            color: white;
            padding: 10px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .add-new:hover {
            background-color: rgb(46 130 255);
            transform: scale(1.05);
        }

        thead {
            background-color: rgb(13, 110, 253);
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: rgb(13, 110, 253);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: rgb(233, 236, 239);
        }
    </style>
</head>

<body>
    <header>
        <h1 class="animate__animated animate__backInLeft">Liste des Événements Réservés</h1>
    </header>

    <div class="container">
        <?php if (empty($evenements_reserves)): ?>
            <div class="alert alert-warning text-center">Aucun événement réservé actuellement.</div>
        <?php else: ?>
            <a href="ajouter_evenement.php" class="add-new"> <i class="fas fa-plus"></i> Ajouter un nouvel événement</a>

            <!-- Tableau des événements réservés -->
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom de l'Événement</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($evenements_reserves as $evenement): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($evenement['id']); ?></td>
                            <td><?php echo htmlspecialchars($evenement['nom']); ?></td>
                            <td><?php echo htmlspecialchars($evenement['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Pied de page -->
    <footer class="footer bg-primary text-white py-3">
        <div class="container text-center">
            <p>&copy; 2024 Restaurant Resto & Verso. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>
