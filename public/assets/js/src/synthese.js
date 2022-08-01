$(function(){
    $('#selectClasse').select2();
    var debut = $('#debut'), fin = $('#fin');
    const format = num => { a=String(num).replace(/(?<!\..*)(\d)(?=(?:\d{3})+(?:\.|$))/g, '$1 '); return a.replace('.',','); };
    // $('#searchNie').on('click', function(){
    //     if(debut.val() == '' || fin.val() == ''){
    //         toastr.error('Veuillez sélectionner des dates !');
    //     }else{
    //         $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    //         $.post('/synthese/getStudent',{nie:$('#nie').val()}, function(res){
    //             $('#searchNie').html('<i class="bi bi-search"></i>');
    //         }, 'JSON')
    //     }
    // })

    // $(document).on("keypress", "#nie", function(e){
    //     if(e.which == 13){
    //         if(debut.val() == '' || fin.val() == ''){
    //             toastr.error('Veuillez sélectionner des dates !');
    //         }else{
    //             $('#searchNie').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    //             $.post('/synthese/getStudent',{nie:$('#nie').val()}, function(res){
    //                 $('#searchNie').html('<i class="bi bi-search"></i>');
    //             }, 'JSON')
    //         }
    //     }
    // });
    $('#btnRecherche').on('click', function() {
        var d = new Date(debut.val()), f = new Date(fin.val());
        var f = $('#filtre').find(':selected').val() == 'FS' ? 'F.S' : $('#filtre').find(':selected').val() == 'DI' ? 'D.I' : 'Tous';
        if(debut.val() == '' || fin.val() == '' || $('#selectStudent').find(':selected').val() == 'Etudiants...'){
            toastr.error('Veuillez vérifier les données !');
        }else{
            if(d.valueOf() > f.valueOf()){
                toastr.error('Veuillez vérifier les dates !');
            }else{
                $.post('/synthese/getPercu', {filtre:f, matr : $('#selectStudent').find(':selected').val(), debut: debut.val(), fin:fin.val()}, function(res){
                    var student = res.student, percu = res.percu, reste = res.reste;
                    if(reste.length == 0){
                        toastr.info('Montant encore vide !')
                    }else{
                        $('#nom').html(student[0].nom+' '+student[0].prenom)
                        $('#nie').html(student[0].nom_niv+''+student[0].nom_gp+' - '+student[0].nie)
                        $('#montant').html('<b>'+format(percu[0].total_percu)+'</b> Ariary')
                        $('#reste').html('<b>'+format(reste[0].reste)+'</b Ariary>')
                        toastr.success('Information bien chargé !')
                    }
                }, 'JSON')
            }
        }
    })
    $('#selectStudent').on('change', function(){
        var d = new Date(debut.val()), f = new Date(fin.val());
        var f = $('#filtre').find(':selected').val() == 'FS' ? 'F.S' : $('#filtre').find(':selected').val() == 'DI' ? 'D.I' : 'Tous';
        if(debut.val() == '' || fin.val() == ''){
            toastr.error('Veuillez sélectionner des dates !');
        }else{
            if(d.valueOf() > f.valueOf()){
                toastr.error('Veuillez vérifier les dates !');
            }else{
                $.post('/synthese/getPercu', {filtre:f, matr : $(this).find(':selected').val(), debut: debut.val(), fin:fin.val()}, function(res){
                    var student = res.student, percu = res.percu, reste = res.reste;
                    if(reste.length == 0){
                        toastr.info('Montant encore vide !')
                    }else{
                        $('#nom').html(student[0].nom+' '+student[0].prenom)
                        $('#nie').html(student[0].nom_niv+''+student[0].nom_gp+' - '+student[0].nie)
                        $('#montant').html('<b>'+format(percu[0].total_percu)+'</b> Ariary')
                        $('#reste').html('<b>'+format(reste[0].reste)+'</b> Ariary')
                        toastr.success('Information bien chargé !')
                    }
                }, 'JSON')
            }
        }
    })

})