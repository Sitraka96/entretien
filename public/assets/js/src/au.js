$(function(){
    $('#au').prop('selectedIndex',-1);
    $('#btnValider').click(function(){
        var au=$('#au :selected').val(),ls=[];
        $('input:checked').each(function(){
            ls.push({ni:$(this).attr('inv'),gi:$(this).attr('igp')});
        });
        if (au==undefined || ls.length==0) {
            $(this).set_alert({color:'warning',message:'Veuillez-remplir les champs obligatoires!'});
            return;
        }
        $.post('/Au/check',{au:au,data:ls},function(res){
            $(this).set_alert(res)
        },'json')
    })
})