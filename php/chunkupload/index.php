<script src="js/jquery.min.js"></script> 
<body>
    <h3>File chunkupload code</h3>
    <div><input type="file" value="" id="file_upload" name="file_upload" /></div>
    <div class="chunk_upload" id="showPreview"></div>
    <div id="invalid_file"></div>
</body>
   
<script>

var _id="file_upload";
var _error_id="invalid_file";

//Max file size in MB
var MAX_FILE_SIZE =10;     

//Mention max no of files user can upload
var MAX_FILES =3;     

//Chunk size 1024*1024 bytes 
// i.e. Number of bytes uploaded in per request
var step = 1048576;


$("#"+_id).on('change',function()
{
    
    
    var type = $("#"+_id)[0].files[0].name.split('.').pop().toLowerCase();
    var size = $("#"+_id)[0].files[0].size;
    var name = $("#"+_id)[0].files[0].name;
            
    switch(type) 
    {
        case 'jpg':
        case 'jpeg': 
        case 'png': 
        case 'bmp':
            case 'pdf':
            if(size<=1048576*MAX_FILE_SIZE)
            {     
                read_file_contents(type);
            } 
            else
            {   
                $('#'+_error_id).css('color','red');
                return false;
            }
            break;
        default:
            $('#'+_error_id).css('color','red');
            return false;
    } 
    
});


function read_file_contents(type)
{
    
    var i =1;
    var loaded = 0;
    
    var total =$("#"+_id)[0].files[0].size;
    var totalRequest = parseInt(total/(1024));//No of request to be made
    var start = 0;
    var randName = Math.random().toString(36).substr(2, 30);
    var name;   
    
    name = $("#"+_id)[0].files[0].name;
    var parts = name.split(".");
    var fileNameWA = parts[0];
    name = encodeURIComponent( fileNameWA+randName+"."+type );
    var resFlag = 1;
    var uploaded = $("#"+_id);
    var reader = new FileReader();
    var fileRes ='';
    
    var cnt=0;
    
    cnt=$("#showPreview").children("div").length;
    
    reader.onload = function(e)
    {
        var xhr = new XMLHttpRequest();
        var upload = xhr.upload;
        xhr.onreadystatechange = function() 
        {
            if( this.readyState == 4 && this.status == 200 ) 
            {
                fileRes = xhr.responseText;

                if (fileRes === "invalid_file" && resFlag === 1)
                {
                    alert("Invalid image file!");
                    xhr.abort();
                    resFlag = 0;
                    loaded=total*100;
                    return;
                }
                if( totalRequest < i ) 
                {
                    if(fileRes === "image_size_exeeded" && resFlag === 1)
                    {
                        alert("Image is too big! Please reduce the size of your photo using an image editor. Max 5 MB is allowed.");
                        xhr.abort();
                        resFlag = 0;
                        loaded=total*100;
                        return;
                    }
                }   
                
                if(loaded >= total)
                {                               
                    var mystr="<div class='fu-up-ph'>";
                    mystr+="<img alt='' class='fu-up-ph-img' src='"+fileRes+"' height='70px' width='70px'>";                    
                    mystr+="<div class='fu-up-del link'>Delete</div>";            
                                     
                    mystr+="<input type='hidden' name='images1[]' value='"+fileRes+"' />";
                    mystr+="</div>";  
                    $("#showPreview").append(mystr);

                    if($("#"+_id).children("div").length>2)
                    {
                        $("#"+_id).parent().hide();
                    }
                    $("#"+_id).val("");
                }
            }
        }
        upload.addEventListener('load',function()
        {
            loaded += step;
            var _p = (loaded/total) * 100;
            if( _p > 100 ) 
            {
                    _p = 100;
            }
            uploaded.innerHTML = 'Please Wait....('+Math.floor(_p)+')%';
            if(loaded <= total)
            {
                blob = $("#"+_id)[0].files[0].slice(loaded,loaded+step);

                reader.readAsDataURL(blob);
                
            }
            else
            {
                loaded = total;                
            }
        },false);
        
        if(resFlag)
        {
            if(cnt<MAX_FILES)
            {   
                params="action=upload";
                params+="&fname="+name;
                params+="&fileSize="+total;
                params+="&nocache="+new Date().getTime();
                params+="&totalRequest="+totalRequest;
                params+="&cid="+(cnt+1);              
                params+="&count="+i++;
                
                xhr.open("POST","./chunkupload.php?"+params);
                xhr.overrideMimeType("application/octet-stream");  
                xhr.send( e.target.result.split(",", 2)[1] );//remove text
                if(cnt>=MAX_FILES-1)
                {
                    $("#"+_id).parent().hide();
                }
            }
            if(cnt>=MAX_FILES-1)
            {
                $("#"+_id).parent().hide();
            }
        }
        
        
    };
    
    var blob = $("#"+_id)[0].files[0].slice(start,step);
    reader.readAsDataURL(blob);  
}

$(document).delegate("#showPreview .fu-up-del",'click',function()
{
            var tst = $(this).parent("div").find("img").attr("src");
            
            deleteFile(tst);
            
            $(this).parent("div").remove();
            $("#"+_id).parent().show();
}); 

function deleteFile(file_path,key)
{
    $.ajax
    ({
        url: './chunkupload.php',
        data: {"action":"deleteFile", "file_path":file_path},
        type: "POST",
        async: true,                
        success: function (data) 
        {                         

        }
    });
}

</script>
    