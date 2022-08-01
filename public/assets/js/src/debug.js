$(function(){
    $('#dfrm').on('submit',(e)=>{
        e.preventDefault();
        $.post('/Debug/InscrE',{nie:$('#nie').val()},(res)=>{
            $(this).set_alert(res);
        },'json')
    })
})