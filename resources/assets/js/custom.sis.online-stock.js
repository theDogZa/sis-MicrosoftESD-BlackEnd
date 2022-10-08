function openProcessingPage() {
    Codebase.loader('show');
}

function closeProcessingPage() {
    Codebase.loader('hide');
}

/** 
 * keep the current tab active on page reload  
 */
$(document).ready(function () {

    if ($(location).attr('pathname') !== sessionStorage.getItem("pathname")) {
        sessionStorage.setItem("pathname", $(location).attr('pathname'))
        sessionStorage.removeItem("clicked")
    }

    if (sessionStorage.getItem("clicked") != null) {
        var clickeId = sessionStorage.getItem("clicked")
        if (clickeId) {
            var idTabPane = $('#' + clickeId).attr('aria-controls');
            if (idTabPane !== undefined) {
                $('.nav-link').removeClass('active')
                $('#' + clickeId).addClass('active')
                $('.tab-pane').removeClass('active show')
                $('#' + idTabPane).addClass('active show')
            } else {
                sessionStorage.removeItem("clicked")
            }
        }
    }

    $('.nav-link').click(function () {
        sessionStorage.setItem("clicked", $(this).attr('id'));
    });

});

/**
 * open/close block search in list.blade
 */
$('.btn-search').on("click", function () {
    $('#block-search').toggle('show');
});


/**
 * reset form Search in list.blade
 */
$(document).on("click", '.btn-reset-search', function () {
    $(".form-search input").not("input[type=radio]").removeAttr('value');
    $('input:radio[name="SAC"]').attr('checked', false);
    $("#SACT_ALL").attr('checked', 'checked');
});

/**
 * del item in list.blade
 */
$(document).on("click", '.btn-del', function () {

    var delId = $(this).data('id-del');
    confirmDel(delId)
})


async function noitMessage(title, type, message) {
    return await Swal.fire({
        title: title,
        type: type,
        html: message,
        showConfirmButton: true
    }).then((confirmed) => {
        if (confirmed.value == true) {
            return true
        } else {
            return false
        }
    });

}

function confirmDel(delId, title = '', type = '', message = '') {

    if (!title) title = $("#form_del").data('confirm-title');
    if (!type) type = $("#form_del").data('confirm-type');
    if (!message) message = $("#form_del").data('confirm-message');
    var textBtn = $("#form_del").data('confirm-btn');

    Swal.fire({
        title: title,
        type: type,
        html: message,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: textBtn
    }).then((result) => {

        if (result.value) {
            var token = $("[name='_token']").val()
            var url_del = $("#form_del").attr('action') + "/" + delId;
            $.ajax({
                url: url_del,
                type: "POST",
                data: {
                    "_method": "DELETE",
                    "_token": token,
                },
                success: function (response) {
                    console.log(response);
                    noitMessage(response.title, response.status, response.message)
                    $('#row_' + delId).hide('show');
                }
            });
        }
    })
}

async function confirmMessage(title, message, status = 'warning') {

    return await swal({
        title: title,
        html: message,
        type: status,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((confirmed) => {
        if (confirmed.value == true) {
            return true
        } else {
            return false
        }
    });
}

function alertLoading(title = '', message = '', status = 'info') {
    if (message == '') {
        message = '<i class="pt-4 pb-4 fa fa-4x fa-cog fa-spin text-primary"></i>'
    }
    if (title == '') {
        title = 'Loading...'
    }
    swal({
        title: title,
        html: message,
        type: status,
        showConfirmButton: false,
        backdrop: true,
        allowOutsideClick: false
        // onBeforeOpen: () => {
        //     swal.showLoading()
        // }
    });
}
