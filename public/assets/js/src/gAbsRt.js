$(function(){
    var TF="HH:mm";
    $.datetimepicker.setLocale('fr');
    $('.form_date').datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });

    $('.form_time').datetimepicker({
        datepicker:false,
        step:15,
        format:'H:i',
        minTime:'07:00',
        maxTime: '18:30'
    });

    $.typeahead({
        input:'#txtMat',
        minLength:3,
        maxItem:20,
        order:'asc',
        display:['value'],
        template:'{{value}}',
        // hint:true,
        searchOnFocus: true,
        // blurOnTab: false,
        emptyTemplate: 'Aucun résultat trouvé : {{query}}',
        source: {
           matiere:{
               ajax:{
                   type:'POST',
                   url:'/Retard/getListMats',
               }
           }
        },
        debug: true,
        callback: {
            onClick: function (node,res,sel) {
                $('#txtMat').data('id',sel.id);
            }
        }
    });
    $.typeahead({
        input:'#txtProf',
        minLength:3,
        maxItem:20,
        order:'asc',
        display:['fullname'],
        template:'{{fullname}}',
        // hint:true,
        searchOnFocus: true,
        // blurOnTab: false,
        emptyTemplate: 'Aucun résultat trouvé : {{query}}',
        source: {
           matiere:{
               ajax:{
                   type:'POST',
                   url:'/Retard/getListProfs',
               }
           }
        },
        debug: true,
        callback: {
            onClick: function (node,res,sel) {
                $('#txtProf').data('id',sel.id);
            }
        }
    });

    $('div.dropdown').on('click','.dropdown-menu button.dropdown-toggle', function(e) {
        if (!$(this).next().hasClass('show')) {
          $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        $(this).next(".dropdown-menu").toggleClass('show');
        $('div.dropdown.show').on('hidden.bs.dropdown', function(e) {
          $('.dropdown-submenus .show').removeClass("show");
        });
        return false;
    });

   

    $('#cnp').on('click','.dropdown-menu button.dropdown-item',function(){
        var item=$(this);
        $('#ddniv').text(item.text()).data({n:item.data('n'),p:item.data('p')});
    })

    $('#csal button.dropdown-item').on('click',function(){
        var item=$(this);
        $('#ddsal').text(item.text()).data('id',item.data('id'));
    })
    $('#ctp button.dropdown-item').on('click',function(){
        var item=$(this);
        $('#ddtp').text(item.text()).data('id',item.data('id'));
    })

    $('#cmot').on('click','button.dropdown-item',function(){
        var item=$(this),id=item.data('id');
        $('#ddmot').text(item.text()).data('id',id);
        if (id=='-1') {
            $('#cautre').remove();
            var s='<div id="cautre" class="input-group form-group col-12 col-md-7 col-lg-3">'+
            '<div class="input-group-prepend">'+
              '<span class="input-group-text" >Motif<em class="text-danger pl-1">*</em></span>'+
            '</div>'+
            '<input type="text"  id="txtmotif" class="form-control" required>'+
            '<div class="input-group-append">'+
              '<button id="btncclose" class="btn btn-danger">X</button>'+
            '</div>'+
          '</div>';
          $('#cmotif').after(s);
        }else{
            $('#cautre').remove();
        }
    })

    $('#ccontaint').on('click','#btncclose',function(){
        $('#ddmot').html('MOTIFS<em class="text-danger px-1">*</em>').removeData('id');
        $('#cautre').remove();
    })

    $('#cau button.dropdown-item').on('click',function(e){
        e.preventDefault();
        $('#au_ico').addClass("fa fa-spinner fa-spin mr-2 text-primary");
        var item=$(this);
        var id=item.data('id');
        $.post('/etudiant/check_niv',{id:id},function(res){
            var s='';
            for (const i in res) {
                const item=res[i];
                s+='<div class="dropdown-submenus">'+
                '<button class="dropdown-item dropdown-toggle">'+i+'</button>'+
                    '<div class="dropdown-menu">';
                var v='';
                if (item.length>0) {
                    for(const j in item){
                        const el=item[j];
                        v+='<button class="dropdown-item " data-n='+el.ni+' data-p='+el.pi+'>'+el.niv+' '+el.gp+'</button>';
                    }
                }else{
                    v+='<button class="dropdown-item" >vide</button>';
                }
                s+=v+'</div></div>';
            }
            $('#ddau').text(item.text()).data('id',id);
            $('#au_ico').removeClass("fa fa-spinner fa-spin mr-2 text-primary");
            $('#cnp').html(s);
        },'json')
    })
  
    function getView(ei){
        return '<tr class="bg-primary">'+
            '<th scope="row">1</th>'+
            '<td>'+ei.nie+'</td>'+
            '<td class="text-weight-bold">'+ei.nom+'</td>'+
            '<td>'+ei.prenom+'</td>'+
            '<td>'+ei.sexe+'</td>'+
        '</tr>';
    }

    $('#btn_verifier').click(function(){
        
        var ne=$('#ne').val(),a=$('#ddau').data('id'),np=$('#ddniv'),n=np.data('n'),p=np.data('p');
        if (ne===''|| n===undefined || p===undefined) {
            $(this).set_alert({color:'danger',message:'veuillez-remplir les champs obligatoires !'});
            return;
        } 
        $('#check-ico').addClass("fa fa-spinner fa-spin mr-2");
        $.post('/Retard/check_e',{token:$('#token').val(),ne:ne,a:a,n:n,p:p},function(res){
            var c='',data=res.data;
            $('#check-ico').removeClass("fa fa-spinner fa-spin mr-2");
            if (data) {
                c=getView(data);
                $('#inc').data({nm:data.nm,ne:data.nie});
            }
            $(this).set_alert(res);
            $('#cei').html(c);
            
        },'json');
    })

    $('#btnValider').click(function(){
        var fc=$('#inc'),nm=fc.data('nm'),ne=fc.data('ne'),dc=$('#dc').val(),st=$('#st').val(),et=$('#et').val(),
        mat=$('#txtMat').data('id'),prof=$('#txtProf').data('id'),sal=$('#ddsal').data('id'),tpi=$('#ddtp').data('id'),moti=$('#ddmot').data('id'),smot='';
        if(nm!==undefined && ne!==undefined && sal!==undefined && mat!==undefined && prof!==undefined && moti!==undefined && tpi!==undefined && dc!='' && st!='' && et!=''){
            $('#cmodal').modal('show');
        }else{
            $(this).set_alert({color:'danger',message:'Remplissez les champs obligatoires et cochez pour confirmation !'});
        }
        
    });

    $('#btn_confirm').click(function(){
        var fc=$('#inc'),nm=fc.data('nm'),ne=fc.data('ne'),dc=$('#dc').val(),st=$('#st').val(),et=$('#et').val(),
        mat=$('#txtMat').data('id'),prof=$('#txtProf').data('id'),sal=$('#ddsal').data('id'),tpi=$('#ddtp').data('id'),moti=$('#ddmot').data('id'),smot='';
        if (moti=='-1') {smot=$('#txtmotif').val();}
        $('#cmodal').modal('hide');
        var params={
        token:$('#token').val(),nm:nm,ne:ne,mat:mat,prof:prof,sal:sal,dc:dc,st:st,et:et,tpi:tpi,moti:moti,smot:smot};
        $.post('/Retard/store',params,function(res){
            $(this).set_alert(res);
        },'json')
    })

    $('#cmodal').on('hidden.bs.modal',function(e){
        $('#c_txt').html('');
    })

})