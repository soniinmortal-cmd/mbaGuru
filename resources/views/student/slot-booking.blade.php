@extends('student_template')

@section('css')
@endsection
@section('content')

<div class="col-md-9 bg-light py-3 " id="right-menu-bar">
    <div id="topbar-right-menu " class="d-flex  px-3 my-3 justify-content-between align-items-center">
        <!-- <h5 class="fw-bold text-capitalize">Slot Booking </h5> -->
        <a class="text-dark" href="{{route('student.booking_detail')}}" style="float:right;">Your booked slot</a>
    </div>
    <?php
    if(isset($newcourses)){
    $newtests = DB::table('tests')
                ->leftjoin('proctored', 'tests.id', '=', 'proctored.test_id')
                ->select('tests.*', 'proctored.course_id', 'proctored.status')
                ->where('tests.course_id',$newcourses->course_id)
                ->where('proctored.status',1)
                //->orderByRaw("CASE WHEN tests.test LIKE '%AIRCAT%' THEN 0 ELSE 1 END")
                ->get();
    }

    //         dd($newtests);

    //         $curdate = date("Y-m-d");

    //     $seats = DB::table('seats')
    //                     ->where('test_id',$request->test_id)
    //                     ->where('course_id',$request->course_id)
    //                     ->where('center_id',$request->center_id)
    //                     ->where('from_date','>=', $curdate)
    //                     ->orderBy('from_date','asc')
    //                     ->get();
    
    //    $stubooking = DB::table('remaining_seats')
    //                     ->where('test_id',$request->test_id)
    //                     ->where('course_id',$request->course_id)
    //                    //->where('center_id',$request->center_id)
    //                    ->where('booking_date','>=', $curdate)
    //                     ->get();
    ?>
    <div class="container">
        <div class="row px-2 my-5">
            <div class="col-md-10 px-1">
                <div class="card bg-white py-4 my-5 px-2 display-box-data">
                    <div class="row mx-3">
                        <div class="col-md-4">
                        <div class="form-group">
                            <label>Choose Test Type:</label>
                           
                            <select class="form-control" name ="course_id" id="course-dropdown">
                                {{-- <option>Select Course</option> --}}
                                @foreach($courses as $course)
                                <option value="{{$course->id}}">{{$course->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br/>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Choose Test Code:</label>
                          <select class="form-control" name ="test_id" id="test-dropdown" style="display:none"></select>

                            <select class="form-control myrecord" name ="test_id">
                                @if(isset($newtests))
                                    @foreach($newtests as $newtest)
                                    <option value="{{ $newtest->id }}">{{$newtest->test}}</option>
                                    @endforeach
                                @endif
                           </select>
                        </div>
                        <br/>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Choose Center:</label>
                          <select class="form-control" name ="center_id" id="center">
                            {{-- <option>Select Center</option> --}}
                            @foreach($centers as $center)
                            <option value="{{$center->id}}">{{$center->centername}}</option>
                            @endforeach
                          </select>
                        </div>
                        <br/>
                    </div>
                        </div>
                    <div class ="col-md-12">
                      <table class="table table-bordered mytable" style="diaplay:none">
                        <tbody>
                        </tbody>
                      </table>
                      {{-- <table class="table table-bordered mynewtable">
                        <tbody>
                            <td>test<td>
                        </tbody>
                      </table> --}}
                        <button class="btn btn-primary subm" style="display:none" data-sts="1">BOOK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
$(document).ready(function () {
    $('#course-dropdown').on('change', function () {
        $(".mytable").html('');
        $('.myrecord').css('display','none');
        $('#test-dropdown').css('display','block');
        $('.mynewtable').css('display','none');
        $('.mytable').css('display','block');
        $('.seats').css('display','none');
        var idCourse = this.value;
        $('.course_id').val(idCourse);
        $("#test-dropdown").html('');
        //$("#center").html('');
        $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
        $.ajax({
            url: "{{route('student.fetch-test')}}",
            type: "POST",
            data: {
                course_id: idCourse,
            },
            dataType: 'json',
            success: function (result) {
                $('#test-dropdown').html('<option value="">-- Select Test --</option>');
                $.each(result.test, function (key, value) {
                    $("#test-dropdown").append('<option value="' + value
                        .id + '">' + value.test + '</option>');
                });
            }
        });
    });

//start old table
//old code

//end old table
//new code
$('#center').on('change', function () {
    $('.subm').css('display', 'block');
    var course_id = $('#course-dropdown').val();
    var test_id = $('#test-dropdown').val();
    var center_id = this.value;
    $(".mytable").html('');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{route('student.fetch-table')}}",
        type: "POST",
        data: {
            course_id: course_id,
            test_id: test_id,
            center_id: center_id,
        },
        dataType: 'json',
        success: function (result) {
            $.each(result.seats, function (key, value) {
                var markup = '<tr><td><input class="booking-date' + key + '" type="hidden" name="booking_date[]" value="' + value.from_date + '">' + value.from_date + '</td>';
                var fromtime = value.from_time.split(',');
                var totime = value.to_time.split(',');

                $.each(fromtime, function (index1, value1) {
                    markup += '<td><span></span><span>' + value1 + '</span>-';
                    var newtime = value1 + '-' + totime[index1];

                    // Initialize flag to track if the seat availability is already displayed
                    var seatDisplayed = false;

                    if (result.stubooking.length) {
                        console.log(result.stubooking.length,"result.stubooking.length");
                        $.each(result.stubooking, function (index3, value3) {
                            if (value.from_date == value3.booking_date && newtime == value3.booking_time) {
                                markup += '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + totime[index1] + '" data-set="' + value.from_date + '" data-avseats="' + value3.remaining_seats + '" style="float: left">';
                                markup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;">';
                                markup += '<p>Available Seats - ' + value3.remaining_seats + '</p>';
                                seatDisplayed = true; // Mark seat as displayed
                                return false; // Exit the loop early
                            }
                        });

                        if (!seatDisplayed) { // If no seat was displayed
                         console.log(seatDisplayed,"seatDisplayed");
                            markup += '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + totime[index1] + '" data-set="' + value.from_date + '" data-avseats="' + value.seats + '" style="float: left">';
                            markup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;">';
                            markup += '<p>Available Seats - ' + value.seats + '</p>';
                        }
                    } else { // If there are no bookings
                     console.log(result.stubooking.length,"else case result.stubooking.length");
                        markup += '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + totime[index1] + '" data-set="' + value.from_date + '" data-avseats="' + value.seats + '" style="float: left">';
                        markup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;">';
                        markup += '<p>Available Seats - ' + value.seats + '</p>';
                    }

                    markup += '</div></td>';
                });

                markup += '</tr>';
                $('.mytable').append(markup);
            });

            let latestAvData = {}; // Object to store the latest .av data

            $('.av').click(function () {
                // Store the latest data in the object
                latestAvData.id = $(this).attr('data-id');
                latestAvData.booking_date = $(this).attr('data-set');
                latestAvData.booking_time = $(this).val();
                latestAvData.course_id = $('#course-dropdown').val();
                latestAvData.test_id = $('#test-dropdown').val();
                latestAvData.center_id = $('#center').val();
                latestAvData.remaining_seats = $(this).attr('data-avseats');
            });

            $('.subm').off('click').on('click', function () {
                var newbook = $(this).attr('data-sts');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('student.save-booking')}}",
                    type: "POST",
                    data: {
                        booking_date: latestAvData.booking_date,
                        booking_time: latestAvData.booking_time,
                        course_id: latestAvData.course_id,
                        test_id: latestAvData.test_id,
                        center_id: latestAvData.center_id,
                        remaining_seats: latestAvData.remaining_seats,
                        newbook: newbook
                    },
                    dataType: 'json',
                    success: function (result) {
                        if (result.success == 2) {
                            alert('You cannot book the slot as you have reached the maximum number of bookings.');
                            rurl = "{{ route('student.booking_detail') }}";
                            window.location.href = rurl;
                        } else if (result.success == 3) {
                            alert('Already Booked.');
                            rurl = "{{ route('student.booking_detail') }}";
                            window.location.href = rurl;
                        } else if (result.success == 4) {
                            alert('Seat is not Available!!');
                            rurl = "{{ route('student.booking_detail') }}";
                            window.location.href = rurl;
                        } else if (result.success == 5) {
                            alert('Unable to book!!');
                            rurl = "{{ route('student.booking_detail') }}";
                            window.location.href = rurl;
                        } else if (result.success == 1) {
                            rurl = "{{ route('student.booking_detail') }}";
                            window.location.href = rurl;
                        } else {
                            console.log(result);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
            });
        }
    });
});


});
</script>


