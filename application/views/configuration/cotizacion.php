<section class="content" >
<div class="box" style="padding-left: 30px;">
  <div class="box-header">
    <h3 class="box-title"> <i class="fa fa-fw fa-dollar text-green"></i>Cotización de Moneda </h3>
  </div>
  <div class="row">
    <div class="col-xs-11">
      <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            <label id="lblError">Revise que todos los campos esten completos</label>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-11">
      <div class="alert alert-success alert-dismissable" id="success" style="display: none">
            <h4><i class="icon fa fa-check"></i> Perfecto!</h4>
            La operación se realizo con éxito!
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-2">
        <label style="margin-top: 7px;">Cotización de Dolar: </label>
      </div>
      <div class="col-xs-1">
          <label style="margin-top: 7px;" class="pull-right">u$s 1 = </label>
        </div>
    <div class="col-xs-2">
        <input type="text" class="form-control" id="cotizacion" value="<?php echo $data['cotizacion'];?>"  >
      </div>
  </div><br>

  <div class="row">
    <div class="col-xs-12">
        <button type="submit" id="btnAceptar" class="btn btn-success pull-center"> Aceptar </button>
    </div>
  </div><br>
</div>
</section>
<script>
$("#cotizacion").maskMoney({allowNegative: false, thousands:'', decimal:'.'});

$('#btnAceptar').click(function(){

    var error_message="";
    if($('#cotizacion').val() == '')
    {
      $('#error').fadeIn('slow');
      $('#lblError').html('No hay un valor asigando para la cotización');
      setTimeout("$('#error').fadeOut('slow');",2000);
      return;
    }

    WaitingOpen('Guardando cambios');
      $.ajax({
            type: 'POST',
            data: {
                    cotizacion:   $('#cotizacion').val()
                  },
        url: 'index.php/configuration/setCotizacion',
        success: function(result){
                      WaitingClose();
                      if(result == true){
                        $('#success').fadeIn('slow');
                        setTimeout("$('#success').fadeOut('slow');",2000);
                      } else {
                        $('#error').fadeIn('slow');
                        $('#lblError').html('Hubo un error al actualizar la cotización');
                        setTimeout("$('#error').fadeOut('slow');",2000);
                      }
              },
        error: function(result){
              WaitingClose();
              alert(result);
            },
            dataType: 'json'
        });
  });
</script>
