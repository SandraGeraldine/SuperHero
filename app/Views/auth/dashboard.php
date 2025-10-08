<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SuperHero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .welcome-card h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
            float: left;
            margin-right: 20px;
        }
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            height: 100%;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
            display: block;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            color: #667eea;
        }
        .menu-icon {
            font-size: 40px;
            margin-bottom: 15px;
            color: #667eea;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
                <i class="fas fa-mask"></i> SuperHero
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('dashboard') ?>">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('profile') ?>">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('logout') ?>">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <!-- Bienvenida-->
        <div class="welcome-card">
            <?php
            $fotoPerfil = base_url('assets/img/default-avatar.svg');
            if (session()->get('foto_perfil') && file_exists(FCPATH . 'uploads/perfiles/' . session()->get('foto_perfil'))) {
                $fotoPerfil = base_url('uploads/perfiles/' . session()->get('foto_perfil'));
            }
            ?>
            <img src="<?= $fotoPerfil ?>" alt="Avatar" class="user-avatar">
            <div>
                <h1>¡Bienvenido, <?= esc(session()->get('nombre')) ?>!</h1>
                <p class="mb-0"><i class="fas fa-envelope"></i> <?= esc(session()->get('email')) ?></p>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- PARTE DE LA PRESENTACION -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stats-card text-center">
                    <div class="stats-icon" style="color: #667eea;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Usuarios</h3>
                    <p class="text-muted">Sistema de autenticación activo</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card text-center">
                    <div class="stats-icon" style="color: #f093fb;">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <h3>Reportes</h3>
                    <p class="text-muted">Genera reportes personalizados</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card text-center">
                    <div class="stats-icon" style="color: #4facfe;">
                        <i class="fas fa-mask"></i>
                    </div>
                    <h3>Superhéroes</h3>
                    <p class="text-muted">Base de datos completa</p>
                </div>
            </div>
        </div>

        <!-- Menu  -->
        <h3 class="mb-4">Accesos Rápidos</h3>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <a href="<?= base_url('reportes/reporte6') ?>" class="menu-card">
                    <div class="text-center">
                        <div class="menu-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <h5>Reporte 6</h5>
                        <p class="text-muted mb-0">Reporte personalizado de superhéroes</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="<?= base_url('reportes/reporte7') ?>" class="menu-card">
                    <div class="text-center">
                        <div class="menu-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h5>Reporte 7</h5>
                        <p class="text-muted mb-0">Gráficos y estadísticas</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="<?= base_url('reportes/reporte8') ?>" class="menu-card">
                    <div class="text-center">
                        <div class="menu-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5>Reporte 8</h5>
                        <p class="text-muted mb-0">Análisis avanzado</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="<?= base_url('profile') ?>" class="menu-card">
                    <div class="text-center">
                        <div class="menu-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h5>Mi Perfil</h5>
                        <p class="text-muted mb-0">Edita tu información personal</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="<?= base_url('reportes/reporte2') ?>" class="menu-card">
                    <div class="text-center">
                        <div class="menu-icon">
                            <i class="fas fa-table"></i>
                        </div>
                        <h5>Reporte 2</h5>
                        <p class="text-muted mb-0">Listado de superhéroes</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="<?= base_url('reportes/reporte3') ?>" class="menu-card">
                    <div class="text-center">
                        <div class="menu-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <h5>Reporte 3</h5>
                        <p class="text-muted mb-0">Catálogo completo</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
