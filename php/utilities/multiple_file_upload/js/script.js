var abc = 0;
//function increment() {
    
//};
$(document).ready(function() {
    $('#add_more').click(function() {//When Add More Files button Clicked these function Willbe Called (new file field is added dynamically)
        $(this).before($("<div/>", {id: 'filediv'}).fadeIn('slow').append(
                $("<input/>", {name: 'file[]', type: 'file', id: 'file'}),        
                $("<br/><br/>")
                ));
    });

$('body').on('change', '#file', function(){
            if (this.files && this.files[0]) {
                //increment();
                abc += 1;
                var z = abc - 1;
                var x = $(this).parent().find('#previewimg' + z).remove();
                $(this).before("<div id='abcd"+ abc +"' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                $(this).hide();
                $("#abcd"+ abc).append($("<img/>", {id: 'img', src: 'x.png', alt: 'X'}).click(function() {
                $(this).parent().parent().remove();
                }));
            }
        });
        
    function imageIsLoaded(e) {
        $('#previewimg' + abc).attr('src', e.target.result);
    };

    $('#upload').click(function(e) {
        var name = $(":file").val();
        if (!name)
        {
            alert("First Image Must Be Selected");
            e.preventDefault();
        }
    });
});