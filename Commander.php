<?php
// Récupération des données passées via GET
$nomC = isset($_GET['nom']) ? htmlspecialchars($_GET['nom']) : '';
$prix = isset($_GET['prix']) ? htmlspecialchars($_GET['prix']) : '';
$image = isset($_GET['image']) ? htmlspecialchars($_GET['image']) : ''; // Optional, if image is required

// Vérifiez que les données nécessaires sont disponibles
if (empty($nomC) || empty($prix)) {
    echo "Données de l'article manquantes. <a href='index.php'>Retour au menu</a>";
    exit;
}

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'ConnexionDb.php';

    // Récupération de la quantité et du mode de livraison depuis POST
    $quantite = isset($_POST['quantite']) ? $_POST['quantite'] : 1; // Default quantity to 1 if not provided
    $modeLivraison = isset($_POST['mode_livraison']) ? $_POST['mode_livraison'] : 'sur place'; // Default to 'sur place'

    // Calculer le prix total
    $prixTotal = $prix * $quantite;

    // Préparer la requête d'insertion dans la table `comande`
    $sql = "INSERT INTO `comande`(`nomC`, `qantC`, `etat`, `prix`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sisd', $nomC, $quantite, $modeLivraison, $prixTotal); // 's' for string, 'i' for integer, 'd' for double (float)

    if ($stmt->execute()) {
        $message = "Commande ajoutée avec succès! Mode de livraison: $modeLivraison";
    } else {
        $message = "Erreur lors de l'ajout de la commande: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
            font-size: 3rem;
            font-family: 'Times New Roman', Times, serif;
            padding: 12px;
            margin-left: 1rem;
            border-radius: 8px 8px 0 0;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            margin-left: 20px;
            transition: border-color 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }

        label {
            color: #4a5568;
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .container2 {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }

        .alert {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .btnAjouter {
            background-color: rgb(13, 110, 253);
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .btnAjouter:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
        }

        .btnAnnuler {
            background-color: red;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .btnAnnuler:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
        }
    </style>
</head>
<body>
    <header>
        <h1 class="animate__animated animate__backInLeft">Passer une Commande</h1>
    </header>

    <section class="py-5">
        <div class="container2">
            <h2 class="text-center mb-4"> <i class="fas fa-shopping-cart"></i> Passer une nouvelle commande</h2>

            <?php if (isset($message)): ?>
                <div class="alert text-center"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form action="commander.php?nom=<?php echo urlencode($nomC); ?>&prix=<?php echo urlencode($prix); ?>" method="POST">
                <div class="form-group">
                    <label for="quantite">Quantité :</label>
                    <input type="number" id="quantite" name="quantite" value="1" min="1" required>
                </div>

                <div class="form-group">
                    <label for="mode_livraison">Mode de livraison :</label>
                    <select name="mode_livraison" id="mode_livraison" required>
                        <option value="sur place">Sur place</option>
                        <option value="livraison">Livraison</option>
                    </select>
                </div>

                <div class="col-12 text-center form-group">
                    <button type="submit" class="btnAjouter"><i class="fas fa-check-circle"></i> Passer la commande</button>
                    <a href="index.php" class="btnAnnuler"><i class="fas fa-times-circle"></i> Annuler</a>
                </div>
            </form>
        </div>
    </section>

    <footer class="footer bg-dark text-white py-3">
        <div class="container text-center">
            <p>&copy; 2024 Cinema Commandes. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
