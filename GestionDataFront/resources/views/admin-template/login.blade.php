<html lang="en">
  <head>
    <base href="/./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>*SGD*</title>
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="/vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="/css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="/css/style.css" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->

    <link href="/css/examples.css" rel="stylesheet">
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      // Shared ID
      gtag('config', 'UA-118965717-3');
      // Bootstrap ID
      gtag('config', 'UA-118965717-5');
    </script>
  </head>
  <body>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card-group d-block d-md-flex row">
              <div class="card col-md-7 p-4 mb-0">
                <div class="card-body">
                  <h5>Inicio de Sesión</h5> 
                    <p class="text-medium-emphasis"> Sistema de Gestión de Data</p>
                    <form method="POST" action="/sgd.login">
                    <div class="form-floating mb-3">
                        <input name="cd_usuario" type="text" class="form-control" id="floatingInput" placeholder="usuario" required>
                        <label for="floatingInput">Código de Usuario</label>
                    </div>
                    <div class="form-floating">
                        <input name="tx_clave" type="password" class="form-control" id="floatingPassword" placeholder="clave" required>
                        <label for="floatingPassword">Clave</label>
                    </div>
                    <br>
                    @csrf
                    <center> <input class="btn btn-dark px-4" type="submit" value="Inicio de Sesión" ></center>
                       
                      
                    </form>
                    <hr>
                    <center>
                      <a href="/sgd.login.recuperacion"> ¿Olvidó su contraseña?</a>
                    </center>
                     
                </div>
              </div>
              <div class="card col-md-5 text-white bg-dark py-5">
                <div class="card-body text-center">
                  <div>
                    <div class="avatar avatar-xl">
                      <img class="avatar-img" src="/assets/img/avatars/3.jpg" alt="user@email.com"> 
                      <div style="margin: 10px;"></div>
                      <img class="avatar-img" src="/assets/img/avatars/2.jpg" alt="user@email.com">
                       <div style="margin: 10px;"></div>
                      <img class="avatar-img" src="/assets/img/avatars/4.jpg" alt="user@email.com">
                    </div>
                     
                    <p></p>
                    <h6>El SGD (Sistema de Gestión de Data)</h6>
                    <p>Se encarga de validar la data cruda cargada por el cliente, dando paso a ralizar procesos de emision de pólizas, envío por correo de solicitud de seguros, cuadro póliza y administrar las campañas de llamadas.</p>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="/vendors/simplebar/js/simplebar.min.js"></script>
    <script>
    </script>

  </body>
</html>