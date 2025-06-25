<form class="py-3" id="topUpSubmit" action="{{route('topDown',$id)}}" method="POST">
    @method('PUT')
    @csrf
    <div>
        <label>TopDown Time (h) </label>
        <select class="form-control" id="choices-hours" name="top_down_hours">
            @for($i = 1 ; $i <= $hours; $i++)
            <option value="{{$i}}" selected>{{$i}} (h) {{($i == $diff) ? 'Will Cancel This Model !' : ''}}</option>
            @endfor
        </select>

        <div class="pay mt-5">
            {{--start choose pay when remanning amount--}}

            <h6>Please select payment method</h6>
            <input type="radio" id="cash" name="pay" value="cash">
            <label for="cash">cash</label><br>

            <input type="radio" id="visa" name="pay" value="visa" checked>
            <label for="visa">visa</label><br>

            <input type="radio" id="mastercard" name="pay" value="mastercard">
            <label for="mastercard">mastercard</label><br>

            <input type="radio" id="Meeza" name="pay" value="Meeza">
            <label for="Meeza">Meeza</label><br>

            <input type="radio" id="voucher" name="pay" value="voucher">
            <label for="voucher">voucher</label><br>

            {{--end choose pay when remanning amount--}}
        </div>
    </div>
    <button type="submit" form="topUpSubmit" class="btn bg-gradient-primary m-3 mb-0"> Confirm </button>
</form>
<script>
    var element = document.getElementById('choices-hours');
    const options = new Choices(element, {
        searchEnabled: false
    });
    $('form#topUpSubmit').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var url = $('#topUpSubmit').attr('action');
        $.ajax({
            url:url,
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('#topUpSubmit').hide()
                $('#topUpBody').append(loader)
            },
            complete: function(){
                setTimeout(function () {

                    $('#topUpBody > .linear-background').hide(loader)
                    $('#topUpSubmit').show()
                },200)
            },
            success: function (data) {
                if (data.status == 200){
                    setTimeout(function () {
                        $('#topUp').modal('hide')
                        location.reload()
                    },300)
                }else {
                    toastr.error('error');
                }

            },
            error: function (data) {
                if (data.status === 500) {
                    toastr.error('error');
                }
                else if (data.status === 422) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                toastr.error(value,key);
                            });

                        } else {
                        }
                    });
                }else {

                    toastr.error('there in an error');
                }
            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    })

</script>
