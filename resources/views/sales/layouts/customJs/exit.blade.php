<script>
    var loader = ` <div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                        </div>
        `;
        var table = $('.customDataTable').DataTable({
            responsive: true,
            paging:false
            // "ordering": true,
            // columnDefs: [{
            //   'targets': [4, 5],
            //   'orderable': false
            // }, ]
        });
        $('#main-exit').addClass('active')


        $(document).on('click','#searchBtn',function () {
            var search = $('#searchValue').val();

            if (!search.length) {
                toastr.info('Please fill this input')
                return true;
            }
            var url = "{{route('exit.index')}}?search=" + search

            getSearchValue(url)
        })
        function getSearchValue(url) {
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function () {
                    window.history.pushState({path: url}, '', url);
                    // $('.spinner').show()
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
                        $('#result').show()


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
                },//end error method   error: function (data) {
            });
        }//end error method

        $(document).on('click','.tempStatus',function () {
            var id = $(this).data('id')
            var status = $(this).data('status')

            var url = "{{route('exit.update',':id')}}";

            url = url.replace(':id',id)

            var method_={
                temp_status:status,
                _method:"PUT",
            }

            $('.spinner').show()

            $.post(url,method_,function (data) {
                if (data.status ==200){
                    location.reload()
                }
            }).then(function (){
                $('.spinner').hide()
            })
        })

    //============================================================================================
        $(document).on('click','.topUpHours',function () {
            var id = $(this).data('id')

            var url = "{{route('exit.edit',':id')}}";

            url = url.replace(':id',id)

            $('#topUpBody').html(loader)

            $('#topUp').modal('show')

            setTimeout($('#topUpBody').load(url),500)
        })

    $(document).on('click','.topDownHours',function () {
        var id = $(this).data('id')

        var url = "{{route('showTopDown',':id')}}";

        url = url.replace(':id',id)

        $('#topUpBody').html(loader)

        $('#topUp').modal('show')

        setTimeout($('#topUpBody').load(url),500)
    })

    if (!{{count($models)}}){
        var url = "{{route('exit.index')}}"
        window.history.pushState({path: url}, '', url);
    }
    $(document).on('click','#print',function () {
        var url = $(this).data('url');

        $('.spinner').show()
        $('#printIframe').attr('src',url)
        setTimeout(function () {
            $('.spinner').hide()
        },500)
        setTimeout(function () {
            $('#modal-print').modal('show')
        },1000)

    })
    $(document).on('click','#print1',function () {
        var url = $(this).data('url');

        $('.spinner').show()
        $('#printIframe1').attr('src',url)
        setTimeout(function () {
            $('.spinner').hide()
        },500)
        setTimeout(function () {
            $('#modal-print1').modal('show')
        },1000)

    })


</script>
