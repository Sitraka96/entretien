$(function(){
    $('#btn-init').click(function(){
        $('#ce').html('<p class="text-center"><i class="fas fa-spinner fa-pulse"></i></p>');
        $.post('data/init',function(res){
            $('#ce').html(res);
        })
    })
    $('#btn-purge').click(function(){
        $('#ce').html('<p class="text-center"><i class="fas fa-spinner fa-pulse"></i></p>');
        $.post('data/purgeTable',function(res){
            $('#ce').html(res);
        })
    })
})