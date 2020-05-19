function facturar(id) {
    WaitingOpen('Cargando Proveedor');
    $.ajax({
        method: 'POST',
        data: {
            id: id,
            puntoDeVenta: 4000,
            tipoComprobante: 6,
            importeNeto: 121000,
            importeIVA: 0,
            importeTotal: 121000
        },
        url: 'http://localhost/afipfev1/',
        success: function(result) {
            WaitingClose();
            console.log(result);
        },
        error: function(result) {
            WaitingClose();
            alert("error");
        },
        dataType: 'json'
    });
}