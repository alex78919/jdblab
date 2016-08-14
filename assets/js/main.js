
var urlBase = "http://localhost/jdblab/index.php/";
$(document).ready(function () {

    var localizacion = window.location.href;
    console.log(localizacion);

    if (localizacion == urlBase + "ControladorCliente/cargarFormulario")
        formularioCliente();
    else if (localizacion == urlBase + "ControladorCliente/validarFormulario")
        formularioCliente();
    else if (localizacion == urlBase + "ControladorCliente/mostrar")
        buscandoClientes();
    else if (localizacion.substring(0, urlBase.length + 45) ==
            urlBase + "ControladorProforma/cargarVistaNuevaProforma/")
        manejoProformas();
    else if (localizacion == urlBase + "ControladorCategoria/formSubdivisiones")
        categorias();
    else if (localizacion == urlBase + "ControladorCliente/formBusquedaSegmentadaClientes")
        busquedaAvanzada();
    else if (localizacion == urlBase + "ControladorCliente/mostrarBusquedaSegmentada")
        busquedaAvanzada();
    else if (localizacion.substring(0, urlBase.length + 38) ==
            urlBase + "ControladorProveedor/detallesProveedor")
        manejoProveedores();



});

var proformas = {
    inputsCantidad: new Array(),
    objProductos: new Array(),
    datosEnvio: new Array(),
    cantTemp: 0,
    $cantidadTotal: null,
    tablaProforma: null,
    itemsProductosCheck: null,
    eventos: function () {
        document.getElementById("enviar_proforma").onclick = function () {
            proformas.enviarProforma();
        }
    },
    existeProducto: function (idProducto) {
        var i = 0;
        var encontrado = false;
        while (i < this.objProductos.length && encontrado == false) {
            if (this.objProductos[i].id == idProducto) {
                encontrado = true;
            }
            i++;
        }
        return encontrado;
    },
    iniciar: function () {
        $("#agregar_items_proforma").click(function () {
            proformas.setItemsProductoCheck($("#proforma-productos input:checkbox"));
            dialogProforma.dialog("open");
            busquedaProductos.buscar($("#input-productos").val(),
                    $("#input-categoria").val());
            //proformas.verificarItemsCheck();
        });
        proformas.setTablaProforma($("#central table"));
        proformas.setItemsProductoCheck($("#proforma-productos input:checkbox"));
        this.eventos();

        this.$cantidadTotal = $("<h3>0</h3>");
        $total = $("<h3>Total: </h3>")
        $total.css("float", "left");
        this.$cantidadTotal.css("float", "left");
        $("#total-importe").append($total);
        $("#total-importe").append(this.$cantidadTotal);
    },
    setTablaProforma: function ($objetoTabla) {
        this.tablaProforma = $objetoTabla;
    },
    setItemsProductoCheck: function ($objetosCheckbox) {
        this.itemsProductosCheck = $objetosCheckbox;
    },
    addItemsProforma: function () {
        this.setItemsProductoCheck($("#proforma-productos input:checkbox"));


        var itemsSelecctionados = new Array();
        this.itemsProductosCheck.each(function () {
            if ($(this).prop("checked")) {
                if (proformas.objProductos.length == 0) {
                    itemsSelecctionados.push($(this).val());
                    this.setAttribute("disabled", 1);
                } else if (proformas.existeProducto(this.value) == false) {
                    itemsSelecctionados.push($(this).val());
                    this.setAttribute("disabled", 1);
                }
            }
        });

        this.getProductos(itemsSelecctionados);

    },
    verificarItemsCheck: function () {
        for (var i = 0; i < this.objProductos.length; i++) {
            if (i == 0 && this.itemsProductosCheck.first().val() ==
                    this.objProductos[i].id) {
                this.itemsProductosCheck.first().prop("checked", true);
            } else if (this.itemsProductosCheck.first().val() ==
                    this.objProductos[i].id) {
                this.itemsProductosCheck.next().prop("checked", true);
            }
            console.log("iteracion numero " + i);
        }

    },
    getProductos: function (idProductos) {
        var url = urlBase + "ControladorProducto/recibirPostAjax";
        var datos = "opcion=getProductos&productos=" + JSON.stringify(idProductos);
        var ajaxProducto = new Ajax(url, modificarTabla, datos);
        ajaxProducto.setMetodoEnvio("POST");
        ajaxProducto.enviarPeticion();


        var objetosProductos;
        function modificarTabla() {
            objetosProductos = jQuery.parseJSON(this.peticionHttp.responseText);

            var totales = 0;
            var vacio = proformas.objProductos.length == 0 ? true : false;

            for (var i = 0; i < objetosProductos.length; i++) {
                var filaTabla = $("<tr></tr>");
                var celdaCodigo = $("<td></td>");
                var celdaProducto = $("<td></td>");
                var celdaCantidad = $("<td></td>");
                var celdaPrecioUnitario = $("<td></td>");
                var celdaPrecioTotal = $("<td></td>");
                var celdaEliminar = $("<td></td>");

                celdaCodigo.append(objetosProductos[i].codigo.toUpperCase());
                celdaProducto.append(objetosProductos[i].nombre);

                var inputCantidad = document.createElement("input");
                inputCantidad.setAttribute("type", "text");
                inputCantidad.setAttribute("size", "5");
                inputCantidad.setAttribute("value", "1");
                inputCantidad.setAttribute("size", "5");

                $(inputCantidad).data({pos: proformas.objProductos.length});
                $(inputCantidad).focus(function () {
                    proformas.cantTemp = parseInt(this.value);
                });
                $(inputCantidad).blur(function () {
                    var cantidad = parseInt(this.value);

                    if (isNaN(cantidad)) {
                        cantidad = 1;
                    } else if (cantidad == 0) {
                        cantidad = 1;
                    } else {
                        cantidad = Math.abs(cantidad);
                    }
                    this.value = cantidad;
                    var index = $(this).data().pos + 1;
                    var precioUnitario = parseInt(proformas.
                            inputsCantidad[index - 1].precioUnitario.val());
                    var precioTotal = precioUnitario * cantidad;
                    var $celdaSet = proformas.tablaProforma.
                            find("tbody tr:eq(" + index + ") td:eq(4)");
                    $celdaSet.text(precioTotal);

                    var totalTemporal = parseInt(proformas.$cantidadTotal.text());
                    totalTemporal -= proformas.datosEnvio[index - 1].
                            cantidad * proformas.datosEnvio[index - 1].precio;
                    console.log("total temporal: " + totalTemporal);
                    totalTemporal += precioTotal;
                    proformas.$cantidadTotal.text(totalTemporal);

                    proformas.setCantidad($(this).data().pos, cantidad);
                });
                celdaCantidad.append(inputCantidad);

                var inputPrecioUnitario = document.createElement("input");
                inputPrecioUnitario.setAttribute("type", "text");
                inputPrecioUnitario.setAttribute("size", "5");
                inputPrecioUnitario.setAttribute("value", objetosProductos[i].precio);
                $(inputPrecioUnitario).data({pos: proformas.objProductos.length});

                inputPrecioUnitario.onblur = function () {
                    var precio = parseInt(this.value);

                    if (isNaN(precio)) {
                        precio = parseInt(proformas.objProductos[$(this).data().pos].precio);
                    } else {
                        precio = Math.abs(precio);
                    }
                    this.value = precio;

                    var index = $(this).data().pos + 1;
                    var cantidad = parseInt(proformas.
                            inputsCantidad[index - 1].cantidad.val());
                    var precioTotal = precio * cantidad;
                    var $celdaSet = proformas.tablaProforma.
                            find("tbody tr:eq(" + index + ") td:eq(4)");
                    $celdaSet.text(precioTotal);

                    var totalTemporal = parseInt(proformas.$cantidadTotal.text());
                    totalTemporal -= proformas.datosEnvio[index - 1].
                            cantidad * proformas.datosEnvio[index - 1].precio;
                    console.log("total temporal: " + totalTemporal);
                    totalTemporal += precioTotal;
                    proformas.$cantidadTotal.text(totalTemporal);

                    proformas.setPrecio(index - 1, precio);
                };
                celdaPrecioUnitario.append(inputPrecioUnitario);

                celdaPrecioTotal.append(objetosProductos[i].precio);

                var opcionEliminar = document.createElement("a");
                opcionEliminar.setAttribute("href", "#");
                opcionEliminar.appendChild(document.createTextNode("X"));
                $(opcionEliminar).data({pos: proformas.objProductos.length});
                $(opcionEliminar).click(function () {
                    proformas.eliminarFila($(this).data().pos);
                    $(this).parent().parent().remove();
                });
                celdaEliminar.append(opcionEliminar);

                proformas.inputsCantidad.push({
                    cantidad: $(inputCantidad),
                    precioUnitario: $(inputPrecioUnitario),
                    indexEliminar: $(opcionEliminar)
                }
                );

                filaTabla.append(celdaCodigo);
                filaTabla.append(celdaProducto);
                filaTabla.append(celdaCantidad);
                filaTabla.append(celdaPrecioUnitario);
                filaTabla.append(celdaPrecioTotal);
                filaTabla.append(celdaEliminar);

                totales += parseInt(objetosProductos[i].precio);

                proformas.tablaProforma.append(filaTabla);
                proformas.objProductos.push(objetosProductos[i]);
                var idProductos = {
                    id: objetosProductos[i].id,
                    cantidad: 1,
                    precio: parseInt(objetosProductos[i].precio)
                };
                proformas.datosEnvio.push(idProductos);
            }
            var total = parseInt(proformas.$cantidadTotal.text());
            total += totales;
            proformas.$cantidadTotal.text(total);
        }
    },
    setCantidad: function (index, cantidad) {
        this.datosEnvio[index].cantidad = cantidad;
    },
    setPrecio: function (index, precio) {
        this.datosEnvio[index].precio = precio;
    },
    enviarProforma: function () {
        console.log("intentando enviar");
        if (this.objProductos.length > 0) {
            var json = JSON.stringify(this.datosEnvio);
            var proforma = document.getElementById("datos_proforma");
            proforma.setAttribute("value", json);
            document.getElementById("proforma_productos").submit();
        }

    },
    eliminarFila: function (index) {
        var restarTotal = parseInt(this.inputsCantidad[index].cantidad.val()) *
                parseInt(this.inputsCantidad[index].precioUnitario.val());
        var saldo = parseInt(this.$cantidadTotal.text()) - restarTotal;
        this.$cantidadTotal.text(saldo);
        console.log(restarTotal);
        console.log(this.inputsCantidad[index].cantidad.val());
        console.log(this.inputsCantidad[index].precioUnitario.val());

        this.inputsCantidad.splice(index, 1);
        this.datosEnvio.splice(index, 1);
        this.objProductos.splice(index, 1);
        for (var i = 0; i < this.inputsCantidad.length; i++) {
            this.inputsCantidad[i].cantidad.data().pos = i;
            this.inputsCantidad[i].precioUnitario.data().pos = i;
            this.inputsCantidad[i].indexEliminar.data().pos = i;
        }
        console.log(this.inputsCantidad.length);
        console.log(this.datosEnvio.length);
        console.log(this.objProductos.length);
    }
};

