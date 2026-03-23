function postPaymentUrl(url, data, targetDiv) {
    if (targetDiv === undefined) targetDiv = 'message';

    $.ajax({
        method: 'POST',
        url: url,
        data: data,
        processData: false,
        contentType: false
    }).done(function (data) {
        if ($('#formModal')) {
            $('#formModal').modal('hide');
        }

        $('#' + targetDiv).html(data);
    });
}

function savePaymentForm(formName, targetURL, targetDiv) {
    if (targetDiv === undefined) targetDiv = 'message';
    //compile a data model
    let data = getFormData(formName);

    postPaymentUrl(targetURL, data, targetDiv);
}