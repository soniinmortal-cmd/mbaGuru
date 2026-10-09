$(document).ready(function(){
    $('#button-group button').click(function(){
$(this).addClass('active').siblings().removeClass('active');
    });
    $(".dropdown-menu").on("click","#li-box-style #booked", function(e){
        e.preventDefault();
        console.log("#li-box-style #booked");
        $('.dropdown-menu').addClass('show');
        $('#booked').html('booked');
        $('.booked-style').show();
            });
            
});