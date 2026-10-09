<style>
    .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
            
        }
        
        
        .pagination span, .pagination a {
            margin: 0 10px; 
            padding: 0.5rem 1rem; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            text-decoration: none; 
            white-space: nowrap; 
            background-color: blue;
            color: white;
        }
    
        .pagination .current {
            background-color: #007bff; 
            color: white; 
            background-color: blue;
        }
    
       
     
    </style>

<div class="flex justify-between">

   
    <?php
      $pageno = $paginator->currentPage();
    ?>
    {{-- Next Page Link --}}
    <div>
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="next pagination "  data-save="{{ $pageno }}" style="background-color:blue;"> Save & Next &raquo;</a>
        @else
            <span>Next &raquo;</span>
        @endif
    </div>
</div>
