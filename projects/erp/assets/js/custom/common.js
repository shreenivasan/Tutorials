/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function setProject(obj,uri)
{
    var id=obj.value;
    window.location.href =uri+"/"+id;
}
function addMaster(module,uri)
{
    window.location.href =uri;
}
function editMaster(module,uri,id)
{
    window.location.href =uri+"/"+id;
}
function searchMaster(module,uri)
{
    val = $("#txtSearch").val();
    if(val=="")
    {
        alert("Please Enter Search Value.");
        return false;
    }
    document.getElementById('hdnSearch').value = "1";
    //alert(document.getElementById('hdnSearch').value);
    document.frmListView.action = uri
    document.forms["frmListView"].submit();
}

function advSearchMaster(module,uri)
{ 
//    projectname = $("#selectProjectName").val();
//    masterlevel = $("#selectMasterLevel").val();
//    sourcelevel = $("#selectSourceLevelName").val();
//    materialcode = $("#txtMaterialCode").val();
//    materialname = $("#txtMaterialName").val();
//    qty = $("#txtQty").val();
//    
//    masterlevel_text = $("#selectMasterLevel option:selected").text();
//    sourcelevel_text = $("#selectSourceLevelName option:selected").text();
//    
//    document.getElementById('hdnAdvSearch').value = "1";
////    document.getElementById('hdnmasterlevel').value = masterlevel_text;
////    document.getElementById('hdnsourcelevel').value = sourcelevel_text;
//    
//    //alert(document.getElementById('hdnSearch').value);
//    document.advSearchList.action = uri
     $('#txtSearch').val('');
    document.forms["advSearchList"].submit();
    
}
function viewMaster(module,uri,id)
{
    window.location.href =uri+"/"+id;
}
function deleteMaster(module,uri,id)
{
    if(confirm('Do you want to delete this record?'))
    {
        window.location.href =uri+"/"+id;
    }
}
function selectMultiple()
{
    var isChecked=document.getElementById('chkSelectAll').checked;
    if(isChecked)
    {
        $('input[name^=chkSelect]').prop('checked', true);        
    }
    else
    {
        $('input[name^=chkSelect]').prop('checked', false);;
    }    
}
function validateDelete(uri)
{
    var checkboxes = document.getElementsByName('chkSelect[]');
    var vals = "";
    for (var i=0, n=checkboxes.length;i<n;i++) {
     if (checkboxes[i].checked) 
     {
     vals += ","+checkboxes[i].value;
     }
    }
    if (vals) vals = vals.substring(1);
    if(vals=='')
    {
        alert('Please select at least one record.');
        return false;
    }
    else
    {
        if(confirm('Do you want to delete selected records?'))
        {
            document.getElementById("frmListView").action = uri+"/deleteMultiple";
            document.forms['frmListView'].submit();
        }
        else
        {
            return false;
        }
    }    
}
function checkDuplicate(uri,callback,fieldname,value,mode,id){
    if(value!="")
    {
        $.ajax({
            url:uri+callback+"/"+fieldname+"/"+value+"/"+mode+"/"+id,
            success:function(result){
                if(result!="Success"){
                    alert(result);
                    $("#"+fieldname).focus();
                    $("#"+fieldname).val("");
                    if($("#defaultForm")){
                        $("#defaultForm").bootstrapValidator('revalidateField', fieldname); 
                    }                     
                }
        }}); 
    }
}

function printMaster(elem,pagetitle)
 {
    Popup($(elem).html(),pagetitle);
 }

 function Popup(data,pagetitle) 
 {
     var mywindow = window.open('', pagetitle , 'height=400,width=600, menubar=0, scrollbars=1');
     mywindow.document.write('<html><head><title>'+pagetitle+'</title>');
     /*optional stylesheet add */ 
     mywindow.document.write('<link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" />');
     mywindow.document.write('<div><h2>'+pagetitle+'</h2></div>');
     mywindow.document.write(data);
     mywindow.document.write('</body></html>');
     mywindow.print();
     return true;
 }        
function showProjectDetails(val)
{
    if(val == '1')
    {
        $("#showProjectDetails").show();
        $("#selAdmin").removeAttr("disabled");
    }
    else
    {
         $("#showProjectDetails").hide();
         $("#selAdmin").attr('disabled',true);
    }
}

