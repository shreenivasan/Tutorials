<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>JQuery File Upload</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  </head>

  <body>
    <form action="upload" enctype="multipart/form-data" method="post">
      Upload image:
      <input id="image-file" type="file" name="file" />
      <input type="submit" value="Upload" />
    </form>
  
   <script type="text/javascript">
      $('#image-file').on('change', function() {
          var file_size = (this.files[0].size/1024/1024).toFixed(2);
        console.log('This file size is: ' + file_size + " MB");
      });
    </script>
  </body>
</html>