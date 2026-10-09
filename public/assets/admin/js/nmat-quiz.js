 $(document).ready(function() {
            $(".mynewcheck").click(function(){
                var mynewcheck = $(this).is(':checked');
                $(".mynewcheck1").click(function(){
                    var mynewcheck1 = $(this).is(':checked');
                    if((mynewcheck == true) && (mynewcheck1)){
                        $('.myCheckBox').removeAttr('disabled');
                    }else{
                        $('.myCheckBox').attr('disabled');
                    }
                }) 
            })
            $(".mynewcheck1").click(function(){
                var mynewcheck1 = $(this).is(':checked');
                $(".mynewcheck").click(function(){
                    var mynewcheck = $(this).is(':checked');
                    if((mynewcheck1 == true) && (mynewcheck)){
                        $('.myCheckBox').removeAttr('disabled');

                    }else{
                        $('.myCheckBox').attr('disabled');
                    }
                }) 
            })
        })


 
    


 