$(document).ready(function () {
    $.validator.addMethod("validate_email", function(value) {
        return /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(value);
    });

    $('#contactUsForm').validate({
        rules:{
            name:{
                required: true
            },
            companyname:{
                required: true
            },
            email:{
                required: true,
                email: true,
                validate_email: true
            },
            companytype:{
                required: true
            },
            referral:{
                required: true
            },
            subject:{
                required: true
            },
            message:{
                required: true,
                minlength: 8
            }
        },
        messages:{
            name:{
                required: 'Please enter your name'
            },
            companyname:{
                required: 'Please enter your company name'
            },
            email:{
                required: "Please enter your email",
                email: "Please enter a valid email address",
                validate_email: "Please enter a valid email"
            },
            companytype:{
                required: 'Please select whether you are a Marketing Agency or Business'
            },
            referral:{
                required: 'Please select where you heard about us'
            },
            subject:{
                required: "Please enter a subject"
            },
            message:{
                required: "Please enter a message",
                minlength: "Enter a longer, more descriptive message"
            }
        }
    });
});