var busquedaProductos = {
    iniciar: function () {
        var categoria = document.getElementById("input-categoria");
        var $entradaTexto = $("#input-productos");
        $entradaTexto.keyup(function () {
            busquedaProductos.buscar(this.value, categoria.value);
        });
        $(categoria).change(function () {
            busquedaProductos.buscar($entradaTexto.val(), categoria.value);
        });

    },
    buscar: function (textoBusqueda, categoria) {
        var url = urlBase + "ControladorProducto/recibirPostAjax";
        var datos = "opcion=buscar&filtroBusqueda=" + textoBusqueda +
                "&categoria=" + categoria;
        var ajax = new Ajax(url, getDatos, datos);
        ajax.setMetodoEnvio("POST");
        ajax.enviarPeticion();

        function getDatos() {
            console.log(this.peticionHttp.responseText);
            var objetosProductos = jQuery.parseJSON(this.peticionHttp.responseText);
            var $tabla = $("#proforma-productos table");
            var $cabeceraTabla = $tabla.find("tbody tr:eq(0)").clone();
            $tabla.empty();
            $tabla.append($cabeceraTabla);

            for (var i = 0; i < objetosProductos.length; i++) {
                var $fila = $("<tr></tr>");

                var $celdaCheck = $("<td></td>");
                var $celdaCodigo = $("<td></td>");
                var $celdaProducto = $("<td></td>");
                var $celdaPrecio = $("<td></td>");

                var inputCheck = document.createElement("input");
                inputCheck.setAttribute("type", "checkbox");
                inputCheck.setAttribute("value", objetosProductos[i].ID_PRODUCTO);
                $celdaCheck.append(inputCheck);
                $celdaCodigo.append(objetosProductos[i].CODIGO_PRODUCTO);
                $celdaProducto.append(objetosProductos[i].NOMBRE_PRODUCTO);
                $celdaPrecio.append(objetosProductos[i].PRECIO_PRODUCTO);

                $fila.append($celdaCheck);
                $fila.append($celdaCodigo);
                $fila.append($celdaProducto);
                $fila.append($celdaPrecio);

                $tabla.append($fila);

                if (proformas.existeProducto(objetosProductos[i].ID_PRODUCTO)) {
                    inputCheck.setAttribute("disabled", 1);
                    inputCheck.setAttribute("checked", 1);
                }
            }
        }
    }
};

