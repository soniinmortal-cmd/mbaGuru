


//localstoretime old correct
// $(document).ready(function(event) {
//   var datatime = $('.countdown').attr('data-time'); 
//   var timer2 = datatime+":0";
//   //var timer2 = "0:10";
  
//     var timer = timer2.split(':');
//     //by parsing integer, I avoid all extra string processing
  
//   if(typeof localStorage.getItem("minutes") !== 'undefined' && typeof localStorage.getItem("seconds") !== 'undefined' && localStorage.getItem("minutes")!= null && localStorage.getItem("seconds")!= null ){
//           var minutes = localStorage.getItem("minutes");
//           var seconds = localStorage.getItem("seconds");
//       }
//       else {
//         var minutes = parseInt(timer[0], 10);
//         var seconds = parseInt(timer[1], 10);
//       }
  
  
  
//     var interval = setInterval(function() {
//         localStorage.setItem("minutes", minutes);
//         localStorage.setItem("seconds", seconds);
  
//     --seconds;
//     minutes = (seconds < 0) ? --minutes : minutes;
//     if (minutes < 0) clearInterval(interval);
//   if(minutes == 0 && seconds ==0){
//   $('#myModal').modal('show');
  
//   }
//     seconds = (seconds < 0) ? 59 : seconds;
//     seconds = (seconds < 10) ? '0' + seconds : seconds;
//     //minutes = (minutes < 10) ?  minutes : minutes;
   
//     if(minutes == -1 && seconds ==59){
//      $('.countdown').html('0:00'); 
//     }else{
//       $('.countdown').html(minutes + ':' + seconds);
//     }
//      if(minutes > 0 && seconds <=59){
//           document.onkeydown = function (e) {
//          // return false;
//           }
//           if(minutes > 0 || seconds <=59){
//             //  window.location.reload();
//             //   window.stop();        
//           }
//       }
//     timer2 = minutes + ':' + seconds;
  
//   }, 1000);
  
//   // Handle button click for redirection
 
          
//   });
//localstoretime old correct end

//localstoretime new 
$(document).ready(function () {
    var datatime = $('.countdown').attr('data-time');
    var timer2 = datatime + ":0";
    var timer = timer2.split(':');

    var minutes, seconds;

    if (localStorage.getItem("minutes") !== null && localStorage.getItem("seconds") !== null) {
        minutes = parseInt(localStorage.getItem("minutes"), 10);
        seconds = parseInt(localStorage.getItem("seconds"), 10);
    } else {
        minutes = parseInt(timer[0], 10);
        seconds = parseInt(timer[1], 10);
    }

    var interval = setInterval(function () {
        localStorage.setItem("minutes", minutes);
        localStorage.setItem("seconds", seconds);

        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) clearInterval(interval);

        if (minutes === 0 && seconds === 0) {
            $('#myModal').modal('show');
        }

        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;

        if (minutes === -1 && seconds === 59) {
            $('.countdown').html('0:00');
        } else {
            $('.countdown').html(minutes + ':' + seconds);
        }

        // Remove unnecessary event interference
        timer2 = minutes + ':' + seconds;

    }, 1000);

    // Allow normal behavior for links
    $(document).on('click', 'a.da', function () {
        clearInterval(interval); // Clear the timer on button click if necessary
        localStorage.removeItem("minutes");
        localStorage.removeItem("seconds");
    });
});

// $(document).ready(function () {
//     var datatime = $('.countdown').attr('data-time'); // Get the timer value
//     var timer2 = datatime + ":0"; // Initialize timer
//     var timer = timer2.split(':');
//     var minutes = parseInt(timer[0], 10);
//     var seconds = parseInt(timer[1], 10);

//     // Clear invalid or stale localStorage data
//     if (localStorage.getItem("minutes") === null || localStorage.getItem("seconds") === null || 
//         parseInt(localStorage.getItem("minutes"), 10) < 0 || 
//         parseInt(localStorage.getItem("seconds"), 10) < 0) {
//         localStorage.removeItem("minutes");
//         localStorage.removeItem("seconds");
//     }

//     // Use stored values if valid
//     if (localStorage.getItem("minutes") !== null && localStorage.getItem("seconds") !== null) {
//         minutes = parseInt(localStorage.getItem("minutes"), 10);
//         seconds = parseInt(localStorage.getItem("seconds"), 10);
//     }

//     // Countdown interval
//     var interval = setInterval(function () {
//         // Save current time in localStorage
//         localStorage.setItem("minutes", minutes);
//         localStorage.setItem("seconds", seconds);

//         // Decrease timer
//         --seconds;
//         if (seconds < 0) {
//             seconds = 59;
//             --minutes;
//         }

//         if (minutes < 0) {
//             clearInterval(interval); // Stop the timer
//             $('#myModal').modal('show'); // Show the modal
//         }

//         // Format and display the timer
//         var formattedSeconds = (seconds < 10) ? '0' + seconds : seconds;
//         $('.countdown').html(minutes + ':' + formattedSeconds);

//     }, 1000);

//     // Handle button clicks
//     $(document).on('click', 'a.da', function (e) {
//         clearInterval(interval); // Stop the timer
//         localStorage.removeItem("minutes"); // Clear localStorage
//         localStorage.removeItem("seconds");
//     });

//     // Clear timer on page unload (optional)
//     $(window).on('beforeunload', function () {
//         clearInterval(interval);
//         localStorage.removeItem("minutes");
//         localStorage.removeItem("seconds");
//     });
// });


//endlocalstoretime
  
 
  function dealSec (sec) {
      const timeRange = [...Array(60).keys()].reverse()
    const idxNow = timeRange.indexOf(sec)
      const idxNext = (idxNow + 1) % timeRange.length
      return timeRange[idxNext]
  }
  
  function dealMin(min, sec) {
      const timeRange = [...Array(60).keys()].reverse()
      if (sec === 59) {
        const idxNow = timeRange.indexOf(min)
          const idxNext = (idxNow + 1) % timeRange.length
          return timeRange[idxNext]
      }
      return min
  }
  
  function dealhour (hour, min, sec) {
    if (min === 59 && sec === 59) return hour - 1
      return hour
  }
  
  function render(hour, min, sec) {
    hour = ("00" + hour).slice(-2)
      min  = ("00" + min).slice(-2)
      sec  = ("00" + sec).slice(-2)
      
      $('.countdown').text(`${hour}:${min}:${sec}`)
  }
  //endchecktimer
  
  
  
//   $(document).ready(function() {
//       var sname = $(".qus").attr("data-snm");
//       $('.sname').text(sname);
//      $('.qus').click(function(){
//         var dataset = $(this).attr('data-set');
//          var setname = $(this).attr('data-snm');
//         $('.sname').text(setname);
//         //$('.sr'+dataset).click(function(){
//           // var setname = $(this).attr('data-snm');
//           //  $('.sname').text(setname);
  
//       // })
//      });
//   });
  
//   $(document).ready(function() {
//     $('.ans').click(function(){
  
//     var val = $(this).attr('data-value');

//     var main = $(this).attr('data-main');
//      $(this).val(main);
//      $(this).attr('checked',true);
//       if(val){
//             $('.sr'+val).css('background-color','green');
//       }
//     });
//     $(".ansi").keyup(function(){
//       var val1 = $(this).attr('data-value1');
//       $('.sr'+val1).css("background-color", "green"); 
//         $(".review").click(function(){
//           var rv1 =  $('.review').attr('data-review');
//           var type =   $('.re'+rv1).attr('type');
//          // $('.sr'+val1).css({background:'linear-gradient(green, purple)'});
//           if(type == 'text' || type == 'number'){
//             var val =  $('.re'+rv1).val();
//             if(val){
//             $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
         
//             }else{
//               $('.sr'+rv1).css('background-color','purple');
//             }
//          }else if(type == 'radio'){
//             let isChecked = $('.re'+rv1).is(':checked');
//             if(isChecked == true){
//              $('.sr'+rv1).css({background:'linear-gradient(green, purple)'});
          
//             }else{
//               $('.sr'+rv1).css('background-color','purple');
//             }
//          }
//       })
//     });
//      $(".ansi").click(function(){
//       var val1 = $(this).attr('data-value1');
//       //$('.sr'+val1).css("background-color", "green"); 
//       //$(".key").addClass('k'+val1);
//       $(".key").click(function(){
//          $('.sr'+val1).css("background-color", "green");
//           $('.review').attr('data-review',val1);
//          $(".review").click(function(){
//           var rv =  $('.review').attr('data-review');
//           var type =   $('.re'+rv).attr('type');
//          if(type == 'text' || type == 'number'){
//             var val =  $('.re'+rv).val();
//             if(val){
//             $('.sr'+rv).css({background:'linear-gradient(green, purple)'});
         
//             }else{
//               $('.sr'+rv).css('background-color','purple');
//             }
//          }else if(type == 'radio'){
//             let isChecked = $('.re'+rv).is(':checked');
//             if(isChecked == true){
//              $('.sr'+rv).css({background:'linear-gradient(green, purple)'});
          
//             }else{
//               $('.sr'+rv).css('background-color','purple');
//             }
//          }
  
  
//       })
//   })
//     });
//       $('.newkey').click(function(){
       
//          var valn = $(this).attr('data-n');
//           $('.sr'+valn).css("background-color", "green");
//           $('review').attr('data-key',valn);
//               $(".review").click(function(){
//               var dkey =   $(this).attr('data-review');
//               $('.sr'+dkey).css({background:'linear-gradient(green, purple)'});
//           })
//           $('.rev').attr('data-rev',valn);
//           $('.rev').click ( function(){
//               var rev = $(this).attr('data-rev');
//               var csr = $('.sr'+rev).css('background-color');
//               $('.re'+rev).val(''); 
//               $('.sr'+rev).css('background-color','red');
//               if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
//                  $('.sr'+rev).removeAttr("style");
//                  $('.sr'+rev).css('background-color','red');
//               }
              
//           })
//       })
    
//     $('.qus').click(function(){
//       var setrecord = $(this).attr('data-set');
//       $(this).css('background-color','red');
//     });
//   });
//   $(document).ready(function() {
//     $('.qus').click(function(){
//      var dataset = $(this).attr('data-set');
//       $('.question').hide();
//           $('.question' + dataset).show();
//      // });
//     });
//   });
  
//   $(document).ready(function() {
//     $('.qus ').click(function(){
//       var qst = $(this).attr('data-set');
//      $('.review').attr('data-review',qst);
//       $('.review').click(function(){
//         var dfg = $(this).attr('data-review');
//          var type =   $('.re'+dfg).attr('type');
//          if(type == 'text' || type == 'number'){
//             var val =  $('.re'+dfg).val();
//             if(val){
//             $('.sr'+dfg).css({background:'linear-gradient(green, purple)'});
//           // $('.sr'+dfg).css('background-color','purple');
//             }else{
//               $('.sr'+dfg).css('background-color','purple');
//             }
//          }else if(type == 'radio'){
//             let isChecked = $('.re'+dfg).is(':checked');
//             if(isChecked == true){
//              $('.sr'+dfg).css({background:'linear-gradient(green, purple)'});
//           // $('.sr'+dfg).css('background-color','purple');
//             }else{
//               $('.sr'+dfg).css('background-color','purple');
//             }
//          }
        
