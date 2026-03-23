$(document).ready(function () {
    $('#whiteLabelForm').validate({
        rules:{
            dashboardUrl:{
                required: true
            },
            companyname:{
                required: true
            },
            email:{
                required: true,
                email: true
            },
            domainName:{
                required: true
            },
            subdomain:{
                required: true
            },
            fromEmail:{
                required: true,
                email: true
            }
        },
        messages:{
            dashboardUrl:{
                required: 'Please enter the Dashboard URL'
            },
            companyname:{
                required: 'Please enter the Company Name'
            },
            email:{
                required: 'Please enter your Email Address',
                email: 'Please enter a valid Email Address'
            },
            domainName:{
                required: 'Please enter the Domain Name'
            },
            subdomain:{
                required: 'Please select a Sub-domain'
            },
            fromEmail:{
                required: 'Please enter the FROM and REPLY-TO Email Address',
                email: 'Please enter a valid Email Address'
            }
        }
    });
});
