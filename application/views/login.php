<body class="login-page">
  <div class="row">
    <div class="col-xs-6">
      <!---------------->
      <div class="login-box">
        <img src="./assets/images/logo.png" >
      </div><!-- /.login-box -->
      <!---------------->
    </div>
    <div class="col-xs-6">
      <div class="login-box" style="margin-top: 200px;">
        <div class="login-logo">
          <a href="#" style="margin-top: 20px;"><?php echo Globals::getTitle();?><b><?php echo Globals::getTitle2();?></b></a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
          <p class="login-box-msg">Ingreso</p>
          <div>
            <div class="row">
              <div class="col-xs-12">
                <div class="alert alert-danger alert-dismissable" id="errorLgn" style="display: none">
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    Revise los datos de acceso ingresados
                </div>
              </div>
            </div>
            <div class="form-group has-feedback">
              <input type="email" class="form-control" placeholder="Usuario" id="usrName">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Contraseña" id="usrPassword">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-8">

              </div><!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat" id="login">Ingresar</button>
              </div><!-- /.col -->
            </div>
          </div>

        </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->
    </div>
  </div>
</body>




  <script>

  //A este script despùes llevarlo a un archivo js
  $(function(){

    $(document).keypress(function (e) {
      if(e.keyCode=='13'){ //Keycode for "Return"
        $('#login').click();
      }
    });


    $('#login').click(function(){
        var hayError = false;
        if($('#usrName').val() == '')
        {
          hayError = true;
        }

        if($('#usrPassword').val() == ''){
          hayError = true;
        }

        if(hayError == true){
          $('#errorLgn').fadeIn('slow');
          return;
        }

        $('#errorLgn').fadeOut('hide');

        WaitingOpen('Validando datos');
        $.ajax({
            type: 'POST',
            data: {
                    usr: $('#usrName').val(),
                    pas: $('#usrPassword').val()
                  },
            url: 'index.php/login/sessionStart_',
            success: function(result){
                  WaitingClose();
                  if(result == 0){
                    $('#errorLgn').fadeIn('slow');
                  }else{
                    window.location.href = 'dash';
                  }
                },
            error: function(result){
                WaitingClose();
                $('#errorLgn').fadeIn('slow');
                },
            dataType: 'json'
          });
    });

  });

  </script>
