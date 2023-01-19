<!doctype html>
<html>
<head>
    <title>YDSF</title>
    <link href="<?= base_url() ?>assets/plugins/materialdesign/css/materialdesignicons.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/materialize.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/logo.png" type="image/png">
        <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    main {
      flex: 1 0 auto;
    }

    body {
      background: #fff;
    }

    .input-field input[type=date]:focus + label,
    .input-field input[type=text]:focus + label,
    .input-field input[type=email]:focus + label,
    .input-field input[type=password]:focus + label {
      color: #26a69a;
    }

    .input-field input[type=date]:focus,
    .input-field input[type=text]:focus,
    .input-field input[type=email]:focus,
    .input-field input[type=password]:focus {
      border-bottom: 2px solid #26a69a;
      box-shadow: none;
    }
  </style>
</head>

<body style="background: repeating-linear-gradient(
  45deg,
  #606dbc,
  #606dbc 10px,
  #465298 10px,
  #465298 20px
);">
  <div class="section"></div>
  <main>
    <center>

      <div class="container">
        <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

      <img class="responsive-img" style="width: 250px;" src="<?= base_url() ?>/assets/images/logo.png" />
          <form class="col s12" method="post" action="">
            <div class='row'>
              <div class='col s12'>
                  <?= ($this->session->flashdata('error') != null) ? '<div class="alert alert-danger text-center">' . $this->session->flashdata('error') . '</div>' : ''; ?>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='text' name='username' id='username' />
                <label for='username'>Username</label>
                <?php if(form_error('username')) echo '<small class="help-block text-danger"><p>'. form_error('username').'</p></small>'?>
                
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='password' name='password' id='password' />
                <label for='password'>Password</label>
                <?php if(form_error('password')) echo '<small class="help-block text-danger"><p>'. form_error('username').'</p></small>'?>
                
              </div>
              <!--label style='float: right;'>
                        <a class='pink-text' href='#!'><b>Forgot Password?</b></a>
                </label-->
            </div>

            <br />
            <center>
              <div class='row'>
                <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect indigo'>Login</button>
              </div>
            </center>
          </form>
        
        </div>
      </div>
      <!--a href="#!">Create account</a-->
    </center>

    <div class="section"></div>
    <div class="section"></div>
  </main>

  
            <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
            <script src="<?= base_url() ?>assets/js/materialize.js"></script>
</body>

</html>