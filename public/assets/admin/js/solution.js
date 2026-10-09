

    $(document).ready(function() {

    	$('.ques1').css('display','block');
    	$('.cns1').css('display','block');
     	$('.avg1').css('display','block');
    	$('.posti1').css('display','block');
    	$('.negti1').css('display','block');
    	var timevalue5 = $('.uti1').val();
	    $('.showusertime').text(timevalue5);
	    $('.answer').click(function(){
		var val = $(this).attr('data-value');
		$('.qusn').css('display','none');
		$('.ques'+val).css('display','block');
	    $('.newavg').css('display','none');
        $('.avg'+val).css('display','block');
		$('.corretans').css('display','none');
		$('.cns'+val).css('display','block');
		$('.pos').css('display','none');
		$('.posti'+val).css('display','block');
		$('.neg').css('display','none');
		$('.negti'+val).css('display','block');
		$('.expt').attr('data-set',val);
		$('.exptt').attr('data-set',val);
		$('.nxt').attr('data-ntx',val);
	    var timevalue = $('.uti'+val).val();
	    $('.showusertime').text(timevalue);
		var ct = $('.nxt').attr('data-ntx');
		var total = $('.nxt').attr('data-total');
        var	ctl = 0;
		$('.nxt').click(function(){
	
			ct ++;
    	   if(total<ct)
    		{
			    ctl++;
			   //$('.nxt').attr("disabled");
				$('.qusn').css('display','none');
				$('.ques'+ctl).css('display','block');
				$('.anstime').css('display','none');
    			$('.ansti'+ctl).css('display','block');
    			$('.corretans').css('display','none');
    			$('.cns'+ctl).css('display','block');
    			$('.pos').css('display','none');
    			$('.posti'+ctl).css('display','none');
    			$('.neg').css('display','none');
    			$('.negti'+ctl).css('display','block');
    			$('.expt').attr('data-set',ctl);
    			$('.exptt').attr('data-set',ctl);
    			$('.newavg').css('display','none');
          		$('.avg'+ctl).css('display','block');
          	    var timevalue1 = $('.uti'+ctl).val();
          	    console.log(timevalue1,"timevalue1");
	            $('.showusertime').text(timevalue1);
			   
    		}else{
    			$('.qusn').css('display','none');
    			$('.ques'+ct).css('display','block');
    			$('.anstime').css('display','none');
    			$('.ansti'+ct).css('display','block');
    			$('.corretans').css('display','none');
    			$('.cns'+ct).css('display','block');
    			$('.pos').css('display','none');
    			$('.posti'+ct).css('display','none');
    			$('.neg').css('display','none');
    			$('.negti'+ct).css('display','block');
    			$('.expt').attr('data-set',ct);
    			$('.exptt').attr('data-set',ct);
    			$('.newavg').css('display','none');
          		$('.avg'+ct).css('display','block');
          		 var timevalue2 = $('.uti'+ct).val();
          		  console.log(timevalue2,"timevalue2");
	            $('.showusertime').text(timevalue2);
    	     }

		})
	})

});

var ct =1;
$(document).ready(function() {
	$('.ques1').css('display','block');
	$('.ansti1').css('display','block');
	$('.cns1').css('display','block');
	$('.avg1').css('display','block');	
	$('.posti1').css('display','block');	
	$('.negti1').css('display','block');
	$('.nxt').click(function(){
		ct +=1;
		$('.qusn').css('display','none');
		$('.ques'+ct).css('display','block');
		$('.anstime').css('display','none');
		$('.ansti'+ct).css('display','block');
			$('.corretans').css('display','none');
			$('.cns'+ct).css('display','block');
			$('.expt').attr('data-set',ct);
			$('.exptt').attr('data-set',ct);
			$('.pos').css('display','none');
			$('.posti'+ct).css('display','block');
			$('.neg').css('display','none');
			$('.negti'+ct).css('display','block');
			$('.newavg').css('display','none');
      		$('.avg'+ct).css('display','block');
			var chcs = $('.ques'+ct).css('display');
				 var timevalue3 = $('.uti'+ct).val();
				  console.log(timevalue3,"timevalue3");
	            $('.showusertime').text(timevalue3);
		if(chcs == undefined){
		    	$('.qusn').css('display','none');
				$('.ques1').css('display','block');
					$('.anstime').css('display','none');
					$('.ansti1').css('display','block');
					$('.corretans').css('display','none');
					$('.cns1').css('display','block');
					$('.pos').css('display','none');
					$('.posti1').css('display','block');
					$('.neg').css('display','none');
					$('.negti1').css('display','block');
					$('.expt').attr('data-set','1');
					$('.exptt').attr('data-set','1');
					$('.newavg').css('display','none');
      				$('.avg1').css('display','block');
				
				ctt =1;
			$('.nxt').click(function(){
					ctt +=1;
					$('.qusn').css('display','none');
					$('.ques'+ctt).css('display','block');
					$('.anstime').css('display','none');
					$('.ansti'+ctt).css('display','block');
					$('.corretans').css('display','none');
					$('.cns'+ctt).css('display','block');
					$('.pos').css('display','none');
					$('.posti'+ctt).css('display','block');
					$('.neg').css('display','none');
					$('.negti'+ctt).css('display','block');
					$('.expt').attr('data-set',ctt);
					$('.exptt').attr('data-set',ctt);
					$('.newavg').css('display','none');
      				$('.avg'+ctt).css('display','block');
      				var timevalue4 = $('.uti'+ctt).val();
	                $('.showusertime').text(timevalue4);
	                	  console.log(timevalue4,"timevalue4");
			})
				
		}
	})
})

$(document).ready(function() {
	$('.ansti1').css('display','block');
	$('.answer').click(function(){
		var val = $(this).attr('data-value');
		$('.anstime').css('display','none');
		$('.ansti'+val).css('display','block');
	})
});

$(document).ready(function() {
	$('.expt').click(function(){
		var set = $(this).attr('data-set');
		if(set){
			//console.log(set)
			$('.expl').css('display','none');
			$('.excp'+set).css('display','block');
		}else{
			$('.excp1').css('display','block');
		}
	})
})

$(document).ready(function() {
	$('.exptt').click(function(){
		var set = $(this).attr('data-set');
		console.log(set,"set");
		if(set){
			//console.log(set)
			$('.cre').css('display','none');
			$('.crtc'+set).css('display','block');
		}else{
			$('.crtc1').css('display','block');
		}
	})
})

$(document).ready(function() {
	    $('.verbal').click(function(){
		$('.verbal').css('display','none');
		$('.showsection').css('display','block');
	})
})

$(document).ready(function() {
	$('.showcol').click(function(){
		var cls = $('.showdata').css('background-color');
		//var cls1 = $('.red').attr('class');
		console.log(cls);
		//console.log(cls1);
	})
});