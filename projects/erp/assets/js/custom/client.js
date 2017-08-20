$(document).ready(function(){
    
    $("#chk_same").on('change',function(){
        
        var cked = $(this).is(":checked");
        if(cked==true){
            $("#contact_no").val($("#mobile").val());
        }
        else
        {
            $("#contact_no").val("");
        }
        
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
            client_name: {
                validators: {
                    notEmpty: {
                        message: 'The client name is required and cannot be empty'
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: 'The address is required and cannot be empty'
                    }
                }
            },
            vat_no: {
                validators: {
                    notEmpty: {
                        message: 'The VAT No. is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid Vat No. entered.<br/>'
                    },
                }
            },
            mobile: {
                validators: {
                    notEmpty: {
                        message: 'The mobile no. is required and cannot be empty'
                    },
                    stringLength: {
                        max: 10,
                        min: 10,
                        message: 'The mobile must be less than 10 characters long'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid Mobile No. entered.<br/>'
                    },
                }
            },
            alt_mobile: {
                validators: {
                    stringLength: {
                        max: 10,
                        min: 10,
                        message: 'The mobile must be less than 10 characters long'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid Mobile No. entered.<br/>'
                    },
                }
            },
            email: {
                validators: 
                {
                  notEmpty: 
                  {
                   message: 'Email should not be empty'
                  },
                  regexp: 
                  {
                    regexp: /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/,
                    message: 'Email is invalid format'
                  }
                }
            },
            contact_no:{
                validators: {
                    stringLength: {
                        max: 10,
                        min: 10,
                        message: 'The mobile must be less than 10 characters long'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '<b><font color="black" size="2">X</font></b>Invalid Mobile No. entered.<br/>'
                    },
                }
            }
        }   
    });
    
});

