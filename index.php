<?php
// Inclusion de la connexion à la base de données
include 'ConnexionDb.php';

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Récupération des plats disponibles du menu
$sql_plats = "SELECT * FROM Menu WHERE estDisponible = 1"; // Plats disponibles
$result_plats = $conn->query($sql_plats);
$plats = [];

if ($result_plats === false) {
    die("Erreur dans la requête : " . $conn->error);
}

if ($result_plats->num_rows > 0) {
    while ($row = $result_plats->fetch_assoc()) {
        $plats[] = $row;
    }
}

// Récupération des tables disponibles pour la réservation
$sql_tables = "SELECT tableID, numeroTable, capacite FROM Tables WHERE estDisponible = 1";
$result_tables = $conn->query($sql_tables);
$tables = [];

if ($result_tables === false) {
    die("Erreur dans la requête : " . $conn->error);
}

if ($result_tables->num_rows > 0) {
    while ($row = $result_tables->fetch_assoc()) {
        $tables[] = $row;
    }
}

$conn->close(); // Fermer la connexion à la base de données
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Gourmet</title>

    <!-- CSS Bootstrap et Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Styles personnalisés -->
    <style>
        .hero {
            background: url('images/restaurant-bg.jpg') no-repeat center center/cover;
            height: 60vh;
        }

        .hero h2 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.2rem;
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }

        .footer {
            font-size: 0.9rem;
        }

        .btn-custom {
            background-color: #f8b400;
            color: #fff;
            border: none;
        }

        .btn-custom:hover {
            background-color: #d69d00;
        }

        .reservation h2 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;

        }

        .reservation .btn {
            background-color: rgb(13, 110, 253);
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 200px;
        }

        .reservation .btn:hover {
            background-color: rgb(46 130 255);
            color: black;
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
        }

        .reservation .btn i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <!-- En-tête -->
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="logo" style="font-family: 'Times New Roman', Times, serif">Resto & Verso</h1>
            <nav class="navbar">
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="#menu">Menu</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#reservation">Réserver</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Section principale -->
    <section
        class="hero text-white d-flex flex-column bg-primary justify-content-center align-items-center text-center">
        <div class="container">
            <h2>Bienvenue chez Restaurant Resto & Verso</h2>
            <p class="lead">Découvrez des saveurs exceptionnelles dans un cadre chaleureux.</p>
            <!-- <a href="#menu" class="btn btn-custom btn-lg">Voir le menu</a> -->
        </div>
    </section>

    <!-- Section Menu -->
    <section id="menu" class="menu py-5">
        <div class="row text-center">
            <h2 class="text-center mb-4" data-aos="fade-up" data-aos-duration="1500">Voir Le Menu</h2>

            <!-- Article 1 -->
            <div class="col-md-4">
                <img src="img/burger.jpg" alt="A delicious burger" style="width:300px; height:300px;"><br>
                <p>Nom : Burger</p>
                <p>Prix : 12.00 €</p>
                <a href="commander.php?nom=Burger&prix=12.00&image=img/burger.jpg" class="btn btn-primary me-3">
                    <i class="fas fa-calendar-alt"></i> Commander
                </a>
            </div>


            <!-- Article 2 -->
            <div class="col-md-4">
                <img src="img/p.jpg" alt="A delicious pizza" style="width:300px; height:300px;"><br>
                <p>Nom : Pizza</p>
                <p>Prix : 15.00 €</p>
                <a href="commander.php?nom=Pizza&prix=15.00&image=img/pizza.jpg" class="btn btn-primary me-3">
                    <i class="fas fa-calendar-alt"></i> Commander
                </a>
            </div>

            <!-- Article 3 -->
            <div class="col-md-4">
                <img src="img/tajine-poulet-soulard.jpg" alt="A delicious tajine"
                    style="width:300px; height:300px;"><br>
                <p>Nom : Tajine</p>
                <p>Prix : 18.00 €</p>
                <a href="commander.php?nom=Tajine&prix=18.00&image=img/tajine-poulet-soulard.jpg"
                    class="btn btn-primary me-3">
                    <i class="fas fa-calendar-alt"></i> Commander
                </a>
            </div>
        </div>

    </section>
    <div class="d-flex justify-content-center align-items-center">
    <a href="ListCommand.php" class="btn btn-primary">
        <i class="fas fa-list"></i> Afficher les réservations
    </a>
</div>



    <!-- Section Réservation -->
    <section id="reservation" class="reservation py-5">
        <div class="container">
            <h2 class="text-center mb-4 " data-aos='fade-up' data-aos-duration="1500">Réserver une Table</h2>
            <div class="d-flex justify-content-center">
                <a href="ajouter_table.php" class="btn btn-custom me-3"> <i class="fas fa-calendar-alt"></i>
                    Réserver</a>
                <a href="lister.php" class="btn btn-praima"><i class="fas fa-list"></i> Afficher les réservations</a>
            </div>
        </div>
    </section>
    <div class="d-flex justify-content-center align-items-center">
        <i class="fas fa-glass-cheers fa-3x mb-3 text-primary"></i>
        <h3>Événements</h3><br>
    </div>
    <div class="d-flex justify-content-center align-items-center" >
    <a href="evenment.php" class="btn btn-primary">
        <i class="fas fa-list"></i> evenment
    </a>
</div><br><br>

    <!-- Section Services -->
    <section id="services" class="services bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Nos Services</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="fas fa-utensils fa-3x mb-3 text-primary"></i>
                    <h3>Repas sur place</h3>
                    <p>Dégustez nos plats dans un cadre convivial.</p>
                </div>

                <div class="col-md-4">
                    <i class="fas fa-shipping-fast fa-3x mb-3 text-primary"></i>
                    <h3>Livraison</h3>
                    <p>Commandez et recevez vos plats chez vous.</p>
                </div>

                <div class="col-md-4">
                    <i class="fas fa-glass-cheers fa-3x mb-3 text-primary"></i>
                    <h3>Événements</h3>
                    <p>Organisez vos fêtes et événements spéciaux avec nous.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Contact -->
    <section id="contact" class="contact bg-dark text-white py-5">

    <div class="container text-center">
            <h2>Nous Contacter</h2>
            <p>Email : RestoVerso@gmail.com</p>
            <p>Téléphone : +212 6 48 60 59 29</p>
            <p>Adresse : 123 Rue de ista, Ifrane, Maroc</p>
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
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>