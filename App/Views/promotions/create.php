<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/promotions.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php if (isset($_GET['action']) && $_GET['action'] === 'add'): ?>
    <!-- Formulaire d'ajout de promotion -->
    <div class="add-promotion-form">
        <h2>Créer une nouvelle promotion</h2>
        <form action="/promotions/create" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create">
            
            <!-- Champ Nom -->
            <div class="form-group">
                <label for="promotionName">Nom de la promotion</label>
                <input type="text" id="promotionName" name="nom" class="form-control" 
                    placeholder="Ex: Promotion 2025" 
                    value="<?= htmlspecialchars(get_old_input('nom')) ?>">
                <?php if (session_has('validation_errors.nom')): ?>
                    <div class="error-text">
                        <?= implode('<br>', session_get('validation_errors.nom', [])) ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Dates -->
            <div class="date-inputs">
                <div class="form-group">
                    <label for="startDate">Date de début</label>
                    <input type="text" id="startDate" name="datedebut" class="form-control" 
                        placeholder="dd/mm/yyyy"
                        value="<?= htmlspecialchars(get_old_input('datedebut')) ?>">
                    <?php if (session_has('validation_errors.datedebut')): ?>
                        <div class="error-text">
                            <?= implode('<br>', session_get('validation_errors.datedebut', [])) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="endDate">Date de fin</label>
                    <input type="text" id="endDate" name="datefin" class="form-control" 
                        placeholder="dd/mm/yyyy"
                        value="<?= htmlspecialchars(get_old_input('datefin')) ?>">
                    <?php if (session_has('validation_errors.datefin')): ?>
                        <div class="error-text">
                            <?= implode('<br>', session_get('validation_errors.datefin', [])) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Photo -->
            <div class="form-group">
                <label for="photo">Photo de la promotion</label>
                <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg,image/png">
                <?php if (session_has('validation_errors.photo')): ?>
                    <div class="error-text">
                        <?= implode('<br>', session_get('validation_errors.photo', [])) ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Référentiels -->
            <div class="form-group">
                <label for="referentiels">Référentiels</label>
                <input type="text" id="referentiels" name="referentiels" class="form-control" 
                    placeholder="Ex: DEV WEB/MOBILE"
                    value="<?= htmlspecialchars(get_old_input('referentiels')) ?>">
                <?php if (session_has('validation_errors.referentiels')): ?>
                    <div class="error-text">
                        <?= implode('<br>', session_get('validation_errors.referentiels', [])) ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Créer la promotion</button>
            <a href="/promotions" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
<?php else: ?>
    <!-- Affichage des promotions -->
    <div class="promotions-list">
        <?php if (!empty($promos)): ?>
            <?php foreach ($promos as $promotion): ?>
                <div class="promotion-card">
                    <h3><?= htmlspecialchars($promotion['nom']) ?></h3>
                    <p><?= htmlspecialchars($promotion['date_debut']) ?> - <?= htmlspecialchars($promotion['date_fin']) ?></p>
                    <p><?= htmlspecialchars($promotion['statut']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune promotion disponible.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>
</body>
</html>