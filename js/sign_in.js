$(document).ready(function () {
  $("#login-error").hide();


  $("#signin-form").submit(function (event) {
    event.preventDefault();

    var email = $("input[name='email']").val();
    var password = $("input[name='parola']").val();

    $.ajax({
      type: "POST",
      url: "php/session/check_user.php",
      data: { email: email, parola: password },
      dataType: "json",
      success: function (data) {
        if (data.requires2FA) {
          $("#login-error").hide();
          createTwoFactorModal(data.FactorAuthCode);
        }
        else if (data.loginSuccess) {
          $("#login-error").hide();
          $.ajax({
            type: "POST",
            url: "php/session/sign_in_send.php",
            data: { email: email, parola: password },
            dataType: "json",
            success: function (response) {
              if (response.success) {
                window.location.href = "index";
              }
              else {
                $("#login-error").html(response.message).show();
              }
            }
          });
        }

        else if (data.unverified_account) {
          var resend_email = ' (<a href="" id="resend-link">Retrimite email-ul</a>)';
          $("#login-error").html(data.message + resend_email).show();

          var resendLink = $('#resend-link');
          var timerValue = 30;
          var timerTimeout;
          var remainingTime;

          var remainingTimeCookie = $.cookie('remainingTime');
          if (remainingTimeCookie) {
            remainingTime = parseInt(remainingTimeCookie);

            if (remainingTime > 0) {
              startTimer();
              resendLink.addClass('disabled');
              resendLink.text('Retrimite email-ul de verificare (' + remainingTime + ')');
            }
          } else {
            remainingTime = 0;
          }

          resendLink.click(function (e) {
            e.preventDefault();

            if (resendLink.hasClass('disabled')) {
              return;
            }

            $.ajax({
              url: 'php/session/resend_email.php',
              type: 'GET',
              data: {
                email: email
              },
              beforeSend: function () {
                resetTimer();
                resendLink.addClass('disabled');
                startTimer();
              }
            });
          });

          function startTimer() {
            remainingTime = timerValue;
            updateTimer();
            timerTimeout = setInterval(updateTimer, 1000);

            $.cookie('remainingTime', remainingTime, { expires: 1 });
          }

          function updateTimer() {
            remainingTime--;
            resendLink.text('Retrimite email-ul de verificare (' + remainingTime + ')');

            if (remainingTime <= 0) {
              resetTimer();
              resendLink.removeClass('disabled');
              resendLink.text('Retrimite email-ul de verificare');
            }

            localStorage.setItem('remainingTime', remainingTime.toString());
          }

          function resetTimer() {
            clearInterval(timerTimeout);
            remainingTime = 0;

            $.removeCookie('remainingTime');
          }
        }
        else {
          $("#login-error").html(data.message).show();
        }
      },
      error: function () {
        alert('An error occurred during validation. Please try again.');
      }
    });
  });
});

function verify2FACode(FactorAuthCode, UserInputAuthCode) {
  $.ajax({
    type: "POST",
    url: "php/session/check_user_2fa.php",
    data: { FactorAuthCode: FactorAuthCode, UserInputAuthCode: UserInputAuthCode },
    dataType: "json",
    success: function (response) {
      if (response.goodCode) {
        var email = $("input[name='email']").val();
        var password = $("input[name='parola']").val();
        $.ajax({
          type: "POST",
          url: "php/session/sign_in_send.php",
          data: { email: email, parola: password },
          dataType: "json",
          success: function (response) {
            if (response.success) {
              window.location.href = "index";
            }
            else {
              $("#login-error").html(response.message).show();
            }
          }
        });
      }
      else {
        $("#error_auth").html(response.message).show().delay(3000).fadeOut();
      }
    },
    error: function () {
      alert('An error occurred during validation. Please try again.');
    }
  });
}