//         var cls = $('.sr'+dfg).css('background-color');
//          if(cls=='rgb(255, 0, 0)'){
//          $('.review').click(function (){
//             $('.review').css('background-color','white');
//              var rwv = $(this).attr('data-review');
//                 $('.sr'+rwv).css('background-color','red');
//           })
//          }
//       });
//     });
//   });
  
//   $(document).ready(function() {
//   $('.ans ').click(function(){
//       var review1 = $(this).attr('data-value');
//       $('.review').attr('data-review',review1);
//       $('.review').click(function(){
//         var dfeg = $(this).attr('data-review');
//          var type =   $('.re'+dfeg).attr('type');
      
//          if((type == 'text') || (type == 'number')){
//             var val =  $('.re'+dfg).val();
//             if(val){
//          $('.sr'+dfeg).css({background:'linear-gradient(green, purple)'});
//             }else{
//               $('.sr'+dfeg).css('background-color','purple');
//             }
//          }else if(type == 'radio'){
//             let isChecked = $('.re'+dfeg).is(':checked');
//             if(isChecked == true){
//               $('.sr'+dfeg).css({background:'linear-gradient(green, purple)'});
//             }else{
//               $('.sr'+dfeg).css('background-color','purple');
//             }
//          }
//       });
//     })
//   });
  
  
      $(document).ready(function() {
        var currentQuestion = 1;
        showQuestion(currentQuestion);
  
        $('.prev').click(function() {
          if (currentQuestion > 1) {
            currentQuestion--;
            showQuestion(currentQuestion);
          }
        });
  
        $('.next').click(function() {
          if (currentQuestion < $('.question').length) {
            currentQuestion++;
            showQuestion(currentQuestion);
          }
        });
  
        function showQuestion(questionNumber) {
          $('.question').hide();
          $('#question' + questionNumber).show();
        }
      });
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
  //simulate pressing of the button by removing
  //shadows and adding a thin black border
  function buttonPressedVisual(b) {
      $(b).css("-webkit-box-shadow", "0");
      $(b).css("-moz-box-shadow", "0");
      $(b).css("box-shadow", "initial");
      $(b).css("border", "1px solid #222");
      setTimeout(function() {
        $(b).css("-webkit-box-shadow", "0 3px 1px rgba(0,0,0,0.2),0 -2px 3px rgba(0,0,0,0.3) inset, 0 -2px 0 white inset");
        $(b).css("-moz-box-shadow", "0 3px 1px rgba(0,0,0,0.2),0 -2px 3px rgba(0,0,0,0.3) inset, 0 -2px 0 white inset");
        $(b).css("box-shadow", "0 3px 1px rgba(0,0,0,0.2),0 -2px 3px rgba(0,0,0,0.3) inset, 0 -2px 0 white inset");
        $(b).css("border", "0");
      }, 200);
    }
    //-----------------------------------------------
    // check if pressed key corresponds to a
    // calculator button
    // n -- negate; c -- clear (C); s -- sqrt; r -- 1/x
    function valid(key) {
      var validKeys = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0", ".", "=", "%", "+", "-", "*", "/", "Backspace", "Delete", "Enter", "n", "N", "c", "C", "s", "S", "r", "R"];
      if (validKeys.indexOf(key) > -1) return true;
      return false;
    }
    //-------------------------------
    function addDigit(key, strInput) {
      //allow 10 digits before dec point and
      // 5 after the dec point
      // if changing make sure to change
      // the next fuction (adding decimal point) too
      var b = 10; //before decimal point
      var a = 5; //after decimal point
      var str = "";
      var decPointIndex = null;
      if (strInput[0] === "-") b++;
      if (strInput.match(/\./) === null) {
        if (strInput === "0") {
          if (key !== "0") strInput = "";
          else return strInput;
        }
        if (strInput.length < b) strInput += key;
      } else {
        decPointIndex = strInput.indexOf(".");
        str = strInput.substring(decPointIndex + 1);
        if (str.length < a) strInput += key;
      }
      $("#inputScr").html(strInput);
      return strInput;
    }
    //-------------------------
    function addDecimalPoint(strInput) {
      //only take action if input string doesn't
      //have a decimal point
      if (strInput.match(/\./) === null) {
        var n = 11;
        if (strInput[0] === "-") n++;
        if (strInput.length < n) {
          if (strInput === "") strInput = "0";
          strInput += ".";
          $("#inputScr").html(strInput);
        }
      } //end of -- if there is no decimal point
      return strInput;
    }
    //------------------------
    // backspace
    function backspc(strInput) {
      if (strInput !== "") {
        var backspaceResultsInZero = (strInput.length === 2 && strInput[0] === "-") || strInput.length === 1;
        if (backspaceResultsInZero) strInput = "0";
        else strInput = strInput.substr(0, strInput.length - 1);
        $("#inputScr").html(strInput);
      }
      return strInput;
    }
    //-----------------------------
    // shorten the output string so the latest
    // data added would be displayed
    // extra data from the beginning of the string
    // is lost
    function fixOut(x) {
      if (x.length > 30) {
        x = x.substring(x.length - 30);
        x = "&laquo;" + x;
      }
      return x;
    }
    //-------------------------------
    //-------------------------
    $(document).ready(function() {
      //focus the window so the keystrokes can be registered without
      //having to click on the screen first
      window.focus();
    
      var strInput = ""; //entered number
      var strOutput = ""; //holds output data for sqrt and 1/x
      var printed = ""; //data printed in the output screen
      var result = 0; //final result calculated up to last + or -
      var tempResult = null; //result after last + or -
      var current = 0; //holds active value, ie. strInput, result or tempResult
      var operation = ""; //active operation, can be any operation
      var prevOp = ""; //can be empty, + or -, holds last used lower order operation
      var prevOpTwo = ""; //empty, * or /, holds last used higher order operation
      var percentage = 0; //number of percents to be calculated with %
      var memory = null; //memory, null if not active
      //--------------
      //clear endtry (CE)
      //---------------------
      function clearEntry() {
        strInput = "";
        current = 0;
        $("#inputScr").html("0");
        return;
      };
      //-----------------
      // deal with floating point error
      // and round the number to max of 5 digits after the decimal point
      // this is only for display purpose, calculations are done without rounding
      function fix(x) {
        x = Number(x);
        x = x.toFixed(5);
        x = Number(x);
        return x;
      }
      //-------------------------
      function negate() {
        if (strInput !== "0") {
          if (strInput !== "") {
            if (strInput[0] === "-") strInput = strInput.substring(1);
            else strInput = "-" + strInput;
            $("#inputScr").html(strInput);
          } else {
            current *= -1;
            $("#inputScr").html(fix(current));
          }
        };
      };
      //---------------
      // clear (C) - everything but memory
      function clear() {
        strInput = "";
        strOutput = "";
        current = 0;
        printed = "";
        result = 0;
        tempResult = null;
        operation = "";
        prevOp = "";
        prevOpTwo = "";
        percentage = 0;
        $("#outputScr").html("");
        $("#inputScr").html("0");
      }
      //-------------------
      // calculates expression containing *, /, sqrt, 1/x and %
      // example: in r+a/b*c*sqrt(d)+ it calculates
      // the a/b*c*sqrt(d) and adds it to previously calculated r
      // in that case result for a/b*c is stored in tempResult
      // and value of sqrt(d) is stored in current
      function checkPrevOpTwo() {
        switch (prevOpTwo) {
          case "":
            switch (prevOp) {
              case "":
                result = current;
                break;
              case "+":
                result += current;
                break;
              case "-":
                result -= current;
                break;
            }
            break;
          case "*":
            switch (prevOp) {
              case "":
                result = tempResult * current;
                break;
              case "+":
                result += tempResult * current;
                break;
              case "-":
                result -= tempResult * current;
                break;
            }
            break;
          case "/":
            switch (prevOp) {
              case "":
                result = tempResult / current;
                break;
              case "+":
                result += tempResult / current;
                break;
              case "-":
                result -= tempResult / current;
                break;
            }
            break;
        }
      }
      //--------------
      // calculates value of sqrt or 1/x into tempResult 
      function checkPrevOpTwoTemp() {
        switch (prevOpTwo) {
          case "":
            tempResult = current;
            break;
          case "*":
            tempResult *= current;
            break;
          case "/":
            tempResult /= current;
            break;
        }
      }
      //---------------
      // + 
      // if there was no previous operations or input set initial result 
      // depending on previous operations calculate tempResult and the overall result
      function add() {
        if (strInput === "" && operation === "" && current === 0) printed = "0+";
        else {
          if (strInput === "" && operation === "" && current !== 0) {
            printed = fix(current) + "+";
            result = current;
          } else {
            if (strInput !== "" && operation === "") {
              printed = strInput + "+";
              result = Number(strInput);
            } else {
              if (strInput !== "") current = Number(strInput);
              switch (operation) {
                case "+":
                  printed += fix(current) + "+";
                  result += current;
                  break;
                case "-":
                  printed += fix(current) + "+";
                  result -= current;
                  break;
                case "*":
                  printed += fix(current) + "+";
                  switch (prevOp) {
                    case "":
                      result = tempResult * current;
                      break;
                    case "+":
                      result += tempResult * current;
                      break;
                    case "-":
                      result -= tempResult * current;
                      break;
                  }
                  break;
                case "/":
                  if (current === 0) {
                    clear();
                    $("#inputScr").html("Cannot divide by zero");
                    return;
                  }
                  printed += fix(current) + "+";
                  switch (prevOp) {
                    case "":
                      result = tempResult / current;
                      break;
                    case "+":
                      result += tempResult / current;
                      break;
                    case "-":
                      result -= tempResult / current;
                      break;
                  }
                  break;
                case "sqrt":
                case "1/":
                  printed += strOutput + "+";
                  checkPrevOpTwo();
                  break;
                case "%":
                  printed += fix(percentage) + "%" + fix(current) + "+";
                  current = percentage * current / 100;
                  checkPrevOpTwo();
                  percentage = 0;
                  break;
              } // end of switch operation
            }
          }
        }
        current = result;
        $("#outputScr").html(fixOut(printed));
        $("#inputScr").html(fix(current));
        operation = "+";
        prevOp = "+";
        prevOpTwo = "";
        tempResult = null;
        strInput = "";
        strOutput = "";
      }
      //----------------
      // -
      // if there was no previous operations or input set initial result 
      // depending on previous operations calculate tempResult and the overall result
      function subtract() {
        if (strInput === "" && operation === "" && current === 0) printed = "0-";
        else {
          if (strInput === "" && operation === "" && current !== 0) {
            printed = fix(current) + "-";
            result = current;
          } else {
            if (strInput !== "" && operation === "") {
              printed = strInput + "-";
              result = Number(strInput);
            } else {
              if (strInput !== "") current = Number(strInput);
              switch (operation) {
                case "+":
                  printed += fix(current) + "-";
                  result += current;
                  break;
                case "-":
                  printed += fix(current) + "-";
                  result -= current;
                  break;
                case "*":
                  printed += fix(current) + "-";
                  switch (prevOp) {
                    case "":
                      result = tempResult * current;
                      break;
                    case "+":
                      result += tempResult * current;
                      break;
                    case "-":
                      result -= tempResult * current;
                      break;
                  }
                  break;
                case "/":
                  if (current === 0) {
                    clear();
                    $("#inputScr").html("Cannot divide by zero");
                    return;
                  }
                  printed += fix(current) + "-";
                  switch (prevOp) {
                    case "":
                      result = tempResult / current;
                      break;
                    case "+":
                      result += tempResult / current;
                      break;
                    case "-":
                      result -= tempResult / current;
                      break;
                  }
                  break;
                case "sqrt":
                case "1/":
                  printed += strOutput + "-";
                  checkPrevOpTwo();
                  break;
                case "%":
                  printed += fix(percentage) + "%" + fix(current) + "-";
                  current = percentage * current / 100;
                  checkPrevOpTwo();
                  percentage = 0;
                  break;
              } // end of switch operation
            }
          }
        }
        current = result;
        $("#outputScr").html(fixOut(printed));
        $("#inputScr").html(fix(current));
        operation = "-";
        prevOp = "-";
        prevOpTwo = "";
        tempResult = null;
        strInput = "";
        strOutput = "";
      }
      //----------------
      // Enter,  =  
      // calculate the final result
      function calculate() {
        if (strInput === "" && operation === "" && current !== "") return;
        if (strInput !== "" && operation === "") {
          printed = strInput + "=";
          result = Number(strInput);
        } else {
          if (strInput !== "") current = Number(strInput);
          switch (operation) {
            case "+":
              printed += fix(current) + "=";
              result += current;
              break;
            case "-":
              printed += fix(current) + "=";
              result -= current;
              break;
            case "*":
              printed += fix(current) + "="
              switch (prevOp) {
                case "":
                  result = tempResult * current;
                  break;
                case "+":
                  result += tempResult * current;
                  break;
                case "-":
                  result -= tempResult * current;
                  break;
              }
              break;
            case "/":
              if (current === 0) {
                clear();
                $("#inputScr").html("Cannot divide by zero");
                return;
              }
              printed += fix(current) + "="
              switch (prevOp) {
                case "":
                  result = tempResult / current;
                  break;
                case "+":
                  result += tempResult / current;
                  break;
                case "-":
                  result -= tempResult / current;
                  break;
              }
              break;
            case "sqrt":
            case "1/":
              printed += strOutput + "=";
              checkPrevOpTwo();
              break;
            case "%":
              printed += fix(percentage) + "%" + fix(current) + "=";
              current = percentage * current / 100;
              checkPrevOpTwo();
              percentage = 0;
              break;
          } // end of switch operation
        }
        current = result;
        $("#outputScr").html(fixOut(printed));
        $("#inputScr").html(fix(current));
        operation = "";
        result = 0;
        prevOp = "";
        prevOpTwo = "";
        tempResult = null;
        strInput = "";
        printed = "";
      }
      //---------------
      // multiplication *
      function multiply() {
        if (strInput === "" && operation === "" && current === 0) printed = "0*";
        else {
          if (strInput === "" && operation === "" && current !== 0) {
            printed = fix(current) + "*";
            tempResult = current;
          } else {
            if (strInput !== "" && operation === "") {
              printed = strInput + "*";
              tempResult = Number(strInput);
            } else {
              if (strInput !== "") current = Number(strInput);
              switch (operation) {
                case "+":
                case "-":
                  printed += fix(current) + "*";
                  tempResult = current;
                  break;
                case "*":
                  printed += fix(current) + "*";
                  tempResult *= current;
                  break;
                case "/":
                  if (current === 0) {
                    clear();
                    $("#inputScr").html("Cannot divide by zero");
                    return;
                  }
                  printed += fix(current) + "*";
                  tempResult /= current;
                  break;
                case "sqrt":
                case "1/":
                  printed += strOutput + "*";
                  checkPrevOpTwoTemp();
                  break;
                case "%":
                  printed += fix(percentage) + "%" + fix(current) + "*";
                  current = percentage * current / 100;
                  checkPrevOpTwoTemp();
                  percentage = 0;
                  break;
              } // end of switch operation
            }
          }
        }
        current = tempResult;
        $("#outputScr").html(fixOut(printed));
        $("#inputScr").html(fix(current));
        operation = "*";
        prevOpTwo = "*";
        strInput = "";
        strOutput = "";
      }
      //----------------
      // division /
      // report error if user trys to 
      // divide by zero
      function divideBy() {
    
        if (strInput === "" && operation === "" && current === 0) printed = "0/";
        else {
          if (strInput === "" && operation === "" && current !== 0) {
            printed = fix(current) + "/";
            tempResult = current;
          } else {
            if (strInput !== "" && operation === "") {
              printed = strInput + "/";
              tempResult = Number(strInput);
            } else {
              if (strInput !== "") current = Number(strInput);
              switch (operation) {
                case "+":
                case "-":
                  printed += fix(current) + "/";
                  tempResult = current;
                  break;
                case "*":
                  printed += fix(current) + "/";
                  tempResult *= current;
                  break;
                case "/":
                  if (current === 0) {
                    clear();
                    $("#inputScr").html("Cannot divide by zero");
                    return;
                  }
                  printed += fix(current) + "/";
                  tempResult /= current;
                  break;
                case "sqrt":
                case "1/":
                  printed += strOutput + "/";
                  checkPrevOpTwoTemp();
                  break;
                case "%":
                  printed += fix(percentage) + "%" + fix(current) + "/";
                  current = percentage * current / 100;
                  checkPrevOpTwoTemp();
                  percentage = 0;
                  break;
              } // end of switch operation
            }
          }
        }
        current = tempResult;
        $("#outputScr").html(fixOut(printed));
        $("#inputScr").html(fix(current));
        operation = "/";
        prevOpTwo = "/";
        strInput = "";
        strOutput = "";
      }
      //---------------------
      // square root
      // report error if user is trying to calculate
      // a square root of a negative number
      function squareRoot() {
        if (strInput !== "") current = Number(strInput);
        if (current < 0) {
          clear();
          $("#inputScr").html("Invalid input");
          return;
        }
        if (operation === "%") {
          strOutput = "sqrt(" + fix(percentage) + "%" + fix(current) + ")";
          current = percentage * current / 100;
          current = Math.sqrt(current);
          percentage = 0;
        } else {
          strOutput = "sqrt(" + fix(current) + ")";
          current = Math.sqrt(current);
        }
        $("#outputScr").html(fixOut(printed + strOutput));
        $("#inputScr").html(fix(current));
        operation = "sqrt";
        strInput = "";
      }
      //----------------
      // calculate reciprocal of a number
      // report error if user trys to calculate
      // reciprocal value of zero
      function oneDividedBy() {
        if (strInput !== "") current = Number(strInput);
        if (current === 0) {
          clear();
          $("#inputScr").html("Cannot divide by zero");
          return;
        }
        if (operation === "%") {
          strOutput = "rec(" + fix(percentage) + "%" + fix(current) + ")";
          current = percentage * current / 100;
          current = 1 / current;
          percentage = 0;
        } else {
          strOutput = "rec(" + fix(current) + ")";
          current = 1 / current;
        }
        $("#outputScr").html(fixOut(printed + strOutput));
        $("#inputScr").html(fix(current));
        operation = "1/";
        strInput = "";
      }
      //----------------
      // to calculate x percent of y 
      // enter x then % then y
      // this function only remembers the percentage (x in example above)
      // the rest is calculated after the next operation is 
      // entered (see previous funtions)
      function percentOf() {
        if (strInput !== "") {
          current = Number(strInput);
          strInput = "";
        }
        if (operation === "%") current = percentage * current / 100;
        percentage = current;
        $("#outputScr").html(fixOut(printed + fix(percentage) + "%"));
        $("#inputScr").html(fix(current));
        operation = "%";
      }
      //----------------
      // register a keystroke
      //----------------
      document.addEventListener("keydown", function(e) {
        //event.preventDefault();
        if (valid(e.key)) {
          if (e.key >= "0" && e.key <= "9") strInput = addDigit(e.key, strInput);
          if (e.key === ".") strInput = addDecimalPoint(strInput);
          if (e.key === "Backspace") strInput = backspc(strInput);
          if (e.key === "Delete") clearEntry();
          if (e.key.toLowerCase() === "n") negate();
          if (e.key.toLowerCase() === "c") clear();
          if (e.key === "+") add();
          if (e.key === "-") subtract();
          if (e.key === "Enter") calculate();
          if (e.key === "*") multiply();
          if (e.key === "/") divideBy();
          if (e.key.toLowerCase() === "s") squareRoot();
          if (e.key.toLowerCase() === "r") oneDividedBy();
          if (e.key === "%") percentOf();
        } //end of if valid key
      })
      $("#buttons div").on("click", function() {
        buttonPressedVisual(this);
      })
      $("#one").on("click", function() {
        strInput = addDigit("1", strInput);
      })
      $("#two").on("click", function() {
        strInput = addDigit("2", strInput);
      })
      $("#three").on("click", function() {
        strInput = addDigit("3", strInput);
      })
      $("#four").on("click", function() {
        strInput = addDigit("4", strInput);
      })
      $("#five").on("click", function() {
        strInput = addDigit("5", strInput);
      })
      $("#six").on("click", function() {
        strInput = addDigit("6", strInput);
      })
      $("#seven").on("click", function() {
        strInput = addDigit("7", strInput);
      });
      $("#eight").on("click", function() {
        strInput = addDigit("8", strInput);
      })
      $("#nine").on("click", function() {
        strInput = addDigit("9", strInput);
      })
      $("#zero").on("click", function() {
        strInput = addDigit("0", strInput);
      })
      $("#decpoint").on("click", function() {
        strInput = addDecimalPoint(strInput);
      })
      $("#plusminus").on("click", function() {
        negate();
      })
      $("#backspace").on("click", function() {
        strInput = backspc(strInput);
      })
      $("#ce").on("click", function() {
        clearEntry();
      })
      $("#c").on("click", function() {
          clear();
        }) //end of clear (c) click
        //------------------
        // save number into memory
      $("#ms").on("click", function() {
          if (strInput === "") {
            if (current !== 0) {
              memory = current;
              $("#displayM").html("M");
            }
          } else
          if (Number(strInput) != 0) {
            memory = Number(strInput);
            current = memory;
            strInput = "";
            $("#displayM").html("M");
          };
        }) // end of click on ms
        //--------------------------------
        // delete number from memory
      $("#mc").on("click", function() {
          $("#displayM").html("");
          memory = null;
        })
        // ----------------------
        // recall memory and set it
        // to be the active value
      $("#mr").on("click", function() {
          if (memory !== null) {
            current = memory;
            strInput = "";
            $("#inputScr").html(fix(current));
          }
        })
        //--------------
        // add currently active value
        // to the existing memory
        // if there is no existing memory 
        // procede as if memory is 0
      $("#mp").on("click", function() {
          if (strInput === "") {
            if (current !== 0) {
              if (memory === null) memory = 0;
              memory += current;
              $("#displayM").html("M");
              $("#displayM").append("+");
              setTimeout(function() {
                $("#displayM").html("M");
              }, 1000);
            }
          } else
          if (Number(strInput) !== 0) {
            if (memory === null) memory = 0;
            memory += Number(strInput);
            $("#displayM").html("M");
            $("#displayM").append("+");
            setTimeout(function() {
              $("#displayM").html("M");
            }, 1000);
          };
        }) //end if mp click
        //--------------
        // subtract currently active value
        // from the existing memory
        // if there is no existing memory 
        // procede as if memory is 0
      $("#mm").on("click", function() {
          if (strInput === "") {
            if (current !== 0) {
              if (memory === null) memory = 0;
              memory -= current;
              $("#displayM").html("M");
              $("#displayM").append("-");
              setTimeout(function() {
                $("#displayM").html("M");
              }, 1000);
            }
          } else
          if (Number(strInput) !== 0) {
            if (memory === null) memory = 0;
            memory -= Number(strInput);
            $("#displayM").html("M");
            $("#displayM").append("-");
            setTimeout(function() {
              $("#displayM").html("M");
            }, 1000);
          };
        }) //end if mm click
        //-----------------------------------------------------
      $("#plus").on("click", function() {
          add();
        })
        //---------------------------------  
      $("#minus").on("click", function() {
          subtract();
        })
        //---------------------------------------------------  
      $("#equals").on("click", function() {
          calculate();
        })
        //--------------------------------------------
      $("#times").on("click", function() {
          multiply();
        })
        //-----------------------------------------------
      $("#divide").on("click", function() {
          divideBy();
        })
        //-----------------------------------------
      $("#sqroot").on("click", function() {
          squareRoot();
        })
        //----------------------------------------
      $("#reciprocal").on("click", function() {
          oneDividedBy();
        })
        //----------------------------------------
      $("#percent").on("click", function() {
        percentOf();
      })
    
    }); //end of document.ready
    
    $(function () {
      $('.calculator').hide();
      $('#dvAccordion').find('.accordion1').click(function (e) {
        //  e.stopPropagation();
          var hasOpened = $(this).hasClass("open")
          $('h4').removeClass("open").addClass("closed");
          if (!hasOpened) {
              $(this).removeClass("closed").addClass("open");
          }
          $(this).next().slideToggle('fast');
      });
    });
  
  //start overall save
