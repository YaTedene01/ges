<?php $currentPage = $currentPage ?? '';?>
<?php if (isset($currentPage) && $currentPage === 'home') : ?>
    <!-- active link -->
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Sonatel Academy' ?></title>
    <!-- Inclure les fichiers CSS -->
    <link rel="stylesheet" href="/assets/css/layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php if (isset($additionalStyles)) echo $additionalStyles; ?>
</head>
<body>
    <!-- Menu toggle button for mobile -->
    <div class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </div>  
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="promotion-badge">
                <img src="/assets/images/sonatel.jpeg" alt="logo sonatel" class="logo-sonatel" style="width: 50px; height: auto;">
                
            </div>
            <div class="pact">
            <div class="pa">
            <?php if (isset($activePromotion) && !empty($activePromotion) && isset($activePromotion['date_debut'])): ?>
    PROMOTION - <?= date('Y', strtotime($activePromotion['date_debut'])) ?>
<?php else: ?>
    <span class="no-active-promotion">Aucune promotion active</span>
<?php endif; ?>
    </div>
    </div>

        </div>
        
        <div class="sidebar-menu">
            <a href="dashboard" class="menu-item <?= $currentPage == 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-th-large"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="promotions" class="menu-item <?= $currentPage == 'promotions' ? 'active' : '' ?>">
                <i class="fas fa-bookmark"></i>
                <span>Promotions</span>
            </a>
            <a href="referentiels" class="menu-item <?= $currentPage == 'referentiels' ? 'active' : '' ?>">
                <i class="fas fa-book"></i>
                <span>Référentiels</span>
            </a>
            <a href="apprenants" class="menu-item <?= $currentPage == 'apprenants' ? 'active' : '' ?>">
                <i class="fas fa-user-graduate"></i>
                <span>Apprenants</span>
            </a>
            <a href="presences" class="menu-item <?= $currentPage == 'presences' ? 'active' : '' ?>">
                <i class="fas fa-clipboard-check"></i>
                <span>Gestion des présences</span>
            </a>
            <a href="kits" class="menu-item <?= $currentPage == 'kits' ? 'active' : '' ?>">
                <i class="fas fa-laptop"></i>
                <span>Kits & Laptops</span>
            </a>
            <a href="rapports" class="menu-item <?= $currentPage == 'rapports' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i>
                <span>Rapports & Stats</span>
            </a>
            <a href="/logout" class="menu-item logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </div> 
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search">
            </div>
            
            <div class="user-section">
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                </div>
                
                <div class="user-profile">
                    <div class="user-info">
                        <div class="user-name"><?= isset($_SESSION['user']['nom']) ? $_SESSION['user']['nom'] : 'Utilisateur' ?></div>
                        <div class="user-role"><?= isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'Rôle non défini' ?></div>
                    </div>
                    
                    <div class="avatar">
                        <img src="assets/images/avatar.jpg" alt="User Avatar">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content container -->
        <div class="content-wrapper">
            <?php if (isset($contentHeader)): ?>
                <div class="content-header">
                    <?= $contentHeader ?>
                </div>
            <?php endif; ?>
            
            <div class="content-container">
            <?php if (isset($content) && file_exists($content)): ?>
    <?php include $content ?>
<?php else: ?>
    <p>Contenu non disponible.</p>
<?php endif; ?>
            </div>
        </div>
    </div>
    
    <!--<script>
        // Mobile menu toggle
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
        // Responsive adjustments
        function checkWidth() {
            if (window.innerWidth <= 576) {
                document.getElementById('sidebar').classList.remove('active');
            }
        }
        
        window.addEventListener('resize', checkWidth);
        window.addEventListener('load', checkWidth);
    </script>-->
    
    <?php if (isset($additionalScripts)) echo $additionalScripts; ?>
</body>
</html>