<!-- Modal -->
<div class="modal fade" id="print_order_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Comprobante Venta Reserva </h4>
      </div>
      <div class="modal-body" >
        <iframe id="iframe_pdf" style="width:100%;min-height:600px"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_order_detail" tabindex="-1" role="dialog" aria-labelledby="modalOrderDetail">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle de Reserva</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<script>
    $(function(){
        var customer_table=$('table#sales_minoristas');
        $(document).on('click','.fa-print',function(){
            var id=$(this).data('id');

            WaitingOpen('Generando Comprobante');
            $.ajax({
                type: 'POST',
                data: { id : id, act: 'Print' },
                url: 'index.php/sale/printComprobante',
                success: function(result){
                    /*console.log(result);
                        WaitingClose();
                        $("#iframe_pdf").attr('src',result.filename_url);
                        $('#print_order_modal').modal('show');
                    */
                    WaitingClose();
                    var url = "./assets/reports/comprobantes/" + result;
                    $('#printDoc').attr('src', url);
                    setTimeout("$('#modalPrint').modal('show')",800);
                },
                error: function(result){
                    WaitingClose();
                    ProcesarError(result.responseText, 'modalRubro');
                },
                dataType: 'json'
            });

            //$("#print_order_modal").modal("show");
            return false;
        });

        $(document).on('click','.fa-sticky-note-o',function(){
            var id=$(this).data('id');
            console.debug("====> fa-search: %o <====",id);

            $.ajax({
                type: 'POST',
                data: { id : id, act: 'Print' },
                url: 'index.php/sale/detailComprobante',
                success: function(result){

                    WaitingClose();
                    $("#modal_order_detail").find('.modal-body').html(result.html);
                    $('#modal_order_detail').modal('show');
                    return false;


                   /* WaitingClose();
                    var url = "./assets/reports/orders_minorista/" + result;
                    $('#printDoc').attr('src', url);
                    setTimeout("$('#modalPrint').modal('show')",800);*/
                },
                error: function(result){
                    WaitingClose();
                    ProcesarError(result.responseText, 'modalRubro');
                },
                dataType: 'json'
            });

            //
            return false;
        });



    })
</script>