//   $(document).ready(function () { 
//     $(".subform").click(function(){
//       var datastring = $("form").serialize();
//       $(".submitbtn1").click(function(){ 
//       //  $(".submitbtn").prop('disabled', true);
//       // $(".submitbtn3").prop('disabled', true);
//           $.ajaxSetup({
//             headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//           });
//           $.ajax({
//             method: 'POST', 
//             url: 'https://test.mbaguru.in/student/savequizedata',
//             data: JSON.stringify(datastring),
//             success: function(response){
//                 console.log(response.message);
//             },
//             error: function(jqXHR, textStatus, errorThrown) { 
//               console.log(JSON.stringify(jqXHR));
//               console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
//             },
            
//           });
//       });
//     });
//   });
  
  ///endoverall save
  
  
//start new overall save

// $(document).ready(function () {
//     $(".newsubmitbtn1").click(function (e) {
//       // e.preventDefault(); 
//         var datastring = $("form").serialize(); 
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });

//         $.ajax({
//             method: 'POST',
//             url: 'https://test.mbaguru.in/student/savequizedatanew',
//             data: datastring, 
//             success: function (response) {
//                 if (response.success) {
//                     console.log(response.message);
//                 } else {
//                     alert('Failed to save answers!');
//                 }
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
//             },
//         });
//     });
// });



