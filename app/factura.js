function fncCambioFormulario(x,y)
{
	div=document.getElementById("divFormularioCliente");
	div2=document.getElementById("divFormularioDetalle");
	div3=document.getElementById("divFormularioPago");
	switch(x)
	{
		case 1:
			div2.style.display = (div2.style.display == 'none') ? 'block' : 'none';
			div.style.display = (div.style.display == 'none') ? 'block' : 'none';
			break;
		case 2:
			if(y==1)
			{div.style.display = (div.style.display == 'none') ? 'block' : 'none';}
			else{div3.style.display = (div3.style.display == 'none') ? 'block' : 'none';}
			bandera=document.getElementById("inputBandera").value;
			if((y==1) && (bandera==0))
			{	
				document.getElementById("inputBandera").value=1;
				strParam="bandera="+x+"&menu=step2";
				ajax_dynamic_div("POST",'factura_update.php',strParam,div2,true);
			}
			else
			{
				div2.style.display = (div2.style.display == 'none') ? 'block' : 'none';
			}
			break;
		case 3:
			bandera=document.getElementById("inputBanderaStep").value;
			div2.style.display = (div2.style.display == 'none') ? 'block' : 'none';
			if((y==2) && (bandera==0))
			{	
				strParam="bandera="+x+"&menu=step3";
				ajax_dynamic_div("POST",'factura_update.php',strParam,div3,true);
				document.getElementById("inputBanderaStep").value=1;
			}
			else
			{
				div3.style.display = (div3.style.display == 'none') ? 'block' : 'none';
			}
			
			inputSubTotalDetalle=document.getElementById('inputSubTotalDetalle').value;
			document.getElementById('inputMontoEfectivo').value = inputSubTotalDetalle;
			document.getElementById('inputMontoDeposito').value = inputSubTotalDetalle;
			break;
	}
}

function fncCalculaRetorno()
{
	inputMontoRecibidoEfectivo=document.getElementById('inputMontoRecibidoEfectivo').value;
	inputMontoEfectivo=document.getElementById('inputMontoEfectivo').value;
	var res=inputMontoRecibidoEfectivo-inputMontoEfectivo;
	document.getElementById('inputMontoVuelto').value=res;
}
function fncConfirmaEfectivo(id)
{
	if(document.formEfectivo.checkConfirmaPago.checked)
	{
		inputMontoVuelto=document.getElementById('inputMontoVuelto').value;
		if(inputMontoVuelto > 0)
		{
			document.getElementById("divMontoRecibidoEfectivo").className = 'form-group has-success';
			document.getElementById("buttonPagoEfectivo").className = 'btn btn-success';
		}
		else
		{
			document.getElementById('divMontoRecibidoEfectivo').className = 'form-group has-error';
			document.getElementById("buttonPagoEfectivo").className = 'btn btn-success disabled';
		}
	}
	else
	{
		document.getElementById('divMontoRecibidoEfectivo').className = 'form-group';
		document.getElementById("buttonPagoEfectivo").className = 'btn btn-success disabled';
	}
}

function fncGuardaPago(idtipo_pago)
{
	
	id_cliente=document.getElementById('inputIdCliente').value;
	idsucursal=1
	div=document.getElementById("divActualizaciones");
	documento=document.getElementById('inputIdDocumento').value;
	movimientoDocumento=document.getElementById('inputIdMovimientoDocumento').value;
	if(idtipo_pago==1)
	{
		monto=document.getElementById('inputMontoEfectivo').value;
		strParam="idtipo_pago="+idtipo_pago+"&id_cliente="+id_cliente+"&monto="+monto+"&idsucursal="+idsucursal+"&documento="+documento+"&movimientoDocumento="+movimientoDocumento+"&pagoEfectivo=1";
		ajax_dynamic_div("POST",'factura_update.php',strParam,div,true);	
	}
	else if(idtipo_pago==2)
	{
		alert();
	}
	else if(idtipo_pago==3)
	{
		alert();
	}
	else
	{
		alert();
	}
}


function fncAgregarBoleta()
{
	document.getElementById('inputBoletaPago').value='';
	$('#myModal').modal('show');
}

function fncBuscaBoletaPago()
{
	alert("si existe la boleta");
	document.getElementById("buttonPagoDeposito").className = 'btn btn-success';
	$('#buttonAgregarBoleta').tooltip('show');
}

function fncBuscaProducto(value)
{
	div=document.getElementById("divDatosProducto");
	strParam="idProducto="+value+"&informacionProducto=1";
	ajax_dynamic_div("POST",'factura_update.php',strParam,div,true);
}

function fncCalculaDetalleSubTotal(cantidad)
{
	precio=document.getElementById('inputPrecio').value;
	precio=parseFloat(precio);
	total=precio*cantidad;
	total=parseFloat(total);
	document.getElementById('inputTotalCompra').value = total;
}

