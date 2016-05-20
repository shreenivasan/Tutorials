<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<form id="frm" method="POST" onsubmit="return false;"> 
    <p>
        <img id="captcha" src="captcha.php" width="160" height="45" border="1" alt="CAPTCHA"> 
        <small>
            <a href="#" onclick=" document.getElementById('captcha').src = 'captcha.php?' + Math.random(); document.getElementById('captcha_code').value = ''; return false; ">refresh</a>
        </small>
    </p>   
    <p>
        <input id="captcha_code" type="text" name="captcha" size="6" maxlength="5" onkeyup="this.value = this.value.replace(/[^\d]+/g, '');"> 
        <small>copy the digits from the image into this box</small>
        <small id="captch_msg" style="color:red"></small>
    </p> 
    
    <input type="submit" id="submit" value="Submit" />
</form>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript"> 
//    function checkForm(form) 
//    { 
//        if(form.captcha.value.trim()=="") 
//        {
//            document.getElementById("captch_msg").innerHTML='Please enter captch values';
//            return false; 
//        }
//        else
//        {
//            if(!form.captcha.value.match(/^\d{5}$/)) 
//            { 
//                //alert('Please enter the CAPTCHA digits in the box provided'); 
//                document.getElementById("captch_msg").innerHTML='Invalid captcha entered';
//                form.captcha.focus(); 
//                return false; 
//            }
//        }
//        return true; 
//    } 
    
    
    $("#frm").on("submit",function()
    {
        var flag=true;
        if($("#captcha_code").val().trim()=="") 
        {
            $("#captch_msg").html('Please enter captch values');
            flag= false; 
        }
        else
        {
            if(!$("#captcha_code").val().match(/^\d{5}$/)) 
            { 
                //alert('Please enter the CAPTCHA digits in the box provided'); 
                $("#captch_msg").html('Invalid captcha entered 1');
                $("#captcha_code").focus(); 
                flag= false; 
            }
        }
       
        if(flag==true)
        {
            var captcha_val=$("#captcha_code").val();
            
            $.ajax
            ({
                url : 'form-handler.php',
                data:{"captcha":captcha_val},
                type: "POST",
                success: function(data)
                {
                    alert("data===>"+data)
                    if(data=="Y")
                    {
                        window.location='home.php'
                    }
                    else
                    {
                        alert('else block');
                        $("#captch_msg").html('Invalid captcha entered 2');
                    }
                },	
                error: function(data) 
                {
                    
                }                
            });    
        }
        else
        {
            return false;
        }
    });	
		
</script>