$(function(){
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
        var item=$(this),nivt=item.text(),n=item.attr('n'),p=item.attr('p'),
        au=$('#cau').attr('sau');
        $('#ddniv').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> En cours ...');
        $.post('/etudiant/getLsCmps',{au:au,niv:n,gp:p},
            function(data) {
                var res='',nbE=data.length,nbH=0,nbF=0;
                data.forEach((item,i) => {
                    if (item.sexe=='1') { nbH++;} else { nbF++;}
                    res+=getView(i,item);
                });
                $('#hau').val(au);$('#hniv').val(n);$('#hgp').val(p);$('#hnau').val($('#ddau').text());$('#hnniv').val(nivt);
                $('#ceih').html('<em> Efféctifs en <span class="text-danger">'+nivt+'</span> : '+nbE+' (<span class="text-boys"> Homme : '+nbH+'</span> , <span class="text-girls">Femme : '+nbF+'</span> )</em>');
                $('#cei').html(res);
                $('#cnp').attr('n',n).attr('p',p);
                $('#ddniv').text(nivt);
                $('#btn_adds').removeClass('d-none').addClass('d-inline-block');
                $('#btn_prints').removeClass('d-none').addClass('d-inline-block');
        },'json');
    })

    
    $('#cau button.dropdown-item').on('click',function(){
        $('#au_ico').addClass("fa fa-spinner fa-spin mr-2 text-primary");
        $('#ceih').html('<i>Efféctifs : ?</i>');
        $('#cei').html('');
        var aui=$(this).attr('ai'),aut=$(this).text();
        $.post('/etudiant/check_niv',{id:aui},function(res){
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
                        v+='<button class="dropdown-item " n='+el.ni+' p='+el.pi+'>'+el.niv+' '+el.gp+'</button>';
                    }
                }else{
                    v+='<button class="dropdown-item" >vide</button>';
                }
                s+=v+'</div></div>';
            }
            $('#btn_adds').removeClass('d-inline-block').addClass('d-none');
            $('#btn_prints').removeClass('d-inline-block').addClass('d-none');
            $('#cau').attr('sau',aui);
            $('#ddau').text(aut);
            $('#au_ico').removeClass("fa fa-spinner fa-spin mr-2 text-primary");
            $('#cmigrate').html(s);
            $('#cnp').html(s);
        },'json')
    })

    function getView(index,ei){
        index++;ei.sexe=(ei.sexe=='1')?'H':'F';
        return '<tr>'+
        '<th scope="row" data-nm="'+ei.num_matr+'" data-ne="'+ei.nie+'">'+index+'</th>'+
        '<td>'+ei.nie+'</td>'+
        '<td>'+ei.pwd+'</td>'+
        '<td>'+ei.nom+'</td>'+
        '<td>'+ei.prenom+'</td>'+
        '<td>'+ei.sexe+'</td>'+
        '<td class="text-center"><button class="btn btn-sm btn-outline-warning btn-edit"><svg width="20" height="20"><use xlink:href="/assets/svg/list.svg#edit"></svg></button></td>'+
        '</tr>';
    }

    $('#cei').on('click','.btn-edit',function(){
        var parent=$(this).parents().eq(1);
        $('#nie').val(parent.find(':nth-child(2)').text());
        $('#nom').val(parent.find(':nth-child(4)').text());
        $('#prenom').val(parent.find(':nth-child(5)').text());
        $('#password').val(parent.find(':nth-child(3)').text());
        $('#cpassword').val(parent.find(':nth-child(3)').text());
        $('#nm').val(parent.find(':first-child').data('nm'))
        $('#ne').val(parent.find(':first-child').data('ne'));
        $('#password').focus();
    })
    $('#btn-aff').on('click',function(){
        var mm="Masquer MDP",am="Afficher MDP";
        if ($(this).text()==am) {
            $(this).text(mm).removeClass('btn-outline-warning').addClass('btn-outline-danger');
            $('#password').attr('type','text');
            $('#cpassword').attr('type','text');
        } else {
            $(this).text(am).removeClass('btn-outline-danger').addClass('btn-outline-warning');
            $('#password').attr('type','password');
            $('#cpassword').attr('type','password');
            
        }
    })

    $('#user-form').on('submit',function(e){
        e.preventDefault();
        var pwd=$('#password').val(),
            cpwd=$('#cpassword').val();
        if(pwd==cpwd){
            var params={pwd:pwd,cpwd:cpwd,nm:$('#nm').val(),ne:$('#ne').val()};
            $.post('/Etudiant/uptcmp',params,function(res){
                $('body').set_alert(res);
            },'json');
        }else{
            $(this).set_alert({color:'warning',message:'mot de passe incorrect !'});
        }
    });

    $('#btn_adds').on('click',function(){
        var item=$('#cnp'),n=item.attr('n'),p=item.attr('p'),
        au=$('#cau').attr('sau'),ls=[];
        $('#cei th').each(function(){
            ls.push($(this).data());
        })
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> En cours ...');
        $.post('/Etudiant/gererateCmps',{au:au,niv:n,gp:p,list:ls},function(data){
            console.log(data);
            var res='',nbE=data.length,nbH=0,nbF=0;
                data.forEach((item,i) => {
                    if (item.sexe=='1') { nbH++;} else { nbF++;}
                    res+=getView(i,item);
                });
                $('#ceih').html('<em> Efféctifs en <span class="text-danger">'+$('#ddniv').text()+'</span> : '+nbE+' (<span class="text-boys"> Homme : '+nbH+'</span> , <span class="text-girls">Femme : '+nbF+'</span> )</em>');
                $('#cei').html(res);
                $('#cnp').attr('n',n).attr('p',p);
                $('#btn_adds').html('Génerer compte').hide();
        },'json')
    })



})