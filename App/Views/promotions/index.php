<?php
// En haut du fichier
require_once __DIR__.'/../../Controllers/PromoController.php';
session_init();
$promos = App\Controllers\get_all_promotions() ?? [];
$nbPromos = App\Controllers\get_nbr_promotions() ?? 0;
$nbPromos = count($promos);
error_log("Promotions récupérées : " . json_encode($promos));


$activePromos = array_filter($promos, function($promo) {
    return $promo['statut'] === 'active';
});
$nbActivePromos = count($activePromos);

// Déterminer le mode d'affichage (par défaut 'list')
$viewMode = isset($_GET['view']) ? $_GET['view'] : 'list';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="/assets/css/promotions.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php if (session_has('success_message')): ?>
        <div class="global-alert success">
            <i class="fas fa-check-circle"></i>
            <p><?= htmlspecialchars(session_get('success_message')['content'] ?? '') ?></p></div>
    <?php endif; ?>
    <div class="container">
        <div class="header">
            <div class="title-section">
                <h1>Promotion</h1>
                <p>Gérer les promotions de l'école</p>
            </div>
            <a href="?action=add" class="add-button">
    <i class="fas fa-plus"></i> Ajouter promotion
</a>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-info">
                    <h2>180</h2>
                    <p>Apprenants</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-info">
                    <h2>5</h2>
                    <p>Référentiels</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="stat-info">
    <h2><?= $nbActivePromos ?></h2>
    <p>promotion actives</p>
</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="stat-info">
    <h2><?= $nbPromos ?></h2>
    <p>Total promotions</p>
</div>
            </div>
        </div>

        <form method="GET" action="/promotions" id="filterForm">
            <di class="search-filter-section <?= (isset($_GET['action']) && $_GET['action'] === 'add') ? 'hidden' : '' ?>">

            <div class="search-bar">
    <form action="/promotions" method="GET">
        <input type="text" name="search" placeholder="Rechercher une promotion..." value="<?= htmlspecialchars($searchTerm ?? '') ?>">
        <button type="submit">Rechercher</button>
    </form>
</div>

<div class="promotions">
    <?php if (!empty($promotions)): ?>
        <?php foreach ($promotions as $promotion): ?>
            <div class="promotion-card">
                <h3><?= htmlspecialchars($promotion['nom']) ?></h3>
                <p>Date de début : <?= htmlspecialchars($promotion['date_debut']) ?></p>
                <p>Date de fin : <?= htmlspecialchars($promotion['date_fin']) ?></p>
                <p>Statut : <?= htmlspecialchars($promotion['statut']) ?></p>
            </div>
        <?php endforeach; ?>
   
    <?php endif; ?>
</div>
                <div class="filter-section">
                    <select class="filter-dropdown" name="classe" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Filtre par classe</option>
                        <option value="dev">Développement</option>
                        <option value="ref">Référentiel</option>
                        <option value="data">Data</option>
                    </select>
                    <select class="filter-dropdown" name="status" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Filtre par status</option>
                        <option value="active" <?= (isset($_GET['status']) && $_GET['status'] === 'active') ? 'selected' : '' ?>>Actifs</option>
                        <option value="inactive" <?= (isset($_GET['status']) && $_GET['status'] === 'inactive') ? 'selected' : '' ?>>Inactifs</option>
                    </select>
                    <div class="view-buttons">
                        <a href="?<?= http_build_query(array_merge($_GET, ['view' => 'grid'])) ?>" class="view-button <?= $viewMode === 'grid' ? 'active' : '' ?>">
                            <i class="fas fa-th-large"></i> Grille
                        </a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['view' => 'list'])) ?>" class="view-button <?= $viewMode === 'list' ? 'active' : '' ?>">
                            <i class="fas fa-list"></i> Liste
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($viewMode === 'grid'): ?>
            <!-- Affichage en grille -->
            <div class="promotions-grid <?= (isset($_GET['action']) && $_GET['action'] === 'add') ? 'hidden' : '' ?>">
                <?php if (!empty($promos)) : ?>
        <?php foreach ($promos as $promotion) : ?>
            <?php
            $defaults = [
                'id' => '0',
                'nom' => 'Promotion sans nom',
                'statut' => 'inactif',
                'date_debut' => 'Non définie',
                'date_fin' => 'Non définie',
                'photo' => '/assets/default-promo.png',
                'nbr_etudiants' => 0
            ];
            $promotion = array_merge($defaults, $promotion);

            $name = $promotion['nom'] ?? 'Promotion';
            $words = explode(' ', $name);
            $initials = count($words) >= 2
                ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                : strtoupper(substr($name, 0, 2));

            $colors = ['#00a67d', '#ff6b1b', '#2ecc71', '#e74c3c', '#3498db'];
            $colorIndex = hexdec(substr(md5($name), 0, 1)) % count($colors);
            $bgColor = $colors[$colorIndex];
            ?>
            <div class="promotion-card">
                <div class="status-bar">
                    <span class="status-badge <?= $promotion['statut'] === 'active' ? 'active' : 'inactive' ?>">
                        <?= htmlspecialchars(ucfirst($promotion['statut'])) ?>
                    </span>
                    <a href="/promotions/toggle?promotion_id=<?= $promotion['id'] ?>" 
                        class="power-button <?= $promotion['statut'] === 'active' ? 'active' : '' ?>">
                        <i class="fas fa-power-off"></i>
                    </a>
                </div>

                <div class="promotion-content">
                    <div class="promotion-header">
                        <div class="promotion-logo initials-logo" style="background-color: <?= $bgColor ?>">
                            <div >P</div>
                        </div>
                        <h3 class="promotion-title">
                            <?= htmlspecialchars($name) ?>
                        </h3>
                    </div>
                    <div class="promotion-date">
                        <i class="far fa-calendar-alt"></i>
                        <span>
                            <?= htmlspecialchars($promotion['date_debut']) ?> - 
                            <?= htmlspecialchars($promotion['date_fin']) ?>
                        </span>
                    </div>
                    <div class="promotion-stats">
                        <i class="fas fa-user-graduate"></i>
                        <span>
                            <?= htmlspecialchars($promotion['nbr_etudiants']) ?> apprenants
                        </span>
                    </div>
                    <div class="promotion-footer">
                        <a href="/promotions/<?= $promotion['id'] ?>" class="details-link">
                            Voir détails <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="no-promotions">
            <p>Aucune promotion disponible pour le moment</p>
        </div>
    <?php endif; ?>
