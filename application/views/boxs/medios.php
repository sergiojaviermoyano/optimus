<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
        <h3 class="box-title">Medios de Pago</h3>
            <?php
            if (strpos($permission,'Add') !== false) {
                echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadMedio(0,\'Add\')" id="btnAdd">Agregar</button>';
            }
            ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tableMedios" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">Acciones</th>
                <th>Medio Pago</th>
                <th>Tipo</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
            <?php
              	foreach($list as $m)
    		        {
                        echo '<tr>';
                        echo '<td>';
                        if (strpos($permission,'Edit') !== false) {
                                echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadMedio('.$m['medId'].',\'Edit\')"></i>';
                        }
                        if (strpos($permission,'Del') !== false) {
                                echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadMedio('.$m['medId'].',\'Del\')"></i>';
                        }
                        if (strpos($permission,'View') !== false) {
                                echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadMedio('.$m['medId'].',\'View\')"></i>';
                        }
                        echo '</td>';
                        echo '<td style="text-align: left">'.$m['medDescripcion'].'</td>';
                        echo '<td style="text-align: left">'.$m['tmpDescripción'].'</td>';
                        
                        echo '<td style="text-align: center">';
                        switch($m['medEstado']){
                        case 'AC':
                            echo '<small class="label pull-left bg-green">Activo</small>';
                            break;

                        case 'IN':
                            echo '<small class="label pull-left bg-red">Inactivo</small>';
                            break;
                        }
                        echo '</td>';
                        echo '</tr>';
    		        }
              ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->



<!-- Modal -->
<div class="modal fade" id="modalMedio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Medio de Pago</h4>
      </div>
      <div class="modal-body" id="modalBodyMedio">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>


<script>
    var _permission=$("#permission").val().split('-');
  $(function () {
    

    $('#tableMedios').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "language": {
              "lengthMenu": "Ver _MENU_ filas por página",
              "zeroRecords": "No hay registros",
              "info": "Mostrando página _PAGE_ de _PAGES_",
              "infoEmpty": "No hay registros disponibles",
              "infoFiltered": "(filtrando de un total de _MAX_ registros)",
              "sSearch": "Buscar:  ",
              "oPaginate": {
                  "sNext": "Sig.",
                  "sPrevious": "Ant."
                }
          }
    });
  });

var id;
function LoadMedio(id_, action_){
    id = id_;
    action = action_;
    LoadIconAction('modalAction',action);
    WaitingOpen('Cargando Medio de Pago');
    $.ajax({
            type: 'POST',
            data: { id : id_, act: action },
            url: 'index.php/box/getMedio',
            success: function(result){
                            WaitingClose();
                            $("#modalBodyMedio").html(result.html);
                            setTimeout("$('#modalMedio').modal('show')",800);
                    },
            error: function(result){
                    WaitingClose();
                    alert("error");
                },
                dataType: 'json'
        });
}

    $('#btnSave').click(function(){

        if(action == 'View')
        {
            $('#modalMedio').modal('hide');
            return;
        }

        var hayError = false;
        if($('#medCodigo').val() == ''){
            hayError = true;
        }
        if($('#medDescripcion').val() == ''){
            hayError = true;
        }
        
        if(hayError == true){
            $('#error').fadeIn('slow');
            return;
        }

        $('#error').fadeOut('slow');
        WaitingOpen('Guardando cambios');
            $.ajax({
                type: 'POST',
                data: {
                        id : id,
                        act: action,
                        code: $('#medCodigo').val(),
                        desc: $('#medDescripcion').val(),
                        tmpI: $('#tmpId').val(),
                        esta: $('#medEstado').val()
                    },
                url: 'index.php/box/setMedio',
                success: function(result){
                                WaitingClose();
                                $('#modalMedio').modal('hide');
                                setTimeout("cargarView('box', 'medios', '"+$('#permission').val()+"');",1000);
                            },
                error: function(result){
                            WaitingClose();
                            ProcesarError(result.responseText, 'modalMedio');
                        },
                dataType: 'json'
                });
  });




//   $('#btnSave_').click(function(){

//     var hayError = false;
//     if($('#retImporte').val() == '')
//     {
//       hayError = true;
//     }

//     if($('#retDescripcion').val() == '')
//     {
//       hayError = true;
//     }

//     if(hayError == true){
//       $('#error_').fadeIn('slow');
//       return;
//     }

//     $('#error_').fadeOut('slow');
//     WaitingOpen('Guardando Retiro');
//       $.ajax({
//             type: 'POST',
//             data: {
//                     imp: $('#retImporte').val(),
//                     des: $('#retDescripcion').val()
//                   },
//         url: 'index.php/box/setRetiro',
//         success: function(result){
//                       WaitingClose();
//                       $('#modalRetiro').modal('hide');
//                       setTimeout("cargarView('box', 'index', '"+$('#permission').val()+"');",1000);
//               },
//         error: function(result){
//               WaitingClose();
//               ProcesarError(result.responseText, 'modalRetiro');
//             },
//             dataType: 'json'
//         });
//   });


//  });
</script>
