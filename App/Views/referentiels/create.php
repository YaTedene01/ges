<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Référentiel</title>
    <style>
        /* Ajoutez ici vos styles ou réutilisez ceux de index.php */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #ff6b1b;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            margin-left: 10px;
        }
        .error-message {
            color: #e74c3c;
            font-size: 0.85em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Créer un nouveau référentiel</h1>
        
        <form action="/referentiels/create" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create">
            
            <!-- Champ Nom -->
            <div class="form-group">
                <label for="nom">Nom du référentiel*</label>
                <input type="text" id="nom" name="nom" class="form-control" 
                    placeholder="Ex: Développement Web/Mobile" 
                    value="<?= htmlspecialchars(session_get('old_input.nom', '')) ?>">
                <?php if (session_has('referentiel_errors') && isset(session_get('referentiel_errors')['nom'])): ?>
                    <div class="error-message"><?= htmlspecialchars(session_get('referentiel_errors')['nom']) ?></div>
                <?php endif; ?>
            </div>
            
            <!-- Description -->
            <div class="form-group">
                <label for="description">Description*</label>
                <textarea id="description" name="description" class="form-control" 
                    placeholder="Description du référentiel" rows="4"><?= htmlspecialchars(session_get('old_input.description', '')) ?></textarea>
                <?php if (session_has('referentiel_errors') && isset(session_get('referentiel_errors')['description'])): ?>
                    <div class="error-message"><?= htmlspecialchars(session_get('referentiel_errors')['description']) ?></div>
                <?php endif; ?>
            </div>
            
            <!-- Image -->
            <div class="form-group">
                <label for="image">Image du référentiel*</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/jpeg,image/png">
                <?php if (session_has('referentiel_errors') && isset(session_get('referentiel_errors')['image'])): ?>
                    <div class="error-message"><?= htmlspecialchars(session_get('referentiel_errors')['image']) ?></div>
                <?php endif; ?>
            </div>
            
            <!-- Capacité -->
            <div class="form-group">
                <label for="capacite">Capacité (nombre d'apprenants)*</label>
                <input type="number" id="capacite" name="capacite" class="form-control" 
                    placeholder="Ex: 30" 
                    value="<?= htmlspecialchars(session_get('old_input.capacite', '')) ?>">
                <?php if (session_has('referentiel_errors') && isset(session_get('referentiel_errors')['capacite'])): ?>
                    <div class="error-message"><?= htmlspecialchars(session_get('referentiel_errors')['capacite']) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Créer le référentiel</button>
                <a href="/referentiels" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
    
    <?php
    // Nettoyer les messages d'erreur après affichage
    if (session_has('referentiel_errors')) {
        session_remove('referentiel_errors');
    }
    if (session_has('old_input')) {
        session_remove('old_input');
    }
    ?>
</body>
</html>