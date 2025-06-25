<script>
    $('.add').click(function () {
        $(this).prev().val(+$(this).prev().val() + 1);
    });
    $('.sub').click(function () {
        if ($(this).next().val() > 0) $(this).next().val(+$(this).next().val() - 1);
    });

    var reservationTypes = JSON.parse('<?php echo $visitorTypes;?>')
    $.each(reservationTypes, function (index, value) {
        window["visitorType" + value.id] = 0;
    })

    $(document).on('input change', '.calculateHourPrice', function () {
        getTypesPrice()
    })


    function getTypesPrice() {

        var hoursCount = parseFloat($('#hours_count').val() || 0);
        var shiftId = parseFloat($('#choices-shift').val() || 0);
        var visitDate = parseFloat($('#visit_date').val() || "{{date('Y-m-d')}}");

        $.ajax({
            type: 'GET',
            url: "{{route('visitorTypesPrices')}}",
            data: {
                'hours_count': hoursCount,
                'shift_id': shiftId,
                'visit_date': visitDate,
            },
            success: function (data) {
                if (data.status === 200) {
                    var newArray = data.array;

                    $.each(newArray, function (key, value) {
                        window["visitorType" + key] = parseFloat(value)
                    })

                    if (data.latestHours != 0) {
                        toastr.warning('there is ' + data.latestHours + ' does n`t have price');
                    }

                }
                calculate()

            },
            error: function (data) {
                if (data.status === 500) {
                    toastr.error('Unexpected Server Error');
                } else if (data.status === 422) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                            });
                        }
                    });
                }
            },//end error method
        });

    }


    function calculate() {
        $.each(reservationTypes, function (index, value) {
            alert(window["visitorType" + key])
        })
    }

    $(document).on('click', '.js-btn-next', function () {
        var next = $(this).data('title');
        var active = $(this).data('active');
        var buttonClass = '-multisteps-form__progress-btn';
        var divClass = '-multisteps-form__panel';
        var  complete = 1
        if ($('.' + active + divClass).attr('validate')){
            complete = validateForms(active+divClass)
        }
        // alert(complete)
        if (complete){
            $('.' + next + buttonClass).addClass('js-active')
            $('.' + next + divClass).addClass('js-active')
            $('.' + active + divClass).removeClass('js-active')
        }

    })
    $(document).on('click', '.js-btn-prev', function () {
        var prev = $(this).data('title');
        var active = $(this).data('active');
        var buttonClass = '-multisteps-form__progress-btn';
        var divClass = '-multisteps-form__panel';
        $('.' + active + buttonClass).removeClass('js-active')
        $('.' + prev + divClass).addClass('js-active')
        $('.' + active + divClass).removeClass('js-active')
    })

    function validateForms(divClass) {
        var count = 0

        // alert("."+divClass+".form-input")
        $("."+divClass+" .form-input").each( function () {
            $(this).next('span').hide();
            $(this).next('span').html('');

            var validate = $(this).data("validate");
            var value = $(this).val();
            // alert()
            if (value.length == 0){
                $(this).next('span').html('required');
                $(this).next('span').show();
                count ++;
            }

        })
        if (count == 0){
            return true
        }
        return  false;
    }
</script>
