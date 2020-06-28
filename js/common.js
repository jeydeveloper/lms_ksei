function MM_openBrWindow(theURL,winName,features) {
  window.open(theURL,winName,features);
}

function f_onsubmit(pURL, pFormID, pErrdiv, pInitMsg, successfunc)
{
	//$("#"+pErrdiv).html(pInitMsg);
    $("#msg-content").hide();
	
	$.post(pURL, $("#"+pFormID).serialize(),
		function(data)
		{
			//alert(data);
			var datas = data.split("\1");
			if (parseInt(datas[0]) > 0)
			{
                $("#msg-content").show();
				$("#"+pErrdiv).html(datas[1]);
				return false;
			}
			
			successfunc(data);
		}
	);
	
	return false;
}

function sortby(pSort, pOrder)
{
	if ($("#sortby").val() == pSort)
	{			
		if ($("#orderby").val() == "asc")
		{
			$("#orderby").val("desc");
		}
		else
		{
			$("#orderby").val("asc");
		}			
	}
	else
	{					
		$("#sortby").val(pSort);
		$("#orderby").val(pOrder);
	}
	
	$("#offset").val(0);
	
	document.frmtemp.submit();
	
	return false;
}

function changelimit(elmt)
{
	$("#limit").val(elmt.value);
	$("#offset").val(0);
	document.frmtemp.submit();
}

function page(n)
{
	if (! n) n = 0;
	$("#offset").val(n);
	document.frmtemp.submit();
}


function setlang(h, ur, lg)
{
	$.post(h, {lang: lg},
		function(data)
		{
			location = ur;
		}
	);
}

function ischeckall(name)
{
	for(var i=0; i < document.frmtraining.elements.length; i++)
	{
		if (document.frmtraining.elements[i].name == name)
		{
			if (! document.frmtraining.elements[i].checked)
			{
				return false;
			}
		}
	}
	
	return true;
}

function checkwithval(frm, name, flag, value)
{		
	for(var i=0; i < frm.elements.length; i++)
	{			
		if (frm.elements[i].name == name) 
		{				
			if (frm.elements[i].value == value)
			{	
				frm.elements[i].checked = flag;
				return true;
			}
		}
	}
	
	return false;
}

function checkall(name, flag, callback)
{
	for(var i=0; i < document.frmtraining.elements.length; i++)
	{
		if (document.frmtraining.elements[i].name == name)
		{
			document.frmtraining.elements[i].checked = flag;
			if (callback)
			{
				callback(document.frmtraining.elements[i]);
			}
		}
	}	
}

function showhide(dvname, speed)
{
	if (! speed)
	{
		speed = "fast";
	}		
	
	if ($(dvname).css("display") == "none")
	{			
		$(dvname).show(speed);
	}
	else
	{
		$(dvname).hide(speed);
	}		
}	

function in_array(arr, val)
{
	for(var i=0; i < arr.length; i++)
	{
		if (arr[i] == val)
		{
			return true;
		}
	}
	
	return false;
}

function getelementnth(frm, name, nth, val)
{
	var j = 0;
  		for(var i=0; i < frm.elements.length; i++)
  		{
  			if (frm.elements[i].name == name)
  			{
  				if (j == nth)
  				{
  					if (val)
  					{
  						frm.elements[i].value = val;
  					}
  					
  					return i;
  				}
  				j++;
  			}
  		}		
  		
  		return -1;
}