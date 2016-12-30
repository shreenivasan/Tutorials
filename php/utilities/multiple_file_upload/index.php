<!DOCTYPE html>
<html>
    <head>
        <meta name="robots" content="noindex, nofollow">       
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/script.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div id="maindiv">
            <div id="formdiv">
                <h2>Multiple Images Upload Form</h2>
                <form enctype="multipart/form-data" action="upload.php" method="post">
                    First Field is Compulsory. Only JPEG,PNG,JPG Type Image Uploaded. Image Size Should Be Less Than 100KB.
                    <hr/>
                    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
           
                    <input type="button" id="add_more" class="upload" value="Add More Files"/>
                    <input type="submit" value="Upload File" name="submit" id="upload" class="upload"/>
                </form>
                <br/>
                <br/>
            </div>
        </div>
    </body>
</html>