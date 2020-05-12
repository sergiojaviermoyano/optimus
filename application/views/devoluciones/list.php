<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Devoluciones</h3>
          <?php
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadDev(0,\'Add\')" id="btnAdd">Agregar</button>';
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="devoluciones" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">Acciones</th>
                <th>Nº Devolución</th>
                <th>Orden</th>
                <th>Fecha</th>
                <th>Usuario</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->


<script>
  $(function () {
    $('#devoluciones').DataTable({
        'processing':true,
        'serverSide':true,
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
        },
        'columns':[
            {className:'text-center'},
            null,
            null,
            null,
            {className:'text-center'},
        ],
        ajax:{
            'dataType': 'json',
            'method': 'POST',
            'url':'index.php/devolucion/datatable_devolucion',
            'dataSrc': function(response){
                
                var output = [];
                var permission=$("#permission").val();
                permission= permission.split('-');
                $.each(response.data,function(index,item){
                    var col1,col2,col3,col4, col5='';
                    col1='';
                    if(permission.indexOf("View")>0){
                      col1='<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadDev('+item.devId+',\'View\')"></i>';
                    }
                    col2=item.devId;
                    col3=item.oId;
                    col4=item.fecha;
                    col5=item.usrNick;
                    output.push([col1,col2,col3,col4,col5]);
                });
                return output;
            },
            error: function(error){
                console.debug(error);
            }
        },
        "createdRow": function ( row, data, index ) {
            if(data[4].search("small")>0){
              $(row).addClass('info');
            }
        }
    });
  });

var idDevolucion = 0;
var acDevolucion = '';

function LoadDev(id_, action){
    idDevolucion = id_;
    acDevolucion = action;
    LoadIconAction('modalAction',action);
    WaitingOpen('Cargando ...');
      $.ajax({
            type: 'POST',
            data: { id : id_, act: action },
        url: 'index.php/devolucion/getDevolucion', 
        success: function(result){
                      WaitingClose();
                      $("#modalBodyDevolucion").html(result.html);
                      setTimeout("$('#modalDevolucion').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalDevolucion');
            },
            dataType: 'json'
        });
}


$('#btnSave').click(function(){
    if(acDevolucion == 'View')
    {
      $('#modalDevolucion').modal('hide');
      return;
    }

    var hayError = false;

    var table = $('#devolucionesDet > tbody> tr');
     var detalle = [];
     var error_message = "";
     var vanTodos = 1;
     table.each(function(r) {
        var descripcion   = this.children[0].textContent;
        var cantidad   = parseFloat(this.children[1].textContent);
        var devuelto   = parseFloat(this.children[2].children[0].value == '' ? 0 : this.children[2].children[0].value ); //devuelto
        var artId      = parseInt(this.children[3].textContent);
         if(devuelto > cantidad){
          this.children[2].children[0].style.backgroundColor = "#dd4b39";
          hayError = true;
         } else {
            if(devuelto > 0){
              this.children[2].children[0].style.backgroundColor = "#FFF";
              var object = {
                            artId:          artId,
                            odDevuelto:     devuelto,
                            artDescripcion: descripcion
                          };
              detalle.push(object);
            }
         }
     });

     if(hayError == true){
        error_message += " * Por Favor, seleccione la cantidad a devolver correcta para los items marcados. <br> ";
      }

     if(detalle.length <= 0){
        hayError = true;
        error_message += " * Por Favor, indique que artículos desea devolver. <br> ";
      }

      if(hayError == true){
        $("#error").find("p").html(error_message);
        $('#error').fadeIn('slow');
        setTimeout("$('#error').fadeOut('slow');",2500);
        return false;
      }

      WaitingOpen('Devolviendo...');
      $.ajax({
            type: 'POST',
            data: {
                    id    :      idOrden,
                    obs   :      $('#devObservacion').val(),
                    det   :      detalle
                  },
        url: 'index.php/devolucion/setDevolucion',
        success: function(result){
                      WaitingClose();
                      $('#modalDevolucion').modal('hide');
                      setTimeout("cargarView('devolucion', 'index', '"+$('#permission').val()+"');",1000);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalDevolucion');
            },
            dataType: 'json'
        });
});
</script>

<!-- Modal -->
<div class="modal fade" id="modalDevolucion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="dialog" style="width: 80%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Devolución de Artículo</h4> 
      </div>
      <div class="modal-body" id="modalBodyDevolucion">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Aceptar</button>
      </div>
    </div>
  </div>
</div>