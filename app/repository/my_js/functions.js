function fncMasterMenu(x)
{
document.getElementById("inicio").className = "";
document.getElementById("nexthor").className = "";
document.getElementById("contacto").className = "";
div=document.getElementById("divUpdate");
switch(x)
{
	case 1:
		document.getElementById("inicio").className = "active";
		strParam="valor="+x+"&menu=inicio";
		ajax_dynamic_div("POST",'updateIndex.html',strParam,div,true);
		break;
	case 2:
		document.getElementById("nexthor").className = "active";
		strParam="valor="+x+"&menu=nexthor";
		ajax_dynamic_div("POST",'updateNexthor.html',strParam,div,true);
		break;
	case 3:
		document.getElementById("contacto").className = "active";
		strParam="valor="+x+"&menu=contacto";
		ajax_dynamic_div("POST",'step.html',strParam,div,true);
		break;
}

}

function fncSuscripcion()
{
if( $('#suscripcion').prop('checked') ) {
	correoSuscripcion=document.getElementById('correoSuscripcion').value;
	nombreSuscripcion=document.getElementById('nombreSuscripcion').value;
	if((correoSuscripcion == '') || (nombreSuscripcion == ''))
	{
		alert('Ingrese los valores necesarios para su suscripción, gracias.');
	}
	else
	{
		alert('Se ha suscrito a nuestra página web...');
	}
}

}

function fncChangeFormulario(x)
{
	div=document.getElementById("divFormulario");
	switch(x)
	{
		case 1:
			strParam="valor="+x+"&menu=step";
			ajax_dynamic_div("POST",'step.html',strParam,div,true);
			break;
		case 2:
			strParam="valor="+x+"&menu=step2";
			ajax_dynamic_div("POST",'step2.html',strParam,div,true);
			break;
		case 3:
			strParam="valor="+x+"&menu=step3";
			ajax_dynamic_div("POST",'step3.html',strParam,div,true);
			break;
	}
}