function fncAgregarProducto()
{
	
	div=document.getElementById("divDetalleVenta");
	//cliente
	nit_cliente=document.getElementById('nit_cliente').value;
	nombre_cliente=document.getElementById('nombre_cliente').value;
	direccion_cliente=document.getElementById('direccion_cliente').value;
	inputIdCliente=document.getElementById('inputIdCliente').value;
	//documento
	inputIdDocumento=document.getElementById('inputIdDocumento').value;
	//detalle
	inputCodigo=document.getElementById('inputCodigo').value;
	inputDescripcion=document.getElementById('inputDescripcion').value;
	inputPrecio=document.getElementById('inputPrecio').value;
	inputCantidad=document.getElementById('inputCantidad').value;
	inputTotalCompra=document.getElementById('inputTotalCompra').value;
	
	
	strParam="nit_cliente="+nit_cliente+"&nombre_cliente="+nombre_cliente+"&direccion_cliente="+direccion_cliente+"&inputIdCliente="+inputIdCliente+"&inputIdDocumento="+inputIdDocumento+"&inputCodigo="+inputCodigo+"&inputDescripcion="+inputDescripcion+"&inputPrecio="+inputPrecio+"&inputCantidad="+inputCantidad+"&inputTotalCompra="+inputTotalCompra+"&creaDocumentoDetalle=1";
	ajax_dynamic_div("POST",'factura_update.php',strParam,div,true);
}

function fncNuevoCliente()
{
	var x=0;
	nit=document.getElementById('nit_cliente').value;
	nombre=document.getElementById('nombre_cliente').value;
	direccion=document.getElementById('direccion_cliente').value;
	div=document.getElementById("divActualizaciones");
	strParam="nit="+nit+"&nombre="+nombre+"&direccion="+direccion+"&insertarDatosCliente=1";
	if(nit=='')
	{
		x=1
	}
	if(nombre=='')
	{
		x=1
	}
	if(direccion=='')
	{
		x=1
	}
	if(x==0)
	{
		ajax_dynamic_div("POST",'factura_update.php',strParam,div,true);
	}
	else
	{
		alert("Solicite toda la información al Cliente para Almacenarlo");
	}
}


function fncValidateIf()
	{
	var txtN = $.trim($("#nit_cliente").val());
	if (txtN !='')
	{	
		var state = fncValidaNit();
		if(state==true)
		{
			document.getElementById("divNit").className = 'form-group';
			div=document.getElementById("divDatosCliente");
			strParam="nit="+txtN+"&verDatosCliente=1";
			ajax_dynamic_div("POST",'factura_update.php',strParam,div,true);
		}
		else if(state==false)
		{
			document.getElementById('nit_cliente').focus();
			document.getElementById("divNit").className = 'form-group has-error';
		}
		else
		{
			alert("NO HAY NADA");
			document.getElementById('nit_cliente').focus();
		}
	}
	else
		{
		alert("INGRESE UN NIT");
		document.getElementById('nit_cliente').focus();
		// document.getElementById('idEmployee1').html("");
		}

	}
	
function fncValidaNit()
{                             
	var txtN = $.trim($("#nit_cliente").val()); 
	if((txtN=="c/f")||(txtN=="cf")||(txtN=="c.f"))
	{
		txtN="C/F";
	}
	else
	{	
		txtN = txtN.toUpperCase();
	}

   var patt1=/(\d+)\-?(\d{1}|[k|K])$/;                                                                                   
   var patt2=/\C\/\F$/; 
                               
	//alert(patt2);
    if (!txtN.match(patt1))
    {                 
         if (!txtN.match(patt2))
         {
             alert("El formato del NIT no es valido ingrese: 'C/F'  o un NIT con guiones");
			 document.getElementById('nit_cliente').focus();
             return false;
         }
    } 
    
    txtN = txtN.toUpperCase();  
    if ( txtN == "C/F")return true;
	var nit = txtN;
    var pos = nit.indexOf("-");
    if (pos < 0)                             
    {  
        var correlativo = txtN.substr(0, txtN.length - 1);
        correlativo = correlativo + "-";
       
        var pos2 = correlativo.length - 2;
        var digito = txtN.substr(pos2 + 1);
        nit = correlativo + digito;
        pos = nit.indexOf("-");
        txtN = nit;		
    }     
    var Correlativo = nit.substr(0, pos);
    var DigitoVerificador = nit.substr(pos + 1);
    var Factor = Correlativo.length + 1;
    var Suma = 0;
    var Valor = 0;
    for (x = 0; x <= (pos - 1); x++) 
    {
        Valor = eval(nit.substr(x, 1));
        var Multiplicacion = eval(Valor * Factor);
        Suma = eval(Suma + Multiplicacion);
        Factor = Factor - 1;
    }      
    var xMOd11 = 0;
    xMOd11 = (11 - (Suma % 11)) % 11;
    var s = xMOd11;
    if ((xMOd11 == 10 && DigitoVerificador == "K") || (s == DigitoVerificador)) 
    {
        return true;
    }   
    else 
    {
		document.getElementById('nit_cliente').focus();
		return false;
    }  
}  

function VerInfoCliente(e,id,value)
{
	tecla=(document.all) ? e.keyCode : e.which;
	alert(tecla);
	if((tecla == 13) || (tecla ==97))
	{
		fncValidateIf();
	}
}
function fncQuitarProducto()
{
	alert("Ingrese su clave para borrar producto");
}