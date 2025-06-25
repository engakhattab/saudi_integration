{{--<script>--}}
{{--    function printTicket(){--}}
{{--        var url = $('#printBtn').data('url');--}}

{{--        $('.spinner').show()--}}
{{--        $('#printIframe').attr('src',url)--}}
{{--        setTimeout(function () {--}}
{{--            $('.spinner').hide()--}}
{{--        },500)--}}
{{--        setTimeout(function () {--}}
{{--            $('#modal-print').modal('show')--}}
{{--        },1000)--}}
{{--    }--}}
{{--    var table = $('.customDataTable').DataTable({--}}
{{--        responsive: true,--}}
{{--        paging: false--}}

{{--        // "ordering": true,--}}
{{--        // columnDefs: [{--}}
{{--        //   'targets': [4, 5],--}}
{{--        //   'orderable': false--}}
{{--        // }, ]--}}
{{--    });--}}
{{--    accessWhenLoad()--}}


{{--    function accessWhenLoad() {--}}
{{--        var url = window.location.href;--}}
{{--        if (url.includes('search')) {--}}
{{--            getSearchValue(url)--}}

{{--            var slug = url.substring(url.indexOf("=") + 1);--}}


{{--            $('#searchValue').val(slug)--}}
{{--        }--}}
{{--    }--}}

{{--    $(document).on('click', '#searchButton', function () {--}}
{{--        var searchValue = $('#searchValue').val(), url;--}}
{{--        if (searchValue.length == 0) {--}}
{{--             url = "{{route('groupAccess.index')}}?search=all"--}}
{{--        }else{--}}
{{--             url = "{{route('groupAccess.index')}}?search=" + searchValue--}}
{{--        }--}}
{{--        getSearchValue(url)--}}

{{--    })--}}

{{--    //////////////// البحث ///////////--}}
{{--    function getSearchValue(url) {--}}
{{--        $.ajax({--}}
{{--            type: 'GET',--}}
{{--            url: url,--}}
{{--            beforeSend: function () {--}}
{{--                window.history.pushState({path: url}, '', url);--}}
{{--                $('.spinner').show()--}}
{{--                table.clear().draw();--}}
{{--            },--}}
{{--            complete: function (data) {--}}
{{--                $('.spinner').hide()--}}
{{--            },--}}
{{--            success: function (data) {--}}
{{--                if (data.status === 200) {--}}
{{--                    var Rows = data.backArray;--}}

{{--                    $.each(Rows, function (key, val) {--}}
{{--                        table.row.add(data.backArray[key]).draw(false);--}}
{{--                    })--}}

{{--                } else if (data.status === 300) {--}}
{{--                    toastr.info('there is no data')--}}
{{--                }--}}
{{--                else if(data.status === 405){--}}
{{--                    toastr.warning('Reservation Date is Invalid')--}}
{{--                }--}}

{{--            },--}}

{{--            error: function (data) {--}}
{{--                if (data.status === 500) {--}}
{{--                    toastr.error('Unexpected Error');--}}
{{--                } else if (data.status === 422) {--}}
{{--                    var errors = $.parseJSON(data.responseText);--}}
{{--                    $.each(errors, function (key, value) {--}}
{{--                        if ($.isPlainObject(value)) {--}}
{{--                            $.each(value, function (key, value) {--}}
{{--                                // toastr.error(value, key);--}}
{{--                            });--}}
{{--                        }--}}
{{--                    });--}}
{{--                }--}}
{{--            },//end error method--}}
{{--        });--}}
{{--    }--}}

{{--    $(document).on('click', '#checkAll', function (e) {--}}
{{--        e.stopImmediatePropagation();--}}
{{--        var type = $(this).data('type')--}}
{{--        if(type == 'getBracelet')--}}
{{--        {--}}
{{--            getBracelets()--}}
{{--        }else if(type == 'accessAll'){--}}
{{--            accessAll()--}}
{{--        }--}}

{{--    })--}}

{{--    function accessAll()--}}
{{--    {--}}

{{--        var ids=[],birthday=[],gender=[],name=[],bracelet_number=[]--}}

{{--        $('.spinner').show()--}}

{{--        $('.braceletNumbers').each(function() {--}}
{{--            if(!$(this).prop('disabled'))--}}
{{--            bracelet_number.push($(this).val());--}}
{{--        });--}}
{{--        $('.braceletNumbers').each(function() {--}}
{{--            if(!$(this).prop('disabled'))--}}
{{--                ids.push($(this).data('id'));--}}
{{--        });--}}
{{--        $('.birthDays').each(function() {--}}
{{--            if(!$(this).prop('disabled'))--}}
{{--            birthday.push($(this).val());--}}
{{--        });--}}
{{--        $('.names').each(function() {--}}
{{--            if(!$(this).prop('disabled'))--}}
{{--                name.push($(this).val());--}}
{{--        });--}}
{{--        $('.choose').each(function(){--}}
{{--            if(!$(this).find('input').prop('disabled'))--}}
{{--            {--}}
{{--                if($(this).find('input:checked').length > 0)--}}
{{--                {--}}
{{--                    gender.push($(this).find('input:checked').val());--}}
{{--                }--}}
{{--                else--}}
{{--                {--}}
{{--                    gender.push('');--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}

{{--        var method = {--}}
{{--            bracelet_number: bracelet_number,--}}
{{--            birthday: birthday,--}}
{{--            gender: gender,--}}
{{--            name: name,--}}
{{--            id: ids,--}}
{{--            _method: "PUT",--}}
{{--        }--}}
{{--        var url = "{{route('groupAccess.update',":id")}}"--}}

{{--        $.post(url, method, function (data) {--}}
{{--            $('.spinner').hide()--}}
{{--            if(!data.count){--}}
{{--                window.open(data.url, "_blank"); // will open new tab on window.onload--}}
{{--            }--}}
{{--            toastr.success('Visitors Accessed Successfully');--}}

{{--            window.location.href = '{{route('groupAccess.index')}}';//???????????????????????????????????????????????????????????--}}
{{--        }).fail(function (data) {--}}
{{--            $('.spinner').hide()--}}

{{--            if (data.status === 500) {--}}
{{--                toastr.error('there is an error');--}}
{{--            } else if (data.status === 422) {--}}
{{--                var errors = $.parseJSON(data.responseText);--}}
{{--                $.each(errors, function (key, value) {--}}
{{--                    if ($.isPlainObject(value)) {--}}
{{--                        $.each(value, function (key, value) {--}}
{{--                            toastr.error(value, key);--}}
{{--                        });--}}

{{--                    } else {--}}
{{--                    }--}}
{{--                });--}}
{{--            } else {--}}
{{--                toastr.error('there in an error');--}}
{{--            }--}}
{{--        });--}}

{{--    }--}}

{{--    function getBracelets()--}}
{{--    {--}}

{{--        var  firstBracelet, count = $('.braceletNumbers').length,--}}
{{--        firstBracelet = $('.braceletNumbers').first().val(),--}}
{{--        firstId = $('.braceletNumbers').first().attr("data-id");--}}


{{--        if (firstBracelet.length <= 2)--}}
{{--        {--}}
{{--            toastr.warning('Please write a correct bracelet')--}}
{{--            return true--}}
{{--        }--}}

{{--        $('.spinner').show()--}}


{{--        var method = {--}}
{{--            count: count,--}}
{{--            firstBracelet: firstBracelet,--}}
{{--            firstId: firstId--}}
{{--        }--}}


{{--        $.post("{{route('capacity.getBracelets')}}", method, function (data) {--}}
{{--            if(data.status == 405) {--}}
{{--                toastr.error('An Amount Of ' + data.rem_amount + ' EGP Is Unpaid');--}}
{{--                $('#payBtn').removeClass('d-none');--}}
{{--                $('#payBtn').attr('data-ticket_id', data.rev_id);--}}
{{--                $('#idOfTicket').val(data.rev_id);--}}
{{--            }--}}
{{--            else{--}}
{{--                if (data.length > 0) {--}}
{{--                    $('.braceletNumbers').each(function (key, value) {--}}
{{--                        $(this).val(data[key])--}}
{{--                    })--}}
{{--                    $('#checkAll').data('type','accessAll')--}}
{{--                    $('#checkAll').attr('data-type','accessAll')--}}
{{--                } else {--}}
{{--                    toastr.warning('there is no bracelet free')--}}
{{--                }--}}
{{--            }--}}

{{--        }).fail(function (data) {--}}
{{--            if (data.status == 404) {--}}
{{--                toastr.info('there is no bracelet found')--}}
{{--            }--}}
{{--        })--}}
{{--        setTimeout(function () {--}}
{{--            $('.spinner').hide()--}}
{{--        }, 500)--}}
{{--    }--}}

{{--    function checkIfBracketFree(title)--}}
{{--    {--}}
{{--        var _method = {--}}
{{--            title:title--}}
{{--        }--}}
{{--         $.get("{{route('groupAccess.checkIfBraceletFree')}}?title="+title,function(data)--}}
{{--         {--}}
{{--            return ''--}}
{{--         })--}}
{{--    }--}}


{{--    $(document).on('click','.check',function () {--}}
{{--        var id = $(this).data('id')--}}
{{--        var braceletNumber = $('#braceletNumber' + id).val()--}}
{{--        var result;--}}



{{--        if (!braceletNumber.length) {--}}
{{--            toastr.warning('you should fill bracelet number')--}}
{{--        }else {--}}
{{--            $('.spinner').show()--}}
{{--            $.get("{{route('groupAccess.checkIfBraceletFree')}}?title="+braceletNumber,function (data) {--}}
{{--                if (data == 0){--}}
{{--                    submitRow(id)--}}
{{--                }else {--}}
{{--                    toastr.warning('the bracelet is busy')--}}
{{--                    $('.spinner').hide()--}}
{{--                }--}}
{{--            })--}}
{{--        }--}}



{{--    })--}}

{{--    function submitRow(id) {--}}


{{--        var braceletNumber = $('#braceletNumber' + id).val()--}}
{{--        var birthDay = $('#birthDay' + id).val()--}}
{{--        var name = $('#name' + id).val()--}}
{{--        var gender = [];--}}

{{--            if($('#mainGenderDiv'+id).find('input:checked').length > 0)--}}
{{--            {--}}
{{--                gender.push($('#mainGenderDiv'+id).find('input:checked').val());--}}
{{--            }--}}
{{--            else--}}
{{--            {--}}
{{--                gender.push('');--}}
{{--            }--}}

{{--        if (!braceletNumber.length) {--}}
{{--            return false;--}}
{{--        }--}}

{{--        var method = {--}}
{{--            bracelet_number: [braceletNumber],--}}
{{--            birthday: [birthDay],--}}
{{--            gender: gender,--}}
{{--            name: [name],--}}
{{--            id: [id],--}}
{{--            _method: "PUT",--}}
{{--        }--}}

{{--        var url = "{{route('groupAccess.update',":id")}}"--}}

{{--        $.post(url, method, function (data) {--}}
{{--            if (data) {--}}
{{--                if(data.status == 405){--}}
{{--                    toastr.error('An Amount Of '+data.rem_amount+' EGP Is Unpaid');--}}
{{--                    $('#payBtn').removeClass('d-none');--}}
{{--                    $('#payBtn').attr('data-ticket_id',data.rev_id);--}}
{{--                    $('#idOfTicket').val(data.rev_id);--}}
{{--                }else {--}}
{{--                    $('#check' + id).addClass('checked');--}}
{{--                    $('#check' + id).removeClass('check');--}}
{{--                    $('#birthDay' + id).attr('disabled', true);--}}
{{--                    $('#braceletNumber' + id).attr('disabled', true);--}}
{{--                    $('#option1' + id).attr('disabled', true);--}}
{{--                    $('#option2' + id).attr('disabled', true);--}}
{{--                    $('#name' + id).attr('disabled', true);--}}
{{--                    if(!data.count){--}}
{{--                        $('#printBtn').attr('data-url',data.url)--}}
{{--                        printTicket()--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--            $('.spinner').hide()--}}

{{--        }).fail(function (data) {--}}
{{--            $('.spinner').hide()--}}

{{--            if (data.status === 500) {--}}
{{--                toastr.error('there is an error');--}}
{{--            } else if (data.status === 422) {--}}
{{--                var errors = $.parseJSON(data.responseText);--}}
{{--                $.each(errors, function (key, value) {--}}
{{--                    if ($.isPlainObject(value)) {--}}
{{--                        $.each(value, function (key, value) {--}}
{{--                            toastr.error(value, key);--}}
{{--                        });--}}

{{--                    } else {--}}
{{--                    }--}}
{{--                });--}}
{{--            } else {--}}
{{--                toastr.error('there in an error');--}}
{{--            }--}}
{{--        })--}}
{{--    }--}}
{{--    // Pay Amount--}}
{{--    $(document).on('click', '#confirmBtn', function (event) {--}}
{{--        var id = $('#idOfTicket').val();--}}
{{--        var pay = $("input[type='radio']:checked").val();--}}

{{--        $('#confirmBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +--}}
{{--            ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);--}}
{{--        $.ajax({--}}
{{--            type: 'POST',--}}
{{--            url: "{{route('updateRevAmount')}}",--}}
{{--            data: {--}}
{{--                '_token': "{{csrf_token()}}",--}}
{{--                'pay': pay,--}}
{{--                'id': id,--}}
{{--            },--}}
{{--            success: function (data) {--}}
{{--                if (data.status === 200) {--}}
{{--                    $('#payBtn').addClass('d-none');--}}
{{--                    toastr.success(data.message)--}}
{{--                } else {--}}
{{--                    toastr.error(data.message)--}}
{{--                }--}}
{{--                $('#confirmBtn').html(`Confirm`).attr('disabled', false);--}}
{{--                $("#payAmount").modal('hide');--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}


<script>
    function printTicket(){
        var url = $('#printBtn').data('url');

        $('.spinner').show()
        $('#printIframe').attr('src',url)
        setTimeout(function () {
            $('.spinner').hide()
        },500)
        setTimeout(function () {
            $('#modal-print').modal('show')
        },1000)
    }
    var table = $('.customDataTable').DataTable({
        responsive: true,
        paging: false

        // "ordering": true,
        // columnDefs: [{
        //   'targets': [4, 5],
        //   'orderable': false
        // }, ]
    });
    accessWhenLoad()


    function accessWhenLoad() {
        var url = window.location.href;
        if (url.includes('search')) {
            getSearchValue(url)

            var slug = url.substring(url.indexOf("=") + 1);


            $('#searchValue').val(slug)
        }
    }

    $(document).on('click', '#searchButton', function () {
        var searchValue = $('#searchValue').val(), url;
        if (searchValue.length == 0) {
            url = "{{route('groupAccess.index')}}?search=all"
        }else{
            url = "{{route('groupAccess.index')}}?search=" + searchValue
        }
        getSearchValue(url)

    })

    //////////////// البحث ///////////
    function getSearchValue(url) {
        $.ajax({
            type: 'GET',
            url: url,
            beforeSend: function () {
                window.history.pushState({path: url}, '', url);
                $('.spinner').show()
                table.clear().draw();
            },
            complete: function (data) {
                $('.spinner').hide()
            },
            success: function (data) {
                if (data.status === 200) {
                    var Rows = data.backArray;

                    $.each(Rows, function (key, val) {
                        table.row.add(data.backArray[key]).draw(false);
                    })

                } else if (data.status === 300) {
                    toastr.info('there is no data')
                }
                else if(data.status === 405){
                    toastr.warning('Reservation Date is Invalid')
                }

            },

            error: function (data) {
                if (data.status === 500) {
                    toastr.error('Unexpected Error');
                } else if (data.status === 422) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                // toastr.error(value, key);
                            });
                        }
                    });
                }
            },//end error method
        });
    }

    $(document).on('click', '#checkAll', function (e) {
        e.stopImmediatePropagation();
        var type = $(this).data('type')
        if(type == 'getBracelet')
        {
            getBracelets()
        }else if(type == 'accessAll'){
            accessAll()
        }

    })

    function accessAll()
    {

        var ids=[],birthday=[],gender=[],name=[],bracelet_number=[]

        $('.spinner').show()

        $('.braceletNumbers').each(function() {
            if(!$(this).prop('disabled'))
                bracelet_number.push($(this).val());
        });
        $('.braceletNumbers').each(function() {
            if(!$(this).prop('disabled'))
                ids.push($(this).data('id'));
        });
        $('.birthDays').each(function() {
            if(!$(this).prop('disabled'))
                birthday.push($(this).val());
        });
        $('.names').each(function() {
            if($(this).prop('disabled'))
                name.push($(this).val());
        });
        $('.choose').each(function(){
            if(!$(this).find('input').prop('disabled'))
            {
                if($(this).find('input:checked').length > 0)
                {
                    gender.push($(this).find('input:checked').val());
                }
                else
                {
                    gender.push('');
                }
            }
        });

        var method = {
            bracelet_number: bracelet_number,
            birthday: birthday,
            gender: gender,
            name: name,
            id: ids,
            _method: "PUT",
        }
        var url = "{{route('groupAccess.update',":id")}}"

        $.post(url, method, function (data) {
            $('.spinner').hide()
            if(!data.count){
                window.open(data.url, "_blank"); // will open new tab on window.onload
            }
            toastr.success('Visitors Accessed Successfully');

            window.location.href = '{{route('groupAccess.index')}}';//???????????????????????????????????????????????????????????
        }).fail(function (data) {
            $('.spinner').hide()

            if (data.status === 500) {
                toastr.error('there is an error');
            } else if (data.status === 422) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    if ($.isPlainObject(value)) {
                        $.each(value, function (key, value) {
                            toastr.error(value, key);
                        });

                    } else {
                    }
                });
            } else {
                toastr.error('there in an error');
            }
        });

    }

    function getBracelets()
    {

        var  firstBracelet, count = $('.braceletNumbers').length,
            firstBracelet = $('.braceletNumbers').first().val(),
            firstId = $('.braceletNumbers').first().attr("data-id");


        if (firstBracelet.length <= 2)
        {
            toastr.warning('Please write a correct bracelet')
            return true
        }

        $('.spinner').show()


        var method = {
            count: count,
            firstBracelet: firstBracelet,
            firstId: firstId
        }


        $.post("{{route('capacity.getBracelets')}}", method, function (data) {
            if(data.status == 405) {
                toastr.error('An Amount Of ' + data.rem_amount + ' EGP Is Unpaid');
                $('#payBtn').removeClass('d-none');
                $('#payBtn').attr('data-ticket_id', data.rev_id);
                $('#idOfTicket').val(data.rev_id);
            }
            else{
                if (data.length > 0) {
                    $('.braceletNumbers').each(function (key, value) {
                        $(this).val(data[key])
                    })
                    $('#checkAll').data('type','accessAll')
                    $('#checkAll').attr('data-type','accessAll')
                } else {
                    toastr.warning('there is no bracelet free')
                }
            }

        }).fail(function (data) {
            if (data.status == 404) {
                toastr.info('there is no bracelet found')
            }
        })
        setTimeout(function () {
            $('.spinner').hide()
        }, 500)
    }

    function checkIfBracketFree(title)
    {
        var _method = {
            title:title
        }
        $.get("{{route('groupAccess.checkIfBraceletFree')}}?title="+title,function(data)
        {
            return ''
        })
    }


    $(document).on('click','.check',function () {
        var id = $(this).data('id')
        var braceletNumber = $('#braceletNumber' + id).val()
        var result;



        //  if (!braceletNumber.length) {
        //     toastr.warning('you should fill bracelet number')
        //  }else {
        $('.spinner').show()
        $.get("{{route('groupAccess.checkIfBraceletFree')}}?title="+braceletNumber,function (data) {
            //  if (data == 0){
            submitRow(id)
            // }else {
            //    toastr.warning('the bracelet is busy')
            //     $('.spinner').hide()
            // }
        })
        //  }



    })

    function submitRow(id) {


        var braceletNumber = $('#braceletNumber' + id).val()
        var birthDay = $('#birthDay' + id).val()
        var name = $('#name' + id).val()
        var gender = [];

        if($('#mainGenderDiv'+id).find('input:checked').length > 0)
        {
            gender.push($('#mainGenderDiv'+id).find('input:checked').val());
        }
        else
        {
            gender.push('');
        }

        //  if (!braceletNumber.length) {
        //    return false;
        //}

        var method = {
            bracelet_number: [braceletNumber],
            birthday: [birthDay],
            gender: gender,
            name: [name],
            id: [id],
            _method: "PUT",
        }

        var url = "{{route('groupAccess.update',":id")}}"

        $.post(url, method, function (data) {
            if (data) {
                if(data.status == 405){
                    toastr.error('An Amount Of '+data.rem_amount+' EGP Is Unpaid');
                    $('#payBtn').removeClass('d-none');
                    $('#payBtn').attr('data-ticket_id',data.rev_id);
                    $('#idOfTicket').val(data.rev_id);
                }else {
                    $('#check' + id).addClass('checked');
                    $('#check' + id).removeClass('check');
                    $('#birthDay' + id).attr('disabled', true);
                    $('#braceletNumber' + id).attr('disabled', true);
                    $('#option1' + id).attr('disabled', true);
                    $('#option2' + id).attr('disabled', true);
                    $('#name' + id).attr('disabled', true);
                    if(!data.count){
                        $('#printBtn').attr('data-url',data.url)
                        printTicket()
                    }
                }
            }
            $('.spinner').hide()

        }).fail(function (data) {
            $('.spinner').hide()

            if (data.status === 500) {
                toastr.error('there is an error');
            } else if (data.status === 422) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    if ($.isPlainObject(value)) {
                        $.each(value, function (key, value) {
                            toastr.error(value, key);
                        });

                    } else {
                    }
                });
            } else {
                toastr.error('there in an error');
            }
        })
    }

    // Pay Amount
    $(document).on('click', '#confirmBtn', function (event) {
        var id = $('#idOfTicket').val();
        var pay = $("input[type='radio']:checked").val();
        $('#confirmBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
            ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
        $.ajax({
            type: 'POST',
            url: "{{route('updateRevAmount')}}",
            data: {
                '_token': "{{csrf_token()}}",
                'id': id,
                'pay': pay
            },
            success: function (data) {
                if (data.status === 200) {
                    $('#payBtn').addClass('d-none');
                    toastr.success(data.message)
                } else {
                    toastr.error(data.message)
                }
                $('#confirmBtn').html(`Confirm`).attr('disabled', false);
                $("#payAmount").modal('hide');
            }
        });
    });
</script>
