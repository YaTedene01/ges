<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Apprenant</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        body {
            padding: 20px;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .form-container {
            border: 2px solid #333;
            border-radius: 10px;
            background-color: white;
            padding: 20px;
            width: 100%;
            max-width: 900px;
        }
        
        .form-header {
            color: #009688;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #333;
            font-weight: bold;
        }
        
        .edit-icon {
            margin-left: 10px;
            color: #777;
            cursor: pointer;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
            gap: 15px;
        }
        
        .form-group {
            flex: 1;
            min-width: 200px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }
        
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f8f8f8;
        }
        
        .calendar-icon {
            position: relative;
        }
        
        .calendar-icon::after {
            content: "📅";
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff9800;
        }
        
        .file-upload {
            border: 1px dashed #0066cc;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            margin-top: 10px;
        }
        
        .upload-icon {
            color: #0066cc;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .upload-text {
            color: #0066cc;
            font-size: 14px;
        }
        
        .buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .btn-cancel {
            background-color: #f5f5f5;
            color: #333;
        }
        
        .btn-submit {
            background-color: #009688;
            color: white;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="form-header">Ajout apprenant</h2>
        
        <form action="/apprenants/create" method="POST">
            <div class="form-section">
                <div class="section-title">
                    Informations de l'apprenant
                    <span class="edit-icon">✏️</span>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Prénom(s)</label>
                        <input type="text" class="form-control" name="prenom" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" name="nom" required />
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group calendar-icon">
                        <label class="form-label">Date de naissance</label>
                        <input type="text" class="form-control" name="date_naissance" placeholder="JJ/MM/AAAA" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lieu de naissance</label>
                        <input type="text" class="form-control" name="lieu_naissance" required />
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Adresse</label>
                        <input type="text" class="form-control" name="adresse" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required />
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" name="telephone" required />
                    </div>
                    <div class="form-group">
                        <div class="file-upload">
                            <div class="upload-icon">📄</div>
                            <div class="upload-text">Ajouter des documents</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <div class="section-title">
                    Informations du tuteur
                    <span class="edit-icon">✏️</span>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Prénom(s) & nom</label>
                        <input type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lien de parenté</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Adresse</label>
                        <input type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" />
                    </div>
                </div>
            </div>
            
            <div class="buttons">
                <button class="btn btn-cancel">Annuler</button>
                <button type="submit" class="btn btn-submit">Enregistrer</button>
            </div>
        </form>
    </div>
</body>
</html>