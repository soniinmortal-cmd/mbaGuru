$( document ).ready(function(){

	$( document ).on( "change", ".input-numeric", function(){
    
    	  var parents = $( this ).parents( ".input-numeric-container" );
        var input = parents.find( ".input-numeric");
        var nonKeys = parents.find( ".key-del, .key-clear");
        var inputValue = input.val();
                
        if( inputValue == "" ){
        	nonKeys.prop( "disabled", true );
        } else {
        	nonKeys.prop( "disabled", false );
        }
        
    });

  
	$( document ).on( "click focus", ".input-numeric", function(){
    
    	  var parents = $( this ).parents( ".input-numeric-container" );
        var data = parents.attr( "data-numeric" );
    
        if( data ){
            if( data == "hidden" ){
               parents.find( ".table-numeric" ).show();
            }
        }
        
    });
  
    
    //key numeric
    $( document ).on( "click", ".key", function(){
      
        var parents = $( this ).parents( ".input-numeric-container" );
        var number = $( this ).attr( "data-key" );
        var input = parents.find( ".input-numeric");
        var inputValue = input.val();
        
        input.val( inputValue + number ).change();
        
    });
    
    
    //delete
    $( document ).on( "click", ".key-del", function(){
    
    	  var parents = $( this ).parents( ".input-numeric-container" );
        var input = parents.find( ".input-numeric");
        var inputValue = input.val();
        
        input.val( inputValue.slice(0, -1) ).change();
        
    });
    
    
    //clear
    $( document ).on( "click", ".key-clear", function(){
    
    	  var parents = $( this ).parents( ".input-numeric-container" );
        var input = parents.find( ".input-numeric");
        
        input.val( "" ).change();
        
    });

});