$(document).ready(function () {
    $(".newsubmitbtn1").click(function (e) {
        //e.preventDefault();
        var datastring = $("form").serialize(); 
        var redirectUrl = $(this).closest('a').attr('href'); 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: 'https://test.mbaguru.in/student/savequizedatanew',
            data: datastring, 
            success: function (response) {
                if (response.success) {
                    console.log(response.message);
                    // Redirect to the URL after successful AJAX request
                    window.location.href = redirectUrl;
                    $('.submitbtn2').css('display','block');
                    $('.newsubmitbtn1').css('display','none');
                } else {
                    alert('Failed to save answers!');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            },
        });
    });
});


  
  ///endoverall new save
  //oldsave
//   $(document).ready(function () {
//       $(".submitbtn").click(function(e){ 
          
//         //   e.preventDefault();

//         // var $btn = $(this);
//         // $btn.attr('disabled', 'disabled'); 
//         var datastring = $("form").serialize();
       
//           $.ajaxSetup({
//             headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//           });
//          $.ajax({
//             method: 'POST', 
//             url: 'https://test.mbaguru.in/student/savequizedata',
//             data: JSON.stringify(datastring),
  
//             success: function(response){
//               console.log(response.message);
//             },
//             error: function(jqXHR, textStatus, errorThrown) { 
//             console.log(JSON.stringify(jqXHR));
//             console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            
//             // $btn.removeAttr('disabled');
//           },
           
//         });
//     });
//   });

  //endoldsave
  
  //newsave
//   $(document).ready(function () {
//     $(".submitbtn").click(function(e){ 
//         e.preventDefault(); // Prevent default behavior if necessary

        
//         var $btn = $(this);
//         $btn.attr('disabled', 'disabled'); // Disable the button to prevent multiple clicks
//         $('.submitbtn2').css('display','block');
//          $btn.css('display','none');
//         var datastring = $("form").serialize();

//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });

//         $.ajax({
//             method: 'POST', 
//             url: 'https://test.mbaguru.in/student/savequizedata',
//             data: datastring, // No need to JSON.stringify for a serialized string

//             success: function(response){
//                 console.log(response.message);
//                 // Optionally, you can re-enable the button if needed
//                 // $btn.removeAttr('disabled');
//                  $btn.attr('disabled', 'disabled');
                 
//             },
//             error: function(jqXHR, textStatus, errorThrown) { 
//                 console.log(JSON.stringify(jqXHR));
//                 console.log("AJAX error: " + textStatus + ' : ' + errorThrown);

//                  // Re-enable the button to allow retrying
//                 // $btn.removeAttr('disabled');
//                  $btn.attr('disabled', 'disabled');
//             },
//         });
//     });
// });
  //endnewsave
  
//   $(document).ready(function () {
//     $('.qdata1').css('display','block');
//     $('.qus').click(function(){
//       var data_set = $(this).attr('data-set');
//       $('.qdata'+data_set).css('display','block');
//     });
//   });
  
  
  
//   $('.ansi').click(function(){
//       var val = $(this).attr('data-value1');
//       $('.rev').attr('data-rev',val);
//       $('.rev').click ( function(){
//           var rev = $(this).attr('data-rev');
//           var csr =  $('.sr'+rev).css('background-color');
       
//           $('.re'+rev).val(''); 
//           if(csr == 'rgb(0, 128, 0)'|| csr == 'rgba(0, 0, 0, 0)'){
//           /// console.log(csr,"csr1");
//           $('.sr'+rev).removeAttr("style")
//             $('.sr'+rev).css('background-color','red');
//           }
//           if(csr == 'rgba(0, 0, 0, 0)'){
//               // console.log(csr,"csr");
//               $('.sr'+rev).removeAttr("style")
//             $('.sr'+rev).css('background-color','red');
//           } 
//       })
//   })
//   $('.rem').click(function(e){
//       var val = $(this).attr('data-value');
//       $('.rev').attr('data-rev',val);
//       $('.rev').click ( function(){
//           var rev = $(this).attr('data-rev');
//           $('.re'+rev).removeAttr('checked');
//           $('.sr'+rev).css('background-color','red');
//           var csr =  $('.sr'+rev).css('background-color');
//           if(csr == 'rgb(0, 128, 0)'){
//             $('.sr'+rev).removeAttr("style")
//             $('.sr'+rev).css('background-color','red');
//           }
//           if(csr == 'rgba(0, 0, 0, 0)'){
//             $('.sr'+rev).removeAttr("style")
//             $('.sr'+rev).css('background-color','red');
//           }
//       })
//   })
 
//   //start
//   // $(document).ready(function() {
//   //   var quscount=0;
//   //  $('.qus').click(function(){
//   //   quscount += 1;
//   //       $('.noqus').css('display','none');
//   //       $('.next').css('display','none');
//   //       $('.nextdata').css('display','block');
//   //       var setsave =  $(this).attr('data-set');
//   //       $('.nextdata').attr('data-save',setsave);
//   //       var ct =0;
//   //       var cts = 0;
//   //       $('.nextdata').click(function (e) {
//   //     if(quscount >=2){
//   //         cts += 1;
//   //         console.log(cts)
//   //         var save = $(this).attr('data-save');
//   //         var save1 =  parseInt(save) +cts;
//   //         $('.question').css('display','none');
//   //        $('.qdata'+save1).css('display','block');
//   //         var dd = $(this).attr('style');	
//   //         var valdata =  $('.re'+save1).val();
//   //         let isChecked = $('.re'+save1).is(':checked');
//   //            if(isChecked == true ||valdata){
//   //               $('.sr'+save1).css('background-color','green');
//   //            }else{
//   //             $('.sr'+save1).css('background-color','red');
//   //            }
//   //         $('.ssm').removeClass('selected');
//   //         $('.sel'+save1).addClass('selected');
//   //         $('.review').attr('data-review',save1);

//   //         $('.review').click(function () {
//   //           var rwv = $(this).attr('data-review');
//   //           if(isChecked == true ||valdata){
//   //             $('.sr'+save1).css({background:'linear-gradient(green, purple)'});
//   //           }
//   //         })

//   //         $('.review').click(function () {
//   //           var rwv = $(this).attr('data-review');
//   //           $('.sr'+rwv).css('background-color','purple'); 
//   //           var cls = $('.sr'+rwv).css('background-color');
//   //             if(cls=='rgb(255, 0, 0)'){
//   //               $('.review').click(function (){
//   //                   $('.review').css('background-color','white');
//   //                   var rwv = $(this).attr('data-review');
//   //                       $('.sr'+rwv).css('background-color','red');
//   //                 })
//   //             }

//   //             if(cls=='rgb(0, 128, 0)'){
//   //               $('.review').click(function (){
//   //                 var rwv = $(this).attr('data-review');
//   //                 $('.sr'+rwv).removeAttr("style")
//   //                 $('.sr'+rwv).css('background-color','green');
//   //               }) 
//   //             }
//   //           if(cls=='rgb(128, 0, 128)'){
//   //             $('.review').click(function (){
//   //               var rwv = $(this).attr('data-review');
//   //                 $('.sr'+rwv).removeAttr("style")
//   //                  $('.sr'+rwv).css('background-color','purple');
//   //            }) 
//   //           }
//   //           if(cls=='rgba(0, 0, 0, 0)'){
//   //             $('.review').click(function (){
//   //               var rwv = $(this).attr('data-review');
//   //               $('.sr'+rwv).removeAttr("style")
//   //               //$('.sr'+rwv).css('background-color','green');
//   //               $('.sr'+rwv).css({background:'linear-gradient(green, purple)'});
//   //             }) 
//   //           }
//   //      })
//   //    var cs = $('.qdata'+save1).css('display');
//   //      if(cs == undefined){
//   //         $('.qdata1').css('display','block');
//   //      }
  
//   // }else{
//   //       ct += 1;
//   //         var save = $(this).attr('data-save');
//   //         var save1 =  parseInt(save) +ct;
//   //         $('.question').css('display','none');
//   //         $('.qdata'+save1).css('display','block');
//   //       let isChecked = $('.re'+save1).is(':checked');
//   //       var valdata =  $('.re'+save1).val();
       
//   //            if((isChecked == true|| valdata)){
//   //               $('.sr'+save1).css('background-color','green');
//   //            }else{
//   //             $('.sr'+save1).css('background-color','red');
//   //            }
//   //         $('.ssm').removeClass('selected');
//   //           $('.sel'+save1).addClass('selected');
          
