<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    
    <?php include '../controlador/link.php'; ?>
</head>

<body>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="../imagenes/img.jpeg" alt="Logo">
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <div class="form-group">
                                <h1 class="text-center">Bienvenidos a "Empresa"</h1>
                            </div>

                            <form action="../vista/tipo_comprobante.php">
                                <h2>Inicia sesión</h2>
                                <div class="form-group">
                                    <label>Nombre del usuario <span class="login-danger">*</span></label>
                                    <input class="form-control" type="text">
                                    <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                </div>
                                <div class="form-group">
                                    <label>Contraseña <span class="login-danger">*</span></label>
                                    <input class="form-control pass-input" type="text">
                                    <span class="profile-views feather-eye toggle-password"></span>
                                </div>
                                <div class="forgotpass">
                                    <div class="remember-me">
                                        <label class="custom_check mr-2 mb-0 d-inline-flex remember-me"> Recuérdame
                                            <input type="checkbox" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <a href="forgot-password.html">¿Olvidó su contraseña?</a>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Iniciar sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../controlador/scrips.php'; ?>

</body>

</html>