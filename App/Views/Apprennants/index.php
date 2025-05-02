<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Apprenants - Sonatel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        
        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .title {
            font-size: 24px;
            color: #333;
        }
        
        .subtitle {
            color: #FF8C00;
            font-size: 14px;
        }
        
        /* Search and filters */
        .search-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .search-input {
            flex: 1;
            position: relative;
        }
        
        .search-input input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        
        .filter-dropdown {
            width: 200px;
        }
        
        .filter-dropdown select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            font-weight: 500;
        }
        
        .btn-primary {
            background-color: #04AA6D;
            color: white;
        }
        
        .btn-outline {
            background-color: white;
            border: 1px solid #04AA6D;
            color: #04AA6D;
        }
        
        /* Tabs */
        .tabs {
            display: flex;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }
        
        .tab.active {
            color: #FF8C00;
            border-bottom: 3px solid #FF8C00;
        }
        
        /* Table */
        .table-container {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background-color: #FF8C00;
            color: white;
            text-align: left;
            padding: 12px 15px;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        .avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-green {
            background-color: #e6f7ef;
            color: #04AA6D;
        }
        
        .status-blue {
            background-color: #e6f1f7;
            color: #0077b6;
        }
        
        .status-orange {
            background-color: #fff3e6;
            color: #ff8c00;
        }
        
        .status-red {
            background-color: #ffebee;
            color: #dc3545;
        }
        
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding: 10px 15px;
        }
        
        .pagination-info {
            color: #6c757d;
        }
        
        .pagination-controls {
            display: flex;
            gap: 5px;
        }
        
        .page-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #dee2e6;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 4px;
        }
        
        .page-btn.active {
            background-color: #FF8C00;
            color: white;
            border-color: #FF8C00;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div>
            <h1 class="title">Apprenants</h1>
            <span class="subtitle">320 apprenants</span>
        </div>
    </div>
    
    <!-- Search and Filters -->
    <div class="search-filters">
        <div class="search-input">
            <input type="text" placeholder="Rechercher...">
        </div>
        <div class="filter-dropdown">
            <select>
                <option>Filtre par classe</option>
            </select>
        </div>
        <div class="filter-dropdown">
            <select>
                <option>Filtre par statut</option>
            </select>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn btn-outline">Télécharger la liste</button>
        <!-- Bouton Ajouter Apprenant -->
        <a href="/apprenants/ajoutApprenant" class="btn btn-primary">Ajouter Apprenant</a>
    </div>
    
    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active">Liste des relevés</div>
        <div class="tab">Liste d'attente</div>
    </div>
    
    <!-- Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Matricule</th>
                    <th>Nom Complet</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Référentiel</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068216</td>
                    <td>Seydina Mouhammad Diop</td>
                    <td>Daup Liberté 6 Vila 659 Dakar, Sénégal</td>
                    <td>786959164</td>
                    <td><span class="status status-green">DEV WEB/MOBILE</span></td>
                    <td><span class="action-btn">Actif</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068216</td>
                    <td>Mamadou Diarra</td>
                    <td>Sicap Mbao Cité Dakar, Sénégal</td>
                    <td>783118455</td>
                    <td><span class="status status-blue">REF DEV</span></td>
                    <td><span class="action-btn">Actif</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068217</td>
                    <td>Fatou Lô</td>
                    <td>Daup Hamo 5, Dakar, Sénégal</td>
                    <td>784557030</td>
                    <td><span class="status status-green">DEV DATA</span></td>
                    <td><span class="action-btn">Actif</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068218</td>
                    <td>Seydina Mouhammad Diop</td>
                    <td>Daup Liberté 6 Vila 659 Dakar, Sénégal</td>
                    <td>786959164</td>
                    <td><span class="status status-orange">HORS</span></td>
                    <td><span class="action-btn">Actif</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068219</td>
                    <td>Seydina Mouhammad Diop</td>
                    <td>Daup Liberté 6 Vila 659 Dakar, Sénégal</td>
                    <td>786959164</td>
                    <td><span class="status status-green">DEV WEB/MOBILE</span></td>
                    <td><span class="action-btn">Actif</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068220</td>
                    <td>Seydina Mouhammad Diop</td>
                    <td>Daup Liberté 6 Vila 659 Dakar, Sénégal</td>
                    <td>786959164</td>
                    <td><span class="status status-green">DEV WEB/MOBILE</span></td>
                    <td><span class="action-btn">Suspendu</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068221</td>
                    <td>Seydina Mouhammad Diop</td>
                    <td>Daup Liberté 6 Vila 659 Dakar, Sénégal</td>
                    <td>786959164</td>
                    <td><span class="status status-red">IACULTURE</span></td>
                    <td><span class="action-btn">Actif</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068222</td>
                    <td>Seydina Mouhammad Diop</td>
                    <td>Daup Liberté 6 Vila 659 Dakar, Sénégal</td>
                    <td>786959164</td>
                    <td><span class="status status-blue">REF DEV</span></td>
                    <td><span class="action-btn">Actif</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068223</td>
                    <td>Seydina Mouhammad Diop</td>
                    <td>Daup Liberté 6 Vila 659 Dakar, Sénégal</td>
                    <td>786959164</td>
                    <td><span class="status status-blue">REF DEV</span></td>
                    <td><span class="action-btn">Actif</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
                <tr>
                    <td><img src="/api/placeholder/30/30" alt="Profile" class="avatar"></td>
                    <td>1068224</td>
                    <td>Ousmane Diombassy</td>
                    <td>Daup Liberté 6 Vila 659 Dakar, Sénégal</td>
                    <td>786959164</td>
                    <td><span class="status status-green">DEV WEB/MOBILE</span></td>
                    <td><span class="action-btn">Actif</span></td>
                    <td>⋮⋮⋮</td>
                </tr>
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="pagination">
            <div class="pagination-info">
                <span>1 à 10 apprenants pour 142</span>
            </div>
            <div class="pagination-controls">
                <button class="page-btn">‹</button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">...</button>
                <button class="page-btn">10</button>
                <button class="page-btn">›</button>
            </div>
        </div>
    </div>
</body>
</html>