@extends('templates.app')
@section('content')
        <div class="jumbotron">
            <h1 class="display-3">Ajax</h1>
            <p class="lead">Ejemplo de envio de datos con ajax</p>
            <hr class="my-4">
        </div>

        <div class="row">
            <div class="col-md-6 float-left">
                <h3>Envíar datos con un botón</h3>
                <p>
                    Al dar click al botón, se generará un numero aleatorio que se enviará por el ajax request y la fucion del controller regresara el mensaje de la mascota que se ha elegido
                </p>
                <button type="button" class="btn btn-primary" id="pet">Elige una mascota al azar</button>

            </div>

            <div class="col-md-6 form-group float-left">
                <h3>Envíar datos con un select</h3>
                <p>
                    Al seleccionar una opcion del select, se enviará el numero correspondiente a la mascota elegida y la fucion del controller regresara el mensaje de la mascota que se ha elegido
                </p>
                <select class="custom-select" id="selectPet">
                    <option selected="">Selecciona una mascota</option>
                    <option value="0">Perro</option>
                    <option value="1">Gato</option>
                    <option value="2">Hamster</option>
                </select>
            </div>
        </div>

        <div class="mb-4"></div>
        <div class="row">
            <div class="col-md-6">

                <h3>Mostrar respuesta en elemento html</h3>
                <p>
                    Al seleccionar una opcion del select, se enviará el numero correspondiente a la mascota elegida y la fucion del controller regresara el mensaje de la mascota que se ha elegido para mostrarse en la tarjeta de abajo
                </p>
                <select class="custom-select" id="insertPet">
                    <option selected="">Selecciona una mascota</option>
                    <option value="0">Perro</option>
                    <option value="1">Gato</option>
                    <option value="2">Hamster</option>
                </select>

                <div class="mb-4"></div>
                <div class="card border-primary mb-3" style="max-width: 20rem;">

                    <div class="card-body">
                        <h4 class="card-title">Mascota</h4>
                        <p class="card-text" id="petText">Aquí aparecera la mascota que elegiste.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <h3>Enviar contenido de input y operar en controller</h3>
                <p>
                    Operación de suma básica. Se ingresan dos números en los inputs de abajo y al dar click en el botón azul, se envia la solicitud a una función del controlador para realizar la suma y regresar la respuesta que se mostrara en la tarjeta de abajo.
                </p>

                <div class="form-group">
                    <input type="number" class="form-control" id="num1">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="num2">
                </div>

                <button type="button" class="btn btn-primary" id="addition">Sumar</button>
                <div class="mb-4"></div>
                <div class="card border-primary mb-3" style="max-width: 20rem;">
                    <div class="card-body">
                        <h4 class="card-title">Resultado</h4>
                        <p class="card-text" id="additionRes"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4"></div>
        <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
            <div class="card-header">Extra</div>
            <div class="card-body">
                <h4 class="card-title">Retos</h4>
                <p class="card-text">Crear una única funcion que permita realizar cualquier petición ajax.</p>
            </div>
        </div>

        <script type="text/javascript">
            // Agregar el csrf token en los headers de la peticion
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            ////// Envíar datos con un botón
            // Selector de JQuery
            // Selecciona el elemento con el id "pet"
            // La funcion de ejecuta con el evento "click"
            $("#pet").click(function(event){
                //Generar un número aleatorio
                var pet = Math.floor(Math.random() * 2);
                // Llamada al a funcion que hace la peticion de ajax
                choosePet(pet);
            });
            ////// Envíar datos con un select
            $("#selectPet").change(function(event){
                // Obtener el valor del select
                var pet = $("#selectPet").val();
                choosePet(pet);
            });
            // Funcion que realiza la peticion Ajax
            function choosePet(pet) {
                // Ajax request con Jquery
                $.ajax({
                    // url a la que se hará la petición
                    url:'ajax-request',
                    // datos en formato json
                    data:{'pet':pet},
                    // tipo de request, en este caso "post"
                    type:'post',
                    // Funcion ejecutada en caso de exito
                    success: function (response) {
                        alert(response);
                    },
                    statusCode: {
                        // Muestra una alerta de acuerdo al error especificado
                        404: function() {
                            alert('web not found');
                        }
                    },
                    // Funcion ejecutada en caso de error
                    error:function(x,xs,xt){
                        // Muestra una alerta con el mensaje de error si es que hay alguno
                        alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
                    }
                });
            }
            ////// Mostrar respuesta en elemento html
            $("#insertPet").change(function(event){
                // Obtener el valor del select
                var pet = $("#insertPet").val();
                $.ajax({
                    url:'ajax-request',
                    data:{'pet':pet},
                    type:'post',
                    success: function (response) {
                        $( "#petText" ).text( response );
                    },
                    statusCode: {
                        // Muestra una alerta de acuerdo al error especificado
                        404: function() {
                            alert('web not found');
                        }
                    },
                    error:function(x,xs,xt){
                        // Muestra una alerta con el mensaje de error si es que hay alguno
                        alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
                    }
                });
            });
            ////// Enviar contenido de input y operar en controller
            $("#addition").click(function(event){
                // Obtener el valor del select
                var num1 = $("#num1").val();
                var num2 = $("#num2").val();
                $.ajax({
                    url:'addition',
                    data:{'num1':num1,'num2':num2},
                    type:'post',
                    success: function (response) {
                        $( "#additionRes" ).text( response );
                    },
                    statusCode: {
                        // Muestra una alerta de acuerdo al error especificado
                        404: function() {
                            alert('web not found');
                        }
                    },
                    error:function(x,xs,xt){
                        // Muestra una alerta con el mensaje de error si es que hay alguno
                        alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
                    }
                });
            });
        </script>
@endsection