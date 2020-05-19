      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <li class="treeview active" onClick="activa(this)">
              <a href="#" onClick="cargarView('dash', 'accesosdirectos', '')"> <!-- onClick="cargarView('dash', 'calendar', '')"-->
                <i class="fa fa-dashboard"></i> <span>Escritorio</span>
              </a>
            </li>
            <?php

               foreach ($menu as $m) {
                 //var_dump($m);
                  if(count($m['childrens']) > 0) {
                    echo '<li class="treeview">
                            <a href="#">
                              <i class="'.$m[0]['menuIcon'].'"></i> <span>'.$m[0]['menuName'].'</span>
                              <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">';
                            foreach ($m['childrens'] as $ch) {
                              $actions = "";
                              foreach ($ch['actions'] as $a) {
                                if($a['grpactId'] != null)
                                  $actions .= $a['actDescription'] .'-';
                              }
                              echo '<li>
                                      <a href="#" onClick="cargarView(\''.$ch['menuController'].'\',\''.$ch['menuView'].'\', \''.$actions.'\')">
                                        <i class="'.$ch['menuIcon'].'"></i> '.str_replace("_", " ", $ch['menuName']).'
                                      </a>
                                    </li>';
                            }
                    echo '</ul>
                        </li>';
                  }
                  else
                  {
                    $actions = "";
                    foreach ($m['actions'] as $a) {
                      if($a['grpactId'] != null)
                        $actions .= $a['actDescription'] .'-';
                    }
                    echo '<li class="treeview" onClick="activa(this)">
                            <a href="#" onClick="cargarView(\''.$m['menuController'].'\',\''.$m['menuView'].'\', \''.$actions.'\')">
                              <i class="'.$m['menuIcon'].'"></i> <span>'.str_replace("_", " ", $m['menuName']).'</span>
                              '.MostrarIcono($m['menuCreated'], $m['menuUpdate']).'
                            </a>
                          </li>';
                  }
                }

                //Datos del usuario
                $userdata = $this->session->userdata('user_data');
                if($userdata[0]['usrEsAdmin'] == 1){
                  echo '<li class="treeview" onClick="activa(this)">
                          <a href="#" onClick="cargarView(\'configuration\',\'getConfiguration\', \'Edit\')">
                            <i class="fa fa-fw  fa-database"></i> <span>Sistema</span>
                          </a>
                        </li>';
                }

            ?>
        </ul>
      </section>
      <li class="treeview" style="position: absolute; bottom: 5px; left: 0;" title="Acerca de Optimus">
          <a href="http://indevla.com/blog/optimus-software-de-control-de-stock/" target="_blank">
            <i class="fa fa-fw"><img src="./assets/images/icono.png" width="25px"></i>
          </a>
        </li>
    </aside>
<?php 
function MostrarIcono($creado, $modificado){
  $actual_ = new DateTime();
  if($creado != null){
    $vencimiento_ = new DateTime($creado);
    $dif = $actual_->diff($vencimiento_);
    if($dif->days <= 7){
      return '<span class="pull-right-container">
            <small class="label pull-right bg-green">nuevo</small>
          </span>';
    }
  }
  if($modificado != null){
    $vencimiento_ = new DateTime($modificado);
    $dif = $actual_->diff($vencimiento_);
    if($dif->days <= 7){
      return '<span class="pull-right-container">
            <small class="label pull-right bg-orange" title="Actualizado" style="padding: 3px;"><i class="fa fa-fw fa-bell-o" ></i> </small>
          </span>';
    }
  }
  
}
?>
      <script>
      function cargarView(controller, metodh, actions)
      {
        WaitingOpen();
        $('#content').empty();

        $.ajax({
            type: 'POST',
            //data: null,
            url: '<?php echo base_url(); ?>index.php/'+controller+'/'+metodh+'/'+actions,
            success: function(result){
                          WaitingClose();
                          $("#content").empty();
                          $("#content").html(result);
                  },
            error: function(result){
                  WaitingClose();
                  ProcesarError(result.responseText, 'modalOper');
                },
                dataType: 'json'
            });
      }

      function editProfile(){
        WaitingOpen();
        $.ajax({
            type: 'POST',
            //data: null,
            url: '<?php echo base_url(); ?>index.php/user/editProfile',
            success: function(result){
                          WaitingClose();
                          $("#modalProfileBody_").html(result.html);
                          setTimeout("$('#modalProfile').modal('show')", 800);
                  },
            error: function(result){
                  WaitingClose();
                  ProcesarError(result.responseText, 'modalProfile');
                },
                dataType: 'json'
            });
      }

      function saveProfile(){

        $('#errorProfile_').fadeOut('slow');
        var hayError = false;

        if($('#usrName').val() == '')
        {
          hayError = true;
        }

        if($('#usrLastName').val() == '')
        {
          hayError = true;
        }

        if($('#usrPassword').val() != $('#usrPasswordConfirm').val()){
          hayError = true;
        }

        if(hayError == true){
          $('#errorProfile_').fadeIn('slow');
          return;
        }

        WaitingOpen('Guardando cambios');
        $.ajax({
              type: 'POST',
              data: {
                      name: $('#usrName').val(),
                      lnam: $('#usrLastName').val(),
                      pas: $('#usrPassword').val()
                    },
          url: 'index.php/user/updateUserProfile',
          success: function(result){
                        WaitingClose();
                        $('#modalProfile').modal('hide');
                },
          error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalUsr');
              },
              dataType: 'json'
          });

      };

      function activa(this_){
        $('li').removeClass('active');
        $(this_).addClass('active');
      }
      </script>

<!-- Modal -->
<div class="modal fade" id="modalProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-fw fa-pencil" style="color: #f39c12"></i> Editar Perfil</h4>
      </div>
      <div class="modal-body" id="modalProfileBody_">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnProfileSave" onclick="saveProfile()">Guardar</button>
      </div>
    </div>
  </div>
</div>
