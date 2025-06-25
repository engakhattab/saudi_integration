<script>
    // Show Data Using YAJRA
    async function showData(routeOfShow,columns,order = 0) {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: routeOfShow,
                columns: columns,
                pageLength: 100,
                order: [
                    [order, "desc"]
                ],
                "language": {
                    "sProcessing": "Loading ...",
                    "sLengthMenu": "Show _MENU_ Row",
                    "sZeroRecords": "No Data",
                    "sInfo": "show _START_ to  _END_ from _TOTAL_ rows",
                    "sInfoEmpty": "No Data",
                    "sInfoFiltered": "For Search",
                    "sSearch": "Search : ",
                    "oPaginate": {
                        "sPrevious": "Previous",
                        "sNext": "Next",
                    },
                    buttons: {
                        copyTitle: 'Copied To Clipboard<i class="fa fa-check-circle text-success"></i>',
                        copySuccess: {
                            1: "Copied One Row",
                            _: "Copied %d Rows Successfully"
                        },
                    }
                },

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: 'Copy',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'colvis',
                        text: 'Visibility',
                        className: 'btn-primary'
                    },
                ]
            });
        }

    // Delete Using Ajax
    function deleteScript(routeOfDelete) {
        $(document).ready(function () {
            //Show data in the delete form
            $('#delete_modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var title = button.data('title')
                var modal = $(this)
                modal.find('.modal-body #delete_id').val(id);
                modal.find('.modal-body #title').text(title);
            });
        });

        $(document).on('click', '#delete_btn', function (event) {
            var id = $("#delete_id").val();
            $.ajax({
                type: 'POST',
                url: routeOfDelete,
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': id,
                },
                success: function (data) {
                    if (data.status === 200) {
                        $("#dismiss_delete_modal")[0].click();
                        $('#dataTable').DataTable().ajax.reload();
                        toastr.success(data.message)
                    } else {
                        $("#dismiss_delete_modal")[0].click();
                        toastr.error(data.message)
                    }
                }
            });
        });
    }
</script>