function formularioCliente() {
    console.log("trabajando para el formulario");
    dialog = $("#ciudad").dialog({
        autoOpen: false,
        height: 300,
        width: 400,
        modal: true,
        buttons: [
            {
                text: "Agregar",
                click: function () {
                    var valor = $('input:text[name=inp_ciudad_cliente]').val();
                    var url = urlBase + "ControladorPrincipal/recibirPostAjax";
                    var datos = "opcion=insertarCiudad&ciudad=" + valor;
                    var ajax = new Ajax(url, respCiudad, datos);
                    ajax.setMetodoEnvio("POST");


                    if (valor == null || valor.length == 0 || /^\s+$/.test(valor)) {
                        alert("Escriba un texto no vacio");
                    } else {
                        ajax.enviarPeticion();
                    }
                }
            }
        ]
    });

    $("#ciudades").change(function () {
        if ($(this).val() == "-1") {
            dialog.dialog("open");
        }
    });

    function respCiudad() {
        console.log("llega aqui");
        console.log(this.peticionHttp.responseText);
        if (this.peticionHttp.responseText != 0) {
            var ciudades = $("#ciudades");
            var objCiudades = jQuery.parseJSON(this.peticionHttp.responseText);
            ciudades.empty();
            for (var i = 0; i < objCiudades.length; i++) {
                var option = document.createElement("option");
                option.appendChild(document.
                        createTextNode(objCiudades[i].NOMBRE_CIUDAD));
                option.setAttribute("value", objCiudades[i].ID_CIUDAD);
                ciudades.append(option);
            }
            option = document.createElement("option");
            option.appendChild(document.
                    createTextNode("Agregar otra ciudad"));
            option.setAttribute("value", "-1");
            ciudades.append(option);
            console.log("algo anda mal");
            dialog.dialog("close");
        } else {
            alert("Ya existe la ciudad en la base de datos");
        }
    }

    dialogCargo = $("#cargo").dialog({
        autoOpen: false,
        height: 300,
        width: 400,
        modal: true,
        buttons: [
            {
                text: "Agregar",
                click: function () {
                    var valor = $('input:text[name=inp_cargo_cliente]').val();
                    var url = urlBase + "ControladorPrincipal/recibirPostAjax";
                    var datos = "opcion=insertarCargo&cargo=" + valor;
                    var ajax = new Ajax(url, respCargo, datos);
                    ajax.setMetodoEnvio("POST");


                    if (valor == null || valor.length == 0 || /^\s+$/.test(valor)) {
                        alert("Escriba un texto no vacio");
                    } else {
                        ajax.enviarPeticion();
                    }
                }
            }
        ]
    });

    $("#cargos").change(function () {
        if ($(this).val() == "-1") {
            dialogCargo.dialog("open");
        }
    });

    function respCargo() {
        if (this.peticionHttp.responseText != 0) {
            var cargos = $("#cargos");
            var objCargos = jQuery.parseJSON(this.peticionHttp.responseText);
            cargos.empty();
            for (var i = 0; i < objCargos.length; i++) {
                var option = document.createElement("option");
                option.appendChild(document.
                        createTextNode(objCargos[i].NOMBRE_CARGO));
                option.setAttribute("value", objCargos[i].ID_CARGO);
                cargos.append(option);
            }
            option = document.createElement("option");
            option.appendChild(document.
                    createTextNode("Agregar otro cargo"));
            option.setAttribute("value", "-1");
            cargos.append(option);

            dialogCargo.dialog("close");
        } else {
            alert("Ya existe el cargo!!!");
        }
    }

    dialogProfesion = $("#profesion").dialog({
        autoOpen: false,
        height: 300,
        width: 400,
        modal: true,
        buttons: [
            {
                text: "Agregar",
                click: function () {
                    var valor = $('input:text[name=inp_profesion_cliente]').val();
                    var url = urlBase + "ControladorPrincipal/recibirPostAjax";
                    var datos = "opcion=insertarProfesion&profesion=" + valor;
                    var ajax = new Ajax(url, respProfesion, datos);
                    ajax.setMetodoEnvio("POST");
                    console.log(valor);

                    if (valor == null || valor.length == 0 || /^\s+$/.test(valor)) {
                        alert("Escriba un texto no vacio");
                    } else {
                        ajax.enviarPeticion();
                    }
                }
            }
        ]
    });

    $("#profesiones").change(function () {
        if ($(this).val() == "-1") {
            dialogProfesion.dialog("open");
        }
    });

    function respProfesion() {
        console.log(this.peticionHttp.responseText);
        if (this.peticionHttp.responseText != 0) {
            var profesiones = $("#profesiones");
            var objProfesiones = jQuery.parseJSON(this.peticionHttp.responseText);
            profesiones.empty();
            for (var i = 0; i < objProfesiones.length; i++) {
                var option = document.createElement("option");
                option.appendChild(document.
                        createTextNode(objProfesiones[i].NOMBRE_PROFESION));
                option.setAttribute("value", objProfesiones[i].ID_PROFESION);
                profesiones.append(option);
            }
            option = document.createElement("option");
            option.appendChild(document.
                    createTextNode("Agregar otra profesion"));
            option.setAttribute("value", "-1");
            profesiones.append(option);

            dialogProfesion.dialog("close");
        } else {
            alert("Ya existe profesion en la base de datos");
        }
    }

    dialogInstitucion = $("#institucion").dialog({
        autoOpen: false,
        height: 300,
        width: 400,
        modal: true,
        buttons: [
            {
                text: "Agregar",
                click: function () {
                    var valor = $('input:text[name=inp_institucion_cliente]').val();
                    var url = urlBase + "ControladorPrincipal/recibirPostAjax";
                    var datos = "opcion=insertarInstitucion&institucion=" + valor;
                    var ajax = new Ajax(url, respInstitucion, datos);
                    ajax.setMetodoEnvio("POST");


                    if (valor == null || valor.length == 0 || /^\s+$/.test(valor)) {
                        alert("Escriba un texto no vacio");
                    } else {
                        ajax.enviarPeticion();
                    }
                }
            }
        ]
    });

    $("#instituciones").change(function () {
        if ($(this).val() == "-1") {
            dialogInstitucion.dialog("open");
        }
    });

    function respInstitucion() {
        if (this.peticionHttp.responseText != 0) {
            var instituciones = $("#instituciones");
            var objInstituciones = jQuery.parseJSON(this.peticionHttp.responseText);
            instituciones.empty();
            for (var i = 0; i < objInstituciones.length; i++) {
                var option = document.createElement("option");
                option.appendChild(document.
                        createTextNode(objInstituciones[i].NOMBRE_INSTITUCION));
                option.setAttribute("value", objInstituciones[i].ID_INSTITUCION);
                instituciones.append(option);
            }
            option = document.createElement("option");
            option.appendChild(document.
                    createTextNode("Agregar otra institucion"));
            option.setAttribute("value", "-1");
            instituciones.append(option);

            dialogInstitucion.dialog("close");
        } else {
            alert("Ya existe la institucion en la base de datos");
        }
    }
}

