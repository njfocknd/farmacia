function fncNewTransaction(option){
	$("#div_first_date").hide();
	$("#div_end_date").hide();
	$(document.getElementById("div_button")).html("");
	div=document.getElementById("div_table");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	str_param="NewTransaction=1&option="+option;
	ajax_dynamic_div("POST",'nexthor_transaction_get.php',str_param,div);
}

function fncViewTransactionTable(option,option2){
	if (option2 == 0)
		option2 = "%";
	$("#div_first_date").show();
	$("#div_end_date").show();
	$(document.getElementById("div_button")).html("");
	div=document.getElementById("div_table");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	date=document.getElementById('first_date').value;
	first_date = date.substring(6,10)+date.substring(3,5)+date.substring(0,2);
	date=document.getElementById('end_date').value;
	end_date = date.substring(6,10)+date.substring(3,5)+date.substring(0,2);
	if (option == 4)
		str_param="ViewTransactionList=1&first_date="+first_date+"&end_date="+end_date+"&option="+option+"&option2="+option2;
	else
		str_param="ViewTransactionTable=1&first_date="+first_date+"&end_date="+end_date+"&option="+option+"&option2="+option2;
	ajax_dynamic_div("POST",'nexthor_transaction_get.php',str_param,div);
}

function fncChangeCategory(id){
	div=document.getElementById("div_category_detail_id");
	$(div).html("<img src='images/loading.gif' align='center'>");
	str_param="changeCategory=1&id="+id;
	ajax_dynamic_div("POST",'nexthor_transaction_get.php',str_param,div);
}
function fncSaveTransaction(option){
	div=document.getElementById("div_msg");
	$(div).html("<img src='images/loading.gif' align='center'>");
	if(option == 1){
		category_id=document.getElementById('category_id').value;
		category_detail_id=document.getElementById('category_detail_id').value;
		debit_account_id=document.getElementById('debit_account_id').value;
		debit_amount=document.getElementById('debit_amount').value;
		day=document.getElementById('transaction_date').value;
		transaction_date = day.substring(6,10)+day.substring(3,5)+day.substring(0,2);
		description=document.getElementById('description').value;
		str_param="SaveTransactionDebit=1&category_id="+category_id+"&category_detail_id="+category_detail_id+"&debit_account_id="+debit_account_id+"&debit_amount="+debit_amount+"&transaction_date="+transaction_date+"&description="+description;
	}
	else if(option == 2){
		category_id=document.getElementById('category_id').value;
		credit_account_id=document.getElementById('credit_account_id').value;
		credit_amount=document.getElementById('credit_amount').value;
		day=document.getElementById('transaction_date').value;
		transaction_date = day.substring(6,10)+day.substring(3,5)+day.substring(0,2);
		description=document.getElementById('description').value;
		str_param="SaveTransactionCredit=1&category_id="+category_id+"&credit_account_id="+credit_account_id+"&credit_amount="+credit_amount+"&transaction_date="+transaction_date+"&description="+description;
	}
	else{
		debit_account_id=document.getElementById('debit_account_id').value;
		debit_amount=document.getElementById('debit_amount').value;
		credit_account_id=document.getElementById('credit_account_id').value;
		credit_amount=document.getElementById('credit_amount').value;
		day=document.getElementById('transaction_date').value;
		transaction_date = day.substring(6,10)+day.substring(3,5)+day.substring(0,2);
		description=document.getElementById('description').value;
		str_param="SaveTransactionTransfer=1&debit_account_id="+debit_account_id+"&debit_amount="+debit_amount+"&credit_account_id="+credit_account_id+"&credit_amount="+credit_amount+"&transaction_date="+transaction_date+"&description="+description;
	}
	ajax_dynamic_div("POST",'nexthor_transaction_update.php',str_param,div);
}
	