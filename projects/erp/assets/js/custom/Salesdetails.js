$(document).ready(function(){
    $('#cur_date').datepicker( {format: 'dd-mm-yyyy'});
    
    $("select.my_select").select2();
    
    $("select.my_select").select2({placeholder: "Select Client Name",allowClear: true});

});
