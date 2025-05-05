<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Apprenant</title>
    <link rel="stylesheet" href="/assets/css/apprenants.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .error-message {
            color: #e74c3c;
            font-size: 0.85em;
            margin-top: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title-section">
                <h1>Ajouter un apprenant</h1>
                <p>Remplissez le formulaire pour ajouter un nouvel apprenant</p>
            </div>
            <a href="/apprenants" class="back-button">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <div class="add-apprenant-form">
            <form action="/apprenants/create" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">
                
                <div class="form-row">
                    <!-- Informations personnelles -->
                    <div class="form-column">
                        <h3>Informations personnelles</h3>
                        
                        <div class="form-group">
                            <label for="nom">Nom*</label>
                            <input type="text" id="nom" name="nom" class="form-control" 
                                placeholder="Nom de l'apprenant" 
                                value="<?= htmlspecialchars(session_get('old_input.nom', '')) ?>">
                            <?php if (session_has('apprenant_errors') && isset(session_get('apprenant_errors')['nom'])): ?>
                                <div class="error-message"><?= htmlspecialchars(session_get('apprenant_errors')['nom']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="prenom">Prénom*</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" 
                                placeholder="Prénom de l'apprenant" 
                                value="<?= htmlspecialchars(session_get('old_input.prenom', '')) ?>">
                            <?php if (session_has('apprenant_errors') && isset(session_get('apprenant_errors')['prenom'])): ?>
                                <div class="error-message"><?= htmlspecialchars(session_get('apprenant_errors')['prenom']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email*</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                placeholder="Email de l'apprenant" 
                                value="<?= htmlspecialchars(session_get('old_input.email', '')) ?>">
                            <?php if (session_has('apprenant_errors') && isset(session_get('apprenant_errors')['email'])): ?>
                                <div class="error-message"><?= htmlspecialchars(session_get('apprenant_errors')['email']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="telephone">Téléphone*</label>
                            <input type="tel" id="telephone" name="telephone" class="form-control" 
                                placeholder="Numéro de téléphone" 
                                value="<?= htmlspecialchars(session_get('old_input.telephone', '')) ?>">
                            <?php if (session_has('apprenant_errors') && isset(session_get('apprenant_errors')['telephone'])): ?>
                                <div class="error-message"><?= htmlspecialchars(session_get('apprenant_errors')['telephone']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="date_naissance">Date de naissance*</label>
                            <input type="date" id="date_naissance" name="date_naissance" class="form-control" 
                                value="<?= htmlspecialchars(session_get('old_input.date_naissance', '')) ?>">
                            <?php if (session_has('apprenant_errors') && isset(session_get('apprenant_errors')['date_naissance'])): ?>
                                <div class="error-message"><?= htmlspecialchars(session_get('apprenant_errors')['date_naissance']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Informations académiques -->
                    <div class="form-column">
                        <h3>Informations académiques</h3>
                        
                        <div class="form-group">
                            <label for="promotion">Promotion*</label>
                            <select id="promotion" name="promotion" class="form-control">
                                <option value="">Sélectionner une promotion</option>
                                <!-- Options de promotion à charger dynamiquement -->
                                <?php foreach ($promotions ?? [] as $promotion): ?>
                                    <option value="<?= $promotion['id'] ?>" <?= session_get('old_input.promotion', '') == $promotion['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($promotion['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session_has('apprenant_errors') && isset(session_get('apprenant_errors')['promotion'])): ?>
                                <div class="error-message"><?= htmlspecialchars(session_get('apprenant_errors')['promotion']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="referentiel">Référentiel*</label>
                            <select id="referentiel" name="referentiel" class="form-control">
                                <option value="">Sélectionner un référentiel</option>
                                <!-- Options de référentiel à charger dynamiquement -->
                                <?php foreach ($referentiels ?? [] as $referentiel): ?>
                                    <option value="<?= $referentiel['id'] ?>" <?= session_get('old_input.referentiel', '') == $referentiel['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($referentiel['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session_has('apprenant_errors') && isset(session_get('apprenant_errors')['referentiel'])): ?>
                                <div class="error-message"><?= htmlspecialchars(session_get('apprenant_errors')['referentiel']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="photo">Photo de l'apprenant*</label>
                            <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg,image/png">
                            <?php if (session_has('apprenant_errors') && isset(session_get('apprenant_errors')['photo'])): ?>
                                <div class="error-message"><?= htmlspecialchars(session_get('apprenant_errors')['photo']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Ajouter l'apprenant</button>
                    <a href="/apprenants" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
    
    <?php
    // Nettoyer les messages d'erreur après affichage
    if (session_has('apprenant_errors')) {
        session_remove('apprenant_errors');
    }
    if (session_has('old_input')) {
        session_remove('old_input');
    }
    ?>
</body>
</html>