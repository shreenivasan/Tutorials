var init = [];
init.push(function (){
    $('#forgot-password-link').click(function () {
            $('#password-reset-form').fadeIn(400);
            return false;
    });
    $('#password-reset-form .close').click(function () {
            $('#password-reset-form').fadeOut(400);
            return false;
    });
});

// Setup Sign In form validation
init.push(function (){
    $("#signin-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });

    // Validate username
    $("#username_id").rules("add", {required: true,minlength: 1});
    
    // Validate password
    $("#password_id").rules("add", {required: true,minlength: 1});
});

// Setup Password Reset form validation
init.push(function (){
    $("#password-reset-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });
    // Validate email
    $("#p_email_id").rules("add", {required: true,email: true});
});
window.PixelAdmin.start(init);
