<!DOCTYPE html>
<html>
<head>
    <title>FormValidation demo</title>
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/bootstrapValidator.min.css"/>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>    
    <script type="text/javascript" src="js/bootstrapValidator.js"></script>    
    <script type="text/javascript" src="js/bootstrap.js"></script>    
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="page-header">
                    <h2>Bootstrap Form</h2>
                </div>
                <form id="form">
                    <div class="form-group">
                        <label class="control-label" for="firstname">First Name:</label>
                        <div class="input-group">
                            <span class="input-group-addon">First</span>
                            <input class="form-control" placeholder="First Name" id="firstname" name="firstname" type="text" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="lastname">Last Name:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Last</span>
                            <input class="form-control" placeholder="Last Name" id="lastname" name="lastname" type="text" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Email ID:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Email</span>
                            <input class="form-control" placeholder="Email ID" id="email" name="email" type="text" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="gender">Gender:</label>
                        <div class="input-group">
                            <input type="radio" name="gender" id="male" value="M"/> Male
                            <input type="radio" name="gender" id="female" value="F"/> Female
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="file">Upload Image:</label>
                        <div class="input-group">
                            <input type="file" name="image" id="image" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="file">City:</label>
                        <div class="input-group">
                            <select class="form-control" id="city" name="city" >
                                <option value="">Select City</option>
                                <option value="M">Mumbai</option>
                                <option value="P">Pune</option>
                                <option value="S">Solapur</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" id="captchaOperation"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="captcha" />
                        </div>
                    </div>
                    <div class="form-group">                        
                        <div class="input-group">                            
                            Check Me <input type="checkbox" id="chk_me" name="chk_me" value="1"/> 
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">    
    function randomNumber(min, max) 
    {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

    function generateCaptcha() 
    {
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
    }

    generateCaptcha();
    
    $('#form').bootstrapValidator({  
        message: 'This value is not valid',
        group: '.form-group',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
                    firstname:
                    {
                        validators: 
                        {
                          notEmpty: 
                          {
                           message: 'First name should not be empty'
                          },
                          regexp: 
                          {
                            regexp: /^[a-zA-Z-/]+$/,
                            message: 'First name should be Alpha'
                          },
                          stringLength: 
                            {
                            max: 10,
                            min: 2,
                            message: 'The message must be less than 10 characters long'
                            }
                        }
                       
                    },
                    lastname:
                    {
                        validators: 
                        {
                          notEmpty: 
                          {
                           message: 'Last name should not be empty'
                          },
                          regexp: 
                          {
                            regexp: /^[0-9a-zA-Z-/]+$/,
                            message: 'Last name should be Alpha Numeric'
                          }
                        }
                       
                    },
                    email:
                    {
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
                    'gender':
                    {
                        validators: 
                        {
                          notEmpty: 
                          {
                           message: 'Please Select Gender'
                          }
                        }
                       
                    },
                    image:
                    {
                        validators: 
                        {
                          notEmpty: 
                          {
                           message: 'Please Select image'
                          }
                        }
                    },
                    city:
                    {
                        validators: 
                        {
                          notEmpty: 
                          {
                           message: 'Please Select City'
                          }
                        }
                    },
                    chk_me:
                    {
                        validators: 
                        {
                          notEmpty: 
                          {
                           message: 'Please select check box'
                          },
                          regexp: 
                          {
                            regexp: /^[0-9/]+$/,
                            message: 'Chk value should be numeric'
                          }
                        }
                       
                    },                   
                    captcha: 
                    {
                        validators: 
                        {
                            callback: 
                            {
                                message: 'Wrong answer',
                                callback: function(value, validator, $field) {
                                    var items = $('#captchaOperation').html().split(' '),
                                        sum   = parseInt(items[0]) + parseInt(items[2]);
                                    return value == sum;
                                }
                            }
                        }
                    }
                }       
    })
</script>
</html>