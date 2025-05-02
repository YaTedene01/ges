<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affecter/Désaffecter des Référentiels</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: #444;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .subtitle {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .referentiels-container {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .referentiels-box {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }

        .referentiels-box h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .referentiel-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .referentiel-item:last-child {
            border-bottom: none;
        }

        .btn {
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #0b5ed7;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            float: right;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        .btn-back i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Affecter/Désaffecter des Référentiels</h1>
        <div class="subtitle">Promotion : Promotion 2025</div>

        <button class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour aux référentiels
        </button>

        <div class="referentiels-container">
            <div class="referentiels-box">
                <h2>Référentiels affectés</h2>
                <div class="referentiel-item">
                    <div>Référent Digital</div>
                    <button class="btn">-</button>
                </div>
                <div class="referentiel-item">
                    <div>Hackeuse</div>
                    <button class="btn">-</button>
                </div>
            </div>

            <div class="referentiels-box">
                <h2>Référentiels non affectés</h2>
                <div class="referentiel-item">
                    <div>Développement Web</div>
                    <button class="btn">+</button>
                </div>
                <div class="referentiel-item">
                    <div>Développement Data</div>
                    <button class="btn">+</button>
                </div>
                <div class="referentiel-item">
                    <div>AWS & DevOps</div>
                    <button class="btn">+</button>
                </div>
                <div class="referentiel-item">
                    <div>Cybersécurité</div>
                    <button class="btn">+</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>