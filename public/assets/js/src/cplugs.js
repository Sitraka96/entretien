(function($){
    var o={
        message:'deposez votre image ici'
    }
    $.fn.dropfile=function(oo){
        if(oo) $.extend(o,oo);
        this.each(function(){
            $('<span>').addClass('text-center font-italic').append(o.message).appendTo(this);
        });
    }
    $.fn.info=function(res){
        var c='<div class="alert alert-info alert-dismissible fade show" role="alert">'+
        '<p class="text-center my-0">'+res+'</p>'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $('#feedback').html(c);
        $('#feedback').fadeIn(()=>{
            setTimeout(()=>{
                $('#feedback').html('').fadeOut('slow');
            },2000);
        });
    }
    $.fn.danger=function(res){
        var c='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
        '<p class="text-center my-0">'+res+'</p>'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $('#feedback').html(c);
        $('#feedback').fadeIn(()=>{
            setTimeout(()=>{
                $('#feedback').html('').fadeOut('slow');
            },2000);
        });
    }
    $.fn.set_alert=function(res,ct='#feedback'){
        var c='<div class="alert alert-'+res.color+' alert-dismissible fade show" role="alert">'+
        '<p class="text-center my-0">'+res.message+'</p>'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $(ct).html(c);
        $(ct).fadeIn(()=>{
            setTimeout(()=>{
                $(ct).html('').fadeOut('slow');
            },2000);
        });
    }
   
    $.fn.reset_form=function(){
        $(':input').not(':button,:submit').val('').prop('selectedIndex',-1).prop('checked',false);
    }
    $.fn.isNotEmpty=function(){
        var isNE=true;
        $(this).find(':input[required]:visible').each(function(){
            if ($(this).val()=='') { isNE=false;return; }
        })
        return isNE;
    }


})(jQuery)