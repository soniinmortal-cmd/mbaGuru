@foreach($verbal_quesd as $verbal_quess)
    <div class="sel{{$j}} ssm">
        <button type="button" data-snm ="{{$verbal_quess->section_name}}" data-set="{{$j}}" class="qus btn btn-circle btn-lg sr{{$j}}" data-equ="{{$verbal_quess->id}}">{{$j}}</button>
        <?php $j++; ?>
    </div>
@endforeach