function emptyCheck(fldName, fldType) {
    var currObj = getObj(fldName);
    if (fldType=="text") {
        if (currObj.value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0) {
            alert("Field cannot be empty.");
            try {
                    currObj.focus()	
            } catch(error) {
                // Fix for IE: If element or its wrapper around it is hidden, setting focus will fail
                // So using the try { } catch(error) { }
            }
        return false
        }
        else{
            return true
        }
    } else if((fldType == "textarea")  
            && (typeof(CKEDITOR)!=='undefined' && CKEDITOR.intances[fldName] !== 'undefined')) {
            var textObj = CKEDITOR.intances[fldName];
            var textValue = textObj.getData();
            if (trim(textValue) == '' || trim(textValue) == '<br>') { 
                alert("Field cannot be empty.");
                return false; 
            } else{ 
                return true; 
            } 
    }else{
    if (trim(currObj.value) == '') {
            alert("Field cannot be empty.");
            return false
    } else 
            return true
    }
}
function patternValidate(fldName,fldLabel,type) {
    var currObj=getObj(fldName)
    if (type.toUpperCase()=="YAHOO") //Email ID validation
    {
        //yahoo Id validation
        var re=new RegExp(/^[a-z0-9]([a-z0-9_\-\.]*)@([y][a][h][o][o])(\.[a-z]{2,3}(\.[a-z]{2}){0,2})$/)
    }
    if (type.toUpperCase()=="EMAIL") //Email ID validation
    {
        /*changes made to fix -- ticket#3278 & ticket#3461
          var re=new RegExp(/^.+@.+\..+$/)*/
        //Changes made to fix tickets #4633, #5111  to accomodate all possible email formats
        var re=new RegExp(/^[a-zA-Z0-9]+([\_\-\.]*[a-zA-Z0-9]+[\_\-]?)*@[a-zA-Z0-9]+([\_\-]?[a-zA-Z0-9]+)*\.+([\-\_]?[a-zA-Z0-9])+(\.?[a-zA-Z0-9]+)*$/)
    }
    if (type.toUpperCase()=="DATE") {//DATE validation 
        //YMD
        //var reg1 = /^\d{2}(\-|\/|\.)\d{1,2}\1\d{1,2}$/ //2 digit year
        //var re = /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/ //4 digit year

        //MYD
        //var reg1 = /^\d{1,2}(\-|\/|\.)\d{2}\1\d{1,2}$/ 
        //var reg2 = /^\d{1,2}(\-|\/|\.)\d{4}\1\d{1,2}$/ 

        //DMY
        //var reg1 = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{2}$/ 
        //var reg2 = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/
        switch (userDateFormat) {
            case "yyyy-mm-dd" : 
                var re = /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/
                break;
            case "mm-dd-yyyy" : 
            case "dd-mm-yyyy" : 
                var re = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/								
                break;
            case "" : 
                var re = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/
        }
    }

    if (type.toUpperCase()=="TIME") {//TIME validation
        var re = /^\d{1,2}\:\d{1,2}$/
    }
    //Asha: Remove spaces on either side of a Email id before validating
    if (type.toUpperCase()=="EMAIL" || type.toUpperCase() == "DATE") currObj.value = trim(currObj.value);	
    if (!re.test(currObj.value)) {
        alert(alert_arr.ENTER_VALID + fldLabel  + " ("+type+")");
        try {
                currObj.focus()	
        } catch(error) {
                // Fix for IE: If element or its wrapper around it is hidden, setting focus will fail
                // So using the try { } catch(error) { }
        }
        return false
    }
    else return true
}
function splitDateVal(dateval) {
    var datesep;
    var dateelements = new Array(3);

    if (dateval.indexOf("-")>=0) datesep="-"
    else if (dateval.indexOf(".")>=0) datesep="."
    else if (dateval.indexOf("/")>=0) datesep="/"

    switch (userDateFormat) {
        case "yyyy-mm-dd" : 
            dateelements[0]=dateval.substr(dateval.lastIndexOf(datesep)+1,dateval.length) //dd
            dateelements[1]=dateval.substring(dateval.indexOf(datesep)+1,dateval.lastIndexOf(datesep)) //mm
            dateelements[2]=dateval.substring(0,dateval.indexOf(datesep)) //yyyyy
            break;
        case "mm-dd-yyyy" : 
            dateelements[0]=dateval.substring(dateval.indexOf(datesep)+1,dateval.lastIndexOf(datesep))
            dateelements[1]=dateval.substring(0,dateval.indexOf(datesep))
            dateelements[2]=dateval.substr(dateval.lastIndexOf(datesep)+1,dateval.length)
            break;
        case "dd-mm-yyyy" : 
            dateelements[0]=dateval.substring(0,dateval.indexOf(datesep))
            dateelements[1]=dateval.substring(dateval.indexOf(datesep)+1,dateval.lastIndexOf(datesep))
            dateelements[2]=dateval.substr(dateval.lastIndexOf(datesep)+1,dateval.length)
    }

    return dateelements;
}
function isNumber(n,element) {
    if(n == ''){
        return true;
    }
    else
        return !isNaN(parseFloat(n)) && isFinite(n);
}
// Replace the % sign with %25 to make sure the AJAX url is going wel.
function escapeAll(tagValue)
{
    //return escape(tagValue.replace(/%/g, '%25'));
    if(default_charset.toLowerCase() == 'utf-8')
            return encodeURIComponent(tagValue.replace(/%/g, '%25'));
    else
            return escape(tagValue.replace(/%/g, '%25'));
}
function numericValidator(txtid)
    {
    var ok=0;
    var a=document.getElementById(txtid).value;
     
      for(var i=0;i<=a.length-1;i++)
      {
        var j=a.charCodeAt(i);
           for(var k=48;k<=57;k++)
        {
          ok=0;
          if(k==j)
          {
            ok=1;
            break ;
          }
        }
       
      }
      if(ok==0)
      {
        document.getElementById(txtid).value="";
        for(var i=0;i<a.length-1;i++)
        {
         var j=a.charCodeAt(i);
           for(var k=48;k<=57;k++)
        {
          ok=0;
          if(k==j)
          {
           document.getElementById(txtid).value+=a.charAt(i);
           }
         } 
        }
      }
    }
    
function generatePdf(module,uri,id)
{
    window.location.href =uri+"/"+id;
}