</div>
            <?php else : ?>
    <!-- Affichage en liste -->
    <div class="promotions-list-container <?= (isset($_GET['action']) && $_GET['action'] === 'add') ? 'hidden' : '' ?>">
    <table class="promotions-list-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Promotion</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Référentiel</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Données de démonstration basées sur l'image
                $demoPromos = [
                    [
                        'id' => '1',
                        'nom' => 'Promotion 2025',
                        'date_debut' => '01/02/2025',
                        'date_fin' => '01/02/2026',
                        'statut' => 'active',
                        'referentiels' => ['DEV WEB/MOBILE', 'REF DIG', 'DEV DATA', 'AWS', 'HACKEUSE']
                    ],
                    [
                        'id' => '2',
                        'nom' => 'Promotion 2024',
                        'date_debut' => '01/02/2024',
                        'date_fin' => '01/02/2024',
                        'statut' => 'inactive',
                        'referentiels' => ['DEV WEB/MOBILE', 'REF DIG', 'DEV DATA', 'AWS', 'HACKEUSE']
                    ],
                    [
                        'id' => '3',
                        'nom' => 'Promotion 2023',
                        'date_debut' => '01/02/2023',
                        'date_fin' => '01/11/2023',
                        'statut' => 'inactive',
                        'referentiels' => ['DEV WEB/MOBILE', 'REF DIG', 'DEV DATA', 'AWS', 'HACKEUSE']
                    ],
                    [
                        'id' => '4',
                        'nom' => 'Promotion 2022',
                        'date_debut' => '01/02/2022',
                        'date_fin' => '01/02/2022',
                        'statut' => 'inactive',
                        'referentiels' => ['DEV WEB/MOBILE', 'REF DIG', 'DEV DATA', 'AWS', 'HACKEUSE']
                    ],
                    [
                        'id' => '5',
                        'nom' => 'Promotion 2021',
                        'date_debut' => '01/02/2021',
                        'date_fin' => '01/02/2021',
                        'statut' => 'inactive',
                        'referentiels' => ['DEV WEB/MOBILE', 'REF DIG', 'DEV DATA', 'AWS']
                    ]
                ];
                
                // Utiliser les données de démonstration ou les données réelles selon votre besoin
                $displayPromos = !empty($promos) ? $promos : $demoPromos;
                
                if (!empty($displayPromos)) : 
                    foreach ($displayPromos as $promotion) : 
                        $name = $promotion['nom'] ?? 'Promotion';
                        $words = explode(' ', $name);
                        $initials = count($words) >= 2 
                            ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                            : strtoupper(substr($name, 0, 2));
                        
                        $colors = ['#00a67d', '#ff6b1b', '#2ecc71', '#e74c3c', '#3498db'];
                        $colorIndex = hexdec(substr(md5($name), 0, 1)) % count($colors);
                        $bgColor = $colors[$colorIndex];
                        
                        $referentiels = isset($promotion['referentiels']) ? $promotion['referentiels'] : ['DEV WEB/MOBILE', 'REF DIG', 'DEV DATA', 'AWS', 'HACKEUSE'];
                ?>
                        <tr>
                            <td>
                                <div class="promotion-logo initials-logo" style="background-color: <?= $bgColor ?>">
                                    <div>P</div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($promotion['nom']) ?></td>
                            <td><?= htmlspecialchars($promotion['date_debut']) ?></td>
                            <td><?= htmlspecialchars($promotion['date_fin']) ?></td>
                            <td>
                                <?php foreach ($referentiels as $index => $ref): ?>
                                    <span class="referentiel-tag <?= strtolower(str_replace(' ', '-', str_replace('/', '', $ref))) ?>"><?= htmlspecialchars($ref) ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <span class="status-badge <?= $promotion['statut'] === 'active' ? 'active' : 'inactive' ?>">
                                    <?= htmlspecialchars(ucfirst($promotion['statut'])) ?>
                                </span>
                            </td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <button class="action-menu-button">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                    <?php endforeach; ?>
                    
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="no-promotions">
                            <p>Aucune promotion disponible pour le moment</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table> 
    </div>
    <?php
