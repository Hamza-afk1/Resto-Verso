<?php
// Inclusion de la connexion à la base de données
include 'ConnexionDb.php';

// Ajouter un événement si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si les clés "nom" et "date" existent dans $_POST
    if (isset($_POST['nom']) && isset($_POST['date'])) {
        // Récupérer les valeurs du formulaire
        $nom = $_POST['nom'];
        $date = $_POST['date'];

        // Vérifier si un événement avec la même date existe déjà
        $sql_check = "SELECT id FROM evenment WHERE date = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('s', $date);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $message = "Un événement existe déjà pour cette date. Veuillez choisir une autre date.";
        } else {
            // Préparer et exécuter la requête d'insertion si la date est disponible
            $sql = "INSERT INTO evenment (nom, date) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $nom, $date);

            // Vérifier l'exécution de la requête
            if ($stmt->execute()) {
                $message = "Événement ajouté avec succès.";
            } else {
                $message = "Erreur lors de l'ajout de l'événement: " . $conn->error;
            }

            $stmt->close();  // Fermer la requête préparée
        }

        $stmt_check->close();  // Fermer la requête de vérification
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}

// Récupérer les événements réservés
$sql_events = "SELECT id, nom, date FROM evenment ORDER BY date ASC";
$result_events = $conn->query($sql_events);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        section {
            display: flex;
            align-items: center;
            justify-content: center;
        }

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

        .container2 {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 600px;
        }

        label {
            color: #4a5568;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
        }

        button {
            background-color: rgb(13, 110, 253);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
        }

        .alert {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <!-- En-tête -->
    <header>
        <h1><i class="fas fa-calendar-alt"></i> Gestion des Événements</h1>
    </header>

    <!-- Formulaire pour ajouter un événement -->
    <section class="py-5">
        <div class="container2">
            <h2 class="text-center mb-4"> <i class="fas fa-plus-circle"></i> Ajouter un nouvel événement</h2>

            <?php if (isset($message)): ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form action="evenment.php" method="POST" class="row g-3">
                <div class="form-group">
                    <label for="nom" class="form-label">Nom de l'Événement :</label>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <div class="form-group">
                    <label for="date" class="form-label">Date de l'Événement :</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="col-12 text-center form-group">
                    <button type="submit"><i class="fas fa-check-circle"></i> Ajouter l'événement</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Affichage des événements réservés -->
    <section class="py-5">
        <div class="container2">
            <h2 class="text-center mb-4">Événements Réservés</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom de l'Événement</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_events->num_rows > 0) {
                        while ($row = $result_events->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['nom'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Aucun événement réservé.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Pied de page -->
    <footer class="footer bg-dark text-white py-3">
        <div class="container text-center">
            <p>&copy; 2024 Restaurant Resto & Verso. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Lien vers Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
