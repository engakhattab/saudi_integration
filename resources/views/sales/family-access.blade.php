@extends('sales.layouts.master')
@section('page_title')
    {{$setting->title}} | Family Access
@endsection
@section('content')
      <h2 class="MainTiltle mb-5 ms-4"> Family Access </h2>
      <div class="card p-3 py-4 w-100 w-sm-80 m-auto ">
          <label class="form-label fs-4"> <i class="fas fa-ticket-alt me-2"></i>Sale Number Or Phone</label>
          <div class="d-flex">
              <input type="text" class="form-control" id="searchValue" placeholder="Type here...">
              <button type="button" id="searchButton" class="input-group-text ms-2 bg-gradient-primary px-4 text-body"><i
                      class="fas fa-search text-white"></i></button>
          </div>
      </div>

      <form class="card p-2 py-4 mt-3 ">
        <!-- table -->
        <table class=" customDataTable table table-bordered nowrap">
            <div class="d-flex justify-content-between align-items-center flex-wrap px-3 pb-3">
                <button type="button" class="btn btn-success d-none" data-bs-toggle="modal" data-bs-target="#payAmount" id="payBtn">
                    <i class="far fa-check me-1"></i> Pay Amount
                </button>
            </div>
          <thead>
            <tr>
              <th>Sale Number</th>
              <th>Type</th>
              <th>Bracelet Number </th>
              <th>Name</th>
              <th>Birthday</th>
              <th>Gender</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>

          <div class="modal fade" id="payAmount" tabindex="-1" role="dialog" aria-labelledby="payAmount" aria-hidden="true"
               data-bs-backdrop="static">
              <div class="modal-dialog modal-danger modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h6 class="modal-title" id="modal-title-print">Pay Remaining Amount</h6>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                              <i class="fal fa-times text-dark fs-4"></i>
                          </button>
                      </div>
                          <div class="modal-body">
                              <input class="data_id" name="id" id="idOfTicket" type="hidden">
                              <p>Are You Sure Of Paying The Remaining Amount ?</p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-dark ml-auto me-2" data-bs-dismiss="modal"> Close</button>
                              <button type="submit" class="btn btn-success" id="confirmBtn"> Confirm</button>
                          </div>
                  </div>
              </div>
          </div>

      </form>
       <!-- Print Modal -->
        <div class="modal fade" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="modal-title-print"
            aria-hidden="true">
          <div class="modal-dialog modal-danger modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-print">Print Ticket</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times text-dark fs-4"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="fad fa-print fa-4x"></i>
                        <h5 class="text-gradient text-dark mt-4" id="modal-question">Send Receipt</h5>
                        <h6>Please choose whether to print the ticket or send it via WhatsApp.</h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="printBtn" href="javascript:void(0);" onclick="printTicket()" class="btn btn-success">
                        Print
                    </button>
    
                    <a class="btn btn-success" target="_blank" id="whatsappBtn" href="">
                        <i class="fab fa-whatsapp me-2"></i>Send via WhatsApp
                    </a>
                </div>
            </div>
          </div>
        </div>
      @include('layouts.print.iframe')

@endsection
@section('js')
    <script>
        ////////////////////////////////////////////
        // choice Js
        ////////////////////////////////////////////
        $(".controlIcons .icon").click(function () {
            $(this).addClass('checked')
        });
        $('#main-family').addClass('active')
        $('.familyAccess').addClass('active')
        $('#familySale').addClass('show')
        /*$('#whatsappBtn').attr('data-id',whats_ticket_no );
        $('#whatsappBtn').attr('href', $pdfurl );*/

       function sendWhatsApp() {
    // Get the 'search' parameter from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search'); // Get the 'search' parameter
// Construct the full URL of the request
    const postUrl = `${window.location.origin}/send-whatsapp`;

    // Log the full URL
    console.log(`Full URL: ${postUrl}`);
    // Make an AJAX POST request
    $.ajax({
        url: 'https://kidsstation.fun/send-whatsapp/index.php', // Laravel route URL
        method: 'POST',
        data: {
            search: searchParam, // Pass the 'search' parameter
            domain: "s", // Pass the 'search' parameter
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function(response) {
            console.log(response); // Handle success response
            $('#whatsappBtn').attr('href', response );
            //toastr.success('WhatsApp message sent successfully!');
            //alert('WhatsApp message sent successfully!');
        },
        error: function(xhr) {
            console.error(xhr); // Handle error response
            toastr.error("Failed to send WhatsApp message!");
           // alert('Failed to send WhatsApp message.');
        }
    });
}    

sendWhatsApp(); 
    </script>
    {{--================= custom js ==================--}}
    @include('sales.layouts.customJs.familyAccess')
@endsection