//   //      $('.review').attr('data-review',save1);
//   //       $('.review').click(function () {
//   //         var rwv = $(this).attr('data-review');
//   //         $('.sr'+rwv).css('background-color','purple'); 
//   //         var cls = $('.sr'+rwv).css('background-color');
//   //         if(cls=='rgb(255, 0, 0)'){
//   //           $('.review').click(function (){
//   //             $('.review').css('background-color','white');
//   //             var rwv = $(this).attr('data-review');
//   //                 $('.sr'+rwv).css('background-color','red');
//   //           })
//   //         }

//   //         if(cls=='rgb(0, 128, 0)'){
//   //           $('.review').click(function (){
//   //           var rwv = $(this).attr('data-review');
//   //           $('.sr'+rwv).removeAttr("style")
//   //             $('.sr'+rwv).css('background-color','green');
//   //         }) 
//   //       }
//   //       if(cls=='rgb(128, 0, 128)'){
//   //         $('.review').click(function (){
//   //           var rwv = $(this).attr('data-review');
//   //             $('.sr'+rwv).removeAttr("style")
//   //              $('.sr'+rwv).css('background-color','purple');
//   //        }) 
//   //        }
//   //       if(cls=='rgba(0, 0, 0, 0)'){
//   //         $('.review').click(function (){
//   //         var rwv = $(this).attr('data-review');
//   //         $('.sr'+rwv).removeAttr("style")
//   //         //$('.sr'+rwv).css('background-color','green');
//   //         $('.sr'+rwv).css({background:'linear-gradient(green, purple)'});
//   //       }) 
//   //     }
//   //      })
       
       
//   //    var cs = $('.qdata'+save1).css('display');
//   //      if(cs == undefined){
//   //         $('.qdata1').css('display','block');
      
//   //      }
//   // }
 
    
//   //   //$('.nextdata').removeAttr('onclick');
      
//   //     })
//   //  })    
  
//   // })

//   ////////////
//   $(document).ready(function() {
//     var quscount = 0;
//     $('.qus').click(function() {
//         quscount += 1;
//         $('.noqus').css('display', 'none');
//         $('.next').css('display', 'none');
//         $('.nextdata').css('display', 'block');
//         var setsave = $(this).attr('data-set');
    
//         $('.nextdata').attr('data-save', setsave);
//         var ct = 0;
//         var cts = 0;  // Move cts declaration here
        
//         $('.nextdata').off('click').click(function(e) { // Add .off() to avoid multiple bindings
//             if (quscount >= 2) {
//                 cts += 1;
//                 console.log(cts);
//                 var save = $(this).attr('data-save');
               
//                 var save1 = parseInt(save) + cts;
//                 $('.question').css('display', 'none');
//                 $('.qdata' + save1).css('display', 'block');
//                 var dd = $(this).attr('style');
//                 var valdata = $('.re' + save1).val();
//                 let isChecked = $('.re' + save1).is(':checked');
//                 if (isChecked == true || valdata) {
//                     $('.sr' + save1).css('background-color', 'green');
//                 } else {
//                     $('.sr' + save1).css('background-color', 'red');
//                 }
//                 $('.ssm').removeClass('selected');
//                 $('.sel' + save1).addClass('selected');
//                 $('.review').attr('data-review', save1);

//                 $('.review').off('click').click(function() { // Add .off() to avoid multiple bindings
//                     var rwv = $(this).attr('data-review');
//                     if (isChecked == true || valdata) {
//                         $('.sr' + save1).css({ background: 'linear-gradient(green, purple)' });
//                     }
//                 });

//                 $('.review').off('click').click(function() { // Add .off() to avoid multiple bindings
//                     var rwv = $(this).attr('data-review');
//                     $('.sr' + rwv).css('background-color', 'purple');
//                     var cls = $('.sr' + rwv).css('background-color');
//                     if (cls == 'rgb(255, 0, 0)') {
//                         $('.review').off('click').click(function() {
//                             $('.review').css('background-color', 'white');
//                             var rwv = $(this).attr('data-review');
//                             $('.sr' + rwv).css('background-color', 'red');
//                         });
//                     }

//                     if (cls == 'rgb(0, 128, 0)') {
//                         $('.review').off('click').click(function() {
//                             var rwv = $(this).attr('data-review');
//                             $('.sr' + rwv).removeAttr("style")
//                             $('.sr' + rwv).css('background-color', 'green');
//                         });
//                     }
//                     if (cls == 'rgb(128, 0, 128)') {
//                         $('.review').off('click').click(function() {
//                             var rwv = $(this).attr('data-review');
//                             $('.sr' + rwv).removeAttr("style")
//                             $('.sr' + rwv).css('background-color', 'purple');
//                         });
//                     }
//                     if (cls == 'rgba(0, 0, 0, 0)') {
//                         $('.review').off('click').click(function() {
//                             var rwv = $(this).attr('data-review');
//                             $('.sr' + rwv).removeAttr("style")
//                             //$('.sr' + rwv).css('background-color', 'green');
//                             $('.sr' + rwv).css({ background: 'linear-gradient(green, purple)' });
//                         });
//                     }
//                 });

//                 var cs = $('.qdata' + save1).css('display');
//                 if (cs == undefined) {
//                     $('.qdata1').css('display', 'block');
//                 }
//             } else {
//                 ct += 1;
//                 var save = $(this).attr('data-save');
//                 var save1 = parseInt(save) + ct;
//                 $('.question').css('display', 'none');
//                 $('.qdata' + save1).css('display', 'block');
//                 let isChecked = $('.re' + save1).is(':checked');
//                 var valdata = $('.re' + save1).val();

//                 if ((isChecked == true || valdata)) {
//                     $('.sr' + save1).css('background-color', 'green');
//                 } else {
//                     $('.sr' + save1).css('background-color', 'red');
//                 }
//                 $('.ssm').removeClass('selected');
//                 $('.sel' + save1).addClass('selected');

//                 $('.review').attr('data-review', save1);
//                 $('.review').off('click').click(function() { // Add .off() to avoid multiple bindings
//                     var rwv = $(this).attr('data-review');
//                     $('.sr' + rwv).css('background-color', 'purple');
//                     var cls = $('.sr' + rwv).css('background-color');
//                     if (cls == 'rgb(255, 0, 0)') {
//                         $('.review').off('click').click(function() {
//                             $('.review').css('background-color', 'white');
//                             var rwv = $(this).attr('data-review');
//                             $('.sr' + rwv).css('background-color', 'red');
//                         });
//                     }

//                     if (cls == 'rgb(0, 128, 0)') {
//                         $('.review').off('click').click(function() {
//                             var rwv = $(this).attr('data-review');
//                             $('.sr' + rwv).removeAttr("style")
//                             $('.sr' + rwv).css('background-color', 'green');
//                         });
//                     }
//                     if (cls == 'rgb(128, 0, 128)') {
//                         $('.review').off('click').click(function() {
//                             var rwv = $(this).attr('data-review');
//                             $('.sr' + rwv).removeAttr("style")
//                             $('.sr' + rwv).css('background-color', 'purple');
//                         });
//                     }
//                     if (cls == 'rgba(0, 0, 0, 0)') {
//                         $('.review').off('click').click(function() {
//                             var rwv = $(this).attr('data-review');
//                             $('.sr' + rwv).removeAttr("style")
//                             //$('.sr' + rwv).css('background-color', 'green');
//                             $('.sr' + rwv).css({ background: 'linear-gradient(green, purple)' });
//                         });
//                     }
//                 });

//                 var cs = $('.qdata' + save1).css('display');
//                 if (cs == undefined) {
//                     $('.qdata1').css('display', 'block');
//                 }
//             }
//         });
//     });
// });

//   //end

// //newstart



// //newend

//   $('.qus').click(function(){
//     var cts = 0;
//     $('.nextdata').click(function (e) { 
     
//             var save = $(this).attr('data-save');
//             var save1 =  parseInt(save) +cts;
//             $('.question').css('display','none');
//               var valdata =  $('.re'+save1).val();
//               let isChecked = $('.re'+save1).is(':checked');
//               if(isChecked == true || valdata){
                 
//                   $('.sr'+save1).css('background-color','green');
//               }else{
//                 $('.sr'+save1).css('background-color','red');
//               }
//               })

//   })
  
//   //time save data
//   var  crtt = 1;
//   $(document).ready(function() {
//   $('.next').on('click', function() {
//     crtt +=1; 
//   $('.ssm').removeClass('selected');
//   $('.sel'+crtt).addClass('selected');
//   })
//   })
//   // end time save data
  
  
//   $(document).ready(function () {
//     console.log(navigator.onLine);
//   if (!navigator.onLine) {
//       showNoInternetPage();
//   } else{
//      $(".review").attr('data-review','1')
//      $(".review").click(function(){
//         var rv1 = $(this).attr('data-review');
//           $('.sr'+rv1).css('background-color','purple');
//       });
//       $('.qdata1').css('display','block');
//       $('.sr1').css('background-color','red');
//     (function () {
//       $(".qus").click(function(){
  
//         $('.next').click(function () { 
//         var sdf = $(this).data('clicked', true);
//         var sdff = $(this).attr('data-set');
//         if(sdf!= ''){
//           $('.qdata'+sdff).css('display','block');
//         }
//         });
//       });
     
//       var count = 1;
//       $('.next').click(function () { 
//       count += 1;
//         $('.question').css('display','none');
//         $('.qdata'+count).css('display','block');
//         let isChecked = $('.re'+count).is(':checked');
//         let valuu = $('.re'+count).val();
//         if(isChecked == true || valuu){
//           $('.sr'+count).css('background-color','green');
//         }else{
//           $('.sr'+count).css('background-color','red');
//         }
       
//         $('.review').attr('data-review',count);
//         $('.review').click(function () {
//         $('.review').css('background-color','lightgray');
//           var rwv = $(this).attr('data-review');
//           $('.sr'+rwv).css('background-color','purple');
//           var cls = $('.sr'+rwv).css('background-color');
//           // console.log(cls);
//          if(cls=='rgb(255, 0, 0)'){
//               $('.review').click(function (){
//                  var rwv = $(this).attr('data-review');
//                  $('.sr'+rwv).css('background-color','red');
//               })
//          }
         
//          if(cls=='rgb(0, 128, 0)'){
//               $('.review').click(function (){
//               var rwv = $(this).attr('data-review');
//               $('.sr'+rwv).removeAttr("style")
//               $('.sr'+rwv).css('background-color','green');
//             }) 
//           }
//           if(cls=='rgb(128, 0, 128)'){
//             $('.review').click(function (){
//               var rwv = $(this).attr('data-review');
//                 $('.sr'+rwv).removeAttr("style")
//                  $('.sr'+rwv).css('background-color','purple');
//           }) 
//           }
//           if(cls=='rgba(0, 0, 0, 0)'){
//             $('.review').click(function (){
//             var rwv = $(this).attr('data-review');
//             $('.sr'+rwv).removeAttr("style")
//             //$('.sr'+rwv).css('background-color','green');
//             $('.sr'+rwv).css({background:'linear-gradient(green, purple)'});
//           }) 
//         }
          
//       })
      
//         var cs = $('.qdata'+count).css('display');
//         if(cs == undefined){
//           $('.question').css('display','none');
//           $('.qdata1').css('display','block');
//           var counttt =2
//           $('.next').click(function () { 
//             counttt += 1;
//              $('.question').css('display','none');
//              $('.qdata'+counttt).css('display','block');
//              let isChecked = $('.re'+counttt).is(':checked');
//              let valdata = $('.re'+counttt).val();
//              if(isChecked ==true || valdata){
//               $('.sr'+counttt).css('background-color','green');
//              }else{
//               $('.sr'+counttt).css('background-color','red');
//              }
            
