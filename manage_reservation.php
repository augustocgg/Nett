<?php
require_once("./DBConnection.php");
if(isset($_GET['table_id'])){
$qry = $conn->query("SELECT * FROM table_list where table_id = '{$_GET['table_id']}'");
    foreach($qry->fetchArray() as $k => $v){
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <dl>
        <dt class="text-info">Mesa No.<dt>
        <dd class="ps-4">#<?php echo isset($tbl_no) ? $tbl_no : "" ?><dd>
        <dt class="text-info">Identificación<dt>
        <dd class="ps-4"><?php echo isset($name) ? $name : "" ?><dd>
        <dt class="text-info">Caracteristica de Mesa<dt>
        <dd class="ps-4"><?php echo isset($description) ? $description : "" ?><dd>
    <dl>
    <hr>
    <fieldset>
        <legend class="text-info">Formulario de Reserva</legend>
    <form action="" id="reservation-form">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="table_id" value="<?php echo isset($_GET['table_id']) ? $_GET['table_id'] : "" ?>">
        <div class="form-group">
            <label for="datetime" class="control-label">Fecha de Reservación</label>
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <input type="datetime-local" name="datetime" autofocus id="datetime" required class="form-control form-control-sm rounded-0 input_fecha_valid" value="<?php echo isset($datetime) ? $datetime : '' ?>">
                </div>
                <div class="col-lg-6 col-sm-6 contet_button_reserva">
                    <button type="button" class="btn btn-sm rounded-0 btn-primary valid_reserva">Validar disponibilidad</button>
                </div>
            </div>
        </div>
        <script>
            $(function(){
                $('#reservation-form').submit(function(e){
                    e.preventDefault();
                    $('.pop_msg').remove()
                    var _this = $(this)
                    var _el = $('<div>')
                        _el.addClass('pop_msg')
                    $('#uni_modal button').attr('disabled',true)
                    $('#uni_modal button[type="submit"]').text('submitting form...')
                    $.ajax({
                        url:'./Actions.php?a=save_reservation',
                        method:'POST',
                        data:$(this).serialize(),
                        dataType:'JSON',
                        error:err=>{
                            console.log(err)
                            _el.addClass('alert alert-danger')
                            _el.text("An error occurred.")
                            _this.prepend(_el)
                            _el.show('slow')
                            $('#uni_modal button').attr('disabled',false)
                            $('#uni_modal button[type="submit"]').text('Save')
                        },
                        success:function(resp){
                            if(resp.status == 'success'){
                                _el.addClass('alert alert-success')
                                    location.reload()
                                if("<?php echo isset($reservation_id) ?>" != 1)
                                _this.get(0).reset();
                            }else{
                                _el.addClass('alert alert-danger')
                            }
                            _el.text(resp.msg)

                            _el.hide()
                            _this.prepend(_el)
                            _el.show('slow')
                            $('#uni_modal button').attr('disabled',false)
                            $('#uni_modal button[type="submit"]').text('Save')
                        }
                    })
                })
            })
        </script>
        <div class="form-group oculta_reserva">
            <label for="customer_name" class="control-label">Nombre Completo o Empresa</label>
            <input type="text" name="customer_name" autofocus id="customer_name" required class="form-control form-control-sm rounded-0" value="<?php echo isset($customer_name) ? $customer_name : '' ?>" placeholder="*">
        </div>
        <div class="form-group oculta_reserva">
            <label for="contact" class="control-label">Numero de Contacto</label>
            <input type="text" name="contact" autofocus id="contact" required class="form-control form-control-sm rounded-0" value="<?php echo isset($contact) ? $contact : '' ?>" placeholder="Requerido">
        </div>
        <div class="form-group oculta_reserva">
            <label for="email" class="control-label">Email</label>
            <input type="email" name="email" autofocus id="email" required class="form-control form-control-sm rounded-0" value="<?php echo isset($email) ? $email : '' ?>" placeholder="Requerido">
        </div>
        <div class="form-group oculta_reserva">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <label for="customer_name" class="control-label">Tipo documento</label>
                    <select id="tipo_documento" name="tipo_documento">
                        <option value="0" selected disabled>Opcional Factura Electrónica</option>
                        <option value="1">Cedula de Ciudadania</option>
                        <option value="2">Nit</option>
                        <option value="3">Cédula Extranjeria</option>
                        <option value="4">Pasaporte</option>
                        <option value="5">Nit de Otros Pais</option>
                        <option value="6">Registro Civil</option>
                        <option value="7">Tarjeta de Identidad</option>
                        <option value="8">Doc. Identificación Extranjero</option>
                        <option value="9">PEP</option>
                        <option value="10">NUIP</option>
                    </select>
                </div>
                <div class="col-lg-8 col-sm-8">
                    <label for="id_documento" class="control-label"># Documento</label>
                    <input type="text" name="id_documento" autofocus id="id_documento" required class="form-control form-control-sm rounded-0" value="<?php echo isset($customer_name) ? $customer_name : '' ?>" placeholder="Opcional Factura Electrónica">
                </div>
            </div>
        </div>        
        <div class="form-group oculta_reserva">
            <label for="address" class="control-label">Dirección</label>            
            <textarea rows="2" name="address" id="address" required class="form-control form-control-sm rounded-0" placeholder="Opcional Factura Electrónica"><?php echo isset($address)? $address : ''; ?></textarea>
        </div>        
    </form>
    </fieldset>
</div>

<script>
    $(function(){
        $('#reservation-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled',true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'./Actions.php?a=save_reservation',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                            location.reload()
                        if("<?php echo isset($reservation_id) ?>" != 1)
                        _this.get(0).reset();
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>