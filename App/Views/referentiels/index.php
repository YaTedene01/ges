<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Référentiels de Formation</title>
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
        }

        header {
            margin-bottom: 20px;
        }

        .back-link {
            display: flex;
            align-items: center;
            color: var(--text-color);
            text-decoration: none;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .back-link svg {
            margin-right: 8px;
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 5px;
            font-size: 24px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .search {
            flex:3;
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .search-input {
            width: 75%; /* Modification ici: l'input prend 75% de la largeur */
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
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition);
            width: 23%; /* Modification ici: le bouton prend 23% de la largeur */
        }

        .btn svg {
            margin-right: 8px;
        }

        .btn:hover {
            background-color: #078069;
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

        /* Modal Styles - Using :target for no-JS modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal:target {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: var(--white);
            width: 90%;
            max-width: 500px;
            border-radius: var(--border-radius);
            padding: 20px;
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
        }

        .close-modal {
            font-size: 24px;
            color: #999;
            text-decoration: none;
            transition: var(--transition);
        }

        .close-modal:hover {
            color: #333;
        }

        .image-upload {
            border: 2px dashed var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .image-upload svg {
            fill: #999;
            margin-bottom: 8px;
        }
        .file-input {
            position: absolute;
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            z-index: -1;
        }

        .upload-label {
            display: block;
            width: 100%;
            cursor: pointer;
        }

        .image-upload-text {
            color: #999;
            font-size: 14px;
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
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-col {
            flex: 1;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-secondary {
            background-color: #f2f2f2;
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background-color: #e5e5e5;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            .search-bar {
                flex-direction: column;
            }
            
            .search-input {
                width: 100%; /* Sur mobile, l'input prend toute la largeur */
                margin-bottom: 10px;
            }
            
            .btn {
                width: 100%; /* Sur mobile, le bouton prend toute la largeur */
            }
            
            .form-row {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .grid {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <header>
            <h1>Tous les Référentiels</h1>
            <p class="subtitle">Liste complète des référentiels de formation</p>
        </header>
        <div class="search">
            <input type="text" class="search-input" placeholder="Rechercher un référentiel...">
            <a href="/referentiels/create" class="btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Créer un référentiel
            </a>
        </div>

        <div class="grid">
            <!-- Référent digital -->
            <div class="card">
                <div class="card-img">
                <img src="/assets/images/refdij.jpeg">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Référent digital</h3>
                    <p class="card-description">Couteau-suisse du numérique, le référent digital participe activement à la transformation digitale.</p>
                    <div class="card-capacity">0 apprenants</div>
                </div>
            </div>

            <!-- Développement data -->
            <div class="card">
                <div class="card-img">
                <img src="/assets/images/data.jpeg">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Développement data</h3>
                    <p class="card-description">De l'analyse du besoin à la data visualisation, en passant par la récolte et le traitement des données.</p>
                    <div class="card-capacity">0 apprenants</div>
                </div>
            </div>

            <!-- Assistanat Digital -->
            <div class="card">
                <div class="card-img">
                <img src="/assets/images/hakeuse.jpeg">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Assistanat Digital (Hackeuse)</h3>
                    <p class="card-description">La formation d'assistante digitale réservée uniquement aux femmes.</p>
                    <div class="card-capacity">0 apprenants</div>
                </div>
            </div>

            <!-- AWS & DevOps -->
            <div class="card">
                <div class="card-img">
                <img src="/assets/images/devops.jpeg">
                </div>
                <div class="card-content">
                    <h3 class="card-title">AWS & DevOps</h3>
                    <p class="card-description">De l'analyse des besoins au monitoring de l'infrastructure, en passant par le développement et le déploiement.</p>
                    <div class="card-capacity">0 apprenants</div>
                </div>
            </div>

            <!-- Développement web/mobile -->
            <div class="card">
                <div class="card-img">
                <img src="/assets/images/web.jpeg">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Développement web/mobile</h3>
                    <p class="card-description">De l'analyse du besoin à la mise en production d'applications web et mobiles.</p>
                    <div class="card-capacity">0 apprenants</div>
                </div>
            </div>

    <!-- Modal pour créer un référentiel (using :target for no-JS) -->
    <div id="create-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Créer un nouveau référentiel</h2>
                <a href="#" class="close-modal">&times;</a>
            </div>
            
            <form action="/referentiels/create" method="POST" enctype="multipart/form-data">
                <div class="image-upload">
                    <label for="photo-upload" class="upload-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        <p class="image-upload-text">Cliquez pour ajouter une photo</p>
                    </label>
                    <input type="file" id="photo-upload" name="photo" accept="image/*" class="file-input">
                </div>
                <div class="form-group">
                    <label for="nom">Nom*</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea id="description" name="description" class="form-control" required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="capacite">Capacité*</label>
                            <input type="number" id="capacite" name="capacite" class="form-control" value="30" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="sessions">Nombre de sessions*</label>
                            <select id="sessions" name="sessions" class="form-control" required>
                                <option value="1">1 session</option>
                                <option value="2">2 sessions</option>
                                <option value="3">3 sessions</option>
                                <option value="4">4 sessions</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/referentiels" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn">Créer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