//              $('.review').attr('data-review',counttt);
//              $('.review').click(function () {
//              $('.review').css('background-color','lightgray');
//               var rwv = $(this).attr('data-review');
//               $('.sr'+rwv).css('background-color','purple');
//               var cls = $('.sr'+rwv).css('background-color');
             
//               if(cls=='rgb(255, 0, 0)'){
//                 $('.review').click(function (){
//                 // $('.review').css('background-color','white');
//                   var rwv = $(this).attr('data-review');
//                      $('.sr'+rwv).css('background-color','red');
//               })
//               }
//               if(cls=='rgb(0, 128, 0)'){
//                   $('.review').click(function (){
//                   var rwv = $(this).attr('data-review');
//                   $('.sr'+rwv).removeAttr("style")
//                     $('.sr'+rwv).css('background-color','green');
//                 }) 
//               }
//               if(cls=='rgb(128, 0, 128)'){
//                 $('.review').click(function (){
//                   var rwv = $(this).attr('data-review');
//                     $('.sr'+rwv).removeAttr("style")
//                      $('.sr'+rwv).css('background-color','purple');
//               }) 
//               }
//               if(cls=='rgba(0, 0, 0, 0)'){
//                 $('.review').click(function (){
//                 var rwv = $(this).attr('data-review');
//                 $('.sr'+rwv).removeAttr("style")
//                 //$('.sr'+rwv).css('background-color','green');
//                 $('.sr'+rwv).css({background:'linear-gradient(green, purple)'});
//               }) 
//             }
//             })
           
            
//           });
//      }
//       });
//      })();
//     }
//   });
  
  
//   $(document).ready(function() {
//     $('.virtual-keyboard').css('display','none');
//     $('.exampledata ').click(function(){
//       $('.virtual-keyboard').css('display','none');
//       $('.virtual-keyboard').css('display','block');
//       $('.next').on('click', function() {
//         $('.virtual-keyboard').css('display','none');
//       })
//       $('.qus').click(function(){
//          $('.virtual-keyboard').css('display','none');
//       })
       
//     })
    
//   })
  
//   $(document).ready(function() {
//   //$('.form').css('display','block');
//   $('.quesall').click(function(){
//         $('.form').css('display','none');
//         $('.allqstd').css('display','block');
//   })
//   $('.inst').click(function(){
//         $('.form').css('display','none');
//       $('.inh').css('display','block');
//   })
//   $('.cls').click(function(){
//          $('.form').css('display','block');
//         $('.allqstd').css('display','none');
//          $('.inh').css('display','none');
//   })
//   })
  

//   $('.qus').click(function(){
//      var dataset = $(this).attr('data-set');
//      var val =  $('.re'+dataset).val(); 
//      var val =  $('.re'+dataset).val(); 
//      $('.sr'+dataset).click(function(){
//       if(val){
//           $('.sr'+dataset).css('background-color','green'); 
//           $('.rev').attr('data-rev',dataset);
//           $('.rev').click ( function(){
//                 var rev = $(this).attr('data-rev');
//                 var csr = $('.sr'+rev).css('background-color');
//                 $('.re'+rev).val('');
//                 $('.sr'+rev).css('background-color','red');
//                 if(csr == '(rgba(0, 0, 0, 0)') {
//                   $('.sr'+rwv).removeAttr("style")
//                   $('.sr'+rev).css('background-color','red');
//                 }
                
//           })
//       }else{
//             let isChecked = $('.re'+dataset).is(':checked');
//              if(isChecked == true){
//                 $('.sr'+dataset).css('background-color','green');
//              }else{
//               $('.sr'+dataset).css('background-color','red');
//              }
//       }
//      })
//   })
  
//   $(document).ready(function(){
//      $('.row').on("cut copy paste",function(e) {
//         e.preventDefault();
//      });
//   });
  
  
//   (function($){
//           $.fn.disableSelection = function() {
//               return this
//                       .attr('unselectable', 'on')
//                       .css('user-select', 'none')
//                       .on('selectstart', false);
//           };
//       })(jQuery);
      
//       $('body').disableSelection();
      
        
//          $('.mydives').on('click',function(e){
//           var data =   $('#buttons').attr('clicked',true);
//          // console.log(data);
//           if(data){
          
//           $('.calculator').css('display','none');
//           }else{
//          $('.calculator').css('display','block');
//             }
      
//       })
      
  
  
//   $(document).ready(function () {  
//     $('.review').click(function(){
//      var review_id = $(this).attr('data-review');
//      var section_name = $(this).attr('data-section');
//      var paper_id = $(this).attr('data-pid');
//      var test_id = $(this).attr('data-tid');
//     //var url1 = '{{route("student.savereview")}}';
//       $.ajaxSetup({
//     headers: {
//     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
//   });
//       $.ajax({
//       url: 'https://test.mbaguru.in/student/savereview',
//       type: "POST",
//         data: {
//           test_id: test_id,
//           paper_id: paper_id,
//           section_name: section_name,
//           review_id: review_id
//          },
//          cache: false,
//       success: function(dataResult){
//         // console.log(dataResult);
//          var dataResult = JSON.parse(dataResult);
//          if(dataResult.statusCode==200){
//          //  location.reload(true);   
//          }
//          else if(dataResult.statusCode==201){
//          //  alert("Error occured !");
//          }
//       },
   
//      });
//     })
//   })
  
  
//   //old only qus

//   window.addEventListener('offline', function(e) {
//     window.location.href = "/no-internet"; // Redirect to a no internet page
//   });

//   $(document).ready(function () { 
//     var arr = $('.check_color').attr('data-half');
//      var raa = $('.check_review').attr('data-review');
//     // console.log(raa);
//     if(arr){
//       $.each(JSON.parse(arr), function(index, value) {
//         var sr_no = value.sr_no;
//         var id = value.id;
//         var saveans = value.answer;
//         var qusid = value.question_id
//         var type =   $('.re'+sr_no).attr('type');
//         if(saveans){
//          if(type == 'text' || type == 'number'){
//             $('.sr'+sr_no).css('background-color','green');
//             $('.review').click(function(){
//               var revi =   $(this).attr('data-review');
//               var invalue = $('.re'+revi).val();
//               if(invalue){
//               $('.sr'+revi).css({background:'linear-gradient(green, purple)'});
//               }else{
//                 $('.sr'+revi).css('background-color','purple');
//               }
//             })
//             $.each(JSON.parse(raa), function(index1, value1) {
//               if(value.sr_no == value1.review_id){
//               $('.sr'+sr_no).css({background:'linear-gradient(green, purple)'});
//               }
//             })
//           }
//           else if(type == 'radio'){
//             let isChecked = $('.shans'+saveans).is(':checked');
//             if(isChecked == true){
//               $.each(JSON.parse(raa), function(index1, value1) {
//               if(value.sr_no == value1.review_id){
//               $('.sr'+sr_no).css({background:'linear-gradient(green, purple)'});
//                 }else if(saveans){ 
//                  $('.sr'+sr_no).css('background-color','green');
//                 }
//               })
  
//               $('.qus').click(function(){
//                 //$('.shans'+saveans).trigger("click");
//                  var dat = $(this).attr('data-set');
//                  $('.sr'+dat).css('background-color','green');
//               })
//               $('.review').click(function(){
//               var reviess =  $(this).attr('data-review');
//               if(isChecked == true){
//                  $('.re'+reviess).trigger("click");
//               }
             
//               })
//               $('.sr'+sr_no).css('background-color','green');
//             }
//           }
//         }
//       });
//     }
 
//     $('.qus').click(function(){
//       if (!navigator.onLine) {
//         window.location.href = "/no-internet"; 
//         return; 
//       }
//       var set = $(this).attr('data-set');
//       var sr_no1 = $(this).attr('data-set');
//       var sr_no = [sr_no1 - 1]; 
//       var ansset = set-1;
//       var section_name = [$('.section').val()];
//       var test_id = [$('.testid').val()];
//       var user_id = [$('.userid').val()];
//       var paper_id = [$('.paperid').val()];
//       var set_type = [$('.set_type').val()];
//       var question_id1 = $(this).attr('data-equ');
//       var question_id = [question_id1 -1];
//       var type = $('.re'+set).attr('type'); 
//       var answer = $('.re'+ansset).val();
      
      
//       if(answer){
//          var answer = [$('.re'+ansset).val()];
//       }else{
//         var answer = $('.re' + ansset).filter(':checked').map(function() {
//         return this.value;
//         }).get();
//       }
      
//       var ans_duration =[$('.countdown').text()];
//       var ans_du =$('.countdown').text();
//         if(ans_du=="0:00"){
//              $('#myModal').modal('show');
//         }else{   
//         //  $.ajaxSetup({
//         //     headers: {
//         //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         //     }
//         // });
//         //   $.ajax({
//         //   url: 'https://test.mbaguru.in/student/savehalfquiz',
//         //   type: "POST",
//         //     data: {
//         //       test_id: test_id,
//         //       paper_id: paper_id,
//         //       section_name: section_name,
//         //       question_id: question_id,
//         //       user_id: user_id,
//         //       answer: answer,
//         //       sr_no: sr_no,
//         //       set_type:set_type,
//         //       ans_duration:ans_duration
//         //     },
//         //     cache: false,
//         //     success: function(dataResult){
//         //     // console.log(dataResult);
//         //      var dataResult = JSON.parse(dataResult);
//         //      if(dataResult.statusCode==200){
//         //      //  location.reload(true);   
//         //      }
//         //      else if(dataResult.statusCode==201){
//         //       //alert("Error occured !");
//         //      }
//         //     },
//         // });
//         }
        
//      })
//   })
  
//   ////end//




  
//   //old
//   // $(document).ready(function () {
//   // var cunt = 1; 
//   //   $('.next').click(function(){
//   //      cunt += 1;
//   //     var sr_no = [cunt - 1];
//   //     var section_name = [$('.section').val()];
//   //     var test_id = [$('.testid').val()];
//   //     var user_id = [$('.userid').val()];
//   //     var paper_id = [$('.paperid').val()];
//   //     var set_type = [$('.set_type').val()];
//   //     var ans_duration =[$('.countdown').text()];
//   //     //console.log(ans_duration,"okkl")
//   //     var ansset = cunt-1;
//   //      var answer = $('.re'+ansset).val();
//   //     if(answer){
//   //        var answer = [$('.re'+ansset).val()];
//   //     }else{
//   //     var answer = $('.re' + ansset).filter(':checked').map(function() {
//   //         return this.value;
//   //     }).get();
//   //   }
//   //    $.ajaxSetup({
//   //       headers: {
//   //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//   //       }
//   //     });
//   //     $.ajax({
//   //      url: 'https://test.mbaguru.in/student/savenexthalfquiz',
//   //      type: "POST",
//   //       data: {
//   //          test_id: test_id,
//   //          paper_id: paper_id,
//   //          section_name: section_name,
//   //          user_id: user_id,
//   //          answer: answer,
//   //          sr_no: sr_no,
//   //          set_type:set_type,
//   //          ans_duration: ans_duration
//   //       },
//   //       cache: false,
//   //       success: function(dataResult){
//   //        //console.log(dataResult);
//   //        var dataResult = JSON.parse(dataResult);
//   //        if(dataResult.statusCode==200){
//   //        //  location.reload(true);  
//   //         //console.log(dataResult); 
//   //        }
//   //        else if(dataResult.statusCode==201){
//   //          //alert("Error occured !");
//   //        }
//   //       }
//   //     });
      
  
//   // //return false;
  
  
  
