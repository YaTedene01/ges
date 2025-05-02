<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Référentiels de la Promotion Active</title>

    <style>
        :root {
            --primary-color: #0a967a;
            --primary-light: #e0f2f1;
            --secondary-color: #6067e6;
            --text-color: #333;
            --light-gray: #f2f2f2;
            --border-color: #ddd;
            --white: #fff;
            --box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            margin-bottom: 20px;
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 24px;
        }

        .search {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .search-input {
            width: 75%;
            padding: 12px 20px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 14px;
            background-color: var(--white);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px; /* Espace entre l'icône et le texte */
            transition: var(--transition);
        }

        .btn:hover {
            background-color: #078069;
        }

        .btn svg {
            width: 1px;
            height: 16px;
            stroke: white;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .card-img {
            height: 150px;
            overflow: hidden;
        }

        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        .card-title {
            color: var(--primary-color);
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: 600;
        }

        .card-description {
            color: #666;
            font-size: 12px;
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .card-capacity {
            font-size: 12px;
            color: #777;
            display: inline-block;
            padding: 3px 8px;
            background-color: var(--primary-light);
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Liste des référentiels de la promotion active</h1>
        </header>
        <div class="search">
            <input type="text" class="search-input" placeholder="Rechercher un référentiel...">
            <!-- Bouton "Tous" -->
            <a href="/referentiels/index" class="btn">Tous</a>
            <!-- Bouton "Ajouter Référentiel" -->
            <a href="/referentiels/affreferentiel" class="btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Ajouter Référentiel
            </a>
        </div>
        <?php
        global $data;
        $referentiel = $data['referentiel'] ?? null;
        ?>
        <div class="grid">
            <?php if ($referentiel): ?>
                <div class="card">
                    <div class="card-img">
                        <img src="/assets/images/default.jpg" alt="<?= htmlspecialchars($referentiel['nom']) ?>">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title"><?= htmlspecialchars($referentiel['nom']) ?></h3>
                        <p class="card-description"><?= htmlspecialchars($referentiel['description']) ?></p>
                    </div>
                </div>
            <?php else: ?>
                <p>Aucun référentiel trouvé pour la promotion active.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>