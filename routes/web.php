<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\StudentLogInController;
use App\Http\Controllers\Student\StudentRecordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/clear-cache', function () {
    // Run artisan commands via shell_exec
    $output = [];
    //$output[] = shell_exec('php ' . base_path('artisan') . ' cache:clear');
     //$output[] = shell_exec('php ' . base_path('artisan') . ' config:clear');
     //$output[] = shell_exec('php ' . base_path('artisan') . ' route:clear');
     //$output[] = shell_exec('php ' . base_path('artisan') . ' view:clear');
     //$output[] = shell_exec('php ' . base_path('artisan') . ' optimize:clear');
     ///$output[] = shell_exec('php ' . base_path('artisan') . ' queue:flush 2>&1');

    // Return all output as a string
    //return implode("<br>", $output) . "<br>Laravel caches cleared!";
//});


//run in url :https://test.mbaguru.in/admin/clear-cache



Route::get('/', function () {
    return view('student.login');
});

// Route::get('/no-internet', function () {
//     return view('errors.no_internet');
// })->name('no.internet');

Route::get('/no-internet', function () {
    return view('errors.no_internet');
});




Route::group(['prefix' => 'student'], function () {

    Route::group(['middleware' => 'student.guest'], function () {
        
        //        // login routes
        Route::get('/student', [StudentLogInController::class, 'index']);
        
        Route::get('/login', [StudentLogInController::class, 'index'])->name('student.login');
        
        Route::post('/login', [StudentLogInController::class, 'login'])->name('student.authentication');
         // Route::post('/savequizedata', [StudentRecordController::class, 'savequizedata'])->name('student.savequizedata');
         
        // register routes
        Route::get('/register', [StudentLogInController::class, 'register'])->name('register');
        Route::post('/register', [StudentLogInController::class, 'register_code'])->name('student.register-code');

        Route::get('/forget-password', [StudentLogInController::class, 'forget_password'])->name('student.forget-password');
         Route::post('/newpassword', [StudentController::class, 'newpassword'])->name('student.newpassword');
    });
 // student authentication routes // */
   // Route::group(['middleware' => 'student.auth'], function () {
   Route::group(['middleware' => ['student.auth', 'check.internet','check.student.session']], function () {
        Route::get('/dashboard', [StudentLogInController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/logout', [StudentLogInController::class, 'logout'])->name('student.logout');
        Route::get('/dashboard', function () {
            return view('student.dashboard');
        })->name('student.dashboard');
        Route::get('/propzone', function () { return view('student.propzone'); })->name('student.propzone');
        Route::get('/test-analytics', function () { return view('student.test_analytics'); })->name('student.test-analytics');
       
        Route::get('/bundle-creation', function () { return view('student.bundlecreation'); })->name('student.bundlecreation');
      
        
          Route::get('/test-template', function () {
            return view('student.testtemplate');
        })->name('student.testtemplate'); 
          Route::get('/launchtest/{id}', [StudentController::class, 'launchtest'])->name('student.launchtest');
          Route::get('/slot-booking', [StudentController::class, 'slotBooking'])->name('student.slot-booking');
            
           
            
        Route::get('/start-test/{id}', [StudentController::class, 'starttest'])->name('student.start-test');
        Route::get('/instructions/{id}', [StudentController::class, 'instructions'])->name('student.instructions');
        Route::get('/nmat-instructions/{id}', [StudentController::class, 'nmatInstructions'])->name('student.nmat-instructions');

        Route::get('/non-disclosure/{id}', [StudentController::class, 'nonDisclosure'])->name('student.non-disclosure');

        Route::get('/nmat-section/{id}', [StudentController::class, 'nmatSection'])->name('student.nmat-section');

         Route::get('/quiz_instructions/{id}', [StudentController::class, 'quizInstructions'])->name('student.quiz_instructions');
        Route::get('/start-quize/{id}/{paperid}', [StudentController::class, 'startQuize'])->name('student.start-quize');
        Route::get('/stop-quiz/{sid}/{id}/{paperid}', [StudentController::class, 'stopQuiz'])->name('student.stop-quiz');
        Route::post('/savequizedata', [StudentController::class, 'savequizedata'])->name('student.savequizedata');

         Route::post('/savequizedata1', [StudentController::class, 'savequizedata1'])->name('student.savequizedata1');
         
           Route::post('/savequizedatanew', [StudentController::class, 'savequizedatanew'])->name('student.savequizedatanew');

        Route::post('/savepaper', [StudentController::class, 'savepaper'])->name('student.savepaper');

         Route::post('/savereview', [StudentController::class, 'savereview'])->name('student.savereview');
         
         Route::post('/savehalfquiz', [StudentController::class, 'savehalfquiz'])->name('student.savehalfquiz');
          Route::post('/savenexthalfquiz', [StudentController::class, 'savenexthalfquiz'])->name('student.savenexthalfquiz');
          Route::post('/savenexthalfquiznew', [StudentController::class, 'savenexthalfquiznew'])->name('student.savenexthalfquiznew');
            
        Route::get('/all-question/{id}', [StudentController::class, 'allQuestion'])->name('student.all-question');
          Route::get('/data-quiz/{sid}/{id}/{paperid}', [StudentController::class, 'dataQuiz'])->name('student.data-quiz');
          Route::get('/quantitative-quiz/{sid}/{id}/{paperid}', [StudentController::class, 'quantitativeQuiz'])->name('student.quantitative-quiz');
          Route::get('/report/{sid}/{id}/{paperid}', [StudentController::class, 'report'])->name('student.report');

          Route::get('/report2/{sid}/{id}/{paperid}', [StudentController::class, 'report2'])->name('student.report2');

          Route::get('/solution/{testid}/{paperid}', [StudentController::class, 'solution'])->name('student.solution');

            Route::get('/datasolution/{testid}/{paperid}', [StudentController::class, 'datasolution'])->name('student.datasolution');

            Route::get('/qtsolution/{testid}/{paperid}', [StudentController::class, 'qtsolution'])->name('student.qtsolution');

            Route::get('/booking_detail', [StudentController::class, 'bookingDetail'])->name('student.booking_detail');
            
            Route::get('/solution-question/{testid}/{sectionid}/{paperid}', [StudentController::class, 'solutionQuestion'])->name('student.solution-question');
              
            Route::get('/solution-instruction/{testid}/{sectionid}/{paperid}', [StudentController::class, 'solutionInstruction'])->name('student.solution-instruction');
            Route::post('/fetch-test', [StudentController::class, 'fetchTest'])->name('student.fetch-test');

            Route::post('/save-booking', [StudentController::class, 'saveBooking'])->name('student.save-booking');

            Route::post('/fetch-table', [StudentController::class, 'fetchTable'])->name('student.fetch-table');
            Route::post('/fetch-accross', [StudentController::class, 'fetchAccross'])->name('student.fetch-accross');
            Route::get('/accross-test', [StudentController::class, 'accrossTest'])->name('student.accross-test');
            Route::get('/fetch-accross1', [StudentController::class, 'fetchAccross1'])->name('student.fetch-accross1');
            Route::get('/nmat-quiz/{id}/{paperid}/{sid}', [StudentController::class, 'nmatQuiz'])->name('student.nmat-quiz');
            Route::get('/nmat-next-quiz/{id}/{paperid}/{sid}/{nextid}', [StudentController::class, 'nmatNextQuiz'])->name('student.nmat-next-quiz');
            Route::get('/nmat-next-page/{id}/{paperid}/{sid}/{nextid}', [StudentController::class, 'nmatNextPage'])->name('student.nmat-next-page');
            Route::get('/nmat-report/{id}/{paperid}/{nextid}', [StudentController::class, 'nmatReport'])->name('student.nmat-report');
            Route::get('/nmat-solution/{testid}/{paperid}', [StudentController::class, 'nmatSolution'])->name('student.nmat-solution');
            Route::get('/languagesolution/{testid}/{paperid}', [StudentController::class, 'languageSolution'])->name('student.languagesolution');
            Route::get('/logicalsolution/{testid}/{paperid}', [StudentController::class, 'logicalSolution'])->name('student.logicalsolution');
            Route::post('/savenmatnexthalfquiz', [StudentController::class, 'savenmatnexthalfquiz'])->name('student.savenmatnexthalfquiz');

            Route::post('/fetch-test-record', [StudentController::class, 'fetchTestRecord'])->name('student.fetch-test-record');
            Route::post('/save-proctored', [StudentController::class, 'saveProctored'])->name('student.save-proctored');

            Route::get('/phonepe', [StudentController::class,'phonepe'])->name('phonepe');
            Route::post('/response', [StudentController::class,'response'])->name('response');
             Route::post('/fetch-test-dashboard/', [StudentController::class, 'fetchTestDashboard'])->name('student.fetch-test-dashboard');
            Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
            Route::post('/profile-update', [StudentController::class, 'profileUpdate'])->name('student.profile-update');
            
              Route::get('/section-instructions/{id}', [StudentController::class, 'sectionInstructions'])->name('student.section-instructions');
               Route::get('/next-section-quiz/{id}/{paperid}/{section_name}', [StudentController::class, 'nextSectionQuiz'])->name('student.next-section-quiz');
             //Route::get('/next-section-quiz/', [StudentController::class, 'nextSectionQuiz'])->name('student.next-section-quiz');
            Route::get('/section-quiz/{id}/{paperid}/{section_name}', [StudentController::class, 'sectionQuiz'])->name('student.section-quiz');
            Route::get('/section-report/{id}/{paperid}', [StudentController::class, 'sectionReport'])->name('student.section-report');
            Route::get('/section-solution/{id}/{paperid}/{section_name}', [StudentController::class, 'sectionSolution'])->name('student.section-solution');
            Route::get('/next-section-solution/{id}/{paperid}/{section_name}', [StudentController::class, 'nextSectionSolution'])->name('student.next-section-solution');
            
             Route::get('/results', [StudentController::class, 'results'])->name('student.results');
             Route::get('/resume', [StudentController::class, 'resume'])->name('student.resume');
             
             Route::get('/next-tests/{courseid}', [StudentController::class, 'nextTests'])->name('student.next-tests');
               Route::get('/xat-tests/{courseid}', [StudentController::class, 'xatTests'])->name('student.xat-tests');
             Route::get('/nmat-tests/{courseid}', [StudentController::class, 'nmatTests'])->name('student.nmat-tests');
             
              Route::get('/next-results/{courseid}', [StudentController::class, 'nextResults'])->name('student.next-results');
              Route::get('/next-resume/{courseid}', [StudentController::class, 'nextResume'])->name('student.next-resume');
              
                Route::get('/xat-resume/{courseid}', [StudentController::class, 'xatResume'])->name('student.xat-resume');
              Route::get('/xat-results/{courseid}', [StudentController::class, 'xatResults'])->name('student.xat-results');
              
              Route::get('/nmat-results/{courseid}', [StudentController::class, 'nmatResults'])->name('student.nmat-results');
              Route::get('/nmat-resume/{courseid}', [StudentController::class, 'nmatResume'])->name('student.nmat-resume');
              
              Route::get('/verbal-resume/{id}/{paperid}', [StudentController::class, 'verbalResume'])->name('student.verbal-resume');
              Route::get('/fetchHalfQuizData', [StudentController::class, 'fetchHalfQuizData'])->name('student.fetchHalfQuizData');
              Route::get('/load-more-questions', [StudentController::class, 'loadMoreQuestions'])->name('student.load-more-questions');
             
              Route::get('/stop-section-quiz/{id}/{paperid}', [StudentController::class, 'stopSectionQuiz'])->name('student.stop-section-quiz');
              Route::get('/report-section-quiz/{id}/{paperid}', [StudentController::class, 'reportSectionQuiz'])->name('student.report-section-quiz');
              Route::get('/section-wise-solution/{id}/{paperid}/{section_name}', [StudentController::class, 'sectionWiseSolution'])->name('student.section-wise-solution');
              Route::get('/next-section-wise-solution/{id}/{paperid}/{section_name}', [StudentController::class, 'nextSectionWiseSolution'])->name('student.next-section-wise-solution');
              
              
                Route::get('/time_analysis/{testid}/{paperid}', [StudentController::class, 'timeAnalysis'])->name('student.time_analysis');

              Route::get('/time_taken_plotting/{testid}/{paperid}', [StudentController::class, 'timeTakenPlotting'])->name('student.time_taken_plotting');

    });
});
//Student Route end

// Admin Route
Route::group(['middleware' => 'admin.guest'], function () {
    Route::get('/admin', function () {return view('admin.login'); });
});

Route::group(['prefix' => 'admin'], function () {


    Route::group(['middleware' => 'admin.guest'], function () {
        
        // login routes
        Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminController::class, 'login'])->name('admin.authentication');

        // register routes
        Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
        Route::post('/register', [AdminController::class, 'register_code'])->name('admin.register-code');

        Route::get('/newtest/{id}', [AdminController::class, 'newTest'])->name('admin.newtest');
        Route::get('/testbuilder/{id}', [AdminController::class, 'testBuilder'])->name('admin.testbuilder');
        Route::post('/setcreation', [AdminController::class, 'setCreation'])->name('admin.setcreation');
        Route::get('/setdelete/{id}', [AdminController::class, 'setdelete'])->name('admin.setdelete');
        Route::get('/deletequestion/{id}', [AdminController::class, 'deletequestion'])->name('admin.deletequestion');
        Route::get('/testdelete/{id}', [AdminController::class, 'testDelete'])->name('admin.testdelete');
        Route::post('/setedit', [AdminController::class, 'setEdit'])->name('admin.setedit');
        Route::post('/testcreation', [AdminController::class, 'testcreation'])->name('admin.testcreation');
        Route::post('/save-test-uploading', [AdminController::class, 'saveTestUploading'])->name('admin.save-test-uploading');
        Route::get('/importwordexcel/{id}', [AdminController::class, 'importWordExcel'])->name('admin.importwordexcel');
        Route::post('/saveexcelword', [AdminController::class, 'saveExcelWord'])->name('admin.saveexcelword');
        Route::post('/saveword', [AdminController::class, 'saveWord'])->name('admin.saveword');
        Route::get('/publishstatus/{id}', [AdminController::class, 'publishStatus'])->name('admin.publishstatus');
        Route::post('/savepublish', [AdminController::class, 'savePublish'])->name('admin.savepublish');
        Route::get('/questionbuilder', [AdminController::class, 'questionbuilder'])->name('admin.questionbuilder');
        Route::post('/savequestion', [AdminController::class, 'savequestion'])->name('admin.savequestion');
        Route::get('/editquestion/{urlid}/{id}/{sr}', [AdminController::class, 'editquestion'])->name('admin.editquestion');
        Route::get('/preview/{question}/{id}', [AdminController::class, 'preview'])->name('admin.preview');
        Route::get('/seriesbuilder/{id}', [AdminController::class, 'seriesbuilder'])->name('admin.seriesbuilder');
        Route::get('/create-center', [AdminController::class, 'CreateCenter'])->name('admin.create-center');
        Route::get('/center', [AdminController::class, 'Center'])->name('admin.center');
        Route::post('/save-center', [AdminController::class, 'saveCenter'])->name('admin.save-center');
         Route::get('/edit-center/{id}', [AdminController::class, 'editCenter'])->name('admin.edit-center');
         Route::post('/update-center', [AdminController::class, 'updateCenter'])->name('admin.update-center');
          Route::get('/delete-center/{id}', [AdminController::class, 'deleteCenter'])->name('admin.delete-center');
        Route::get('/edit-test/{id}', [AdminController::class, 'editTest'])->name('admin.edit-test');
        Route::post('/edit-test-record', [AdminController::class, 'editTestRecord'])->name('admin.edit-test-record');

        Route::get('/edit-course/{id}', [AdminController::class, 'editCourse'])->name('admin.edit-course');
        Route::post('/edit-course-record', [AdminController::class, 'editCourseRecord'])->name('admin.edit-course-record');

        Route::get('/instruction/{id}', [AdminController::class, 'instruction'])->name('admin.instruction');
        Route::post('/save-instruction', [AdminController::class, 'saveInstruction'])->name('admin.save-instruction');
        Route::post('/save-series-builder', [AdminController::class, 'saveSeriesBuilder'])->name('admin.save-series-builder');
        Route::post('/edittime', [AdminController::class, 'edittime'])->name('admin.edittime');
        Route::get('/settings/{id}', [AdminController::class, 'settings'])->name('admin.settings');
        Route::get('/duration/{id}', [AdminController::class, 'duration'])->name('admin.duration');
        Route::get('/editstudent/{id}', [AdminController::class, 'editstudent'])->name('admin.editstudent');
         Route::get('/slot-booking', [AdminController::class, 'slotBooking'])->name('admin.slot-booking');
        Route::get('/show-seat', [AdminController::class, 'showSeat'])->name('admin.show-seat');

        Route::get('/delete-seat/{id}', [AdminController::class, 'deleteSeat'])->name('admin.delete-seat');

        Route::get('/delete-course/{id}', [AdminController::class, 'deleteCourse'])->name('admin.delete-course');

        Route::get('/delete-student/{id}', [AdminController::class, 'deleteStudent'])->name('admin.delete-student');
         Route::get('/edit-seat/{id}', [AdminController::class, 'editSeat'])->name('admin.edit-seat');
           
        Route::post('/fetch-test', [AdminController::class, 'fetchTest'])->name('admin.fetch-test');
         Route::post('/fetch-seat', [AdminController::class, 'fetchSeat'])->name('admin.fetch-seat');

        Route::post('/save-seat', [AdminController::class, 'saveSeat'])->name('admin.save-seat');
        Route::post('/quiz-duration', [AdminController::class, 'quizduration'])->name('admin.quiz-duration');
        Route::post('/editstudentdata', [AdminController::class, 'editstudentdata'])->name('admin.editstudentdata');
        Route::post('/updatequestion', [AdminController::class, 'updateQuestion'])->name('admin.updatequestion');
        Route::get('/percentile-cutoff/{id}', [AdminController::class, 'percentileCutoff'])->name('admin.percentile-cutoff');
        Route::post('/save-percentile', [AdminController::class, 'savePercentile'])->name('admin.save-percentile');
        Route::post('/save-cutoff', [AdminController::class, 'saveCutoff'])->name('admin.save-cutoff');
        Route::post('/saveproctored', [AdminController::class, 'saveProctored'])->name('admin.saveproctored');
        Route::post('/upload', [AdminController::class, 'upload'])->name('admin.ckeditor.upload');

        Route::post('/assignTestImport', [AdminController::class, 'assignTestImport'])->name('admin.assignTestImport');
        Route::post('/saveAllUser', [AdminController::class, 'saveAllUser'])->name('admin.saveAllUser');
        Route::post('/saveProduct', [AdminController::class, 'saveProduct'])->name('admin.saveProduct');
        Route::post('/updateAssignUser', [AdminController::class, 'updateAssignUser'])->name('admin.updateAssignUser');

        Route::post('/save-maximum-attempt', [AdminController::class, 'savemMaximumAttempt'])->name('admin.save-maximum-attempt');

        Route::get('/assign-test', [AdminController::class, 'assignTest'])->name('admin.assign-test');
        Route::get('/assign-user/{id}', [AdminController::class, 'assignUser'])->name('admin.assign-user');
        Route::get('/assign-product/{id}', [AdminController::class, 'assignProduct'])->name('admin.assign-product');

        // Route::get('/searchuser', [AdminController::class, 'searchUser'])->name('admin.searchuser');

        Route::get('/maximum-attempt/{id}', [AdminController::class, 'maximumAttempt'])->name('admin.maximum-attempt');
        Route::get('/booking-report', [AdminController::class, 'bookingReport'])->name('admin.booking-report');
        Route::get('/report-excel', [AdminController::class, 'reportExcel'])->name('admin.report-excel');
        
        Route::get('/exportuser', [AdminController::class, 'exportUser'])->name('admin.exportuser');

        Route::get('/show-course', [AdminController::class, 'showCourse'])->name('admin.show-course');
        Route::get('/showtest/{id}', [AdminController::class, 'showTest'])->name('admin.showtest');
        Route::get('/student-report/{id}', [AdminController::class, 'studentReport'])->name('admin.student-report');
        Route::get('/show-question/{id}/{userid}', [AdminController::class, 'showQuestion'])->name('admin.show-question');
        Route::post('/fetch-report', [AdminController::class, 'fetchReport'])->name('admin.fetch-report');
        Route::post('/fetch-question', [AdminController::class, 'fetchQuestion'])->name('admin.fetch-question');
        Route::post('/download-excel', [AdminController::class, 'downloadExcel'])->name('admin.download-excel');
        Route::get('/student-excel-report/{id}', [AdminController::class, 'studentExcelReport'])->name('admin.student-excel-report');
        Route::get('/search', [AdminController::class, 'searchByEmail'])->name('admin.search');
        Route::get('/test-pdf/{id}', [AdminController::class, 'testPdf'])->name('admin.test-pdf');
        Route::get('/cerate-test-pdf/{id}', [AdminController::class, 'cerateTestPdf'])->name('admin.cerate-test-pdf');
        Route::post('/save-pdf', [AdminController::class, 'savePdf'])->name('admin.save-pdf');
        
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        // forget password routes
        Route::get('/forget-password', [AdminController::class, 'forget_password'])->name('admin.forget-password');
        Route::post('/forget-password-code', [AdminController::class, 'forget_password_code'])->name('admin.forget-password-code');
        Route::get('/reset-password', [AdminController::class, 'reset_password'])->name('admin.reset-password');
        Route::post('/reset-password-code', [AdminController::class, 'reset_password_code'])->name('admin.reset-password-code');
        Route::get('/delete-test-pdf/{id}', [AdminController::class, 'deleteTestPdf'])->name('admin.delete-test-pdf');
        Route::get('/edit-test-pdf/{id}', [AdminController::class, 'editTestPdf'])->name('admin.edit-test-pdf');
        Route::post('/update-test-pdf', [AdminController::class, 'updateTestPdf'])->name('admin.update-test-pdf');
        Route::get('/student-quiz-detail', [AdminController::class, 'studentQuizDetail'])->name('admin.student-quiz-detail');
        
        Route::post('/section-save-cutoff', [AdminController::class, 'sectionSaveCutoff'])->name('admin.section-save-cutoff');
        
        Route::get('/new-testbuilder/{id}/{testtemp_id}', [AdminController::class, 'newTestbuilder'])->name('admin.new-testbuilder');
        
        Route::post('/add-section', [AdminController::class, 'addSection'])->name('admin.add-section');
        Route::post('/edit-section', [AdminController::class, 'editSection'])->name('admin.edit-section');
        Route::get('/delete-section/{id}', [AdminController::class, 'deleteSection'])->name('admin.delete-section');
        Route::get('/new-questionbuilder/{id}/{testid}/{testtemp_id}/{type}', [AdminController::class, 'newQuestionbuilder'])->name('admin.new-questionbuilder');
        
        Route::get('/clear-cache', [AdminController::class, 'clearCache'])->name('admin.clear-cache');
        Route::get('/getWord', [AdminController::class, 'getWord'])->name('student.getWord');


    });

    /* // admin authentication routes // */
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // student route
        Route::get('/student', [StudentController::class, 'index'])->name('student.student');
       
        Route::get('/student-list', [StudentController::class, 'student_list'])->name('admin.student_list');
        
        // Admin route start
      
           Route::post('/save', [AdminController::class, 'save'])->name('admin.save');
        //Admin route end
        // Route::get('/student/edit', [StudentController::class, 'edit'])->name('admin.student/edit');
        Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
           Route::get('/studentcreation', [AdminController::class, 'studentcreation'])->name('admin.studentcreation');
        //Test Analytics route
        Route::get('/test-uploading', function () {
            return view('admin.test-uploading');
        })->name('admin.test-uploading');

        // Across Test route
       
        Route::get('/import', [AdminController::class, 'import'])->name('admin.import');
        Route::post('/import2', [AdminController::class, 'import2'])->name('admin.import2');
        Route::get('/export', [AdminController::class, 'export'])->name('admin.export');

    });


});