function initializeTwoFactorModal() {
  var $inputs = $('[name^=pincode]');
  var $submitButton = $('#twoFactorModal button[name="2fa_auth"]');

  $inputs.on('input', function (event) {
    var currentIndex = $inputs.index(this);
    var inputValue = $(this).val().trim();
    var numericValue = inputValue.replace(/[^0-9]/g, '');

    $(this).val(numericValue);

    if (event.inputType === 'deleteContentBackward' && currentIndex > 0) {
      $inputs.eq(currentIndex - 1).focus();
    } else if (numericValue !== '' && currentIndex < $inputs.length - 1) {
      $inputs.eq(currentIndex + 1).focus();
    }

    var codeLength = $inputs.toArray().reduce(function (total, input) {
      return total + ($(input).val() ? 1 : 0);
    }, 0);

    if (codeLength === 6) {
      $submitButton.prop('disabled', false);
    } else {
      $submitButton.prop('disabled', true);
    }
  });

  $inputs.on('keydown', function (event) {
    if (event.which === 9 || event.which === 8) {
      var currentIndex = $inputs.index(this);
      var inputValue = $(this).val().trim();
      var numericValue = inputValue.replace(/[^0-9]/g, '');
      $(this).val(numericValue);

      if (event.which === 8 && currentIndex > 0 && numericValue === '') {
        $inputs.eq(currentIndex - 1).focus();
      } else if (event.which === 9 && currentIndex < $inputs.length - 1 && numericValue === '') {
        event.preventDefault();
        $inputs.eq(currentIndex + 1).focus();
      }

      var codeLength = $inputs.toArray().reduce(function (total, input) {
        return total + ($(input).val() ? 1 : 0);
      }, 0);

      if (codeLength === 6) {
        $submitButton.prop('disabled', false);
      } else {
        $submitButton.prop('disabled', true);
      }
    }
  });
}

function createTwoFactorModal(FactorAuthCode) {
  var modalHtml = `
    <div class="modal fade" id="twoFactorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title">Autentificare în doi factori</h1>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
              <form id="form">
                  <div class="form__group form__pincode">
                    <label>Introduceți codul de 6 cifre din aplicația dvs. de autentificare</label>
                    <input type="tel" name="pincode-1" maxlength="1" tabindex="1" placeholder="·" autocomplete="off">
                    <input type="tel" name="pincode-2" maxlength="1" tabindex="2" placeholder="·" autocomplete="off">
                    <input type="tel" name="pincode-3" maxlength="1" tabindex="3" placeholder="·" autocomplete="off">
                    <input type="tel" name="pincode-4" maxlength="1" tabindex="4" placeholder="·" autocomplete="off">
                    <input type="tel" name="pincode-5" maxlength="1" tabindex="5" placeholder="·" autocomplete="off">
                    <input type="tel" name="pincode-6" maxlength="1" tabindex="6" placeholder="·" autocomplete="off">
                  </div>
                  <div class="form__buttons">
                    <p class="error text-center" id="error_auth"></p>
                    <button class="btn btn_main" type="submit" name="2fa_auth" disabled>Autentificare <i class="icofont-arrow-right"></i></button>
                  </div>
              </form>
              </div>
          </div>
        </div>
    </div>
      `;

  $("body").append(modalHtml);

  $("#twoFactorModal").modal("show");

  var $modalForm = $("#twoFactorModal form");

  $modalForm.on("submit", function (event) {
    event.preventDefault();

    var authCode = "";

    $modalForm.find("[name^=pincode]").each(function () {
      authCode += $(this).val();
    });

    console.log(authCode + " "); console.log(FactorAuthCode);
    verify2FACode(FactorAuthCode, authCode);
  });

  initializeTwoFactorModal();
}

function handleCredentialResponse(response) {
  var googleAuthIdToken = response.credential;

  $.ajax({
    type: "POST",
    url: "php/session/sign_in_send.php",
    data: { google_auth_token: googleAuthIdToken },
    dataType: "json",
    success: function (ajaxResponse) {
      if (ajaxResponse.success) {
        window.location.href = "index";
      } else {
        $("#login-error").html(ajaxResponse.message).show();
      }
    }
  });
}