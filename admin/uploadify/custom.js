$(document).ready(function(){
    $("#tabs").hover(function(){

        $( "#done" ).prop( "disabled", function( i, val ) {
            if(val == 'false'){
                $(".notification").show();
            }else{
                $(".notification").hide();
            }
        });
    });

    if (!$('#FlieDiv span').length){
        $("#done").prop( "disabled", true );

    }

//    $('#FlieDiv img').live('click',function(){
        $(document).on('click', '#FlieDiv img', function(){
            if ($('#FlieDiv span').length){
            $("#done").prop( "disabled", false );

        }
    });
//    $("#done").live('click',function(){
        $(document).on('click', '#done', function(){
        var data = $("#done").attr('class');
        if(data == undefined){
            data = '';
        }
        var url = $("#done").attr('fileName');
        var id = $("#done").attr('name');
        if(id != ''){
            data = data.split("*");
            window.location = url+'?tImg='+data[0]+'&id='+id;
        }else{
            if(url.indexOf('?') == -1){
                if(url.indexOf('**') > -1){
                    url = url.split("**");
                    window.location = url[0]+'?tImg='+data+'&id='+url[1];
                }else{
                    window.location = url+'?data='+data;
                }

            }else{
                window.location = url+'&data='+data;
            }
        }

    });
    $(".Cancel").live('click',function(){

        var url = $("#done").attr('fileName');

        if(url.indexOf('?') == -1){
            if(url.indexOf('**') > -1){
                url = url.split("**");
                window.location = url[0];
            }else{
                window.location = url;
            }

        }else{
           window.location = url;
        }
    });
//    var $container = $('#container');
//    $container.imagesLoaded( function(){
//        $container.masonry({
//            itemSelector : '#FlieDiv',
//            gutterWidth : 1,
//            isAnimated : true
//        });
//        $("#FlieDiv img, .ui-icon").click(function(){
//            $container.masonry({
//                itemSelector : '#FlieDiv',
//                gutterWidth : 1,
//                isAnimated : false
//            }).reloadItems();
//        })
//    });

});