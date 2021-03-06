<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Ventas</h3>
          <?php
          /*
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadCust(0,\'Add\')" id="btnAdd">Agregar</button>';
          }
          */
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="sales_minoristas" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="10px;">-</th>
                <th class="text-center">Acciones</th>
                <th>Nº Orden</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th class="text-center">-</th>
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
    $('#sales_minoristas').DataTable({
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
            {className:'text-center'},
            null,
            null,
            null,
            {className:'text-center'},
        ],
        ajax:{
            'dataType': 'json',
            'method': 'POST',
            'url':'index.php/sale/datatable_minorista',
            'dataSrc': function(response){
                console.log(response);
                console.log(response.data);
                var output = [];
                var permission = $("#permission").val();
                $.each(response.data,function(index,item){
                    var col0,col1,col2,col3,col4, col5='';
                    col0='';
                    if(item.oEstado == 'CO' && item.oEstado != 'FA'){
                      if(permission.indexOf("Fac")>0 ){
                        col0 += '<small class="label bg-blue" style="cursor: pointer;" title="Facturar" onClick="facturar('+item.oId+')">AFIP</small>';
                      }
                    }
                    col1=''; 
                    if(item.oEstado == 'CO' && item.oEstado != 'FA'){
                      if(permission.indexOf("Fac")>0 ){
                        col1+='<i class="fa fa-fw fa-dollar text-green" style="cursor: pointer;" title="Facturar" onClick="Cobrar_('+item.oId+')"></i>';
                      }
                    }
                    
                   // col1+='<i class="fa fa-fw fa-print" style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" onclick="Print('+item.ocId+')"></i>';
                    col1+='<i class="fa fa-fw fa-print" style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" data-id="'+item.oId+'"></i>';
                    col2=item.oId;
                    col3=item.fecha;
                    switch(item.oEstado){
                        case 'AC':{
                            col4='<small class="label pull-left bg-green">Activa</small>';
                            break;
                        }
                        case 'IN':{
                            col4='<small class="label pull-left bg-red">Inactiva</small>';
                            break;
                        }
                        case 'FA':{
                            col4='<small class="label pull-left bg-blue">Facturado</small>';
                            break;
                        }
                        case 'CO':{
                            col4='<small class="label pull-left bg-blue">Cobrado</small>';
                            break;
                        }
                        default:{
                            col4='';
                            break;
                        }
                    }
                    //col4=item.oEstado;
                    if(item.oEstado == 'AC'){
                        col5= (item.oEsPresupuesto==1)?'<small class="label pull-left bg-orange" style="font-size:14px; margin-right:5px; cursor: pointer;" title="Cobrar" onClick="cobrar(' + item.oId + ')">P</small>':' ';
                    } else {
                        col5= (item.oEsPresupuesto==1)?'<small class="label pull-left bg-navy" style="font-size:14px; margin-right:5px;">P</small>':' ';
                    }
                    output.push([col0,col1,col2,col3,col4,col5]);
                });
                return output;
            },
            error: function(error){
                console.debug(error);
            }
        },
        "createdRow": function ( row, data, index ) {
            if(data[5].search("small")>0){
              $(row).addClass('info');
            }
        }
    });
  });

  // function cobrar(id){
  //   cargarView('sale','minoristaGet',id);
  // }
</script>
<script src="<?php  echo base_url();?>assets/js/afip.js"></script>
