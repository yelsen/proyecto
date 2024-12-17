$(document).ready(function () {
    cargarOpciones("#cbComprobante", "obtenerOpciones");
    listadoProductos("txtProductos", "lista");
    mostrar("");
    $("#txbuscar").on("keyup", function () {
        mostrar($(this).val());
    });

    $("#cbComprobante").on("change", function () {
        const selectedValue = $(this).val(); 
        if (selectedValue) {
            mostrarNumero(selectedValue);
        }
    });
    
});









function mostrar(dta) {
    $.ajax({
        url: '../modelo/DAOventas.php',
        type: 'post',
        data: {
            ev: 0,
            dt: dta
        },
        success: function (msg) {
            $("#tabla").html(msg);
        },
        error: function (xml, msg) {
            swal('Aviso', msg.trim(), 'error');
        }
    });
}


$("#btnAñadir").on("click", function (e) {
    e.preventDefault();
    agregarFila();
});


$("#btnCancelar").on("click", function () {
    limpiarFormulario();
    $("#txtProductos").val("");
    $("#txtStock").val("");
    $("#txtCantidad").val("");
    $("#txtPrecio").val("");
});


$("#btnAgregar").on("click", function (e) {
    e.preventDefault();
    const comprobante = $("#cbComprobante").val().trim();
    const numero = $("#txtNumero").val().trim();
    const monto = $("#txtMonto_total").val().trim();
    const proveedor = $("#txtProveedor").val().trim();
    const transporte = $("#txtTransporte").val().trim();

    if (comprobante === "" && numero === "" && monto === "" && proveedor === "") {
        alert("El campo de producto no puede estar vacío");
        return;
    }
    $.ajax({
        url: "../modelo/DAOcompras.php",
        type: "post",
        data: {
            ev: 1,
            comprobante: comprobante,
            numero: numero,
            proveedor: proveedor,
            monto: monto,
            transporte: transporte
        },
        success: function (msg) {
            const tableBody = $("#tabla-body");
            const rows = tableBody.find("tr");
            rows.each(function () {
                const insumo = $(this).find("td:nth-child(2) input").val().trim();
                const precio = $(this).find("td:nth-child(3) input").val().trim();
                const cantidad = $(this).find("td:nth-child(4) input").val().trim();
                const fecha = $(this).find("td:nth-child(5) input").val().trim(); 

                if (!fecha) {
                    console.error("Fecha no válida encontrada en la fila:", fecha);
                    return;
                }

                $.ajax({
                    url: "../modelo/DAOcompras.php",
                    type: "post",
                    data: {
                        ev: 6,
                        monto: monto,
                        numero: numero,
                        comprobante: comprobante,
                        cantidad: cantidad,
                        precio: precio,
                        fecha: fecha,
                        insumo: insumo                 
                    },
                    success: function (msg) {
                        limpiarFormulario();
                        $("#cbComprobante").val("");
                        $("#txtNumero").val("");
                        $("#txtTransporte").val("");
                        $("#txtProveedor").val("");
                        $("#txtMonto_total").val("");
                        mostrar();
                        mostrarAlerta("¡Proceso Exitoso!", "El registro se ha creado correctamente.", "success");
                        console.log("Registro exitoso para detalle compra: " + insumo);
                    },
                    error: function (xml, msg) {
                        console.log("Error al registrar insumo: " + insumo);
                    }
                });

            });
        },
        error: function (xml, msg) {
        }
    });
});









function limpiarFormulario() {
    $("#txtProductos").val("");
    $("#txtPrecio").val("");
    $("#txtStock").val("");
    $("#txtCantidad").val("");
}



function agregarFila() {
    const producto = $("#txtProductos").val().trim();
    const stock = parseFloat($("#txtStock").val().trim());
    const cantidad = parseInt($("#txtCantidad").val().trim(), 10);
    const precio = parseFloat($("#txtPrecio").val().trim());

    if (cantidad > stock) {
        mostrarAlerta("Error", "La cantidad no puede superar el stock", "danger");
        return;
    }

    if (!producto || isNaN(precio) || isNaN(cantidad) || cantidad <= 0) {
        mostrarAlerta("Error", "Ningún campo puede estar vacío o contener datos inválidos", "danger");
        return;
    }

    const tableBody = $("#tabla-body");
    let existingRow = null;
    tableBody.find("tr").each(function () {
        const rowProducto = $(this).find("td:nth-child(2) textarea").val();
        const rowPrecio = parseFloat($(this).find("td:nth-child(3) input").val());
        if (rowProducto === producto && rowPrecio === precio) {
            existingRow = $(this);
            return false;
        }
    });

    if (existingRow) {
        const existingCantidad = parseInt(existingRow.find("td:nth-child(4) input").val(), 10);
        const newCantidad = existingCantidad + cantidad;

        if (newCantidad > stock) {
            mostrarAlerta("Error", "La cantidad total no puede superar el stock", "danger");
        } else {
            existingRow.find("td:nth-child(4) input").val(newCantidad);
            const newSubtotal = newCantidad * precio;
            existingRow.find("td:nth-child(5) input").val(newSubtotal.toFixed(2));
            actualizarTotal(newSubtotal - (existingCantidad * precio));
        }
    } else {
        const rowCount = tableBody.find("tr").length + 1;
        const subtotal = precio * cantidad;
        const row = $("<tr>").addClass("add-row");

        row.append(`
            <td><input type="text" class="form-control readonly-input" value="${rowCount}" readonly></td>
            <td><textarea class="form-control readonly-input" rows="1" readonly>${producto}</textarea></td>
            <td><input type="number" class="form-control readonly-input" value="${precio.toFixed(2)}" readonly></td>
            <td><input type="number" class="form-control readonly-input" value="${cantidad}" readonly></td>
            <td><input type="number" class="form-control readonly-input" value="${subtotal.toFixed(2)}" readonly></td>
            <td class="text-end">
                <div class="btn-group">
                    <button title="Eliminar datos" type="button" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        `);

        row.find(".btn-danger").on("click", function () {
            const precioFila = parseFloat(row.find("td:nth-child(3) input").val());
            const cantidadFila = parseInt(row.find("td:nth-child(4) input").val(), 10);
            const subtotalFila = precioFila * cantidadFila;
            actualizarTotal(-subtotalFila);
            row.remove();
        });

        tableBody.append(row);
    }

    limpiarFormulario();  
}


