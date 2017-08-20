$(document).ready(function(){
    $("#seller_name").select2({
        placeholder: "Select Seller",
        allowClear: true
    });
    $("#unit_name").select2({
        placeholder: "Select Unit",
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
            product_name: {
                validators: {
                    notEmpty: {
                        message: 'The product name is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9. ]+$/,
                        message: '<b><font color="black" size="2">X</font></b> Only aplphabates are allowed.<br/>'
                    },
                }
            },
            seller_name:{
                validators: {
                    notEmpty: {
                        message: 'Please select seller name.'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid seller name selected.<br/>'
                    },
                }
            },
            unit_name:{
                validators: {
                    notEmpty: {
                        message: 'Please select unit name.'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid unit selected.<br/>'
                    },
                }
            }
        }   
    });
});



