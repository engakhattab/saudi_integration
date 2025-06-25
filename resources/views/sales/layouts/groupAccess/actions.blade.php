<span class="controlIcons">
    <span class="icon check" id="check{{$model->id}}" data-id="{{$model->id}}"  data-bs-toggle="tooltip" title="Check"> <i class="fal fa-check"></i> </span>
    @if(!$key)
    <span class="icon" data-bs-toggle="tooltip" id="checkAll" data-type="getBracelet" title="Check All"> <i class="fas fa-check-double"></i> </span>
    @endIf
</span>
