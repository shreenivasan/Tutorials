<html>
  <head>
    <?php
    $username = "root";
    $password = "";
    $hostname = "localhost";
    $dbhandle = mysql_connect($hostname, $username, $password);
    if (!$dbhandle)
    {
        echo 'Unable to Connect DB';
    }
    else
    {
        mysql_select_db("sinfra");
    }
    $sql="select count(*) as cnt,approved_status as status FROM requisitions group by approved_status";
    $res=  mysql_query($sql);
    $data=array();
    while($row= mysql_fetch_assoc($res))
    {
        $data[]=$row;
    }
    
    ?>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        
        
        data.addRows([
          ['<?=$data[0]['status']=="A"?"Approved":"Pending"?>', <?=$data[0]['cnt']?>],
          ['<?=$data[1]['status']=="A"?"Approved":"Pending"?>', <?=$data[1]['cnt']?>]
         
        ]);

        // Set chart options
        var options = {'title':'Requisition Status',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>