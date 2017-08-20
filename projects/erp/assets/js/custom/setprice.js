$(document).ready(function(){
    
    $("#error_msg_container").css("display","none");
    
    $("#client_id").select2({
        placeholder: "Select Client Name",
        allowClear: true
    });
    $("#product_id").select2({
        placeholder: "Select Product Name",
        allowClear: true
    });
    $("#year").select2({
        placeholder: "Select Product Name",
        allowClear: true
    });
    
    $('#defaultForm').bootstrapValidator({
        
        message: 'This value is not valid',
        group:'.form-control',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            product_id: {
                validators: {
                    notEmpty: {
                        message: 'The product name is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid product name selected.<br/>'
                    },
                }
            },
            client_id:{
                validators: {
                    notEmpty: {
                        message: 'Please select seller name.'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid client name selected.<br/>'
                    },
                }
            },
            price:{
                validators: {
                    notEmpty: {
                        message: 'Please enter price value.'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid price entered.<br/>'
                    },
                }
            },
            year:{
                validators: {
                    notEmpty: {
                        message: 'Please select Year.'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid Year selected.<br/>'
                    },
                }
            }
        }   
    });
    
    $("#year").on('change',function(){
        var mode=$("#mode").val();
        var id=$("#id").val();
        var client_id=$("#client_id").val();
        var product_id=$("#product_id").val();
        var year=$("#year").val();
        
        if(client_id==""){
            alert("Please select client name");$("#client_id").focus();return;
        }
        if(product_id==""){
            alert("Please select product name");$("#product_id").focus();return;
        }
        if(year==""){
            alert("Please select year");$("#year").focus();return;
        }
        
        if(mode=='Add'){            
            $.ajax({
            url:ROOT_URL+"setprice/check_duplicate",
            data:{"id":id,"client_id":client_id,"product_id":product_id,"year":year},
            method:"Post",
            success:function(result){
             if(result=='duplicate'){
                 $("#error_msg_container").css("display","block");
                 $("#error_msg").html("Already entered price against client name ,product name & year.");
             }else{
                 $("#error_msg_container").css("display","none");
             }
            }}); 
        }
        
    });
});