//   //    var arr = $('.check_color').attr('data-half');
//   //    var raa = $('.check_review').attr('data-review');
  
//   //   if(arr){
//   //     $.each(JSON.parse(arr), function(index, value) {
//   //       var sr_no = value.sr_no;
//   //       var id = value.id;
//   //       var saveans = value.answer;
//   //       var qusid = value.question_id
//   //       var type =   $('.re'+sr_no).attr('type');
//   //       //console.log(saveans);
//   //       //return false;
//   //       if(saveans){
  
//   //        if(type == 'text' || type == 'number'){
//   //          // console.log(sr_no);
//   //           $('.sr'+sr_no).css('background-color','green');
//   //           $('.review').click(function(){
//   //              var revi =   $(this).attr('data-review');
//   //              var invalue = $('.re'+revi).val();
//   //             if(invalue){
//   //             $('.sr'+revi).css({background:'linear-gradient(green, purple)'});
//   //             }else{
//   //              // $('.sr'+revi).css('background-color','purple');
//   //             }
//   //           })
//   //           $.each(JSON.parse(raa), function(index1, value1) {
//   //             if(value.sr_no == value1.review_id){
//   //             $('.sr'+sr_no).css({background:'linear-gradient(green, purple)'});
//   //             }
//   //           })
//   //         }
//   //         else if(type == 'radio'){
//   //           let isChecked = $('.shans'+saveans).is(':checked');
//   //           if(isChecked == true){
//   //             $.each(JSON.parse(raa), function(index1, value1) {
//   //             if(value.sr_no == value1.review_id){
//   //             $('.sr'+sr_no).css({background:'linear-gradient(green, purple)'});
//   //               }else if(saveans){ 
//   //                $('.sr'+sr_no).css('background-color','green');
//   //               }
//   //             })
  
//   //             $('.qus').click(function(){
//   //               //$('.shans'+saveans).trigger("click");
//   //                var dat = $(this).attr('data-set');
//   //                $('.sr'+dat).css('background-color','green');
//   //             })
//   //             $('.review').click(function(){
//   //              var reviess =  $(this).attr('data-review');
//   //             if(isChecked == true){
//   //                $('.re'+reviess).trigger("click");
//   //              }
//   //             })
//   //              $('.sr'+sr_no).css('background-color','green');
//   //           }
//   //         }
//   //       }
//   //     });
//   //   }
  
//   //   })
//   // })
//   //endold

//   //new
//   window.addEventListener('offline', function(e) {
//     window.location.href = "/no-internet"; // Redirect to a no internet page
// });

// // $(document).ready(function () {
// //   var cunt = 1; 
// //   $('.next').click(function(){
// //       if (!navigator.onLine) {
// //           window.location.href = "/no-internet"; // Redirect to a no internet page
// //           return; // Stop further execution
// //       }

// //       cunt += 1;
// //       var sr_no = [cunt - 1];
// //       var section_name = [$('.section').val()];
// //       var test_id = [$('.testid').val()];
// //       var user_id = [$('.userid').val()];
// //       var paper_id = [$('.paperid').val()];
// //       var set_type = [$('.set_type').val()];
// //       var ans_duration =[$('.countdown').text()];

// //       var ansset = cunt - 1;
// //       var answer = $('.re' + ansset).val();
// //       if(answer){
// //           var answer = [$('.re' + ansset).val()];
// //       } else {
// //           var answer = $('.re' + ansset).filter(':checked').map(function() {
// //               return this.value;
// //           }).get();
// //       }

// //       $.ajaxSetup({
// //           headers: {
// //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// //           }
// //       });

// //       $.ajax({
// //           url: 'https://test.mbaguru.in/student/savenexthalfquiz',
// //           type: "POST",
// //           data: {
// //               test_id: test_id,
// //               paper_id: paper_id,
// //               section_name: section_name,
// //               user_id: user_id,
// //               answer: answer,
// //               sr_no: sr_no,
// //               set_type: set_type,
// //               ans_duration: ans_duration
// //           },
// //           cache: false,
// //           success: function(dataResult) {
// //               var dataResult = JSON.parse(dataResult);
// //               if(dataResult.statusCode == 200) {
// //                   // Handle success
// //               } else if(dataResult.statusCode == 201) {
// //                   // Handle error
// //               }
// //           }
// //       });

// //       // Your existing code continues here
// //       var arr = $('.check_color').attr('data-half');
// //       var raa = $('.check_review').attr('data-review');

// //       if(arr) {
// //           $.each(JSON.parse(arr), function(index, value) {
// //               var sr_no = value.sr_no;
// //               var id = value.id;
// //               var saveans = value.answer;
// //               var qusid = value.question_id;
// //               var type = $('.re' + sr_no).attr('type');
// //               if(saveans) {
// //                   if(type == 'text' || type == 'number') {
// //                       $('.sr' + sr_no).css('background-color', 'green');
// //                       $('.review').click(function(){
// //                           var revi = $(this).attr('data-review');
// //                           var invalue = $('.re' + revi).val();
// //                           if(invalue) {
// //                               $('.sr' + revi).css({background:'linear-gradient(green, purple)'});
// //                           }
// //                       });
// //                       $.each(JSON.parse(raa), function(index1, value1) {
// //                           if(value.sr_no == value1.review_id) {
// //                               $('.sr' + sr_no).css({background:'linear-gradient(green, purple)'});
// //                           }
// //                       });
// //                   } else if(type == 'radio') {
// //                       let isChecked = $('.shans' + saveans).is(':checked');
// //                       if(isChecked == true) {
// //                           $.each(JSON.parse(raa), function(index1, value1) {
// //                               if(value.sr_no == value1.review_id) {
// //                                   $('.sr' + sr_no).css({background:'linear-gradient(green, purple)'});
// //                               } else if(saveans) {
// //                                   $('.sr' + sr_no).css('background-color', 'green');
// //                               }
// //                           });

// //                           $('.qus').click(function(){
// //                               var dat = $(this).attr('data-set');
// //                               $('.sr' + dat).css('background-color', 'green');
// //                           });
// //                           $('.review').click(function(){
// //                               var reviess = $(this).attr('data-review');
// //                               if(isChecked == true) {
// //                                   $('.re' + reviess).trigger("click");
// //                               }
// //                           });
// //                           $('.sr' + sr_no).css('background-color', 'green');
// //                       }
// //                   }
// //               }
// //           });
// //       }
// //   });
// // });

// $(document).ready(function () {
//   var cunt = 1; 
//   $('.next').click(function(){
//       if (!navigator.onLine) {
//           window.location.href = "/no-internet"; // Redirect to a no internet page
//           return; // Stop further execution
//       }

//       cunt += 1;
//       var sr_no = [cunt - 1];
//       var section_name = [$('.section').val()];
//       var test_id = [$('.testid').val()];
//       var user_id = [$('.userid').val()];
//       var paper_id = [$('.paperid').val()];
//       var set_type = [$('.set_type').val()];
//       var ansset = cunt - 1;
//       var answer = $('.re' + ansset).val();
//       if(answer){
//           var answer = [$('.re' + ansset).val()];
//       } else {
//           var answer = $('.re' + ansset).filter(':checked').map(function() {
//               return this.value;
//           }).get();
//       }
//       var ans_duration =[$('.countdown').text()];
//         var ans_du =$('.countdown').text();
//             if(ans_du=="0:00"){
//                  $('#myModal').modal('show');
//             }else{
               
//             //     $.ajaxSetup({
//             //       headers: {
//             //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             //       }
//             //     });
//             //     $.ajax({
//             //      url: 'https://test.mbaguru.in/student/savenexthalfquiz',
//             //       type: "POST",
//             //       data: {
//             //           test_id: test_id,
//             //           paper_id: paper_id,
//             //           section_name: section_name,
//             //           user_id: user_id,
//             //           answer: answer,
//             //           sr_no: sr_no,
//             //           set_type: set_type,
//             //           ans_duration: ans_duration
//             //       },
//             //       cache: false,
//             //       success: function(dataResult, textStatus, jqXHR) {
                    
//             //             console.log("okk1");
//             //               var dataResult = JSON.parse(dataResult);
//             //               if(dataResult.statusCode == 200) {
//             //                   // Handle success
//             //               } else if(dataResult.statusCode == 201) {
//             //                   // Handle error
//             //               }
                     
//             //       },
               
//             //     //   }
//             //   });
//             }

//       // Your existing code continues here
//       var arr = $('.check_color').attr('data-half');
//       var raa = $('.check_review').attr('data-review');

//       if(arr) {
//           $.each(JSON.parse(arr), function(index, value) {
//               var sr_no = value.sr_no;
//               var id = value.id;
//               var saveans = value.answer;
//               var qusid = value.question_id;
//               var type = $('.re' + sr_no).attr('type');
//               if(saveans) {
//                   if(type == 'text' || type == 'number') {
//                       $('.sr' + sr_no).css('background-color', 'green');
//                       $('.review').click(function(){
//                           var revi = $(this).attr('data-review');
//                           var invalue = $('.re' + revi).val();
//                           if(invalue) {
//                               $('.sr' + revi).css({background:'linear-gradient(green, purple)'});
//                           }
//                       });
//                       $.each(JSON.parse(raa), function(index1, value1) {
//                           if(value.sr_no == value1.review_id) {
//                               $('.sr' + sr_no).css({background:'linear-gradient(green, purple)'});
//                           }
//                       });
//                   } else if(type == 'radio') {
//                       let isChecked = $('.shans' + saveans).is(':checked');
//                       if(isChecked == true) {
//                           $.each(JSON.parse(raa), function(index1, value1) {
//                               if(value.sr_no == value1.review_id) {
//                                   $('.sr' + sr_no).css({background:'linear-gradient(green, purple)'});
//                               } else if(saveans) {
//                                   $('.sr' + sr_no).css('background-color', 'green');
//                               }
//                           });

//                           $('.qus').click(function(){
//                               var dat = $(this).attr('data-set');
//                               $('.sr' + dat).css('background-color', 'green');
//                           });
//                           $('.review').click(function(){
//                               var reviess = $(this).attr('data-review');
//                               if(isChecked == true) {
//                                   $('.re' + reviess).trigger("click");
//                               }
//                           });
//                           $('.sr' + sr_no).css('background-color', 'green');
//                       }
//                   }
//               }
//           });
//       }
//   });
// });
//   //endnew
  
//   //old qus with next
//   // $(document).ready(function() {
//   //   $('.qus').click(function(){
//   //     var setsave =  $(this).attr('data-set');
//   //     $('.nextdata').attr('data-save',setsave);
//   //         var ct = 0;
//   //     $('.nextdata').click(function () {  
        
