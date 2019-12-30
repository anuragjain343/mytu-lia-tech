

$(document).ready(function() {
    jQuery.fn.visible = function() {
        return this.css('visibility', 'visible');
    };
    jQuery.fn.invisible = function() {
        return this.css('visibility', 'hidden');
    };
    $('#message').keyup(function() {
        var max = 200;
        var len = $(this).val().length;
        if (len >= max) {
            $('#count_message').html('<font color="red"></font>').slideDown();
        } else {
            var char = max - len;
            $('#count_message').html(char + '&nbsp;&nbsp;<font color="black">Characters</font>').slideDown();
        }
    });
    var add_feedback = $("#myform");
    add_feedback.validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true,
               
            },
            subject: {
                required: true
            },
            message: {
                required: true,
                minlength: 50,
                maxlength: 200
            },
        },
        messages: {
            name: {
                required: "Name is required field."
            },
            email: {
                required: "Email is required field.",
                email: "Please enter valid email"
            },
            subject: {
                required: "Subject is required field."
            },
            message: {
                required: "Messager is required field.",
                minlength: "Please enter minimum 50 characters.",
                maxlength: "Please enter maximum 200 characters.",
            },
        }
    });
    jQuery.validator.addMethod("phoneno", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
    }, "<br />Please enter a valid contact number");
    var create_post = $("#create_post");
    create_post.validate({
        rules: {
            category: {
                required: true
            },
            guest_number: {
                required: true
            },
            event_date: {
                required: true
            },
            event_time: {
                required: true
            },
            event_type: {
                required: true
            },
            budget_from: {
                required: true
            },
            contact_number: {
                required: true,
                number: true,
                phoneno: true,
                minlength: 7,
                maxlength: 20
            },
            currency_symbol: {
                required: true
            },
            address: {
                required: true
            },
            description: {
                required: true,
                minlength: 50,
                maxlength: 200
            },
        },
        messages: {
            category: {
                required: "Please select category"
            },
            guest_number: {
                required: "Please select number of guest"
            },
            event_date: {
                required: "Please select event date"
            },
            event_time: {
                required: "Please select event time"
            },
            event_type: {
                required: "Please select event type"
            },
            budget_from: {
                required: "Please select budget from"
            },
            guest_number: {
                required: "Please select number of guest"
            },
            contact_number: {
                required: "Contact number is required field.",
                number: "Please enter a valid contact number.",
                minlength: "Please enter minimum 7 digits.",
                maxlength: "Please enter maximum 20 digits."
            },
            currency_symbol: {
                required: "Please select currency code"
            },
            address: {
                required: "Address is required field."
            },
            description: {
                required: "Description is required field.",
                minlength: "Please enter minimum 50 characters.",
                maxlength: "Please enter maximum 200 characters."
            }
        }
    });
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "Letters and spaces only please");
    var base_url = $('#tl_front_body').attr('data-base-url');
    var updateProfile_form = $("#edit_profile");
    updateProfile_form.validate({
        rules: {
            fullName: {
                required: true,
                lettersonly: true
            },
            email: {
                required: true,
                email: true,
                
                remote: base_url + "home/users/check_user_email"
            },
            address: {
                required: true
            },
            contactNumber: {
                required: true,
                number: true,
                phoneno: true,
                remote: base_url + "home/users/check_contact",
                minlength: 7,
                maxlength: 20
            },
            currency_symbol: {
                required: true
            },
            description: {
                required: true
            },
            category: {
                required: true
            },
            price: {
                required: true,
                number: true,
                min: 1
            }
        },
        messages: {
            fullName: {
                required: "Name is required field.",
                lettersonly: "Enter only alphabates"
            },
            email: {
                required: "Email is required field.",
                email: "Please enter valid email",
                remote: "Email already exist"
            },
            address: {
                required: "City is required field."
            },
            contactNumber: {
                required: "Contact number is required field.",
                number: "Please enter valid contact number .",
                remote: "Mobile number already exist",
                minlength: "Please enter minimum 7 digits.",
                maxlength: "Please enter maximum 20 digits.",
            },
            currency_symbol: {
                required: "please select currency symbol"
            },
            description: {
                required: "description is required field."
            },
            category: {
                required: "please select category"
            },
            price: {
                required: "Price is required field.",
                number: "Please enter numbers only.",
                min: "Please enter amount"
            },
        }
    });
    var base_url = $('#tl_front_body').attr('data-base-url');
    var updateUserProfile_form = $("#edit_user_profile");
    updateUserProfile_form.validate({
        rules: {
            fullName: {
                required: true,
                lettersonly: true
            },
            email: {
                required: true,
                email: true,
               
                remote: base_url + "home/users/check_user_email"
            },
            address: {
                required: true
            },
            contactNumber: {
                required: true,
                number: true,
                phoneno: true,
                remote: base_url + "home/users/check_contact",
                minlength: 7,
                maxlength: 20
            },
        },
        messages: {
            fullName: {
                required: "Name is required field.",
                lettersonly: "Enter only alphabates"
            },
            email: {
                required: "Email is required field.",
                email: "Please enter valid email",
                remote: "Email already exist"
            },
            address: {
                required: "City is required field."
            },
            contactNumber: {
                required: "Contact number is required field.",
                number: "Please eneter valid contact number .",
                remote: "Mobile number already exist",
                minlength: "Please enter minimum 7 digits.",
                maxlength: "Please enter maximum 20 digits.",
            },
        }
    });
    var base_url = $('#tl_front_body').attr('data-base-url');
    var changePassword_form = $("#update_password");
    changePassword_form.validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                remote: base_url + "home/users/check_password"
            },
            npassword: {
                required: true,
                minlength: 6
            },
            rnpassword: {
                required: true,
                minlength: 6,
                equalTo: "#npassword"
            }
        },
        messages: {
            password: {
                required: "Password is required field.",
                minlength: "Please enter minimum 6 characters.",
                remote: "Your current password is wrong"
            },
            npassword: {
                required: "New password is required field.",
                minlength: "Please enter minimum 6 characters."
            },
            rnpassword: {
                required: "Confirm password is required field.",
                minlength: "Please enter minimum 6 characters.",
                equalTo: "Confirm password and new password doesn't match."
            }
        }
    });
    var addReview_form = $("#vendor_review");
    addReview_form.validate({
        rules: {
            review_description: {
                required: true,
                maxlength: 200
            },
        },
        messages: {
            review_description: {
                required: "Please enter description.",
                maxlength: "Please enter maximum 200 words."
            },
        }
    });
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    var base_url = $('#tl_front_body').attr('data-base-url');
    $('body').on('click', ".update_user_profile", function(event) {
        if (updateUserProfile_form.valid()) {
            var _that = $(this),
                form = _that.closest('form'),
                formData = new FormData(form[0]),
                f_action = form.attr('action');
            $.ajax({
                type: "POST",
                url: f_action,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function() {
                    show_loader();
                },
                success: function(data, textStatus, jqXHR) {
                    hide_loader();
                    if (data.status == 1) {
                        var userData = {
                            category: "",
                            email: data.userData.email,
                            firebaseId: "",
                            firebasetoken: "",
                            name: data.userData.fullName,
                            profilePic: data.userData.thumbImage,
                            uid: data.userData.id,
                            userType: data.userData.userType
                        };
                        var userType = data.userData.userType;
                        var uid = data.userData.id;
                        if (userType == 'user') {
                            var newPostKey = firebase.database().ref('users').child('user').child(data.userData.id).set(userData);
                        } else {
                            var newPostKey = firebase.database().ref('users').child('vendor').child(data.userData.id).set(userData);
                        }
                        toastr.success(data.message);
                        window.setTimeout(function() {
                            window.location.href = data.url;
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                    }
                    setTimeout(function() {
                        $(".alert").hide(1000);
                    }, 4000);
                },
                error: function() {
                    $(".loaders").fadeOut("slow");
                }
            });
        } else {
            toastr.error('Failed! Please try again');
        }
    });
    var base_url = $('#tl_front_body').attr('data-base-url');
    $('body').on('click', ".update_profile", function(event) {
        if (updateProfile_form.valid()) {
            var _that = $(this),
                form = _that.closest('form'),
                formData = new FormData(form[0]),
                f_action = form.attr('action');
            $.ajax({
                type: "POST",
                url: f_action,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function() {
                    show_loader();
                },
                success: function(data, textStatus, jqXHR) {
                    hide_loader();
                    if (data.status == 1) {
                        var userData = {
                            category: "",
                            email: data.userData.email,
                            firebaseId: "",
                            firebasetoken: "",
                            name: data.userData.fullName,
                            profilePic: data.userData.thumbImage,
                            uid: data.userData.id,
                            userType: data.userData.userType
                        };
                        var userType = data.userData.userType;
                        var uid = data.userData.id;
                        if (userType == 'user') {
                            var newPostKey = firebase.database().ref('users').child('user').child(data.userData.id).set(userData);
                        } else {
                            var newPostKey = firebase.database().ref('users').child('vendor').child(data.userData.id).set(userData);
                        }
                        toastr.success(data.message);
                        window.setTimeout(function() {
                            window.location.href = data.url;
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                    }
                    setTimeout(function() {
                        $(".alert").hide(1000);
                    }, 4000);
                },
                error: function() {
                    $(".loaders").fadeOut("slow");
                }
            });
        } else {
            toastr.error('Failed! Please try again');
        }
    });
    var base_url = $('#tl_front_body').attr('data-base-url');
    $('body').on('click', ".change_password", function(event) {
        if (changePassword_form.valid()) {
            var _that = $(this),
                form = _that.closest('form'),
                formData = new FormData(form[0]),
                f_action = form.attr('action');
            $.ajax({
                type: "POST",
                url: f_action,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function() {
                    show_loader();
                },
                success: function(data, textStatus, jqXHR) {
                    hide_loader();
                    if (data.status == 1) {
                        toastr.success(data.message);
                        window.setTimeout(function() {
                            window.location.href = data.url;
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function() {
                    $(".loaders").fadeOut("slow");
                }
            });
        }
    });
    var base_url = $('#tl_front_body').attr('data-base-url');
    $('body').on('click', ".add_post", function(event) {
        var t = checkDateTime();
        if (t) {
            var add_post = $('.add_post');
            add_post.attr('disabled', 'disabled');
            if (create_post.valid()) {
                var latitude = $("#latitude").val();
                var longitude = $("#longitude").val();
                if (latitude == '' && longitude == '') {
                    toastr.error('This is not a valid address');
                } else {
                    var _that = $(this),
                        form = _that.closest('form'),
                        formData = new FormData(form[0]),
                        f_action = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: f_action,
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "JSON",
                        beforeSend: function() {
                            $("div#divLoading").addClass('show');
                          
 
                        },
                        success: function(data, textStatus, jqXHR) {
                           $("div#divLoading").removeClass('show');
                          
                            if (data.status == 1) {
                                toastr.success(data.message);
                                window.setTimeout(function() {
                                    window.location.href = data.url;
                                }, 1000);
                            } else if (data.status == -1) {
                                toastr.error(data.message);
                                window.setTimeout(function() {
                                    window.location.href = data.url;
                                }, 100);
                            } else {
                                add_post.removeAttr('disabled');
                                toastr.error(data.message);
                            }
                        },
                        error: function() {
                            $(".loaders").fadeOut("slow");
                        }
                    });
                }
            } else {
                add_post.removeAttr('disabled');
            }
        }
    });
    var base_url = $('#tl_front_body').attr('data-base-url');
    $('body').on('click', ".update_post", function(event) {
        var d = checkTime();
        if (d) {
            if (create_post.valid()) {
                var latitude = $("#latitude").val();
                var longitude = $("#longitude").val();
                if (latitude == '' && longitude == '') {
                    toastr.error('This is not a valid address');
                } else {
                    var _that = $(this),
                        form = _that.closest('form'),
                        formData = new FormData(form[0]),
                        f_action = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: f_action,
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "JSON",
                        beforeSend: function() {
                            show_loader();
                        },
                        success: function(data, textStatus, jqXHR) {
                            hide_loader();
                            if (data.status == 1) {
                                toastr.success(data.message);
                                window.setTimeout(function() {
                                    window.location.href = data.url;
                                }, 2000);
                            } 
                            else {
                                toastr.error(data.message);

                            }
                        },
                        error: function() {
                            $(".loaders").fadeOut("slow");
                        }
                    });
                }
            }
        }
    });
    var base_url = $('#tl_front_body').attr('data-base-url');
    $('body').on('click', ".add_review", function(event) {
        var add_review = $('.add_review');
        add_review.attr('disabled', 'disabled');
        if (addReview_form.valid()) {
            var _that = $(this),
                form = _that.closest('form'),
                formData = new FormData(form[0]),
                f_action = form.attr('action');
            $.ajax({
                type: "POST",
                url: f_action,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function() {
                    show_loader();
                },
                success: function(data, textStatus, jqXHR) {
                    hide_loader();
                    if (data.status == 1) {
                        toastr.success(data.message);
                        window.setTimeout(function() {
                            window.location.href = data.url;
                        }, 1000);
                    } else if (data.status == -1) {
                        toastr.error(data.message);
                        window.setTimeout(function() {
                            window.location.href = data.url;
                        }, 1000);
                    } else {
                        add_review.removeAttr('disabled');
                        toastr.error(data.message);
                    }
                },
                error: function() {
                    $(".loaders").fadeOut("slow");
                    add_review.removeAttr('disabled');
                }
            });
        } else {
            add_review.removeAttr('disabled');
            toastr.error('Please, select rating!');
        }
    });
});

//ajax function to get_who_you_like load more btn
$('body').on('click',"#btnLoadViewMe", function(event){ 
    var is_offset_set = 1
    get_view_me_list(is_offset_set);
});

function get_view_me_list(is_load_more=0){ 
    if(is_load_more!=0){//if is_load_more is not 0 then get offset data from btnlod attr
        offset = $('#btnLoadViewMe').attr("data-offset");
    }else{ //set offset =0 when is_load_more is 0
        offset = 0;
    }
    $.ajax({
        url: base_url+"home/blogList",
        type: "POST",
        data:{offset:offset}, 
        dataType: "JSON",
        beforeSend: function() {
            show_loader();
        }, 
        success: function(data){ 
            hide_loader();
            if(data.status==-1){
                toastr.error(data.msg);
                window.setTimeout(function () {
                      window.location.href = data.url;
                }, 1000); 
            }
            $('#btnLoadViewMe').remove();//remove load more button 
            if(offset==0){ //clear div when offset 0
                $("#blog_list").html('');
            }
            if(data.no_record==0){//show data in div when no previous record 
                $("#blog_list").html(data.html_view);
                
            }else{
                //append data when already record show in view
                $("#blog_list").append(data.html_view);
                $("#ourBlogs").append(data.btn_html);
            }
        },
    }); 
}


function detailsFn(re){
    var more = $("#moreData"+re).attr('data-value');
    var title = $("#moreDataTitle"+re).attr('data-value');

     $("#showTitle").html(title);
      $("#showDetail").html(more);
      $('#myModal1').modal('show');
  
}
function  opModel(ree){
 var notificationData =$("#noti_title"+ree).attr('data-value');

     $("#notificationDetail").html(notificationData);
     $('#ModalNotification').modal('show');
}
