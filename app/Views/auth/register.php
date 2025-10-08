<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - SuperHero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }
        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: flex;
            margin: 20px;
        }
        .register-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 40px;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .register-left i {
            font-size: 80px;
            margin-bottom: 20px;
        }
        .register-left h2 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .register-right {
            padding: 60px 50px;
            flex: 1.5;
        }
        .register-right h3 {
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .register-right p {
            color: #666;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            color: white;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px 0 0 10px;
        }
        .form-control {
            border-radius: 0 10px 10px 0;
        }
        @media (max-width: 768px) {
            .register-left {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-left">
            <i class="fas fa-user-plus"></i>
            <h2>Únete a SuperHero</h2>
            <p>Crea tu cuenta y accede a todas las funcionalidades del sistema</p>
        </div>
        <div class="register-right">
            <h3>Crear Cuenta</h3>
            <p>Completa el formulario para registrarte</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="nombre" 
                                   placeholder="Tu nombre" 
                                   value="<?= old('nombre') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="apellido" 
                                   placeholder="Tu apellido" 
                                   value="<?= old('apellido') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre de Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                        <input type="text" class="form-control" name="username" 
                               placeholder="Elige un nombre de usuario" 
                               value="<?= old('username') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" name="email" 
                               placeholder="tu@email.com" 
                               value="<?= old('email') ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" 
                                   placeholder="Mínimo 6 caracteres" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password_confirm" 
                                   placeholder="Repite la contraseña" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">
                        Acepto los términos y condiciones
                    </label>
                </div>

                <button type="submit" class="btn btn-register">
                    <i class="fas fa-user-plus"></i> Crear Cuenta
                </button>

                <div class="text-center mt-4">
                    <p class="mb-0">¿Ya tienes cuenta? <a href="<?= base_url('login') ?>" style="color: #667eea; font-weight: bold;">Inicia sesión aquí</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
