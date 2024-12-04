<?php
// Inclusion de la connexion à la base de données
include 'ConnexionDb.php';

// Récupérer les données des commandes
$sql = "SELECT `idC`, `nomC`, `qantC`, `etat`, `prix` FROM `comande` WHERE 1";
$result = $conn->query($sql);

// Vérifier si des commandes ont été trouvées
if ($result->num_rows > 0) {
    // Tableau pour stocker les commandes
    $commands = [];
    while ($row = $result->fetch_assoc()) {
        $commands[] = $row;
    }
} else {
    $commands = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

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
            border: none;
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
            color: white;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #e2e8f0;
        }

        table th {
            background-color: rgb(13, 110, 253);
            color: white;
        }

        .container {
            margin-top: 50px;
        }

        .link-dark {
            color: #064e3b;
            text-decoration: none;
        }

        .link-dark:hover {
            color: rgb(46 130 255);
        }
    </style>
</head>
<body>

<header>
    <h1 class="animate__animated animate__backInLeft">Liste des Commandes</h1>
</header>

<div class="container">
    <?php if (count($commands) > 0): ?>
        <!-- Tableau des commandes -->
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col" style="color: black">ID Commande</th>
                    <th scope="col" style="color: black">Nom Client</th>
                    <th scope="col" style="color: black">Quantité</th>
                    <th scope="col" style="color: black">État</th>
                    <th scope="col" style="color: black">Prix</th>
                    <!-- <th scope="col" style="color: black">Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commands as $command): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($command['idC']); ?></td>
                        <td><?php echo htmlspecialchars($command['nomC']); ?></td>
                        <td><?php echo htmlspecialchars($command['qantC']); ?></td>
                        <td><?php echo htmlspecialchars($command['etat']); ?></td>
                        <td><?php echo htmlspecialchars($command['prix']); ?> €</td>
                        <!-- <td>
                            <a href="edit_command.php?id=<?php echo $command['idC']; ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                            <a href="delete_command.php?id=<?php echo $command['idC']; ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center">Aucune commande trouvée.</div>
    <?php endif; ?>

    <div class="text-center">
        <a href="index.php" class="add-new"><i class="fas fa-home"></i>Retour à l'accueil</a>
    </div>
</div>

<!-- Bootstrap and JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