function buscandoClientes() {
    console.log("busqueda de clientes");
    var inputBusqueda = $("input:text[name=busqueda_cliente]").keyup(function () {
        var textoBusqueda = inputBusqueda.val();
        var url = urlBase + "ControladorCliente/getBusquedaClientes";
        var datos = "parametroBusqueda=" + textoBusqueda;
        var ajax = new Ajax(url, busquedaClientes, datos);
        console.log("enviando: " + textoBusqueda);
        ajax.setMetodoEnvio("POST");
        ajax.enviarPeticion();
    });

    function busquedaClientes() {
        console.log(this.peticionHttp.responseText);

        var $tablaClientes = $("#tabla_clientes");
        var $cabeceraTabla = $tablaClientes.find("tbody tr:eq(0)").clone();
        $tablaClientes.empty();
        $tablaClientes.append($cabeceraTabla);

        var objClientes = jQuery.parseJSON(this.peticionHttp.responseText);

        if (objClientes.length == 0)
            $tablaClientes.hide();
        else
            $tablaClientes.show();

        for (var i = 0; i < objClientes.length; i++) {
            console.log("objClientes: " + i);

            var fila = document.createElement("tr");
            var celdaCliente = document.createElement("td");
            var celdaEmail = document.createElement("td");
            var celdaDireccion = document.createElement("td");
            var celdaDetalles = document.createElement("td");

            celdaCliente.appendChild(document.createTextNode(
                    objClientes[i].NOMBRES_CLIENTE + " " +
                    objClientes[i].APELLIDO_P_CLIENTE + " " +
                    objClientes[i].APELLIDO_M_CLIENTE));
            celdaEmail.appendChild(document.createTextNode(objClientes[i].EMAIL_CLIENTE));
            celdaDireccion.appendChild(document.createTextNode(objClientes[i].DIRECCION_CLIENTE));

            var formulario = document.createElement("form");
            formulario.setAttribute("action", urlBase +
                    "ControladorCliente/detallesCliente");
            formulario.setAttribute("method", "post");
            var idCliente = document.createElement("input");
            idCliente.setAttribute("type", "hidden");
            idCliente.setAttribute("name", "id_cliente_detalle");
            idCliente.setAttribute("value", objClientes[i].ID_CLIENTE);
            var submit = document.createElement("input");
            submit.setAttribute("type", "submit");
            submit.setAttribute("value", "Mas Informacion");
            submit.setAttribute("class", "botones");
            formulario.appendChild(submit);
            formulario.appendChild(idCliente);

            celdaDetalles.appendChild(formulario);

            fila.appendChild(celdaCliente);
            fila.appendChild(celdaEmail);
            fila.appendChild(celdaDireccion);
            fila.appendChild(celdaDetalles);

            if (i % 2 == 0) {
                fila.setAttribute("class", "row-odd");
            } else {
                fila.setAttribute("class", "row-even");
            }

            $tablaClientes.append(fila);
        }
    }
}

