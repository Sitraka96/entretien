$(function(){
    //https://xdsoft.net/jqplugins/datetimepicker/
    $.datetimepicker.setLocale('fr');
    // $.datetimepicker.setDateFormatter({
    //     parseDate: function (date, format) {
    //         var d = moment(date, format);
    //         d.locale('fr');
    //         return d.isValid() ? d.toDate() : false;
    //     },
        
    //     formatDate: function (date, format) {
    //         var d=moment(date);
    //         d.locale('fr');
    //         return d.format(format);
    //     },
    
    //     //Optional if using mask input
    //     formatMask: function(format){
    //         return format
    //             .replace(/Y{4}/g, '9999')
    //             .replace(/Y{2}/g, '99')
    //             .replace(/M{2}/g, '19')
    //             .replace(/D{2}/g, '39')
    //             .replace(/H{2}/g, '29')
    //             .replace(/m{2}/g, '59')
    //             .replace(/s{2}/g, '59');
    //     }
    // });

    
    $('.form_date').datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });

    $('.datetime_business').datetimepicker({
        step:5,
        minTime:'08:00',
        maxTime: '17:00',
        format:'d/m/Y H:i',

    });

    $('#date_picker_start').datetimepicker({
     format:'d.m.Y H:i',
     minTime:'08:00',
     onShow:function( ct ){
      this.setOptions({
       maxDate:$('#date_picker_end').val()?$('#date_picker_end').val():false ,
       maxTime:$('#date_picker_end').val()==this.val()?$('#time_picker_end').val():false 
      })
     }
     
    });

    $('#date_picker_end').datetimepicker({
     format:'d.m.Y H:i',
     minTime:'08:00',
     onShow:function( ct ){
      this.setOptions({
       minDate:$('#date_picker_start').val()?$('#date_picker_start').val():false ,
       minTime:$('#date_picker_start').val()==this.val()?$('#time_picker_start').val():false
      })
     }
     
    });
    
    


    
})