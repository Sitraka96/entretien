$(function(){
    // $('#cchart').html('');
    var iEnCours='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',sEnCours=iEnCours+'<span class="pl-2">En cours ...</span>';
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
    $('#cau button.dropdown-item').on('click',function(){
        $('#ddau').html(sEnCours);
        $('#cchart').html('');
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
            $('#cau').attr('sau',aui);
            $('#ddau').text(aut);
            $('#cnp').html(s);
        },'json')
    })
    $('#cnp').on('click','.dropdown-menu button.dropdown-item',function(){
        var item=$(this),nivt=item.text(),n=item.attr('n'),p=item.attr('p'),au=$('#cau').attr('sau');
        var params={au:au,niv:n,gp:p};
        $('#ddniv').html(sEnCours);
        $('#cchart').html('');
        $.post('/Statistique/getCheckData', params,function(res) {
            $('#cchart').html('<canvas id="myChart"></canvas>');
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: res.label,
                    datasets: [{
                        label: nivt,
                        borderColor: '#119ea8',
                        data: res.data
                    }]
                },
                options: {
                    scales: {
                      yAxes: [{
                        ticks: {
                          min: 0,
                          reverse: false,
                          stepSize: 5
                        },
                      }]
                    }
                }
            });
            $('#ddniv').text(nivt);                    
        },'json');
    })


    
    
})