function manejoProformas() {
    console.log("manejo de proformas");
    dialogProforma = $("#proforma").dialog({
        autoOpen: false,
        height: 600,
        width: 700,
        modal: true,
        buttons: [
            {
                text: "Añadir a la proforma",
                click: function () {
                    proformas.addItemsProforma();
                    dialogProforma.dialog("close");
                }
            },
            {
                text: "Cancelar",
                click: function () {
                    dialogProforma.dialog("close");
                }
            }
        ]
    });
    proformas.iniciar();
    busquedaProductos.iniciar();
}

function categorias() {
    console.log("hola");
    var url = urlBase + "ControladorCategoria/recibirPostAjax"

    $("#selectS").change(function () {
        var idCategoria = this.value;
        var datos = "opcion=categorias&id_categoria=" + idCategoria;
        var ajaxCategoria = new Ajax(url, getCategorias, datos);
        ajaxCategoria.setMetodoEnvio("POST");
        ajaxCategoria.enviarPeticion();

        function getCategorias() {
            var objCategorias = jQuery.parseJSON(this.peticionHttp.responseText);
            var $selectI = $("#selectI");
            $selectI.empty();
            for (var i = 0; i < objCategorias.length; i++) {
                var option = document.createElement("option");
                option.setAttribute("value", objCategorias[i].ID_CATEGORIA);
                var texto = document.
                        createTextNode(objCategorias[i].NOMBRE_CATEGORIA);
                option.appendChild(texto);
                $selectI.append(option);
            }
        }
        console.log("parece que todo salio bien");
    });
}

