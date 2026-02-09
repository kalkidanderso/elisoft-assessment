<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'NGO ERP System') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --primary: #2563EB;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --dark: #1F2937;
            --light: #F9FAFB;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
            width: 250px;
            color: white;
        }
        
        .sidebar-brand {
            padding: 20px;
            background: rgba(0,0,0,0.2);
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand h4 {
            margin: 10px 0 0 0;
            font-weight: 700;
            font-size: 18px;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu a {
            display: block;
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--warning);
        }
        
        .sidebar-menu a i {
            width: 20px;
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 0;
        }
        
        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .topbar h5 {
            margin: 0;
            color: var(--dark);
            font-weight: 600;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-info strong {
            display: block;
            color: var(--dark);
            font-size: 14px;
        }
        
        .user-info small {
            color: #6B7280;
        }
        
        .content-area {
            padding: 30px;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stats-card h3 {
            font-size: 32px;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .stats-card p {
            color: #6B7280;
            margin: 0;
            font-size: 14px;
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background: #1e40af;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .card-header {
            background: white;
            border-bottom: 2px solid var(--light);
            padding: 20px;
            font-weight: 600;
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .table {
            margin: 0;
        }
        
        .table th {
            border-top: none;
            color: #6B7280;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-hands-helping fa-2x"></i>
            <h4>NGO ERP</h4>
        </div>
        <nav class="sidebar-menu">
            <a href="<?= base_url('dashboard') ?>" class="<?= uri_string() == 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="<?= base_url('beneficiaries') ?>" class="<?= strpos(uri_string(), 'beneficiaries') !== false ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Beneficiaries
            </a>
            <a href="<?= base_url('households') ?>" class="<?= strpos(uri_string(), 'households') !== false ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Households
            </a>
            <a href="<?= base_url('projects') ?>" class="<?= strpos(uri_string(), 'projects') !== false ? 'active' : '' ?>">
                <i class="fas fa-project-diagram"></i> Projects
            </a>
            <a href="<?= base_url('monitoring') ?>" class="<?= strpos(uri_string(), 'monitoring') !== false ? 'active' : '' ?>">
                <i class="fas fa-clipboard-check"></i> Monitoring
            </a>
            <a href="<?= base_url('alerts') ?>" class="<?= strpos(uri_string(), 'alerts') !== false ? 'active' : '' ?>">
                <i class="fas fa-bell"></i> Alerts
                <?php if (isset($alertCount) && $alertCount > 0): ?>
                    <span class="badge bg-danger float-end"><?= $alertCount ?></span>
                <?php endif; ?>
            </a>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <a href="<?= base_url('auth/logout') ?>">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h5><?= esc($page_title ?? 'Dashboard') ?></h5>
            <div class="user-menu">
                <div class="user-info">
                    <strong><?= esc(session()->get('full_name')) ?></strong>
                    <small class="text-uppercase"><?= esc(session()->get('role')) ?></small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="content-area">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
