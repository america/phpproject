$(function(){
    $('#word').bind('keydown keyup change',function(){
        var tnum  = $(this).val().length;
        $('#txtnum').text(tnum);
        var tmax = 255 - tnum;
        if(tmax > 0){
            $('#txtmax').text(tmax);
        }else{
            $('#txtmax').text("文字数オーバーです。");
            //文字数オーバーの際の挙動
        }
    });
});