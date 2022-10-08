function openProcessingPage() {
    Codebase.loader("show");
}

function closeProcessingPage() {
    Codebase.loader("hide");
}

$('.nav-tabs .nav-item a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});
/**
 * keep the current tab active on page reload
 */
$(document).ready(function () {
    if ($(location).attr("pathname") !== sessionStorage.getItem("pathname")) {
        sessionStorage.setItem("pathname", $(location).attr("pathname"));
        sessionStorage.removeItem("clicked");
    }

    if (sessionStorage.getItem("clicked") != null) {
        var clickeId = sessionStorage.getItem("clicked");
        if (clickeId) {
            var idTabPane = $("#" + clickeId).attr("aria-controls");
            if (idTabPane !== undefined) {
                $(".nav-link").removeClass("active");
                $("#" + clickeId).addClass("active");
                $(".tab-pane").removeClass("active show");
                $("#" + idTabPane).addClass("active show");
            } else {
                sessionStorage.removeItem("clicked");
            }
        }
    }

    $(".nav-link").click(function () {
        sessionStorage.setItem("clicked", $(this).attr("id"));
    });
});

/**
 * open/close block search in list.blade
 */
$(".btn-search").on("click", function () {
    $("#block-search").toggle("show");
    $(".overlay").toggle();
});

/**
 * reset form Search in list.blade
 */
$(document).on("click", ".btn-reset-search", function () {
    $(".form-search input").not("input[type=radio]").removeAttr("value");
    $('input:radio[name="SAC"]').attr("checked", false);
    $("#SACT_ALL").attr("checked", "checked");
});

/**
 * del item in list.blade
 */
$(document).on("click", ".btn-del", function () {
    var delId = $(this).data("id-del");
    confirmDel(delId);
});

async function noitMessage(title, type, message) {
    return await Swal.fire({
        title: title,
        type: type,
        html: message,
        showConfirmButton: true,
    }).then((confirmed) => {
        if (confirmed.value == true) {
            return true;
        } else {
            return false;
        }
    });
}

function confirmDel(delId, title = "", type = "", message = "") {
    if (!title) title = $("#form_del").data("confirm-title");
    if (!type) type = $("#form_del").data("confirm-type");
    if (!message) message = $("#form_del").data("confirm-message");
    var textBtn = $("#form_del").data("confirm-btn");

    Swal.fire({
        title: title,
        type: type,
        html: message,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: textBtn,
    }).then((result) => {
        if (result.value) {
            var token = $("[name='_token']").val();
            var url_del = $("#form_del").attr("action") + "/" + delId;
            $.ajax({
                url: url_del,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: token,
                },
                success: function (response) {
                    console.log(response);
                    noitMessage(
                        response.title,
                        response.status,
                        response.message
                    );
                    $("#row_" + delId).hide("show");
                },
            });
        }
    });
}

async function confirmMessage(title, message, status = "warning") {
    return await swal({
        title: title,
        html: message,
        type: status,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
    }).then((confirmed) => {
        if (confirmed.value == true) {
            return true;
        } else {
            return false;
        }
    });
}

function alertLoading(title = "", message = "", status = "info") {
    if (message == "") {
        message =
            '<i class="pt-4 pb-4 fa fa-4x fa-cog fa-spin text-primary"></i>';
    }
    if (title == "") {
        title = "Loading...";
    }
    swal({
        title: title,
        html: message,
        type: status,
        showConfirmButton: false,
        backdrop: true,
        allowOutsideClick: false,
        // onBeforeOpen: () => {
        //     swal.showLoading()
        // }
    });
}

async function checkUsername(username = '', old_username = '') {

    if (username === '') {   
        var username = $('#username').val();
    }
    if (old_username === '') {
        var old_username = $('#old_username').val();
    }
    if (old_username !== username) {

        var url = urlChkUsername
        res = $.post(url, {
                'username': username
            })
            .then(function (response) {
                var decodedResponse = atob(response);
                var obj = JSON.parse(decodedResponse);
                if (obj.code === 200) {
                    return obj.message;
                } else {
                    return false;
                }
            })
            .catch(function (err) {
                return false;
            });
        return await res;

    } else {
        return await true;
    }
}

async function checkEmail( email = '', old_email = '') {

    // var url = "{{ route('chk.email') }}";
    // var email = $('#email').val();
    // var old_email = $('#old_email').val();
     if (email === '') {
         var email = $('#email').val();
     }
     if (old_email === '') {
         var old_email = $('#old_email').val();
     }
    if (old_email !== email) {
        var url = urlChkEmail
        res = $.post(url, {
                'email': email
            })
            .then(function (response) {
                var decodedResponse = atob(response);
                var obj = JSON.parse(decodedResponse);
                if (obj.code === 200) {
                    return obj.message;
                } else {
                    return false;
                }
            })
            .catch(function (err) {
                return false;
            });
        return await res;

    } else {
        return await true;
    }
}

async function checkPassword(password = '') {

    // Strong: The password has to meet all the requirements.
    // -- minimum 8 character 
    // -- minimum 1 lowercase character
    // -- minimum 1 uppercase character
    // -- minimum 1 digit
    // -- minimum 1 special character  
    let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})');

    if (strongPassword.test(password)) {
        return await true;
    } else {
        return await false;
    }
}