<script>
//old center trigger change


//new center trigger change
$(document).ready(function () {
    $('#center').trigger('change');
    $('.subm').css('display', 'block');

    var course_id = $('#course-dropdown option:first').val();
    var test_id = $('.myrecord option:first').val();
    var center_id = $('#center option:first').val();
    $(".mytable").html('');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{route('student.fetch-table')}}",
        type: "POST",
        data: {
            course_id: course_id,
            test_id: test_id,
            center_id: center_id,
        },
        dataType: 'json',
        success: function (result) {
            $.each(result.seats, function (key, value) {
                var markup = '<tr><td><input class="booking-date' + key + '" type="hidden" name="booking_date[]" value="' + value.from_date + '">' + value.from_date + '</td>';
                var fromtime = value.from_time.split(',');
                var totime = value.to_time.split(',');

                $.each(fromtime, function (index1, value1) {
                    markup += '<td><span></span><span>' + value1 + '</span>-';
                    
                    if (totime[index1]) {
                        markup += '<span>' + totime[index1] + '</span>';
                        var newtime = value1 + '-' + totime[index1];

                        var isSeatAvailable = false;
                        var seatMarkup = '';

                        if (result.stubooking.length) {
                            $.each(result.stubooking, function (index3, value3) {
                                if (value.from_date == value3.booking_date && newtime == value3.booking_time) {
                                      console.log(value.from_date,"value.from_date");
                                    isSeatAvailable = true;
                                    seatMarkup = '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + totime[index1] + '" data-set="' + value.from_date + '" data-avseats="' + value3.remaining_seats + '" style="float: left">';
                                    seatMarkup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;"><p>Available Seats-' + value3.remaining_seats + '</p></div>';
                                }
                            });
                        }

                        if (!isSeatAvailable) {
                              console.log(isSeatAvailable,"isSeatAvailable");
                            seatMarkup = '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + totime[index1] + '" data-set="' + value.from_date + '" data-avseats="' + value.seats + '" style="float: left">';
                            seatMarkup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;"><p>Available Seats-' + value.seats + '</p></div>';
                        }

                        markup += seatMarkup;
                    }

                    markup += '</td>';
                });

                markup += '</tr>';
                $('.mytable').append(markup);
            });

            let latestAvData = {};

            $('.av').click(function () {
                latestAvData.id = $(this).attr('data-id');
                latestAvData.booking_date = $(this).attr('data-set');
                latestAvData.booking_time = $(this).val();
                latestAvData.course_id = $('#course-dropdown option:first').val();
                latestAvData.test_id = $('.myrecord').val();
                latestAvData.center_id = $('#center').val();
                latestAvData.remaining_seats = $(this).attr('data-avseats');
            });

            $('.subm').off('click').on('click', function () {
                var newbook = $(this).attr('data-sts');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('student.save-booking')}}",
                    type: "POST",
                    data: {
                        booking_date: latestAvData.booking_date,
                        booking_time: latestAvData.booking_time,
                        course_id: latestAvData.course_id,
                        test_id: latestAvData.test_id,
                        center_id: latestAvData.center_id,
                        remaining_seats: latestAvData.remaining_seats,
                        newbook: newbook
                    },
                    dataType: 'json',
                    success: function (result) {
                        if (result.success == 2) {
                            alert('You cannot book the slot as you have reached the maximum number of bookings.');
                        } else if (result.success == 3) {
                            alert('Already Booked.');
                        } else if (result.success == 4) {
                            alert('Seat is not Available!!');
                        } else if (result.success == 5) {
                            alert('Unable to book!!');
                        } else {
                            console.log(result);
                        }
                        if (result.success == 1) {
                            window.location.href = "{{ route('student.booking_detail') }}";
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
            });
        }
    });
});

