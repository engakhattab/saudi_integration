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
{{--            responsive: true,--}}
{{--            paging: false--}}
{{--            // "ordering": true,--}}
{{--            // columnDefs: [{--}}
{{--            //   'targets': [4, 5],--}}
{{--            //   'orderable': false--}}
{{--            // }, ]--}}
{{--        });--}}
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
{{--            url = "{{route('familyAccess.index')}}?search=all"--}}
{{--        }else{--}}
{{--            url = "{{route('familyAccess.index')}}?search=" + searchValue--}}
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



{{--    $(document).on('click','.check',function () {--}}
{{--        var id = $(this).data('id')--}}
{{--        var braceletNumber = $('#braceletNumber' + id).val()--}}

{{--        $('.spinner').show()--}}

{{--        if (!braceletNumber.length) {--}}
{{--            toastr.warning('you should fill bracelet numberzz')--}}
{{--        }else {--}}
{{--            submitRow(id)--}}
{{--            // if (submitRow(id)){--}}

{{--            // }--}}
{{--        }--}}

{{--        setTimeout(function () {--}}
{{--            $('.spinner').hide()--}}
{{--        }, 500)--}}


{{--    })--}}

{{--    function submitRow(id) {--}}

{{--        var return_ = 0;--}}
{{--        var braceletNumber = $('#braceletNumber' + id).val()--}}
{{--        var birthDay = $('#birthDay' + id).val()--}}
{{--        var name = $('#name' + id).val()--}}
{{--        var gender = $('input[name=gender' + id + ']:checked').val();--}}
{{--        if (!braceletNumber.length) {--}}
{{--            return false;--}}
{{--        }--}}

{{--        var method = {--}}
{{--            bracelet_number: braceletNumber,--}}
{{--            birthday: birthDay,--}}
{{--            gender: gender,--}}
{{--            name: name,--}}
{{--            id: id,--}}
{{--            _method: "PUT",--}}
{{--        }--}}

{{--        var url = "{{route('familyAccess.update',":id")}}"--}}

{{--        url = url.replace(':id', id)--}}
{{--        $.post(url, method, function (data) {--}}
{{--            if (data) {--}}
{{--                if(data.status == 405){--}}
{{--                    toastr.error('An Amount Of '+data.rem_amount+' EGP Is Unpaid');--}}
{{--                    $('#payBtn').removeClass('d-none');--}}
{{--                    $('#payBtn').attr('data-ticket_id',data.ticket_id);--}}
{{--                    $('#idOfTicket').val(data.ticket_id);--}}
{{--                }else{--}}
{{--                    $('#check'+id).addClass('checked');--}}
{{--                    $('#check'+id).removeClass('check');--}}
{{--                    $('#birthDay'+id).attr('disabled', true);--}}
{{--                    $('#braceletNumber'+id).attr('disabled', true);--}}
{{--                    $('#option1'+id).attr('disabled', true);--}}
{{--                    $('#option2'+id).attr('disabled', true);--}}
{{--                    $('#name'+id).attr('disabled', true);--}}
{{--                    if(!data.count){--}}
{{--                        $('#printBtn').attr('data-url',data.url)--}}
{{--                        printTicket()--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--        }).fail(function (data) {--}}
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
{{--            return true;--}}
{{--        }).then(function (return_) {--}}
{{--            return return_--}}
{{--        })--}}


{{--    }--}}
{{--        // Pay Amount--}}
{{--        $(document).on('click', '#confirmBtn', function (event) {--}}
{{--            var id = $('#idOfTicket').val();--}}
{{--            $('#confirmBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +--}}
{{--                ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);--}}
{{--            $.ajax({--}}
{{--                type: 'POST',--}}
{{--                url: "{{route('ticket.updateAmount')}}",--}}
{{--                data: {--}}
{{--                    '_token': "{{csrf_token()}}",--}}
{{--                    'id': id,--}}
{{--                },--}}
{{--                success: function (data) {--}}
{{--                    if (data.status === 200) {--}}
{{--                        $('#payBtn').addClass('d-none');--}}
{{--                        toastr.success(data.message)--}}
{{--                    } else {--}}
{{--                        toastr.error(data.message)--}}
{{--                    }--}}
{{--                    $('#confirmBtn').html(`Confirm`).attr('disabled', false);--}}
{{--                    $("#payAmount").modal('hide');--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

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
            url = "{{route('familyAccess.index')}}?search=all"
        }else{
            url = "{{route('familyAccess.index')}}?search=" + searchValue
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



    $(document).on('click','.check',function () {
        var id = $(this).data('id')
        var braceletNumber = $('#braceletNumber' + id).val()

        $('.spinner').show()

        // if (!braceletNumber.length) {
        //     toastr.warning('you should fill bracelet number')
        // }else {
        submitRow(id)
        // alert(id)
        // if (submitRow(id)){

        // }
        // }

        setTimeout(function () {
            $('.spinner').hide()
        }, 500)


    })

    function submitRow(id) {

        var return_ = 0;
        var braceletNumber = $('#braceletNumber' + id).val()
        var birthDay = $('#birthDay' + id).val()
        var name = $('#name' + id).val()
        // alert(braceletNumber)
        var gender = $('input[name=gender' + id + ']:checked').val();
        // if (!braceletNumber.length) {
        //     return false;
        // }

        var method = {
            bracelet_number: braceletNumber,
            birthday: birthDay,
            gender: gender,
            name: name,
            id: id,
            _method: "PUT",
        }

        var url = "{{route('familyAccess.update',":id")}}"

        url = url.replace(':id', id)
        $.post(url, method, function (data) {
            if (data) {
                if(data.status == 405){
                    toastr.error('An Amount Of '+data.rem_amount+' EGP Is Unpaid');
                    $('#payBtn').removeClass('d-none');
                    $('#payBtn').attr('data-ticket_id',data.ticket_id);
                    $('#idOfTicket').val(data.ticket_id);
                }else{
                    $('#check'+id).addClass('checked');
                    $('#check'+id).removeClass('check');
                    $('#birthDay'+id).attr('disabled', true);
                    $('#braceletNumber'+id).attr('disabled', true);
                    $('#option1'+id).attr('disabled', true);
                    $('#option2'+id).attr('disabled', true);
                    $('#name'+id).attr('disabled', true);
                    if(!data.count){
                        $('#printBtn').attr('data-url',data.url)
                        printTicket()
                    }
                }
            }
        }).fail(function (data) {
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
            return true;
        }).then(function (return_) {
            return return_
        })


    }
    // Pay Amount
    $(document).on('click', '#confirmBtn', function (event) {
        var id = $('#idOfTicket').val();
        $('#confirmBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
            ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
        $.ajax({
            type: 'POST',
            url: "{{route('ticket.updateAmount')}}",
            data: {
                '_token': "{{csrf_token()}}",
                'id': id,
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
