<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TestTemplatevalue;

class TestTemplatevalueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestTemplatevalue::create([
            // 'temp_id' => '2',
            // 'total_marks'  => '198',
            // 'exam_duration' => '120',
            // 'total_question' => '100',
            // 'total_question_type' => '[MCQ, +3, -1],[NON-MCQ, +3, -0]',
            // 'total_section' => '[VERBAL ABILITY AND READING COMPREHENSION,   24Q,   40MIN],[DATA INTERPRETATION AND LOGICAL REASONING,   20Q,   40MIN],[QUANTITATIVE ABILITY,   22Q,   40MIN]',
            // 'section_duration' => 'ENABLED',
            // 'calculator_type' => 'NORMAL CALCULATOR',
            // 'exame_instruction' => 'TRUE',

            'temp_id' => '3',
            'total_marks'  => '360',
            'exam_duration' => '120',
            'total_question' => '120',
            'total_question_type' => '[MCQ, +3, -1]',
            'total_section' => '[Language Skills, 32Q, 22MIN],[Quantitative Skills, 48Q, 60MIN],[Logical Reasoning, 40Q, 38MIN]',
            'section_duration' => 'Enabled',
            'section_order_selection' => 'ENABLED',
            'exame_instruction' => 'TRUE',

            //'temp_id' => '1',
            // 'total_marks'  => '198',
            // 'exam_duration' => '120',
            // 'total_question' => '100',
            //'total_question_type' => '[MCQ, +1, -0.25],[NON-MCQ, +1, -0],[ESSAY, +1, -0],[FEEDBACK, +0, -0],[FILL IN THE BLANKS, +1, -0]',
            //'total_section' => 'SECTION 1',
            //'section_duration' => 'ENABLED',
            //'calculator_type' => 'NORMAL CALCULATOR',
            //'exame_instruction' => 'TRUE',
        ]);
    }
}
