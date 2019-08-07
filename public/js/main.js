url = 'http://localhost/instagram/public';

window.addEventListener('load',function(){
    
    //Estilo del puntero
    $('.btn-like').css('cursor','pointer');
    $('.btn-dislike').css('cursor','pointer');

    function like(){
        $('.btn-like').unbind('click').click(function(){ //unbind funciona para limpiar los blindeo
            $(this).addClass('btn-dislike').removeClass('btn-like'); //cambia  clase
            $(this).attr('src',url+'/img/heart-red.png'); //cambia atributo
            
/*
            $.ajax({
                url: url+'/like/'+$(this).attr('data-info'),
                type: 'GET',
                success: function(response){
                    console.log(response);
                }

            });

            dislike();
            
            alert($(this).attr('data-info'));*/
        })
    }

    like();

    function dislike(){
       
        $('.btn-dislike').unbind('click').click(function(){
            $(this).addClass('btn-like').removeClass('btn-dislike'); //cambia  clase
            $(this).attr('src',url+'/img/heart-black.png'); //cambia atributo

        /*    $.ajax({
                url: url+'/dislike/'+$(this).attr('data-info'),
                type: 'GET',
                success: function(response){
                    console.log(response);
                }

            });

            like();
            alert($(this).attr('data-info'));*/
        })
    }

    dislike();

});