</script>

//

<script>
//old code

//newcode
$(document).ready(function () {
    $('#center').on('change', function () {
        $(".mytable").html('');
        $('.subm').css('display', 'block');
        var course_id = $('#course-dropdown option:first').val();
        var test_id = $('.myrecord').val();
        var center_id = $(this).val();

        $(".mytable").html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('student.fetch-table')}}",
            type: "POST",
            data: {
                course_id: course_id,
                test_id: test_id,
                center_id: center_id,
            },
            dataType: 'json',
            success: function (result) {
                
                $.each(result.seats, function (key, value) {
                   
                    var markup = '<tr><td><input class="booking-date' + key + '" type="hidden" name="booking_date[]" value="' + value.from_date + '">' + value.from_date + '</td>';
                    var fromtime = value.from_time.split(',');
                    var totime = value.to_time.split(',');

                    $.each(fromtime, function (index1, value1) {
                        markup += '<td><span></span>' +
                            '<span>' + value1 + '</span>-';
                        $.each(totime, function (index2, value2) {
                            if (index1 == index2) {
                                markup += '<span>' + value2 + '</span>';
                                var newtime = value1 + '-' + value2;
                                var added = false; // Flag to check if seats are added

                                if (result.stubooking.length) {
                                    var i = 0;
                                    $.each(result.stubooking, function (index3, value3) {
                                     
                                        if ((value.from_date == value3.booking_date) && (newtime == value3.booking_time) && !added) {
                                            i = 1;
                                            markup += '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + value2 + '"/ data-set="' + value.from_date + '" data-avseats="' + value3.remaining_seats + '" style="float: left">';
                                            markup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;">';
                                            markup += '<p>Available Seats-' + value3.remaining_seats + '</p>';
                                            markup += '</div>';
                                            added = true; // Set flag to true
                                        }
                                    });

                                    if (i == 0 && !added) {
                                    //      console.log(value.seats,"added");
                                    //     markup += '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + value2 + '"/ data-set="' + value.from_date + '" data-avseats="' + value.seats + '" style="float: left">';
                                    //     markup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;">';
                                    //   markup += '<p>Available Seats-' + value.seats + '</p>';///wrong value showing 
                                         
                                    //       //markup += '<p>Available Seats-' + value3.remaining_seats + '</p>';
                                    //     markup += '</div>';
                                    //     added = true; // Set flag to true
                                    
                                    
                                     // right seats for multiple booking issue  resolving 
                                     
                                            let lastValue3 = null;
    
                                            $.each(result.stubooking, function (index3, value3) {
                                                if (value3.booking_date == value.from_date && (newtime == value3.booking_time)) {
                                                    lastValue3 = value3; // Keep updating last match
                                                }
                                            });
                                            
                                            // Now after the loop, use the last matched value
                                            if (lastValue3 !== null) {
                                                console.log(lastValue3, "Last matched value3...");
                                                markup += '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + value2 + '" data-set="' + value.from_date + '" data-avseats="' + lastValue3.remaining_seats + '" style="float: left">';
                                                markup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;">';
                                                markup += '<p>Available Seats - ' + lastValue3.remaining_seats + '</p>';
                                                markup += '</div>';
                                                added = true;
                                            }else{
                                                 markup += '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + value2 + '" data-set="' + value.from_date + '" data-avseats="' + value.seats + '" style="float: left">';
                                                markup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;">';
                                                markup += '<p>Available Seats - ' + value.seats + '</p>';
                                                markup += '</div>';
                                                added = true;
                                            }
    
                                         }
                                   
                                    
                                } else if (!added) {
                                       console.log(value.seats,"added1value");
                                        // right seats for multiple booking issue  resolving 
                                        let lastValue4 = null;
                                          $.each(result.stubooking, function (index3, value3) {
                                                if (value3.booking_date == value.from_date && (newtime == value3.booking_time)) {
                                                    lastValue4 = value3; // Keep updating last match
                                                }
                                            });
                                            ///end loop value for right seat showing 
                                            //console.log(lastValue4.remaining_seats,"lastValue4.remaining_seats...");
                                            if (lastValue4 && lastValue4.remaining_seats !== undefined) {
                                                markup += '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + value2 + '"/ data-set="' + value.from_date + '" data-avseats="' + lastValue4.remaining_seats + '" style="float: left">';
                                                markup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;">';
                                              // markup += '<p>Available Seats-' + value.seats + '</p>';  //for wrong slot is showing changes
                                              markup += '<p>Available Seats-' + lastValue4.remaining_seats + '</p>';
                                                markup += '</div>';
                                                added = true; // Set flag to true
                                            }else{
                                                
                                                markup += '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + value2 + '"/ data-set="' + value.from_date + '" data-avseats="' + value.seats + '" style="float: left">';
                                                markup += '<div class="px-3 text-success av-seats" style="font-size:18px!important;">';
                                               // markup += '<p>Available Seats-' + value.seats + '</p>';  //for wrong slot is showing changes
                                               markup += '<p>Available Seats-' + value.seats + '</p>';
                                                markup += '</div>';
                                                added = true; // Set flag to true
                                                
                                            }
                                }

                                markup += '</td>';
                            }
                        });
                    });

                    markup += '</tr>';
                    $('.mytable').append(markup);
                });

                let latestAvData = {};  // Object to store the latest .av data

                $('.av').click(function () {
                    // Store the latest data in the object
                    latestAvData.id = $(this).attr('data-id');
                    latestAvData.booking_date = $(this).attr('data-set');
                    latestAvData.booking_time = $(this).val();
                    latestAvData.course_id = $('#course-dropdown option:first').val();
                    latestAvData.test_id = $('.myrecord').val();
                    latestAvData.center_id = $('#center').val();
                    latestAvData.remaining_seats = $(this).attr('data-avseats');
                });

                $('.subm').off('click').on('click', function () {
                    var newbook = $(this).attr('data-sts');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{route('student.save-booking')}}",
                        type: "POST",
                        data: {
                            booking_date: latestAvData.booking_date,
                            booking_time: latestAvData.booking_time,
                            course_id: latestAvData.course_id,
                            test_id: latestAvData.test_id,
                            center_id: latestAvData.center_id,
                            remaining_seats: latestAvData.remaining_seats,
                            newbook: newbook
                        },
                        dataType: 'json',
                        success: function (result) {
                            if (result.success == 2) {
                                alert('You cannot book the slot as you have reached the maximum number of bookings.');
                                rurl = "{{ route('student.booking_detail') }}";
                                window.location.href = rurl;
                            } else if (result.success == 3) {
                                alert('Already Booked.');
                                rurl = "{{ route('student.booking_detail') }}";
                                window.location.href = rurl;
                            } else if (result.success == 4) {
                                alert('Seat is not Available!!');
                                rurl = "{{ route('student.booking_detail') }}";
                                window.location.href = rurl;
                            } else if (result.success == 5) {
                                alert('Unable to book!!');
                                rurl = "{{ route('student.booking_detail') }}";
                                window.location.href = rurl;
                            } else {
                                console.log(result);
                            }
                            if (result.success == 1) {
                                rurl = "{{ route('student.booking_detail') }}";
                                window.location.href = rurl;
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(JSON.stringify(jqXHR));
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    });
                });
            }
        });
    });
});

