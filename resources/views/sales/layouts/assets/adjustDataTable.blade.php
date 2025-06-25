<script>
    var table,totalBeforeTax = 0,vat = 0 , ent = 0;
    table = $('.firstTable').DataTable({
        responsive: true,
        paging:false
    });
    var amountCash = $("#amount"),
        total = $('#totalPrice');
    localStorage.setItem('prevent', '0')
    function checkDay(e) {
        // Create date from input value
        var inputDate = new Date(e.target.value);
        // Get today's date
        var Today = new Date();
        // call setHours to take the time out of the comparison
        if (inputDate.setHours(0, 0, 0, 0) === Today.setHours(0, 0, 0, 0)) {
            localStorage.setItem('prevent', '0')
            $('#duration').removeAttr('disabled');
            $('#choices_times').removeAttr('disabled');
            $('#firstNext').removeAttr('disabled');
            $('#dayError').text("")
            $('#start').val('')
            $('#timeDiv').hide(500);
            checkTime()
        } else if (inputDate.setHours(0, 0, 0, 0) > Today.setHours(0, 0, 0, 0)) {
            localStorage.setItem('prevent', '0')
            $('#dayError').text("")
            $('#duration').removeAttr('disabled');
            $('#choices_times').removeAttr('disabled');
            $('#firstNext').removeAttr('disabled');
            $('#duration').val("")
            $('#choices_times').empty()
            $('#start').val($('#first_shift_start').val())
            // $('#timeDiv').show(500);
        } else {
            $('#dayError').text("The Day Can't Be Past !")
            localStorage.setItem('prevent', '1')
            $('#duration').val("")
            $('#duration').attr('disabled', 'disabled')
            $('#choices_times').attr('disabled', 'disabled')
            $('#firstNext').attr('disabled', 'disabled');
            $('#choices_times').empty()
        }
    }

    function checkTime() {
        var myDuration = $('#duration').val(),
            time = $('#start').val(),
            myDate = $('#date').val();
        if (time.length === 0) {
            var now = new Date(Date.now());
            time = now.getHours();
        }
        $('#startError').text('')
        $('#durationError').text('')
        if (localStorage.getItem('prevent') !== '1' && myDuration.length > 0) {
            $.ajax({
                type: 'GET',
                url: "{{route('getShifts')}}",
                data: {
                    'duration': myDuration,
                    'time': time,
                    'visit_date': myDate,
                    'id': 81,
                },
                success: function (data) {
                    if (data.status === 200) {
                        $('#choices_times').empty()
                        if (data.times.length !== 0) {
                            $.each(data.times, function (key, value) {
                                if(data.starts[key] == data.selected_start && data.ends[key] == data.selected_end)
                                    $("#choices_times").append(`<option selected data-starts = ${data.starts[key]} data-ends = ${data.ends[key]}  value= ${data.shift_id[key]}> ${value} </option>`);
                                else
                                $("#choices_times").append(`<option data-starts = ${data.starts[key]} data-ends = ${data.ends[key]}  value= ${data.shift_id[key]}> ${value} </option>`);
                            });
                        } else
                            toastr.error("Can't Enter To The Next Day !");
                    }
                }
            });
        }
    }

    $(document).on('click', '#secondPrev', function () {
        DeleteRows();
    });


    // Check Capacity And Get Price Of Visitor Models
    $(document).on('click', '#firstNext', function () {
        var myDate = $('#date').val(),
            myDuration = $('#duration').val(),
            shift = $('#choices_times').val();
        if (myDuration.length > 0) {
            $.ajax({
                type: 'GET',
                url: "{{route('calcCapacity')}}",
                data: {
                    'client_id': {{$id}},
                    'visit_date': myDate,
                    'hours_count': myDuration,
                    'shift_id': shift,
                },
                success: function (data) {
                    if (data.status === true) {
                        $('#dateOfTicket').text(myDate);
                        $('#hourOfTicket').text(myDuration + " h");
                        $('#shiftOfTicket').text($('#choices_times option:selected').text());
                        for (var i = 0; i < data.shift_prices.length; i++) {
                            $('#price' + data.shift_prices[i].visitor_type_id).val(data.shift_prices[i].price)
                        }
                        localStorage.setItem('available', data.available)
                        toastr.success(data.available + " places are still available");
                    } else if (data.status === false) {
                        toastr.error(data.day + " is fully booked");
                        $("button[title='visitors']").removeClass('js-active');
                        $("#visitorsTab").removeClass('js-active');
                        $("button[title='ticket']").addClass('js-active');
                        $("#ticketTab").addClass('js-active');
                    }
                    else if (data.status === 405) {
                        toastr.error("Client Has A Ticket At "+data.day);
                        $("button[title='visitors']").removeClass('js-active');
                        $("#visitorsTab").removeClass('js-active');
                        $("button[title='ticket']").addClass('js-active');
                        $("#ticketTab").addClass('js-active');
                    }
                },
                error: function (data) {
                    if (data.status === 500) {
                        toastr.error('Sorry there is an error');
                    } else if (data.status === 422) {
                        $("button[title='ticket']").addClass('js-active');
                        $("#ticketTab").addClass('js-active');
                        $("button[title='visitors']").removeClass('js-active');
                        $("#visitorsTab").removeClass('js-active');
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value, key);
                                });
                            }
                        });
                    }
                },//end error method
            });
        } else {
            $("button[title='visitors']").removeClass('js-active');
            $("#visitorsTab").removeClass('js-active');
            $("button[title='ticket']").addClass('js-active');
            $("#ticketTab").addClass('js-active');
            if (myDuration.length === 0)
                $('#durationError').text('Reservation Duration Is Required')
        }
    });

    var count = 1;
    table.clear();

    function appendRow(type_id, type, price) {
        if(price != null){
            if (localStorage.getItem('available') > table.rows().count()) {
                var row = table.row.add([
                    `<span data-type_id="${type_id}" id="visitor_type[]">${type}</span>`,
                    `<span data-price="${price}" id="visitor_price[]">${price}</span>`,
                    '<input type="text" class="form-control" placeholder="Name" name="visitor_name[]">',
                    '<input type="date" class="form-control" name="visitor_birthday[]" id="visitor_birthday[]">',
                    `<div class="choose">
                   <div class="genderOption">
                     <input type="radio" class="btn-check" name="gender${count}" id="option1${count}" value="male">
                     <label class=" mb-0 btn btn-outline" for="option1${count}"><span><i class="fas fa-male"></i></span></label>
                   </div>
                   <div class="genderOption" style="display: none">
                     <input type="radio" class="btn-check" name="gender${count}" id="option1${count}" value="" checked>
                     <label class=" mb-0 btn btn-outline" for="option1${count}"></label>
                   </div>
                 <div class="genderOption">
                    <input type="radio" class="btn-check" name="gender${count}" id="option2${count}" value="female">
                    <label class=" mb-0 btn btn-outline" for="option2${count}"><span><i class="fas fa-female"></i> </span></label>
                 </div>
                 </div>`,
                    `<span class="controlIcons">
                     <span class="icon Delete" data-bs-toggle="tooltip" title="Delete" data-model_id="${type_id}"> <i
                      class="far fa-trash-alt"></i> </span>
                </span>`
                ]).draw().node();
                count++;
                $(row).addClass(type);
                getCount(type, type_id)
            } else {
                toastr.error("The park is full")
            }
        }
        else{
            toastr.error(`The ${type} Does not Has A Price For This Duration`)
        }

    }

    function getCount(className, type_id) {
        $('.visitorType' + type_id).find('.count').text(table.rows('[class*=' + className + ']').count());
        $('.visitorType' + type_id).find('.inputCount').val(table.rows('[class*=' + className + ']').count());
    }

    $(document).on('click', '.visitorTypeDiv', function () {
        var type = $(this).find('.visitor').text();
        var visitor_type_id = $(this).find('#visitor_type_id').val();
        appendRow(visitor_type_id, type, $(this).find('input').val())
    });

    $('.firstTable').on('click', 'tbody tr .Delete', function () {
        table.row($(this).parent().parent()).remove().draw();
        getCount($(this).parent().parent().parent().attr('class').replace('odd ', '').replace('even ', '').replace(' odd', '').replace(' even', ''), $(this).attr("data-model_id"))
    });


    ////////////////////////////////////////////
    // choice Js
    ////////////////////////////////////////////
    if (document.getElementById('choices-shift')) {
        var element = document.getElementById('choices-shift');
        const options = new Choices(element, {
            searchEnabled: false
        });
    }
    // if (document.getElementById('choices_times')) {
    //     var element = document.getElementById('choices_times');
    //     const options = new Choices(element, {
    //         searchEnabled: false
    //     });
    // }
    if (document.getElementById('choices-category')) {
        var element = document.getElementById('choices-category');
        const options = new Choices(element, {
            searchEnabled: false
        });
    }
    if (document.getElementById('choices-discount')) {
        var element = document.getElementById('choices-discount');
        const options = new Choices(element, {
            searchEnabled: true
        });
    }
    if (document.getElementById('choices-discount')) {
        var element = document.getElementById('choices-discount');
        const options = new Choices(element, {
            searchEnabled: false
        });
    }


    // Show categories
    var categories = JSON.parse('<?php echo json_encode($categories) ?>');
    $(document).on('change', '#choices-category', function () {
        var id = $(this).val();
        var category = categories.filter(oneObject => oneObject.id == id)
        if (category.length > 0) {
            var products = category[0].products

            $('#choices-product').html('<option value="" disabled>Choose The Product</option>')

            $.each(products, function (index) {
                $('#choices-product').append('<option value="' + products[index].id + '" data-price="' + products[index].price + '"> ' + products[index].title + '</option>')
            })
        }
    })

    var myNewTable = $('#myNewTable');
    var myTable;
    myTable = myNewTable.DataTable({
        responsive: true,
    });
    myTable.clear();
    $('#addBtn').click(function () {
        var product_select = $('#choices-product'),
            product = product_select.find(":selected").text(),
            product_id = product_select.find(":selected").val(),
            price = product_select.find(":selected").attr('data-price'),
            category_id = $('#choices-category').find(":selected").val();
        if (myTable.rows('[class*=productrow' + product_id + ']').count() === 0) {
            if (product_id === '') {
                toastr.error("Please Choose The Product ");
            } else {
                var row = myTable.row.add([
                    `<span id="spanProductId" data-product_id="${product_id}">${product}</span>`,
                    `<span class="price" id="price${product_id}">${price}</span>`,
                    `<div class="countInput">
                        <button type="button" class=" sub" id="subBtn">-</button>
                        <input type="number"  disabled id="qtyVal${product_id}" class="qtyVal" value="1" min="1"/>
                        <button type="button" class=" add plusBtn" id="plusBtn">+</button>
                    </div>`,
                    `<span class="productTotalPrice" id="productTotalPrice${product_id}">${price}</span>`,
                    `
                              <span class="controlIcons">
                                <span class="icon Delete" data-bs-toggle="tooltip" title="Delete"> <i
                                    class="far fa-trash-alt"></i> </span>
                              </span>
                `
                ]).draw().node();
                $(row).addClass('productrow' + product_id);
            }
        } else {
            var oldQty = parseInt($('#qtyVal' + product_id).val() || 0)
            $('#qtyVal' + product_id).val(oldQty + 1)
            var qty = $('#qtyVal' + product_id).val();
            $('#productTotalPrice' + product_id).text(price * qty)
        }
    });
    myNewTable.on('click', 'tbody tr .Delete', function () {
        myTable.row($(this).parent().parent()).remove().draw();
    });
    myNewTable.on('click', 'tbody tr .plusBtn', function () {
        var value = $(this).closest('tr').find(".qtyVal").val();
        value++;
        $(this).closest('tr').find(".qtyVal").val(value);
        var price = +$(this).closest('tr').find(".price").text();
        $(this).closest('tr').find(".productTotalPrice").text(value * price);
    });
    myNewTable.on('click', 'tbody tr #subBtn', function () {
        var value = $(this).closest('tr').find(".qtyVal").val();
        if (value != 1) {
            value--;
            $(this).closest('tr').find(".qtyVal").val(value);
            var price = +$(this).closest('tr').find(".price").text();
            $(this).closest('tr').find(".productTotalPrice").text(value * price);
        }
    });
    var totalBeforeDiscount = 0;
    $(document).on('click', '#secondNext', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        if (table.rows().count() != 0) {
            $('.firstInfo').append(`
                        <h6 class="billTitle"> visitors</h6>
                        <div class="items">
                            <div class="itemsHead row visitorItemRows">
                                <span class="col">type</span>
                                <span class="col"> Quantity </span>
                                <span class="col"> price </span>
                            </div>
                        </div>
            `)
            $('.visitorType').each(function () {
                var div = $(this),
                    count = div.find('span.count').text(),
                    price = div.find('input[name*=price]').val() * parseInt(count),
                    visitor = div.find('span.visitor').text();

                if (count != 0) {
                    $('.visitorItemRows').after(
                        `<div class="item row insertRows">
                        <span class="col"> ${visitor}</span>
                        <span class="col"> ${count}</span>
                        <span class="col"> ${price} SAR</span>
                        </div>`)
                    totalBeforeDiscount += price;
                }
            });
            localStorage.setItem('priceOfVisitor',totalBeforeDiscount)
        } else {
            toastr.error("at least one model should be exists");
            $("button[title='products']").removeClass('js-active');
            $("#productsTab").removeClass('js-active');
            $("button[title='visitors']").addClass('js-active');
            $("#visitorsTab").addClass('js-active');
        }
    });
    $(document).on('click', '#thirdPrev', function () {
        $('.insertRows').remove();
        $('.firstInfo').html('');
        totalBeforeDiscount = 0;
    });
    var Percent = $('#offerType1'),
        Amount = $('#offerType2');

    $(document).on('click', '#thirdNext', function () {
        $('#paid').text(0)
        $('#change').text(0)
        $('#amount').val('')
        totalBeforeDiscount = parseInt(localStorage.getItem('priceOfVisitor'));
        if (myTable.rows().count() != 0) {
            $('.secondInfo').append(`
                <h6 class="billTitle"> products</h6>
                <div class="items">
                   <div class="itemsHead row productsInfoRows">
                     <span class="col">type</span>
                     <span class="col"> Quantity </span>
                     <span class="col"> price </span>
                </div>
            `)
            $('#myNewTable tr').each(function () {
                var div = $(this),
                    name = div.find('td:first').text(),
                    product_id = div.find('#spanProductId').attr('data-product_id'),
                    total = parseInt(div.find('span.productTotalPrice').text()),
                    qty = div.find('input.qtyVal').val();
                if (qty != undefined) {
                    $('.productsInfoRows').after(
                        `<div class="item row productInsertRows">
                            <input type="hidden" name="product_id[]" value="${product_id}">
                            <input type="hidden" name="proQtyInput[]" value="${qty}">
                            <input type="hidden" name="proTotalInput[]" value="${total}">
                            <span class="col" id="proName">${name} </span>
                        <span class="col" id="proQty"> ${qty} </span>
                        <span class="col" id="proTotal"> ${total} SAR </span>
                    </div>`)
                    totalBeforeDiscount += total;
                }
            });

            // get prices of products
            var product_id      =  $("input[name='product_id[]']").map(function(){return $(this).val();}).get()
            var product_qty     =  $("input[name='proQtyInput[]']").map(function(){return $(this).val();}).get()
            var vat = [];
            $.ajax({

                url : "{{route('getProductsPrices')}}",
                type : 'GET',
                data : {
                    'products_id' :product_id,
                    'product_qty' :product_qty,
                },
                dataType:'json',
                success : function(data) {
                    console.log(data)
                    localStorage.setItem('TotalOfProducts',`<li><label> products : </label> <strong id="productsTotal">${data.prices_before_tax} SAR</strong></li>`);
                    for(var i = 0 ; i < data.titles.length; i++) {
                        vat.push(`<li><label> ${data.titles[i]} : </label> <strong id="productsTotal">${data.vat[i]} SAR</strong></li>`);
                    }
                    localStorage.setItem('vat',vat.toString().replace(/,/g , ''));
                },
                async: false,
                error : function()
                {
                    toastr.warning('sorry there is an error')
                }
            });
        }

        localStorage.setItem('price',totalBeforeDiscount)

        if (window.location.href.indexOf("ticket") > -1) {
            totalBeforeTax  = parseFloat(localStorage.getItem('priceOfVisitor') / {{ $setting->family_tax }} / {{ $setting->family_ent }}).toFixed(2);
            vat   = parseFloat(localStorage.getItem('priceOfVisitor') - localStorage.getItem('priceOfVisitor') / {{ $setting->family_tax }}).toFixed(2);
            ent   = parseFloat(localStorage.getItem('priceOfVisitor') / {{ $setting->family_tax }} - localStorage.getItem('priceOfVisitor') /  {{ $setting->family_tax }} / {{ $setting->family_ent }}).toFixed(2);
        }else if(window.location.href.indexOf("reservations") > -1){
            totalBeforeTax  = parseFloat(localStorage.getItem('priceOfVisitor') / {{ $setting->rev_tax }} / {{ $setting->rev_ent }}).toFixed(2);
            vat   = parseFloat(localStorage.getItem('priceOfVisitor') - localStorage.getItem('priceOfVisitor') / {{ $setting->rev_tax }}).toFixed(2);
            ent   = parseFloat(localStorage.getItem('priceOfVisitor') / {{ $setting->rev_tax }} - localStorage.getItem('priceOfVisitor') /  {{ $setting->rev_tax }} / {{ $setting->rev_ent }}).toFixed(2);
        }

        if(ent != 0)
            entText = `<li><label> Ent.Tax : </label> <strong id="ent"> ${ent} SAR</strong></li>`;
        else
            entText = '';

        total.text(totalBeforeDiscount);
        $('#totalInfoPrice').text(totalBeforeDiscount + " SAR")
        $('#totalInfoDiscount').text(0 + " SAR")
        $('#totalInfoRevenue').text(totalBeforeDiscount + " SAR")
        $('#revenue').text(totalBeforeDiscount)
        $('#calcDiscount').val('')
        if (window.location.href.indexOf("ticket") > -1) {
            $('.thirdInfo').append(`
                        <h6 class="billTitle"> Totals </h6>
                        <ul>
                            ${localStorage.getItem('TotalOfProducts')}
                            ${localStorage.getItem('vat')}
                            <li><label> Ticket Price : </label> <strong id="beforeTax">${totalBeforeTax} SAR</strong></li>
                            ${entText}
                            <li><label> Vat : </label> <strong id="vat"> ${vat} SAR</strong></li>
                            <li><label> total after taxes : </label> <strong id="totalInfoPrice">${localStorage.getItem('price')} SAR</strong></li>
                            <li><label> Discount : </label> <strong id="totalInfoDiscount">0 SAR</strong></li>
                            <li><label> Amount To Pay : </label> <strong id="totalInfoRevenue">${totalBeforeDiscount} SAR</strong></li>
            `)
        }
        else if(window.location.href.indexOf("reservations") > -1){
            $('.thirdInfo').append(`
                        <h6 class="billTitle"> Totals </h6>
                        <ul>
                            ${localStorage.getItem('TotalOfProducts')}
                            ${localStorage.getItem('vat')}
                            <li><label> Ticket Price : </label> <strong id="beforeTax">${totalBeforeTax} SAR</strong></li>
                            ${entText}
                            <li><label> Vat : </label> <strong id="vat"> ${vat} SAR</strong></li>
                            <li><label> total after taxes : </label> <strong id="totalInfoPrice">${localStorage.getItem('price')} SAR</strong></li>
                            <li><label> Discount : </label> <strong id="totalInfoDiscount">0 SAR</strong></li>
                            <li><label> Amount To Pay : </label> <strong id="totalInfoRevenue">${totalBeforeDiscount} SAR</strong></li>
            `)
        }
    });
    var totalPrice = parseInt(total.text());
    Percent.prop("checked", true);
    $('#revenue').text(totalBeforeDiscount)

    $("#calcDiscount").on("keyup change", function (e) {
        if($("#calcDiscount").val() != 0){
            $('#reasonDiv').show();
        }else {
            $('#reasonDiv').hide();
        }
        if (Percent.is(':checked'))
            checkPercent()
        else if (Amount.is(':checked'))
            checkAmount()
    });

    Percent.change(function () {
        checkPercent()
    });

    function checkPercent() {
        if ($('#calcDiscount').val() > 100 || $('#calcDiscount').val() < 0) {
            toastr.error("enter valid discount percent !");
            $('#calcDiscount').val('');
            $('#totalInfoDiscount').text(0 + " SAR")
            $('#discount').text('0');
            $('#revenue').text(parseFloat(total.text()).toFixed(2));
            $('#reasonDiv').hide();
        } else {
            if($('#calcDiscount').val().length > 0){
                $('#discount').text($('#calcDiscount').val() + "%")
                $('#totalInfoDiscount').text($('#calcDiscount').val() + "%")
            }
            else{
                $('#discount').text("0")
                $('#totalInfoDiscount').text("0 SAR")
            }
            var after = (parseFloat(total.text()) - $('#calcDiscount').val() * parseFloat(total.text()) / 100).toFixed(2);
            $('#revenue').text(after)
            $('#totalInfoPrice').text(total.text() + " SAR")
            $('#totalInfoRevenue').text(after + " SAR")
            calculateChange()
        }
    }

    function checkAmount() {
        if ($('#calcDiscount').val() > parseFloat(total.text() || $('#calcDiscount').val() < 0)) {
            toastr.error("discount amount more than total !");
            $('#totalInfoDiscount').text(0 + " SAR")
            $('#calcDiscount').val('');
            $('#discount').text('0');
            $('#revenue').text(parseFloat(total.text()).toFixed(2));
            $('#reasonDiv').hide();
        } else {
            $('#discount').text($('#calcDiscount').val() || 0)
            var after = (parseFloat(total.text()) - $('#calcDiscount').val()).toFixed(2);
            $('#revenue').text(after)
            $('#totalInfoPrice').text(total.text() + " SAR")
            if($('#calcDiscount').val().length > 0)
                $('#totalInfoDiscount').text($('#calcDiscount').val() + " SAR")
            else
                $('#totalInfoDiscount').text("0 SAR")


            $('#totalInfoRevenue').text(after + " SAR")
            calculateChange()
        }
    }

    Amount.change(function () {
        checkAmount()
    });


    function calculateChange() {
        if (amountCash.val() > parseFloat($('#revenue').text())) {
            var change = (parseFloat(amountCash.val()).toFixed(2) - parseFloat($('#revenue').text()).toFixed(2)).toFixed(2);
            $("#change").text(change || 0);
        } else
            $("#change").text('0');

        $('#paid').text(amountCash.val() || 0);
    }

    $(document).on('click', '#lastPrev', function () {
        $('.productInsertRows').remove();
        $('.secondInfo').html('');
        $('.thirdInfo').html('')
        $('#discount').text('0')
        totalBeforeDiscount = parseFloat(localStorage.getItem('priceOfVisitor')).toFixed(2);
        localStorage.setItem('TotalOfProducts','');
        localStorage.setItem('vat','');
    });
    $(document).on('click', '#confirmBtn', function () {
        localStorage.removeItem('TotalOfProducts');
        localStorage.removeItem('vat');
        localStorage.setItem('TotalOfProducts','');
        localStorage.setItem('vat','');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });


    function DeleteRows() {
        $('.firstTable').DataTable().clear().draw();
        $('.visitorType').each(function () {
            $(this).find('span.count').text('0');
            $(this).find('input.inputCount').val(0);
        });
    }

    $('.inputCount').focusout(function () {
        var type = $(this).parent().parent().find('.visitor').text();
        var number = Math.abs(parseInt($(this).parent().parent().find('.count').text()) - $(this).val());
        // add only if input number more than count --> to prevent multiple insertion
        if ($(this).val() > parseInt($(this).parent().parent().find('.count').text())) {
            var visitor_type_id = $(this).parent().parent().find('#visitor_type_id').val();
            for (var i = 0; i < number; i++) {
                appendRow(visitor_type_id, type, $(this).parent().parent().find('input').val())
            }
        } else if ($(this).val() < parseInt($(this).parent().parent().find('.count').text())) {
            // means the user enter a number less than count so he want to delete not insert
            for (var j = 0; j < number; j++) {
                table.row('tr.' + type.toLowerCase()).remove().draw();
            }
            $(this).parent().parent().find('.count').text($(this).val())
        }
    });


     function afterDic() {
         $('.thirdInfo').html('');
        $('#paid').text(0)
        $('#change').text(0)
        $('#amount').val('')
        totalBeforeDiscount = parseInt(localStorage.getItem('priceOfVisitor'));
        if (myTable.rows().count() != 0) {
            $('.secondInfo').append(`
                <h6 class="billTitle"> products</h6>
                <div class="items">
                   <div class="itemsHead row productsInfoRows">
                     <span class="col">type</span>
                     <span class="col"> Quantity </span>
                     <span class="col"> price </span>
                </div>
            `)
            $('#myNewTable tr').each(function () {
                var div = $(this),
                    name = div.find('td:first').text(),
                    product_id = div.find('#spanProductId').attr('data-product_id'),
                    total = parseInt(div.find('span.productTotalPrice').text()),
                    qty = div.find('input.qtyVal').val();
                if (qty != undefined) {
                    $('.productsInfoRows').after(
                        `<div class="item row productInsertRows">
                            <input type="hidden" name="product_id[]" value="${product_id}">
                            <input type="hidden" name="proQtyInput[]" value="${qty}">
                            <input type="hidden" name="proTotalInput[]" value="${total}">
                            <span class="col" id="proName">${name} </span>
                        <span class="col" id="proQty"> ${qty} </span>
                        <span class="col" id="proTotal"> ${total} SAR </span>
                    </div>`)
                    totalBeforeDiscount += total;
                }
            });

            // get prices of products
            var product_id      =  $("input[name='product_id[]']").map(function(){return $(this).val();}).get()
            var product_qty     =  $("input[name='proQtyInput[]']").map(function(){return $(this).val();}).get()
            var vat = [];
            $.ajax({

                url : "{{route('getProductsPrices')}}",
                type : 'GET',
                data : {
                    'products_id' :product_id,
                    'product_qty' :product_qty,
                },
                dataType:'json',
                success : function(data) {
                    console.log(data)
                    localStorage.setItem('TotalOfProducts',`<li><label> products : </label> <strong id="productsTotal">${data.prices_before_tax} SAR</strong></li>`);
                    for(var i = 0 ; i < data.titles.length; i++) {
                        vat.push(`<li><label> ${data.titles[i]} : </label> <strong id="productsTotal">${data.vat[i]} SAR</strong></li>`);
                    }
                    localStorage.setItem('vat',vat.toString().replace(/,/g , ''));
                },
                async: false,
                error : function()
                {
                    toastr.warning('sorry there is an error')
                }
            });
        }

        localStorage.setItem('price',totalBeforeDiscount)

         var priceOfVisitorAfterDiscount = localStorage.getItem('priceOfVisitor')
        if (window.location.href.indexOf("ticket") > -1) {
            totalBeforeTax  = parseFloat(localStorage.getItem('priceOfVisitor') / {{ $setting->family_tax }} / {{ $setting->family_ent }}).toFixed(2);
            vat   = parseFloat(localStorage.getItem('priceOfVisitor') - localStorage.getItem('priceOfVisitor') / {{ $setting->family_tax }}).toFixed(2);
            ent   = parseFloat(localStorage.getItem('priceOfVisitor') / {{ $setting->family_tax }} - localStorage.getItem('priceOfVisitor') /  {{ $setting->family_tax }} / {{ $setting->family_ent }}).toFixed(2);
        }else if(window.location.href.indexOf("reservations") > -1){
            totalBeforeTax  = parseFloat(localStorage.getItem('priceOfVisitor') / {{ $setting->rev_tax }} / {{ $setting->rev_ent }}).toFixed(2);
            vat   = parseFloat(localStorage.getItem('priceOfVisitor') - localStorage.getItem('priceOfVisitor') / {{ $setting->rev_tax }}).toFixed(2);
            ent   = parseFloat(localStorage.getItem('priceOfVisitor') / {{ $setting->rev_tax }} - localStorage.getItem('priceOfVisitor') /  {{ $setting->rev_tax }} / {{ $setting->rev_ent }}).toFixed(2);
        }

        if(ent != 0)
            entText = `<li><label> Ent.Tax : </label> <strong id="ent"> ${ent} SAR</strong></li>`;
        else
            entText = '';

        total.text(totalBeforeDiscount);
        $('#totalInfoPrice').text(totalBeforeDiscount + " SAR")
        $('#totalInfoDiscount').text(0 + " SAR")
        $('#totalInfoRevenue').text(totalBeforeDiscount + " SAR")
        $('#revenue').text(totalBeforeDiscount)
        $('#calcDiscount').val('')
        if (window.location.href.indexOf("ticket") > -1) {
            $('.thirdInfo').append(`
                        <h6 class="billTitle"> Totals </h6>
                        <ul>
                            ${localStorage.getItem('TotalOfProducts')}
                            ${localStorage.getItem('vat')}
                            <li><label> Ticket Price : </label> <strong id="beforeTax">${totalBeforeTax} SAR</strong></li>
                            ${entText}
                            <li><label> Vat : </label> <strong id="vat"> ${vat} SAR</strong></li>
                            <li><label> total after taxes : </label> <strong id="totalInfoPrice">${localStorage.getItem('price')} SAR</strong></li>
                            <li><label> Discount : </label> <strong id="totalInfoDiscount">0 SAR</strong></li>
                            <li><label> Amount To Pay : </label> <strong id="totalInfoRevenue">${totalBeforeDiscount} SAR</strong></li>
            `)
        }
        else if(window.location.href.indexOf("reservations") > -1){
            $('.thirdInfo').append(`
                        <h6 class="billTitle"> Totals </h6>
                        <ul>
                            ${localStorage.getItem('TotalOfProducts')}
                            ${localStorage.getItem('vat')}
                            <li><label> Ticket Price : </label> <strong id="beforeTax">${totalBeforeTax} SAR</strong></li>
                            ${entText}
                            <li><label> Vat : </label> <strong id="vat"> ${vat} SAR</strong></li>
                            <li><label> total after taxes : </label> <strong id="totalInfoPrice">${localStorage.getItem('price')} SAR</strong></li>
                            <li><label> Discount : </label> <strong id="totalInfoDiscount">0 SAR</strong></li>
                            <li><label> Amount To Pay : </label> <strong id="totalInfoRevenue">${totalBeforeDiscount} SAR</strong></li>
            `)
        }
    };

</script>
