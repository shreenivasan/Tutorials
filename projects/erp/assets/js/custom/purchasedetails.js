$(document).ready(function()
{
    $('#inward_date,#cur_date').datepicker( {format: 'dd-mm-yyyy'});
    
    $("select.my_select").select2();
    
    $("select.my_select").select2({placeholder: "Select Product",allowClear: true});

    $('body').on('change',".my_select",function()
    {    
        var id=$(this).attr("id").split("-")[1];
        var arrays = JSON.parse(product_details);
        for(i=0;i<arrays.length;i++){
            if(arrays[i].id==$(this).val()){
              $("#unit-label-"+id).text(arrays[i].code);
            }
        }
    });

    $('body').on('click',".remove-row",function(){
    var _id=$(this).attr("id").split("-")[2];
        $("#tr-"+_id).remove();
    });

    $(".add-row").on('click',function(){
    var table_row_cnt = $('#dataTable tr').length;
    
    new_id= parseInt(table_row_cnt)+1;
    
    var product_array=JSON.parse(product_details);
    
    var str="<tr id='tr-"+new_id+"'>";
    str+="<td>";
    str+="<select id='product-"+new_id+"' name='product[]' class='form-control my_select'>";
    str+="<option value=''></option>";
    for(i=0;i<product_array.length;i++){
    str+="<option value='"+product_array[i].id+"'>"+product_array[i].name+"</option>";    
    }
    str+="</select>";
    
    str+="</td>";
    str+="<td><label id='unit-label-"+new_id+"'></label></td>";
    str+="<td><input type='number' id='price-"+new_id+"' name='price[]' min='1' placeholder='Price' class='form-control' value='' /></td>";
    str+="<td><input type='number' id='qty-"+new_id+"' name='qty[]' max='1000' min='1' placeholder='Qty' class='form-control' value='' /></td>";
    str+="<td><input type='number' id='vat-price-"+new_id+"' name='vat_price[]' min='1' placeholder='VAT Price' class='form-control' value='' /></td>";
    str+="<td>";    
    str+="<button class='btn btn-default remove-row' id='remove-row-"+new_id+"' type='button' title='Delete'>-</button>";
    str+="</td>"
    str+="</tr>";
    
    $("#tr-"+table_row_cnt).after(str);
    $("select.my_select").select2();
});

    $("#btn-msr-sheet").on('click',function(){
    var snm = $("#seller_name").val();
    var idt=$("#inward_date").val();
    var ino =$("#invoice_no").val();
    var cdt = $("#cur_date").val();
    
    if(snm.trim().length==0){
        alert("Invalid selller name");
        return;
    }
    
    if(idt.trim().length==0){
        alert("Invalid inward date");
        return;
    }
    if(ino.trim().length==0){
        alert("Invalid inward no");
        return;
    }
    if(cdt.trim().length==0){
        alert("Invalid date");
        return;
    }
    
    var rows = $('table>tbody>tr');
    alert(rows.length)
    if(rows.length>0)
    {
        for (var i = 0; i < rows.length; i++)
        {
           var cells = rows.eq(i).children('td');
           var material = cells.eq(0).find('select').val();

            if(material.trim().length==0){
                alert("plese select material at location "+(i+1));
                return;
            }
            var price = cells.eq(2).find('input').val();
            if(price.trim().length==0){
                alert("plese enter price at location "+(i+1));
                return;
            }

            var qty = cells.eq(3).find('input').val();
            if(qty.trim().length==0){
                alert("plese enter Qty at location "+(i+1));
                return;
            }

            var vatprice = cells.eq(4).find('input').val();
            if(vatprice.trim().length==0){
                alert("plese enter Qty at location "+(i+1));
                return;
            }

        }
    }
    else
    {
        alert("Please add atleast one material details");
        return;
    }
    $("#defaultForm").submit();
    
});

//$('#defaultForm').bootstrapValidator({
//        
//        message: 'This value is not valid',
//        group:'.form-control',
//        feedbackIcons: {
//            valid: 'glyphicon glyphicon-ok',
//            invalid: 'glyphicon glyphicon-remove',
//            validating: 'glyphicon glyphicon-refresh'
//        },
//        fields: {
//            seller_name: {
//                validators: {
//                    notEmpty: {
//                        message: 'Seller name is mandotory'
//                    },
//                    regexp: {
//                        regexp: /^[0-9]+$/,
//                        message: '<b><font color="black" size="2">X</font></b> Invalid seller name.<br/>'
//                    },
//                }
//            },
//            inward_date:{
//                validators: {
//                    notEmpty: {
//                        message: 'Inward date is mandotory.'
//                    }
//                }
//            },
//            invoice_no:{
//                validators: {
//                    notEmpty: {
//                        message: 'Invoice no is mandotory.'
//                    }
//                }
//            },
//            cur_date:{
//                validators: {
//                    notEmpty: {
//                        message: 'Date is mandotory.'
//                    }
//                }
//            },
//            'product[]':{
//                validators: {
//                    notEmpty: {
//                        message: 'Invoice no is mandotory.'
//                    }
//                }
//            }
//        }   
//    });

});