$totalItems = count($promos);
$itemsPerPage = 4;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPages = ceil($totalItems / $itemsPerPage);
$offset = ($currentPage - 1) * $itemsPerPage;
$currentPromos = array_slice($promos, $offset, $itemsPerPage);?>
    <div class="pagination <?= (isset($_GET['action']) && $_GET['action'] === 'add') ? 'hidden' : '' ?>">
    <div class="pagination-info">
        <?= $currentPage ?> à <?= $itemsPerPage ?> pour <?= $totalItems ?>
    </div>
    <div class="pagination-controls">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>" class="pagination-button">
                <i class="fas fa-chevron-left"></i>
            </a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="pagination-button <?= $i === $currentPage ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>" class="pagination-button">
                <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

        <!-- Modal d'ajout de promotion -->
        <?php if (isset($_GET['action']) && $_GET['action'] === 'add'): ?>
    <!-- Formulaire d'ajout de promotion -->
    <div class="add-promotion-form">
        <h2>Créer une nouvelle promotion</h2>
        
        <form action="/promotions/create" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create">
            
            <!-- Champ Nom -->
            <div class="form-group">
                <label for="promotionName">Nom de la promotion*</label>
                <input type="text" id="promotionName" name="nom" class="form-control" 
                    placeholder="Ex: Promotion 2025" 




                    value="<?= htmlspecialchars(get_old_input('nom')) ?>">
            </div>

            <!-- Dates -->
            <div class="date-inputs">
                <div class="form-group">
                    <label for="startDate">Date de début*</label>
                    <input type="date" id="startDate" name="datedebut" class="form-control" 




                        value="<?= htmlspecialchars(get_old_input('datedebut')) ?>">
                </div>
                <div class="form-group">
                    <label for="endDate">Date de fin*</label>
                    <input type="date" id="endDate" name="datefin" class="form-control" 




                        value="<?= htmlspecialchars(get_old_input('datefin')) ?>">
                </div>
            </div>

            <!-- Photo -->
            <div class="form-group">
                <label for="photo">Photo de la promotion*</label>
                <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg,image/png">



            </div>

            <!-- Référentiels -->
            <div class="form-group">
                <label for="referentiels">Référentiels*</label>
                <input type="text" id="referentiels" name="referentiels" class="form-control" 





                    placeholder="Ex: DEV WEB/MOBILE,REF DIG,DEV DATA"
                    value="<?= htmlspecialchars(get_old_input('referentiels')) ?>">
            </div>

            <button type="submit" class="btn btn-primary">Créer la promotion</button>
            <a href="/promotions" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
<?php endif; ?>




<?php
// Nettoyer les messages d'erreur après affichage
if (session_has('promotion_errors')) {
    session_remove('promotion_errors');
}
if (session_has('old_input')) {
    session_remove('old_input');
}
?>    
<!--<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Formater les dates
        const dateInputs = document.querySelectorAll('#startDate, #endDate');
        dateInputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (input.value.trim() !== '') {
                    const parts = input.value.split('/');
                    if (parts.length === 3) {
                        input.value = parts.join('/');
                    }
                }
            });
        });

        // Gestion du menu d'actions
        const actionButtons = document.querySelectorAll('.action-menu-button');
        actionButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                // Ici vous pouvez ajouter le code pour afficher un menu contextuel
                console.log('Menu action clicked');
            });
        });
    });
    </script>
-->
    
</div>
</body>
</html>