function busquedaAvanzada() {
    console.log("si funciona");

    var url = urlBase + "ControladorPrincipal/recibirPostAjax";

    var $selectFiltro = $("#opcion-seleccionada");

    var $opcionBusqueda = $("#opcion-busqueda-avanzada");
    $opcionBusqueda.change(function () {
        $opcionSeleccionda = $(this).val();
        console.log($opcionSeleccionda);

        var datos = "opcion=" + $opcionSeleccionda;
        var ajaxCategoria = new Ajax(url, cambiarSelect, datos);
        ajaxCategoria.setMetodoEnvio("POST");
        ajaxCategoria.enviarPeticion();

        function cambiarSelect() {
            var objOpciones = jQuery.parseJSON(this.peticionHttp.responseText);
            $selectFiltro.empty();

            if (objOpciones.length > 0) {
                switch (Object.getOwnPropertyNames(objOpciones[0])[0]) {
                    case "ID_CARGO":
                        for (var i = 0; i < objOpciones.length; i++) {
                            var option = document.createElement("option");
                            option.setAttribute("value", objOpciones[i].ID_CARGO);
                            var texto = document.createTextNode(objOpciones[i].NOMBRE_CARGO);
                            option.appendChild(texto);

                            $selectFiltro.append(option);
                        }
                        break;

                    case "ID_INSTITUCION":
                        for (var i = 0; i < objOpciones.length; i++) {
                            var option = document.createElement("option");
                            option.setAttribute("value", objOpciones[i].ID_INSTITUCION);
                            var texto = document.createTextNode(objOpciones[i].NOMBRE_INSTITUCION);
                            option.appendChild(texto);

                            $selectFiltro.append(option);
                        }
                        break;

                    case "ID_PROFESION":
                        for (var i = 0; i < objOpciones.length; i++) {
                            var option = document.createElement("option");
                            option.setAttribute("value", objOpciones[i].ID_PROFESION);
                            var texto = document.createTextNode(objOpciones[i].NOMBRE_PROFESION);
                            option.appendChild(texto);

                            $selectFiltro.append(option);
                        }
                        break;

                    case "ID_CIUDAD":
                        for (var i = 0; i < objOpciones.length; i++) {
                            var option = document.createElement("option");
                            option.setAttribute("value", objOpciones[i].ID_CIUDAD);
                            var texto = document.createTextNode(objOpciones[i].NOMBRE_CIUDAD);
                            option.appendChild(texto);

                            $selectFiltro.append(option);
                        }
                        break;
                }

            }
        }
    });
}

