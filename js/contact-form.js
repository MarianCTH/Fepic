function sendForm() {
    var formData = {
        name: $("input[name=name]").val(),
        email: $("input[name=email]").val(),
        message: $("textarea[name=message]").val(),
        company_name: $("input[name=company_name]").val(),
        city: $("select[name=city]").val(),
        phone: $("input[name=phone]").val(),
        website: $("input[name=website]").val(),
    };

    $.ajax({
        type: "POST",
        url: "send_email.php",
        data: formData,
        dataType: "json",
        success: function (response) {
            $("#result-message").text(response.message);
        },
        error: function () {
            $("#result-message").text("Oops! Something went wrong. Please try again later.");
        }
    });
}