</script>

<script>
//old myrecord change


//new myrecord change
$(document).ready(function () {
    $('.myrecord').on('change', function () {
        $(".mytable").html('');

        var test_id = $(this).val();
        $('.subm').css('display', 'block');
        var course_id = $('#course-dropdown option:first').val();
        var center_id = $('#center').val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{route('student.fetch-table')}}",
            type: "POST",
            data: {
                course_id: course_id,
                test_id: test_id,
                center_id: center_id,
            },
            dataType: 'json',
            success: function (result) {
                $.each(result.seats, function (key, value) {
                    var markup = '<tr><td><input class="booking-date' + key + '" type="hidden" name="booking_date[]" value="' + value.from_date + '">' + value.from_date + '</td>';
                    var fromtime = value.from_time.split(',');
                    var totime = value.to_time.split(',');

                    $.each(fromtime, function(index1, value1) {
                        markup += '<td><span></span><span>' + value1 + '</span>-';

                        if (index1 < totime.length) {
                            var newtime = value1 + '-' + totime[index1];
                            markup += '<span>' + totime[index1] + '</span>';
                            
                            // Check for existing bookings and available seats
                            var seatInfo = result.seats;
                            var seatMarkup = '';
                            var seatFound = false;

                            $.each(result.stubooking, function(index3, value3) {
                                if (value.from_date == value3.booking_date && newtime == value3.booking_time) {
                                    console.log(value3.remaining_seats,"value3.remaining_seats");
                                    seatFound = true;
                                    seatMarkup = '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + totime[index1] + '" data-set="' + value.from_date + '" data-avseats="' + value3.remaining_seats + '" style="float: left">';
                                    seatMarkup += '<div class="px-3 text-success av-seats" style="font-size: 18px!important;">';
                                    seatMarkup += '<p>Available Seats - ' + value3.remaining_seats + '</p>';
                                    seatMarkup += '</div>';
                                    return false; // Break the loop once a match is found
                                }
                            });

                            if (!seatFound) {
                                  console.log(value.seats,"value.seats2");
                                seatMarkup = '<input type="radio" name="book_seat[]" class="av" value="' + value1 + '-' + totime[index1] + '" data-set="' + value.from_date + '" data-avseats="' + value.seats + '" style="float: left">';
                                seatMarkup += '<div class="px-3 text-success av-seats" style="font-size: 18px!important;">';
                                seatMarkup += '<p>Available Seats - ' + value.seats + '</p>';
                                seatMarkup += '</div>';
                            }

                            markup += seatMarkup + '</td>';
                        }
                    });

                    markup += '</tr>';
                    $('.mytable').append(markup);
                });

                let latestAvData = {};  // Object to store the latest .av data

                $('.av').click(function() {
                    // Store the latest data in the object
                    latestAvData.id = $(this).attr('data-id');
                    latestAvData.booking_date = $(this).attr('data-set');
                    latestAvData.booking_time = $(this).val();
                    latestAvData.course_id = $('#course-dropdown option:first').val();
                    latestAvData.test_id = $('.myrecord').val();
                    latestAvData.center_id = $('#center').val();
                    latestAvData.remaining_seats = $(this).attr('data-avseats');
                });

                $('.subm').off('click').on('click', function() {
                    var newbook = $(this).attr('data-sts');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{route('student.save-booking')}}",
                        type: "POST",
                        data: {
                            booking_date: latestAvData.booking_date,
                            booking_time: latestAvData.booking_time,
                            course_id: latestAvData.course_id,
                            test_id: latestAvData.test_id,
                            center_id: latestAvData.center_id,
                            remaining_seats: latestAvData.remaining_seats,
                            newbook: newbook
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.success == 2) {
                                alert('You cannot book the slot as you have reached the maximum number of bookings.');
                            } else if (result.success == 3) {
                                alert('Already Booked.');
                            } else if (result.success == 4) {
                                alert('Seat is not Available!!');
                            } else if (result.success == 5) {   
                                alert('Unable to book!!');
                            } else if (result.success == 1) {
                                window.location.href = "{{ route('student.booking_detail') }}";
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) { 
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    });
                });
            }
        });
    });
});

 
</script>







