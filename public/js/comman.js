$(document).ready(function() {

    $(document).off('click', '.delete-btn').on('click', '.delete-btn', function () {
        var btn = $(this);
        bootbox.confirm({
            size: 'small',
            title: "<span class='text-danger'>Alert !</span>",
            message: "Are You Sure You Want to Delete This Record?",
            buttons: {
               cancel: {
                   label: '<i class="fa fa-times"></i> Cancel'
               },
               confirm: {
                   label: '<i class="fa fa-check"></i> Confirm',
                   class: 'btn-danger'
               }
            },
            callback: function (result) {
                if (result) {
                    $('#' + btn.data('href')).submit();
//                    window.location.href = btn.data('href');
                }
            }
        })
    });

});