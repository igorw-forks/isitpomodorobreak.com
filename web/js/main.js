jQuery(document).ready(function() {

    setInterval( function() {
        var time = parseInt($("#time").html(), 10),
            newTime = new Date(time*1000),
            hours    = newTime.getHours(),
            minutes  = newTime.getMinutes(),
            seconds  = newTime.getSeconds();
        if((minutes >= 25 && minutes <= 29) || minutes >= 55 && minutes <= 59) {
            $("#status").attr('class', 'yes').html('yes');
        } else if(minutes == 26 || minutes == 0) {
            $("#status").attr('class', 'no').html('no');
        }
        $("#time").html(time+1);
    },1000);

});