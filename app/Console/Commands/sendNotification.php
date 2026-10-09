<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use DB;
class sendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:sendemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mail by cron job';

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function handle()
    {
        
        \Log::info('Cron job started at: ' . now());
        $users = DB::table('studentlogs')->orderBy('id', 'desc')->get();
        $result = array();
    foreach ($users as $user) {
        // Fetch all half_student_quiz records for the user
        // Fetch all excel_questions for the user
        $excel_questions = DB::table('excel_questions')
                        ->select('section_name', 'test_id')
                        ->orderBy('id', 'desc')
                        ->get();
        
        // Iterate through each unique test_id in excel_questions
        foreach ($excel_questions->unique('test_id') as $excel_question) {
            // Get all unique section_type from student_quizes for the same test_id
            $quiz_section_types = DB::table('student_quizes')
                ->select('section_type')
                ->where('user_id', $user->id)
                ->where('test_id', $excel_question->test_id)
                ->pluck('section_type')->toArray();
    
            // Log the quiz_section_types for debugging
            // \Log::info('Quiz section types (student_quizes) for user ' . $user->id . ' and test_id ' . $excel_question->test_id . ': ' . json_encode(array_map('strtolower',$quiz_section_types)));
             
            // Get all unique section_name from excel_questions for the same test_id
            $excel_section_names = DB::table('excel_questions')
                ->select('section_name')
                ->where('test_id', $excel_question->test_id)
                ->distinct() // Fetch unique section_name
                ->pluck('section_name')->toArray();
            
            // Log the excel_section_names for debugging
            // \Log::info('Excel section names for test_id ' . $excel_question->test_id . ': ' . json_encode(array_map('strtolower',$excel_section_names)));
        
            // Check if the number of sections match between excel_questions and student_quizes
            if (count($excel_section_names) == count($quiz_section_types)) {
        // \Log::info(' count match for test_id: ' . $excel_question->test_id . ' for user: ' . $user->id);
        
                                    DB::table('half_student_quiz')
                                    ->where('test_id', $excel_question->test_id)
                                    ->where('user_id', $user->id)
                                    ->delete();
                                    
                                    
                         \Log::info(' delete half quize for test_id: '. $excel_question->test_id);
                                    
                                    
                //           $half_quizes = DB::table('half_student_quiz')
                //                             ->select('paper_id', 'test_id', 'user_id', 'question_id', 'section_name', 'answer', 'sr_no', 'mark_review', 'ans_duration', 'set_type')
                //                             ->where('user_id', $user->id)
                //                             ->where('test_id',$excel_question->test_id)
                //                             ->get(); 
                // foreach ($half_quizes as $quiz) {
                //             DB::table('half_student_quiz_backup')->insert([
                //                 'paper_id' => $quiz->paper_id,
                //                 'test_id' => $quiz->test_id,
                //                 'user_id' => $quiz->user_id,
                //                 'question_id' => $quiz->question_id,
                //                 'section_name' => $quiz->section_name,
                //                 'answer' => $quiz->answer,
                //                 'sr_no' => $quiz->sr_no,
                //                 'mark_review' => $quiz->mark_review,
                //                 'ans_duration' => $quiz->ans_duration,
                //                 'set_type' => $quiz->set_type,
                //                 'created_at' => now(),
                //                 'updated_at' => now(),
                //             ]);
                // }
                //   \Log::info('insert half quize for test_id: '. $excel_question->test_id);
                                            

            } else {
                // \Log::info('Section count mismatch for test_id: ' . $excel_question->test_id . ' for user: ' . $user->id);
            }
        }
    }
        
    }


      
    
}
