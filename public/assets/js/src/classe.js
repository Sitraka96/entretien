$(function(){
    var debut = $('#debut'), fin = $('#fin');
    const format = num => { a=String(num).replace(/(?<!\..*)(\d)(?=(?:\d{3})+(?:\.|$))/g, '$1 '); return a.replace('.',','); };
    $('#selectClasse').on('change', function(){
        var d = new Date(debut.val()), f = new Date(fin.val());
        var f = $('#filtre').find(':selected').val() == 'FS' ? 'F.S' : $('#filtre').find(':selected').val() == 'DI' ? 'D.I' : 'Tous';
        if(debut.val() == '' || fin.val() == ''){
            toastr.error('Veuillez sélectionner des dates !');
        }else{
            if(d.valueOf() > f.valueOf()){
                toastr.error('Veuillez vérifier les dates !');
            }else{
                $.post('/synthese/getPercuClasse', {filtre:f, id : $(this).find(':selected').val(), debut: debut.val(), fin:fin.val()}, function(res){
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