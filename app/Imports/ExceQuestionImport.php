<?php

namespace App\Imports;

use App\Models\ExcelQuestion;
use Maatwebsite\Excel\Concerns\ToModel;

class ExceQuestionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     if(!array_filter($row)) {
    //         return null;
    //     } 
    //     return new ExcelQuestion([
    //                 'test_id'     => $row['0'],
    //                 'section_name'     => $row['1'],
    //                 'tag'    => $row['2'], 
    //                 'positive_mark' => $row['3'],
    //                 'negative_mark'    => $row['4'],
    //                 'level'    => $row['5'],
    //                 'answer_time'    => $row['6'],
    //                 'answer_explanation'    => $row['7'],
    //                 'question'    => $row['8'],
    //                 'question_type'    => $row[9],
    //                 'correct_option'    => $row[10],
    //                 'instruction'    => $row['11'],
    //                 'option1'    => $row[12],
    //                 'option2'    => $row[13],
    //                 'option3'    => $row[14],
    //                 'option4'    => $row[15],
    //                 'option5'    => $row[16],
    //                 'criteria1'    => $row[17],
    //                 'percentage1'    => $row[18],
    //                 'criteria2'    => $row[19],
    //                 'percentage2'    => $row[20],
    //                 'criteria3'    => $row[21],
    //                 'percentage3'    => $row[22],
    //                 'criteria4'    => $row[23],
    //                 'percentage4'    => $row[24],
    //                 'criteria5'    => $row[25],
    //                 'percentage5'    => $row[26],
    //                  'video_link'    => $row[27],
    //     ]);
    // }
    
    public function model(array $row)
{
    if (!array_filter($row)) {
        return null;
    }

    return new ExcelQuestion([
        'test_id'             => $row[0]  ?? null,
        'section_name'        => $row[1]  ?? null,
        'tag'                 => $row[2]  ?? null,
        'positive_mark'       => $row[3]  ?? null,
        'negative_mark'       => $row[4]  ?? null,
        'level'               => $row[5]  ?? null,
        'answer_time'         => $row[6]  ?? null,
        'answer_explanation'  => $row[7]  ?? null,
        'question'            => $row[8]  ?? null,
        'question_type'       => $row[9]  ?? null,
        'correct_option'      => $row[10] ?? null,
        'instruction'         => $row[11] ?? null,
        'option1'             => $row[12] ?? null,
        'option2'             => $row[13] ?? null,
        'option3'             => $row[14] ?? null,
        'option4'             => $row[15] ?? null,
        'option5'             => $row[16] ?? null,
        'criteria1'           => $row[17] ?? null,
        'percentage1'         => $row[18] ?? null,
        'criteria2'           => $row[19] ?? null,
        'percentage2'         => $row[20] ?? null,
        'criteria3'           => $row[21] ?? null,
        'percentage3'         => $row[22] ?? null,
        'criteria4'           => $row[23] ?? null,
        'percentage4'         => $row[24] ?? null,
        'criteria5'           => $row[25] ?? null,
        'percentage5'         => $row[26] ?? null,
        'video_link'          => $row[27] ?? null,
    ]);
}

}
