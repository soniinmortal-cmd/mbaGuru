$('.nonaircat').css('display','none');
        $(".resuminput").hover(
            function () {
               var id = $(this).attr('data-id');
                  $('.par'+id).text('Only applicable for taking test in MBAGuru centres/labs').css('font-size','11px');
            },
            function () {
               var id = $(this).attr('data-id');
               // $('.par'+id).css("display","none");
            }
        );

    
    
    $(document).ready(function() {
    $('.resum').click(function(){
        localStorage.clear();
    });
});





//correct test record
// $('.newcenter').on('click', function() {
//     // Show the loader
//     $('#loader').show();
//      $('.pagination').css('display', 'none');
//     $('.nomytable').css('display', 'none');
//     var course_id = $(this).attr('data-id');
    
//   // var url1 = "{{ route('student.fetch-test-record') }}";
//   var url1 ='https://test.mbaguru.in/student/fetch-test-record';
//     $(".mytable").html('');
    
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
    
//     $.ajax({
//         url: url1,
//         type: "POST",
//         data: {
//             course_id: course_id
//         },
//         dataType: 'json',
//         success: function(result) {
//             // Hide the loader after data is loaded
//             $('#loader').hide();
//             $('.mytable').append(result.var_1);
//             $('.resum').click(function() {
//                 localStorage.clear();
//             });
//             $(".resuminput").hover(function() {
//                 var id = $(this).attr('data-id');
//                 $('.par' + id).text('Only applicable for taking test in MBAGuru centres/labs').css('font-size', '11px');
//             }, function() {});
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//             // Hide the loader in case of error as well
//             $('#loader').hide();
            
//             if (jqXHR.status === 200) {
//                 location.reload();
//                 var url2 = "{{ route('student.login') }}";
//                 window.location.replace(url2);
//             } else {
//                 try {
//                     var responseJson = JSON.parse(jqXHR.responseText);
//                     console.error('Server Error: ', responseJson.message);
//                 } catch (e) {
//                     console.error('Invalid JSON response from server');
//                 }
//             }
//         }
//     });
// });
//end test correct record

//new test record with pagin
$(document).ready(function() {
    var currentPage = 1;
    var perPage = 5;
    var course_id = $('.newcenter').attr('data-id');

    // When 'newcenter' is clicked, fetch the first set of records
    $('.newcenter').on('click', function() {
        $('.nomytable').css('display', 'none');
        $('.showpagin').css('display', 'block');
        $('#loader').show();
        $('.pagination').css('display', 'none');
        $('#pagination-controls').css('display', 'block');
        currentPage = 1;  // Reset to the first page
        course_id = $(this).attr('data-id'); // Update course_id if needed

        console.log('Clicked on newcenter, course_id:', course_id);

        loadTests(course_id, currentPage, perPage);  // Clear table is false by default
    });

    function loadTests(course_id, page, perPage) {
        console.log('Loading tests for course_id:', course_id, 'Page:', page);
        $.ajax({
            url: "https://test.mbaguru.in/student/fetch-test-record",
            type: "POST",
            data: {
                course_id: course_id,
                page: page,
                per_page: perPage
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(result) {
                $('#loader').hide();
                $('.mytable').empty();  // Clear the table to show only current page data

                if (result.var_1 && result.var_1.trim() !== '') {
                    $('.mytable').append(result.var_1);
                } else {
                    $('.mytable').append('<tr><td colspan="5">No tests available.</td></tr>');
                }

                // Update test count
                if (result.testdata) {
                    $('.no-test').text(' of ' + result.testdata + ' results');
                }

                // Generate pagination if available
                if (result.current_page && result.last_page) {
                    generatePagination(result.current_page, result.last_page);
                }

                // Update pagination info
                $('#current_page').text(result.current_page || '1');
                $('#total_pages').text(result.last_page || '1');

                // Enable/Disable Previous and Next buttons
                $('#prev-page').prop('disabled', result.current_page === 1);
                $('#next-page').prop('disabled', result.current_page === result.last_page);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#loader').hide();
                console.error('AJAX Error:', jqXHR.responseText);
            }
        });
    }

    // Function to generate pagination buttons
    function generatePagination(currentPage, lastPage) {
        $('#pagination').empty();
        for (var i = 1; i <= lastPage; i++) {
            var button = $('<button/>')
                .text(i)
                .attr('data-page', i)
                .addClass('page-button')
                .css('width', '50px');

            if (i == currentPage) {
                button.addClass('active');
            }

            button.on('click', function() {
                $('#loader').show();
                var selectedPage = $(this).data('page');
                loadTests(course_id, selectedPage, perPage);  // Clear table is false by default
            });

            $('#pagination').append(button);
        }
        $('#loader').hide();
    }

    // Event handler for Previous button
    $('#prev-page').on('click', function() {
        if (currentPage > 1) {
            currentPage--;
            $('#loader').show();
            loadTests(course_id, currentPage, perPage);  // Clear table is false by default
        }
    });

    // Event handler for Next button
    $('#next-page').on('click', function() {
        var total_pages = parseInt($('#total_pages').text(), 10);  // Ensure we are working with numbers
        if (currentPage < total_pages) {
            currentPage++;
            $('#loader').show();
            loadTests(course_id, currentPage, perPage);  // Clear table is false by default
        }
    });
});

// end new test record with pagin
 $(document).ready(function() {
    $('svg').css('display', 'none').css('visibility', 'visible');
    //$('.justify-between').css('display','none');
  });

 $(window).on('load', function() {
        $('svg').addClass('hide-svg');
    });