function manejoProveedores() {
    console.log("iniciando...");
    dialogProveedores = $("#modal-proveedores").dialog({
        autoOpen: false,
        height: 600,
        width: 700,
        modal: true,
        buttons: [
            {
                text: "Agregar grupos",
                click: function () {
                    proveedores.enviarFormulario();
                    dialogProveedores.dialog("close");
                }
            },
            {
                text: "Cancelar",
                click: function () {
                    dialogProveedores.dialog("close");
                }
            }
        ]
    });

    var proveedores = {
        itemProveedores: new Array(),
        tablaProveedores: null,
        entradaTexto: document.getElementById("proveedores-texto"),
        iniciar: function () {
            console.log("se inicio");
            $(this.entradaTexto).keyup(function () {
                proveedores.cargarItems();
            });

            this.tablaProveedores = document.createElement("table");
            //this.tablaProveedores.appendChild(
            //      document.createElement("tbody"));
            $("#modal-proveedores").append(this.tablaProveedores);
        },
        cargarItems: function () {
            var url = urlBase + "ControladorProveedor/recibirPostAjax";
            var datos = "opcion=getProveedores&textoBusqueda="
                    + this.entradaTexto.value;
            var ajaxProducto = new Ajax(url, cargarProveedores, datos);
            ajaxProducto.setMetodoEnvio("POST");
            ajaxProducto.enviarPeticion();

            function cargarProveedores() {
                var objProveedores = jQuery.parseJSON(this.peticionHttp.responseText);
                $(proveedores.tablaProveedores).empty();
                
                for (var i = 0; i < objProveedores.length; i++) {
                    var $fila = $("<tr></tr>");
                    var $celdaCheck = $("<td></td>");
                    var $celdaProveedor = $("<td></td>");
                    
                    var inputCheck = document.createElement("input");
                    inputCheck.setAttribute("type", "checkbox");
                    inputCheck.setAttribute("value", objProveedores[i].ID_CLASIFICACION);
                    if(proveedores.existeItem(objProveedores[i].ID_CLASIFICACION)) {
                        inputCheck.setAttribute("checked", 1);
                    }
                    $(inputCheck).click(function() {
                        
                        if($(this).prop("checked")) {
                            proveedores.agregarItem(this.value);
                        }
                        else {
                            proveedores.eliminarItem(this.value);
                        }
                        console.log(proveedores.itemProveedores);
                    });
                    
                    $celdaCheck.append(inputCheck);
                    $celdaProveedor.append(objProveedores[i].NOMBRE_CLASIFICACION);
                    
                    $fila.append($celdaCheck);
                    $fila.append($celdaProveedor);

                    $(proveedores.tablaProveedores).append($fila);
                }
            }
        },
        
        agregarItem: function(id) {
            this.itemProveedores.push(id);
        },
        
        eliminarItem: function(id) {
            var index = 0;
            var encontrado = false;
            while(index < this.itemProveedores.length && encontrado == false) { 
                if(this.itemProveedores[index] == id) {
                    this.itemProveedores.splice(index, 1);
                    encontrado = true;
                }
                index ++;
            }
        },
        
        existeItem: function(id) {
            var index = 0;
            var encontrado = false;
            while(index < this.itemProveedores.length && encontrado == false) {
                if(this.itemProveedores[index] == id) {
                    encontrado = true;
                }
                index ++;
            }
            return encontrado;
        }, 
        
        enviarFormulario: function() {
            if(this.itemProveedores.length > 0) {
                var datos = JSON.stringify(this.itemProveedores);
                var url = urlBase + "ControladorProveedor/asignarGrupo";
                var form = document.createElement("form");
                form.setAttribute("action", url);
                form.setAttribute("method", "post");
                
                var input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("value", datos);
                input.setAttribute("name", "grupos");
                form.appendChild(input);
                $("#modal-proveedores").append(form);
                console.log(form);
                form.submit();
            } 
        }
    };

    $("#act-modal-proveedores").click(function () {
        dialogProveedores.dialog("open");
        proveedores.cargarItems();
    });

    proveedores.iniciar();
}
