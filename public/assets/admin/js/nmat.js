	

$('.nextpage').click(function (){
             $('.newpage').css('display','block');
             $('.prepage').css('display','none');
             $('.sectionselection').css('display','none');
	     $('.nextpage').css('display','none');
	     $('.pre').css('display','block');
         })
         $('.selectpage').click(function (){
             $('.sectionselection').css('display','block');
             $('.newpage').css('display','none');
             $('.prepage').css('display','none');
	     $('.starttest').css('display','block');

         })
         $('.myButton').click(function (){
           
            $('.sectionselection').css('display','block');
            $('.newpage').css('display','none');
            $('.prepage').css('display','none');
         })

  CKEDITOR.replace('editor4', {
         fullPage: true,
         extraPlugins: 'docprops',
         // Disable content filtering because if you use full page mode, you probably
         // want to  freely enter any HTML content in source mode without any limitations.
         allowedContent: true,
         height: 520,
         WIDTH:200,
         removeButtons: 'PasteFromWord'
         });



  $(document).ready(function(){
             $('.submitpaper').click(function (){
                     var url1 = '{{route("student.savepaper")}}';
                     var test_id =  $('.testid').val();
                     var user_id =  $('.userid').val();
                     var paper_id =  $('.paperid').val();
                 $.ajax({
                 url: url1,
                 type: "POST",
                 data: {
                     _token: $("#csrf").val(),
                     test_id: test_id,
                     user_id: user_id,
                     paper_id: paper_id
                     },
                     cache: false,
                 success: function(dataResult){
                     console.log(dataResult);
                     var dataResult = JSON.parse(dataResult);
                     if(dataResult.statusCode==200){
                         //return false;
                     //location.reload(true);       
                     }
                     else if(dataResult.statusCode==201){
                     alert("Error occured !");
                     }
                     }
                 });
             });
         });



  $(document).ready(function() {
            $('.myCheckBox').on('change', function() {
                if ($(this).is(":checked")) {
                $('.myButton').removeAttr('disabled');
                }else{
                $('.myButton').attr('disabled','disabled');
                }
            });
            $('.myCheckBox1').on('change', function() {
                if ($(this).is(":checked")) {
                    $('.myButton').attr('disabled','disabled');
                }else{
                    $('.myButton').removeAttr('disabled');
                }
            });
        });