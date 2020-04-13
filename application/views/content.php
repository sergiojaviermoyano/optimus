<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="content">



</div><!-- /.content-wrapper -->

<?php //$this->load->view('buscadores/singlearticles'); ?>
<?php $this->load->view('buscadores/articlesnoprice'); ?>
<?php $this->load->view('buscadores/articlesprice'); ?>
<?php $this->load->view('buscadores/articlespricemayorista'); ?>
<?php $this->load->view('buscadores/clientes'); ?>
<?php $this->load->view('sales/print_order_modal'); ?>

<!-- Sirve para cargar la vista de cobros -->
<?php $this->load->view('boxs/cobroview'); ?>

<!-- Modal -->
<div class="modal fade" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 50%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel__"><span id="modalAction__"> </span> Comprobante</h4>
      </div>
      <div class="modal-body" id="modalBodyPrint">
        <div>
          <iframe style="width: 100%; height: 600px;" id="printDoc" src=""></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
