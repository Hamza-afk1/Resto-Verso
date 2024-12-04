<?php
// Inclusion de la connexion à la base de données
include 'ConnexionDb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les valeurs du formulaire
    $numeroTable = $_POST['numeroTable'];
    $capacite = $_POST['capacite'];

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO Tables (numeroTable, capacite, estDisponible) VALUES (?, ?, 1)";  // 1 = Table disponible

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $numeroTable, $capacite);

    // Vérifier l'exécution de la requête
    if ($stmt->execute()) {
        $message = "Table ajoutée avec succès.";
    } else {
        $message = "Erreur lors de l'ajout de la table: " . $conn->error;
    }

    $stmt->close();  // Fermer la requête préparée
    $conn->close();  // Fermer la connexion
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Table</title>
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
    color: #064e3b;
    padding: 12px;
    margin-left: 1rem;
    font-size: 3rem;
    border-radius: 8px 8px 0 0;

    color: #fff;
    font-size: 3rem;
    font-family: 'Times New Roman', Times, serif
}

form {
    display: flex;
    flex-direction: column;
}

input {
    width: 100%;
    padding: 10px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    margin-left: 20px;
    transition: border-color 0.3s ease;
}

input:focus {
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



a,
.btnAnnuler,
.btnAjouter {
    background-color: red;
    color: white;
    text-decoration: none;
    margin-left: 20px;
    padding: 10px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    background: red;
    transition: all 0.3s ease;
}
button:hover {
   
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
}
.btnAjouter {
    background-color: rgb(13, 110, 253);
}
    </style>
</head>

<body>
    <!-- En-tête -->
    <header >
       
            <h1 class="animate__animated animate__backInLeft">Ajouter une Table</h1>
        
    </header>

    <!-- Formulaire pour ajouter une table -->
    <section class="py-5">
        <div class="container2">
            <h2 class="text-center mb-4"> <i class="fas fa-table"></i> Ajouter une nouvelle table</h2>

            <?php if (isset($message)): ?>
                <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form action="ajouter_table.php" method="POST" class="row g-3">
                <div class=" form-group">
                    <label for="numeroTable" class="form-label">Numéro de la Table :</label>
                    <input type="text" id="numeroTable" name="numeroTable" required>
                </div>
                <div class=" form-group">
                    <label for="capacite" class="form-label">Capacité de la Table :</label>
                    <input type="number" id="capacite" name="capacite" required>
                </div>
                <div class="col-12 text-center form-group   ">
                    <button type="submit" class="btnAjouter"><i class="fas fa-plus-circle"></i> Ajouter la
                        Table</button>
                    <button type="submit" class="btnAnnuler"> <i class="fas fa-times-circle"></i>
                        <a href="index.php">Annuler</a></button>

                </div>
            </form>
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