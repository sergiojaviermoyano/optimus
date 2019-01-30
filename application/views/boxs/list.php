<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
        <h3 class="box-title">Cajas</h3>
          <?php
          if (strpos($permission,'Add') !== false) {
            if($list['openBox'] == 0) {?>
              <button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" data-id="0" data-action="Add" id="btnAdd" title="Nueva">Abrir</button>
              <button class="btn btn-block btn-danger" style="width: 100px; margin-top: 10px;" data-toggle="modal" id="btnAdd" title="Retiro" disabled="disabled">Retiro</button>
            <?php } else { ?>
              <button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" id="btnAdd" title="Nueva" disabled="disabled">Abrir</button>
              <button class="btn btn-block btn-danger" style="width: 100px; margin-top: 10px;" data-toggle="modal" id="btnRet" title="Retiro" >Retiro</button>
            <?php }
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="datatabl1" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">Acciones</th>
                <th>Nº Caja</th>
                <th>Apertura</th>
                <th>Cierre</th>
                <th>Usuario</th>
                <th>Retiros</th>
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



<!-- Modal -->
<div class="modal fade" id="modalBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Caja</h4>
      </div>
      <div class="modal-body" id="modalBodyBox">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalRetiro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction_"> </span> Retiros</h4>
      </div>
      <div class="modal-body" id="modalBodyRetiro">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave_">Guardar</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(function () {


    //$("#groups").DataTable();

    var _permission=$("#permission").val().split('-');
    console.log(_permission);
    $('#datatabl1').DataTable({
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
        ajax:{
            'dataType': 'json',
            'method': 'POST',
            'url':'index.php/box/datatable_listing',
            'dataSrc': function(response){
                console.log(response);
                console.log(response.data);
                var output = [];
                var permission = $("#permission").val();
                $.each(response.data,function(index,item){
                    var col1,col2,col3,col4, col5 , col6='';
                    col1='';

                    if(_permission.indexOf("Close") && item.cajaCierre==null){
                      col1 += '<i class="bt_close fa fa-fw fa-lock" style="color: #00a65a; cursor: pointer; margin-left: 15px;"  data-id="'+item.cajaId+'" data-action="Close"></i>';
                    }

                    if(item.cajaCierre!=null){
                      col1 += '<i class="bt_print fa fa-fw fa-bookmark" style="color: gray; cursor: pointer; margin-left: 15px;"  data-id="'+item.cajaId+'" ></i>';
                    }

                    if(_permission.indexOf("View")){
                      col1 += '<i class="bt_view fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;"  data-id="'+item.cajaId+'" data-action="View" ></i>';
                    }

                    col2=item.cajaId;
                    col3=(item.cajaApertura!=null)? item.apertura:'';
                    col4=(item.cajaCierre!=null)? item.cierre:'';


                    col5=item.usrNick;
                    if(item.retiro > 0)
                      col6='<td style="text-align: center"><i class="fa fa-fw fa-sign-out" style="color: #3c8dbc; cursor: pointer;" id="btnConsRet" data-id="'+item.cajaId+'"></i></td>';
                      else {
                      col6='';
                      }
                    output.push([col1,col2,col3,col4,col5 ,col6]);
                });
                return output;
            },
            error: function(error){
                console.debug(error);
            }
        }
    });



    $(document).on('click','.fa-bookmark',function(){
      
      var data = $(this).data();
      id = data.id;

      WaitingOpen('Generando Informe...');
      LoadIconAction('modalAction__','Print');
      $.ajax({
              type: 'POST',
              data: {
                      id : id
                    },
          url: 'index.php/box/printBox',
          success: function(result){
                        WaitingClose();
                        var url = "./assets/boxs/" + result;
                        $('#printDoc').attr('src', url);
                        setTimeout("$('#modalPrint').modal('show')",800);
                },
          error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalPrint');
              },
              dataType: 'json'
          });

    });





    $(document).on('click','.bt_view,.bt_close',function(){
      var data = $(this).data();
      console.log("bt_view");
      console.log(data);
      id = data.id;
      action = data.action;
      LoadIconAction('modalAction',action);
      WaitingOpen('Cargando Caja');
        $.ajax({
              type: 'POST',
              data: { id : id, act: action },
          url: 'index.php/box/getBox',
          success: function(result){
                        WaitingClose();
                        $("#modalBodyBox").html(result.html);
                        $("#cajaImpApertura").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                        $("#cajaImpRendicion").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                        setTimeout("$('#modalBox').modal('show')",800);
                },
          error: function(result){
                WaitingClose();
                alert("error");
              },
              dataType: 'json'
          });
    });

    $(document).on('click','#btnAdd',function(){
      var data = $(this).data();
      console.debug(data['id']);
      console.debug(data['action']);
      LoadBox(data['id'],data['action']);
      return false;//
    });

    function LoadBox(id_, action_){
      id = id_;
      action = action_;
      LoadIconAction('modalAction',action);
      WaitingOpen('Cargando Caja');
        $.ajax({
              type: 'POST',
              data: { id : id_, act: action },
          url: 'index.php/box/getBox',
          success: function(result){
                        WaitingClose();
                        $("#modalBodyBox").html(result.html);
                        $("#cajaImpApertura").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                        $("#cajaImpRendicion").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                        setTimeout("$('#modalBox').modal('show')",800);
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
  		$('#modalBox').modal('hide');
  		return;
  	}

  	var hayError = false;
    {
      switch (action){
        case 'Add':
          if($('#cajaImpApertura').val() == '')
          {
            hayError = true;
          }
          break;

        case 'Close':
          if($('#cajaImpRendicion').val() == '')
          {
            hayError = true;
          }
          break;

        default: hayError = true;
      }
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
                    ape: $('#cajaImpApertura').val(),
                    ven: $('#cajaImpVentas').val(),
                    cie: $('#cajaImpRendicion').val()
                  },
    		url: 'index.php/box/setBox',
    		success: function(result){
                			WaitingClose();
                			$('#modalBox').modal('hide');
                			setTimeout("cargarView('box', 'index', '"+$('#permission').val()+"');",1000);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalBox');
    				},
          	dataType: 'json'
    		});
  });

  $(document).on('click','#btnRet',function(){
    AddRetiro();
    return false;//
  });

  function AddRetiro(){
    LoadIconAction('modalAction_','Add');
    WaitingOpen('Cargando Retiro');
      $.ajax({
            type: 'POST',
            data: null,
        url: 'index.php/box/getRetiro',
        success: function(result){
                      WaitingClose();
                      $("#modalBodyRetiro").html(result.html);
                      $("#retImporte").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      setTimeout("$('#modalRetiro').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalRetiro');
            },
            dataType: 'json'
        });
  }

  $('#btnSave_').click(function(){

    var hayError = false;
    if($('#retImporte').val() == '')
    {
      hayError = true;
    }

    if($('#retDescripcion').val() == '')
    {
      hayError = true;
    }

    if(hayError == true){
      $('#error_').fadeIn('slow');
      return;
    }

    $('#error_').fadeOut('slow');
    WaitingOpen('Guardando Retiro');
      $.ajax({
            type: 'POST',
            data: {
                    imp: $('#retImporte').val(),
                    des: $('#retDescripcion').val()
                  },
        url: 'index.php/box/setRetiro',
        success: function(result){
                      WaitingClose();
                      $('#modalRetiro').modal('hide');
                      setTimeout("cargarView('box', 'index', '"+$('#permission').val()+"');",1000);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalRetiro');
            },
            dataType: 'json'
        });
  });


$(document).on('click','#btnConsRet',function(){
  var data = $(this).data();
  id = data.id;
  verEgresos(id);
  return false;//
});

function verEgresos(cajaId){
  LoadIconAction('modalAction_','Ret');
  WaitingOpen('Consultando Retiros');
      $.ajax({
            type: 'POST',
            data: {id: cajaId},
        url: 'index.php/box/getRetiros',
        success: function(result){
                      WaitingClose();
                      $("#modalBodyRetiro").html(result.html);
                      setTimeout("$('#modalRetiro').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalRetiro');
            },
            dataType: 'json'
        });
}

function printBox(cajaId){
    WaitingOpen('Generando Informe...');
    LoadIconAction('modalAction__','Print');
    $.ajax({
            type: 'POST',
            data: {
                    id : cajaId
                  },
        url: 'index.php/box/printBox',
        success: function(result){
                      WaitingClose();
                      var url = "./assets/boxs/" + result;
                      $('#printDoc').attr('src', url);
                      setTimeout("$('#modalPrint').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalPrint');
            },
            dataType: 'json'
        });
}

  });
</script>