function actualizarTotal(cambio) {
    const montoInput = $("#txtMonto_total");
    let montoActual = parseFloat(montoInput.val()) || 0; 
    montoActual += cambio;
    montoInput.val(montoActual.toFixed(2)); 
}







































function mostrarNumero(idComprobante) {
    $.ajax({
        url: '../modelo/DAOventas.php',
        type: 'POST',
        data: { 
            ev: 5,
            idtipo_comprobante: idComprobante 
        },
        dataType: 'json',
        success: function (response) {
            if (response.success && response.num_comprobanteV) {
                $("#txtNumero").val(response.num_comprobanteV); 
            } else if (response.success) {
                $("#txtNumero").val(""); 
            } else {
                $("#txtNumero").val("");
                alert(response.message || "Error inesperado.");
            }
        },
        error: function () {
            alert("Error al obtener los datos del comprobante.");
        }
    });
}


function listadoProductos(idInput, idLista) {
    const input = document.getElementById(idInput);
    const lista = document.getElementById(idLista);

    input.addEventListener("input", () => {
        const entrada = input.value.trim().toLowerCase();
        lista.innerHTML = "";

        if (entrada) {
            $.ajax({
                url: "../modelo/DAOventas.php",
                type: "POST",
                dataType: "json",
                data: {
                    ev: 4,
                    entrada: entrada,
                },
                success: function (response) {
                    if (response.success && Array.isArray(response.data)) {
                        const filteredData = response.data.filter(
                            (item) =>
                                item.val2.toLowerCase().includes(entrada) ||
                                item.val3.toLowerCase().includes(entrada) ||
                                item.val4.toLowerCase().includes(entrada)
                        );

                        filteredData.forEach((item) => {
                            const li = document.createElement("li");
                            li.classList.add(
                                "list-group-item",
                                "list-group-item-action",
                                "border-0"
                            );
                            li.textContent = `${item.val2} - Precio: ${item.val3} (${item.val4})`;
                            
                            li.addEventListener("click", () => {
                                input.value = item.val2;
                                lista.innerHTML = "";
                                mostrarProducto(item.val2);
                            });

                            lista.appendChild(li);
                        });
                    } else {
                        console.error("El formato de los datos recibidos no es válido");
                    }
                },
                error: function (error) {
                    console.error("Error al consultar los datos del servidor:", error);
                },
            });
        }
    });

    document.addEventListener("click", (event) => {
        if (!input.contains(event.target) && !lista.contains(event.target)) {
            lista.innerHTML = "";
        }
    });
}


function mostrarProducto(productoDato) {
    $.ajax({
        url: '../modelo/DAOventas.php',
        type: 'POST',
        data: { 
            ev: 7, 
            producto: productoDato
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.success && response.data) {
                $("#txtPrecio").val(response.data.precio_venta);  
                $("#txtStock").val(response.data.stock_producto); 
                const stockProducto = response.data.stock_producto;
                $("#txtCantidad").attr("max", stockProducto);
                $("#txtCantidad").val(Math.min($("#txtCantidad").val(), stockProducto));
            } else {
                $("#txtPrecio").val('');
                $("#txtStock").val('');
                alert("Producto no encontrado.");
            }
        },
        error: function() {
            alert("Error al obtener la información del producto.");
        }
    });
}


function cargarOpciones(idCombo, funcionVer) {
    $.ajax({
        url: "../modelo/DAOventas.php",
        method: "GET",
        data: {
            funcion: funcionVer,
        },
        dataType: "json",
        success: function (response) {
            if (response.error) {
                alert(response.error);
            } else {
                let select = $(idCombo);
                select.empty();
                select.append(
                    '<option value="" disabled selected>Seleccione...</option>'
                );
                response.data.forEach(function (item) {
                    select.append(
                        '<option value="' + item.val1 + '">' + item.val2 + "</option>"
                    );
                });
            }
        },
        error: function (xhr, status, error) {
            console.log("Estado: " + status);
            console.log("Error: " + error);
            console.log("Respuesta: " + xhr.responseText);
            alert("Error al cargar los roles.");
        },
    });
}

function mostrarAlerta(titulo, mensaje, tipo = "success") {
    $("#alertTitulo").text(titulo);
    $("#alertMensaje").text(mensaje);
    const alerta = $("#miAlerta");
    alerta.removeClass("alert-success alert-danger alert-warning alert-info");
    alerta.addClass(`alert-${tipo}`);
    alerta.show();
    setTimeout(function () {
        alerta.fadeOut("slow");
    }, 3000);
}