//   //         var save = $(this).attr('data-save');
//   //         ct += 1;
//   //         var save1 =  parseInt(save) +ct;
//   //         var sr_no = [save1 - 1];
//   //         var section_name = [$('.section').val()];
//   //         var test_id = [$('.testid').val()];
//   //         var user_id = [$('.userid').val()];
//   //         var paper_id = [$('.paperid').val()];
//   //         var ans_duration =[$('.countdown').text()];
//   //         //console.log(ans_duration,"okk1");
//   //         var set_type = [$('.set_type').val()];
//   //         var ansset = save1-1;
//   //          var answer = $('.re'+ansset).val();
//   //         if(answer){
//   //            var answer = [$('.re'+ansset).val()];
//   //         }else{
//   //           var answer = $('.re' + ansset).filter(':checked').map(function() {
//   //               return this.value;
//   //             }).get();
//   //         }
//   //         $.ajaxSetup({
//   //           headers: {
//   //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//   //           }
//   //         });
//   //         $.ajax({
//   //            url: 'https://test.mbaguru.in/student/savenexthalfquiz',
//   //            type: "POST",
//   //             data: {
//   //                test_id: test_id,
//   //                paper_id: paper_id,
//   //                section_name: section_name,
//   //                user_id: user_id,
//   //                answer: answer,
//   //                sr_no: sr_no,
//   //                set_type:set_type,
//   //                ans_duration: ans_duration
//   //             },
//   //             cache: false,
//   //             success: function(dataResult){
//   //              //console.log(dataResult);
//   //              var dataResult = JSON.parse(dataResult);
//   //              if(dataResult.statusCode==200){
//   //              //  location.reload(true);  
//   //               //console.log(dataResult); 
//   //              }
//   //              else if(dataResult.statusCode==201){
//   //                //alert("Error occured !");
//   //              }
//   //             }
//   //           });
//   //     })
//   //   })
//   // })
// //end qus with next

// // new qus with next
// $(document).ready(function() {
//     window.addEventListener('offline', function(e) {
//         window.location.href = "/no-internet"; // Redirect to a no internet page
//     });
//     $('.qus').click(function(){
//         var setsave = $(this).attr('data-set');
//         $('.nextdata').attr('data-save', setsave);
//          var ct = 0;
//         $('.nextdata').click(function () {
//             if (!navigator.onLine) {
//                 window.location.href = "/no-internet"; // Redirect to a no internet page
//                 return; // Stop further execution
//             }
            
//             var save = $(this).attr('data-save');
//             ct += 1;
//             var save1 = parseInt(save) + ct;
//             var sr_no = [save1 - 1];
//             var section_name = [$('.section').val()];
//             var test_id = [$('.testid').val()];
//             var user_id = [$('.userid').val()];
//             var paper_id = [$('.paperid').val()];
//             var ans_duration =[$('.countdown').text()];
//             var set_type = [$('.set_type').val()];
//             var ansset = save1 - 1;
//             var answer = $('.re' + ansset).val();
//             if(answer){
//                 var answer = [$('.re' + ansset).val()];
//             } else {
//                 var answer = $('.re' + ansset).filter(':checked').map(function() {
//                     return this.value;
//                 }).get();
//             }
//               var ans_du =$('.countdown').text();
//               if(ans_du=="0:00"){
//                   $('#myModal').modal('show');
//               }else{
//             //     $.ajaxSetup({
//             //         headers: {
//             //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             //         }
//             //     });
//             //     $.ajax({
//             //     url: 'https://test.mbaguru.in/student/savenexthalfquiz',
//             //     type: "POST",
//             //     data: {
//             //         test_id: test_id,
//             //         paper_id: paper_id,
//             //         section_name: section_name,
//             //         user_id: user_id,
//             //         answer: answer,
//             //         sr_no: sr_no,
//             //         set_type: set_type,
//             //         ans_duration: ans_duration
//             //     },
//             //     cache: false,
//             //     success: function(dataResult) {
//             //         var dataResult = JSON.parse(dataResult);
//             //         if(dataResult.statusCode == 200) {
//             //             // Handle success
//             //         } else if(dataResult.statusCode == 201) {
//             //             // Handle error
//             //         }
//             //     },
          
//             // });
//               }
//         });
//     });
// });

// //end qus with next


// $('.next').click(function(){
//   $('.rev').prop("disabled", true).addClass("disabled");
//       $('.rem').click(function(){
//         $('.rev').prop("disabled", false).removeClass("disabled");
//       })
// })


// $('.qus').click(function(){
//  var ct = 0;
//   var set1 = $(this).attr('data-set');
//   var set = $('.rev').attr('data-rev',set1);

//   $('.nextdata').click(function(){
//      var save = $(this).attr('data-save');
//           ct += 1;
//           var save1 =  parseInt(save) +ct;
//           var set = $('.rev').attr('data-rev',save1);

//   })
 
// })



// // function preventBackNavigation() {
  
// //     history.pushState(null, null, window.location.href);
// //     // Listen for the back navigation event
// //     window.addEventListener("popstate", function () {
// //         const confirmLeave = confirm("Are you sure you want to go back?");
// //       // alert(confirmLeave);
// //          var datastring = $("form").serialize();
// //             //   var countdownText = $('.countdown').text();
// //             // console.log(countdownText,"countdownText"); 
// //             // return false;
// //         if (confirmLeave  == true) {
          
// //             //   if(countdownText=="0:00"){
// //                 $.ajaxSetup({
// //                     headers: {
// //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// //                     }
// //                 });
// //                 $.ajax({
// //             method: 'POST', 
// //             url: 'https://test.mbaguru.in/student/savequizedata',
// //             data: datastring, // No need to JSON.stringify for a serialized string

// //             success: function(response){
// //                 console.log(response.message);
// //                 // Optionally, you can re-enable the button if needed
// //                 // $btn.removeAttr('disabled');
// //                 // $btn.attr('disabled', 'disabled');
// //                   window.location.href = "https://test.mbaguru.in/student/dashboard"; // Replace with your next page URL
                 
// //             },
// //             error: function(jqXHR, textStatus, errorThrown) { 
// //                 console.log(JSON.stringify(jqXHR));
// //                 console.log("AJAX error: " + textStatus + ' : ' + errorThrown);

// //                  // Re-enable the button to allow retrying
// //                 // $btn.removeAttr('disabled');
// //                  //$btn.attr('disabled', 'disabled');
// //                     window.location.href = "https://test.mbaguru.in/student/dashboard"; // Replace with your next page URL
// //             },
// //         });
          
// //         } else {
// //             // Prevent back navigation by adding the state again
// //             history.pushState(null, null, window.location.href);
// //         }
// //     });
// // }
// // preventBackNavigation();







// $('.rem').click(function() { 
//     $(this).attr('checked',true);
//     var valu = $(this).attr('data-value');
//     console.log("Value from data-value: ", valu);

//     var selector = '.res' + valu; // Updated selector
//     console.log("Expected selector: ", selector);

//     var checkedInput = $(selector).filter(':checked');
//     console.log("Checked input: ", checkedInput);
//     console.log("Input HTML: ", checkedInput[0].outerHTML);

//     // Use prop() to get the value
//     var answer = checkedInput.map(function() {
//         console.log("Element value during map (prop): ", $(this).prop('value'));
//         return $(this).prop('value');
//     }).get();
//     console.log("Selected Answer: ", answer);

//     if (answer.length === 0 || answer[0] === '') {
//         alert("Please select an answer before proceeding.");
//         return;
//     }

//     // Proceed with AJAX if an answer is selected
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     $.ajax({
//         url: 'https://test.mbaguru.in/student/savenexthalfquiznew',
//         type: "POST",
//         data: {
//             test_id: $('.testid').val(),
//             paper_id: $('.paperid').val(),
//             section_name: $('.section').val(),
//             user_id: $('.userid').val(),
//             question_id:valu,
//             answer: answer,
//             sr_no: valu,
//             set_type: $('.set_type').val(),
//             ans_duration: $('.countdown').text()
//         },
//         cache: false,
//         success: function(dataResult) {
//             console.log("AJAX Response:", dataResult);
//         },
//         error: function(xhr, status, error) {
//             console.error("AJAX Error:", status, error);
//         }
//     });
// });


$('.rem').click(function () { 
    var valu = $(this).attr('data-value');
    console.log("Value from data-value: ", valu);

    var selector = '.res' + valu; 
    console.log("Expected selector: ", selector);

    var checkedInput = $(selector).filter(':checked');
    console.log("Checked input: ", checkedInput);
    console.log("Input HTML: ", checkedInput[0]?.outerHTML);

    // Use prop() to get the single value
    var answer = checkedInput.prop('value');
    console.log("Selected Answer: ", answer);

    // if (!answer) {
    //     alert("Please select an answer before proceeding.");
    //     return;
    // }

    // Proceed with AJAX if an answer is selected
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: 'https://test.mbaguru.in/student/savenexthalfquiznew',
        type: "POST",
        data: {
            test_id: $('.testid').val(),
            paper_id: $('.paperid').val(),
            section_name: $('.section').val(),
            user_id: $('.userid').val(),
            answer: answer, // Use single value
            sr_no: valu,
            question_id: valu,
            set_type: $('.set_type').val(),
            ans_duration: $('.countdown').text()
        },
        cache: false,
        success: function (dataResult) {
            console.log("AJAX Response:", dataResult);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
});

$('.rem').on('blur', function() {
    var valu = $(this).attr('data-value');
    var answer =  $('.res'+valu).val();
    
    // if (!answer) {
    //     alert("Please select an answer before proceeding.");
    //     return;
    // }

    // Proceed with AJAX if an answer is selected
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: 'https://test.mbaguru.in/student/savenexthalfquiznew',
        type: "POST",
        data: {
            test_id: $('.testid').val(),
            paper_id: $('.paperid').val(),
            section_name: $('.section').val(),
            user_id: $('.userid').val(),
            answer: answer, // Use single value
            sr_no: valu,
            question_id: valu,
            set_type: $('.set_type').val(),
            ans_duration: $('.countdown').text()
        },
        cache: false,
        success: function (dataResult) {
            console.log("AJAX Response:", dataResult);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
});



//     $('.rem').on('blur', function() {
//       var value1= $(this).attr('data-value1'); 
//       var valu = $(this).attr('data-value'); 
//       var section_name = [$('.section').val()];
//       var test_id = [$('.testid').val()];
//       var user_id = [$('.userid').val()];
//       var paper_id = [$('.paperid').val()];
//       var set_type = [$('.set_type').val()];
//       var ans_duration =[$('.countdown').text()];
//       var sr_no = [valu];
//       var answer = [$('re'+value1).val()];
//       var ans_du = $('.countdown').text();
//      // console.log(answer,"answer");
//     if(ans_du=="0:00"){
//       $('#myModal').modal('show');
//     } else{
//         // $.ajaxSetup({
//         //     headers: {
//         //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         //     }
//         // });
//         // $.ajax({
//         //     url: 'https://test.mbaguru.in/student/savenexthalfquiz',
//         //     type: "POST",
//         //     data: {
//         //         test_id: test_id,
//         //         paper_id: paper_id,
//         //         section_name: section_name,
//         //         user_id: user_id,
//         //         answer: answer,
//         //         sr_no: sr_no,
//         //         set_type: set_type,
//         //         ans_duration: ans_duration
//         //     },
//         //     cache: false,
//         //     success: function(dataResult, textStatus, jqXHR) {
//         //       console.log("okk1");
//         //         var dataResult = JSON.parse(dataResult);
//         //         if(dataResult.statusCode == 200) {
//         //         } else if(dataResult.statusCode == 201) {
//         //         }
//         //     },
//         // });
//     }
// })



        


  