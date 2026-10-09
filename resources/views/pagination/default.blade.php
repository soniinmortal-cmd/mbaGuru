<style>
/* .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
        
    } */
    .pagination {
        display: flex; 
        flex-wrap: wrap;
        justify-content: center; 
        margin: 10px 0; 
    }
    .pagination span, .pagination a {
        margin: 0 10px; 
        padding: 0.5rem 1rem; 
        border: 1px solid #ccc; 
        border-radius: 22px; 
        text-decoration: none; 
        white-space: nowrap; 
        background-color: red;
        color: white;
    }

    .pagination .current {
        background-color: #007bff; 
        color: white; 
        background-color: red;
    }

    .qusc {
        display: inline-block; 
        margin: 5px; 
        padding: 10px; 
        text-align: center; 
        border-radius: 5px; 
    }

    .qusc {
        margin: 5px; 
        padding: 10px; 
    }

    
 
</style>
<?php
    $paperid = request()->paperid;
    $id = request()->id;
    $userid =session()->get('id');
    
?>
<div class="flex justify-between">
    <div class="flex">
        @for ($page = 1; $page <= $paginator->lastPage(); $page++)
        <?php
         $half_data = DB::table('half_student_quiz')
                    ->where('test_id',$id)
                    ->where('user_id',$userid)
                    ->where('paper_id',$paperid)
                    ->where('section_name', 'like', "%verbal%")
                    ->where('sr_no',$page)
                    ->limit(1)
                    ->first(); 
                 
        $review = DB::table('ansmark_review')
                    ->where('test_id',$id)
                    ->where('user_id',$userid)
                    ->where('paper_id',$paperid)
                    ->where('section_name', 'like', "%data%")
                    ->where('review_id',$page)
                    ->limit(1)
                    ->first(); 
                    
        ?>
            @if ($page == $paginator->currentPage())
                <span class="current">{{ $page }}</span>
            @else
            
                {{-- <a class="qus sr{{ $page }} " href="{{ $paginator->url($page) }}"data-equ="" data-test ="{{$id}}" data-paper ="{{$paperid}}" data-set ="{{ $page }}" style="background-color: {{ ($half_data && $half_data->answer) ? 'green' : 'red' }};" >{{ $page }}</a> --}}

                <a class="qusc sr{{ $page }}" 
                href="{{ $paginator->url($page) }}" 
                data-equ="" 
                data-test="{{ $id }}" 
                data-paper="{{ $paperid }}" 
                data-set="{{ $page }}" 
                style="
                     @if ($half_data && $half_data->answer && $review && $review->ans_review == 1)
                         background: linear-gradient(green, purple);
                     @elseif ($half_data && $half_data->answer && $review && $review->ans_review == 0)
                         background-color: green;
                     @elseif ($review && $review->ans_review == 1 && !$half_data)
                         background-color: purple;
                     @elseif ($review && $review->ans_review == 0 && !$half_data)
                         background-color: red;
                     @else
                         background-color: red;  
                     @endif
                ">
                    {{ $page }}
                </a>
            @endif
        @endfor
    </div>
</div>
