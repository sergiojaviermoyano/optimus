<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Exportar - Importar Catálogo de Artículos</h3>
          <br><br>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-fw fa-database"></i> Importante!</h4>
            Esto permitira actualizar el listado de artículos, una vez realizada la operación se perderan todos los datos anteriores correspondientes a los artículos involucrados.
          </div>

          <textarea style="width:100%;" rows="20" id="querys"><?php 
            foreach ($rubros as $r) {
              echo "INSERT INTO `rubros` (`rubId`, `rubDescripcion`, `rubEstado`) VALUES ('".$r['rubId']."','".$r['rubDescripcion']."','".$r['rubEstado']."');~~\n";
            }
            foreach ($subrubros as $s) {
              echo "INSERT INTO `subrubros` (`subrId`, `subrDescripcion`, `rubId`, `subrEstado`) VALUES ('".$s['subrId']."','".$s['subrDescripcion']."','".$s['rubId']."','".$s['subrEstado']."');~~\n";
            }
            foreach ($marcas as $m) {
              echo "INSERT INTO `marcaart` (`id`, `descripcion`) VALUES ('".$m['id']."','".$m['descripcion']."');~~\n";
            }
            foreach ($articles as $a) {
              echo "INSERT INTO `articles` (`artBarCode`,`artDescription`, `artCoste`, `artMarginMinorista`, `artMarginMinoristaIsPorcent`, `artEstado`, `artMinimo`, `ivaId`, `subrId`, `artMarginMayorista`, `artMarginMayoristaIsPorcent`, `artCosteIsDolar`, `marcaId`) VALUES ('".$a['artBarCode']."', '".$a['artDescription']."', '".$a['artCoste']."', '".$a['artMarginMinorista']."', '".$a['artMarginMinoristaIsPorcent']."', '".$a['artEstado']."', '".$a['artMinimo']."', '".$a['ivaId']."', '".$a['subrId']."', '".$a['artMarginMayorista']."', '".$a['artMarginMayoristaIsPorcent']."', '".$a['artCosteIsDolar']."', '".$a['marcaId']."' );~~\n";
            }?>
          </textarea>
          <br>
          <a class="btn btn-primary" id="btn_back">
            <i class="fa fa-fw fa-download"></i>
            Importar
          </a>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<script>

$('#btn_back').click(function(){
    
    LoadIconAction('modalResultAction','View');
    WaitingOpen('Generado Restauracion');
    var data_ajax={
                    type: 'POST',
                    url: "index.php/backup/importar",
                    data: {query: $("#querys").val()},
                    success: function( data ) {
                              WaitingClose();
                              //debugger;
                              var txt = '';
                              $.each(data.data.queryError,function(key,item){
                                txt += item +'<br><hr>';
                              });
                              $('#erroresSINC').html(txt);
                              $('#insertados').html(data.data.rowInserted + '  registros.');
                              $('#updates').html(data.data.rowUpdated + '  registros.');
                              $('#modalResult').modal('show');
                            },
                    error: function(){
                              WaitingClose();
                              //alert("Error al generar el backup.");
                            },
                    dataType: 'json'
                  };
    $.ajax(data_ajax);
});
</script>

<!-- Modal -->
<div class="modal fade" id="modalResult" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalResultAction"> </span> Resultado de Sincronización</h4>
      </div>
      <div class="modal-body" id="modalBodyResult">
        <div class="row">
          <div class="col-xs-6"><strong>Errores: </strong>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12" id="erroresSINC">

          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-xs-6"><strong>Insertados: </strong>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12" id="insertados">

          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-xs-6"><strong>Actualizados: </strong>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12" id="updates">

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>