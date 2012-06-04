jQuery(document).ready(function() {

    setInterval( function() {
        var time = parseInt($("#time").html(), 10),
            newTime,
            hours,
            minutes,
            seconds;

        if(isNaN(time)) {
            newTime = new Date();
        } else {
            newTime = new Date(time * 1000);
        }

        hours    = newTime.getHours();
        minutes  = newTime.getMinutes();
        seconds  = newTime.getSeconds();

        if((minutes >= 25 && minutes <= 29) || minutes >= 55 && minutes <= 59) {
            $("#status").attr('class', 'yes').html('yes');
            document.title = 'Is it Pomodoro break? Yes, it is!';
        } else if(minutes == 30 || minutes == 0) {
            $("#status").attr('class', 'no').html('no');
            document.title = 'Is it Pomodoro break? No, it isn\'t!';
        }
        $("#time").html(time+1);
    },1000);

});