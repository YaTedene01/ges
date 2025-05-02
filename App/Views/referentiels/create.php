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
            font-size: 14px;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-control:focus {
            outline: none;
            border-color: #0a967a;
        }
        .btn {
            background-color: #0a967a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            text-align: center;
        }
        .btn:hover {
            background-color: #078069;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Créer un Référentiel</h1>
        <form action="/referentiels/create" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nom">Nom*</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="capacite">Capacité*</label>
                <input type="number" id="capacite" name="capacite" class="form-control" value="30" required>
            </div>
            <div class="form-group">
                <label for="sessions">Nombre de sessions*</label>
                <select id="sessions" name="sessions" class="form-control" required>
                    <option>1 session</option>
                    <option>2 sessions</option>
                    <option>3 sessions</option>
                    <option>4 sessions</option>
                </select>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo" class="form-control">
            </div>
            <button type="submit" class="btn">Créer</button>
        </form>
    </div>
</body>
</html>