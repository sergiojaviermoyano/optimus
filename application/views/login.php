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
              <?php 
                $actual = strtotime(date("d-m-Y 00:00:00",time()));
                $vencimiento = strtotime($conf['vencimiento']);
              ?>
              <div class="col-xs-4">
              <?php 
                if($actual > $vencimiento){
                 $actual_ = new DateTime();
                 $vencimiento_ = new DateTime($conf['vencimiento']);
                 $dif = $actual_->diff($vencimiento_);
                 if($dif->days > 10)
                 {
                    ?>
                      <input type="hidden" id="estaHabilitado" value="0">
                      <script>
                        animacion = function(){
                          $("#noPagaste").fadeTo(500, .1)
                                          .fadeTo(500, 1);
                        }

                        setInterval(animacion, 1000);
                        </script>
                    <?php
                 } else {
                    ?>
                <input type="hidden" id="estaHabilitado" value="1">
                    <?php 
                  }
                }
              ?>
                <button type="submit" class="btn btn-primary btn-block btn-flat" id="login">Ingresar</button>
              </div><!-- /.col -->
            </div>
          </div>
          <?php 
            //$actual = strtotime(date("d-m-Y 00:00:00",time()));
            //$vencimiento = strtotime($conf['vencimiento']);
            //$dif = $actual->diff($vencimiento);
            //$intervalo = date_diff($vencimiento, $actual);
            //echo $intervalo->format('%a');
            //echo $dif->days . ' dias';
            if($actual > $vencimiento){
              echo '<br>
              <div class="row" id="noPagaste"> 
              <div class="col-xs-12">
                <div class="alert alert-danger alert-dismissable">
                    <h4><i class="icon fa fa-warning"></i> Aviso!</h4>
                    Su servicio a vencido el día '.date('d-m-Y', strtotime($conf['vencimiento'])).', pongase en contato con el administrador y así evitar la suspención del mismo.
                </div>
              </div>
            </div>';
            }
          ?>
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
      if($('#estaHabilitado').val() == 0 && $('#usrName').val() != 'admin'){
        return;
      }
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
