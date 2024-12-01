
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        function fetchEventsFromPHP() {
            return fetch("php/events/get_events.php").then(function (response) {
                return response.json();
            })
                .then(function (data) {
                    return data.map(function (event) {
                        return {
                            title: event.title,
                            start: event.start,
                            end: event.end,
                            description: event.description,
                            link: event.link,
                            banner: event.banner,
                            event_id: event.event_id
                        };
                    });
                });
        }

        function generateCalendar() {
            var c = new FullCalendar.Calendar(calendarEl, {

                allDaySlot: false,
                editable: false,
                contentHeight: 600,
                firstDay: 1,
                locale: 'ro',
                eventClick: function (e) {
                    function CreateModalContent() {
                        var modalbody = $('#modal-event').find('.modal-body');

                        var eventDescription = e.event.extendedProps.description;

                        modalbody.empty();

                        var newModalBody = `
                        <div class="text-center">
                            <div class="image-container">
                                <img src="" id="banner-event">
                            </div>
                            Data de începere a evenimentului
                            <p id="data-starting-event" class="font-weight-bold"></p>
                            Data de încheiere a evenimentului
                            <p id="data-ending-event" class="font-weight-bold"></p>
                            <p id="main-article-event">Pentru a afla mai multe despre acest eveniment citiți <a href=""
                                    id="article-event" class="text_btn">acest articol</a>.</p>

                            <p id="event-description"></p>

                            <div id="not_registred">
                                <p>Pentru a vă înscrie la eveniment apăsați butonul de mai jos.<br>
                                    Atenție! Pentru a vă înscrie este necesară <a href="sign-up"
                                        class="text_btn">înregistrarea</a> dumnevoastră.</p>
                                <a id="registration-link" href="sign-in" class="btn btn_main">ÎNSCRIE-TE </a>
                            </div>
                            <div style="display:none;" id="already-registred-waiting" class="warning">
                                <p>Cererea dumneavoastră de înscriere este în așteptare !<a href="#" id = "cancel_user_registration" style="color:red;">(Anulați înscrierea)</a></p>
                            </div>
                            <div style="display:none;" id="already-registred" class="correct">
                                <p>Sunteți deja înscris la acest eveniment <a href="#" id = "cancel_user_registration2" style="color:red;">(Anulați înscrierea)</a></p>
                            </div>
                        </div>
                        `;

                        modalbody.append(newModalBody);

                        $('#event-title').text(e.event.title);
                        $('#data-starting-event').text(formatRomanianDate(e.event.start));
                        $('#data-ending-event').text(formatRomanianDate(e.event.end));

                        if (e.event.extendedProps.link.length === 0) {
                            $('#main-article-event').show();
                            $('#main-article-event').hide();
                        }
                        else {
                            $('#article-event').attr('href', e.event.extendedProps.link);
                        }

                        if (e.event.extendedProps.banner.length === 0) {
                            $('#banner-event').hide();
                        }
                        else {
                            $('#banner-event').show();
                            $('#banner-event').attr('src', "images/targuri/banner/" + e.event.extendedProps.banner);
                        }

                        if (eventDescription.length === 0) {
                            $('#event-description').hide();
                        }
                        else {
                            $('#event-description').show();
                            $('#event-description').text(eventDescription);
                        }
                        
                        fetch('php/events/get_user_logged_in')
                            .then(response => response.text())
                            .then(status => {
                                if (status === "logged_in") {
                                    $("#registration-link").on("click", function (event) {
                                        event.preventDefault();

                                        modalbody.empty();

                                        newModalBody = `
                                            <div class="text-center" style="margin-bottom:1rem;">
                                                Pentru acest eveniment este necesară încărcarea următoarelor documente:<br>
                                                <div class="text-center d-flex align-items-center">
                                                <div class="form-group">
                                                    <label for="certificat_constatator" class="d-block mb-1">Certificat constatator:</label>
                                                    <div class="d-inline-block">
                                                        <input type="file" id="certificat_constatator" name="certificat_constatator" class="form-control-file">
                                                    </div>
                                                </div>
                                            
                                                <div class="form-group ml-4">
                                                    <label for="expiration_date" class="d-block mb-1">Data eliberării:</label>
                                                    <input type="date" class="form-control" name="expiration_date" id="expiration_date" placeholder="Data de expirare">
                                                </div>
                                            </div>
                                            
                                            </div>
                                            <div class="text-center" style="margin-bottom:1rem;">
                                                Sunteți de acord să vă înscrieți la evenimentul ${e.event.title}?
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-default" id="cancel_registration_event">Anulează</button>
                                                <button type="submit" class="btn btn_main" id="send_registration_event">Înscrie-mă</button>
                                            </div>
                                            <div id="message"></div>
                                        `;

                                        modalbody.append(newModalBody);

                                        
                                        
                                        $('#send_registration_event').on('click', function () {
                                            var expirationDate = $('[name="expiration_date"]').val();

                                            if (!isValidExpirationDate(expirationDate)) {
                                                alert('Vă rugăm să furnizați o dată de expirare validă în următoarele 30 de zile.');
                                                return;
                                            }

                                            var fileInput = document.getElementById('certificat_constatator');
                                            var file = fileInput.files[0];

                                            if (!file) {
                                                alert('Please upload a file.');
                                                return;
                                            }

                                            var allowedFileTypes = ['application/pdf', 'image/jpeg', 'image/png'];

                                            if (allowedFileTypes.indexOf(file.type) === -1) {
                                                alert('Tip de fișier nevalid. Vă rugăm să încărcați un fișier PDF, JPG sau PNG.');
                                                return;
                                            }
                                        
                                            var formData = new FormData();
                                            formData.append('file', file);
                                            formData.append('expiration_date', expirationDate);
                                        
                                            fetch('php/events/register_user.php?event_id=' + e.event.extendedProps.event_id, {
                                                method: 'POST',
                                                body: formData
                                            })
                                            .then(respons => respons.json())
                                            .then(data => {
                                                if (data.success) {
                                                    $('#message').html(data.message).removeClass('error2').addClass('correct');
                                                } else {
                                                    $('#message').html(data.message).removeClass('correct').addClass('error2');
                                                }
                                            })
                                            .catch(error => console.error('Error checking login status:', error));
                                        });

                                        $('#cancel_registration_event').off('click').on('click', function () {
                                            modalbody.empty();
                                            CreateModalContent();
                                        });
                                    });

                                }
                            })
                            .catch(error => console.error('Error checking login status:', error));
                        
                        checkAlreadyRegistred(e.event.extendedProps.event_id);
                        $('#cancel_user_registration, #cancel_user_registration2').on('click', function (ev) {
                            ev.preventDefault();
                        
                            var isConfirmed = window.confirm('Sunteți sigur că doriți să anulați înscrierea la acest eveniment?');
                        
                            if (isConfirmed) {
                                fetch('php/events/delete_event_signup.php?eventID=' + e.event.extendedProps.event_id)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Înscrierea a fost anulată cu success !');
                                            location.reload();
                                        } else {
                                            alert('Error: ' + data.message);
                                        }
                                    })
                                    .catch(error => {
                                        alert('Error: Unable to delete user registration');
                                        console.error('Fetch Error:', error);
                                    });
                            } else {
                                console.log('User canceled the operation.');
                            }
                        });
                        
                    }
                    CreateModalContent();
                    $('#modal-event').modal('show');

                }
            });

            fetchEventsFromPHP()
                .then(function (events) {
                    c.addEventSource(events);
                    c.render();
                });
        }
        generateCalendar();
    }
});

function isValidExpirationDate(expirationDate) {
    var currentDate = new Date();
    var selectedDate = new Date(expirationDate);
    var timeDifference = selectedDate - currentDate;

    var daysDifference = timeDifference / (1000 * 60 * 60 * 24);

    return daysDifference <= 30;
}

function formatRomanianDate(dateString) {
    const months = [
      'Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie',
      'Iulie', 'August', 'Septembrie', 'Octombrie', 'Noiembrie', 'Decembrie'
    ];
  
    const days = ['Duminică', 'Luni', 'Marți', 'Miercuri', 'Joi', 'Vineri', 'Sâmbătă'];
  
    const date = new Date(dateString);
    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();
    const dayOfWeek = days[date.getDay()];
    const hours = date.getHours();
    const minutes = ('0' + date.getMinutes()).slice(-2);
  
    return `${day} ${month} ${year} (${dayOfWeek}) - Ora ${hours}:${minutes}`;
}

function populateSpan(elementId, dateTime) {
    var spanElement = document.getElementById(elementId);
    if (dateTime && dateTime !== "NotExisting") {
        var formattedDate = new Date(dateTime).toLocaleString();
        spanElement.textContent = formattedDate;
    } else if (dateTime === "NotExisting") {
        spanElement.textContent = "Niciun târg viitor";
    } else {
        spanElement.textContent = "nedefinit";
    }
}

function checkAlreadyRegistred(event_id, user_id) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "php/events/check_already_registred.php?eventID=" + event_id + "&userID=" + user_id, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            if (data.success) {
                var confirmationStatus = data.confirmation;                
                if (confirmationStatus === "Confirmat") {
                     document.getElementById("not_registred").style.display = "none";
                    document.getElementById("already-registred-waiting").style.display = "none";
                    document.getElementById("already-registred").style.display = "block";
                } else if (confirmationStatus === "în așteptare") {
                    document.getElementById("not_registred").style.display = "none";
                    document.getElementById("already-registred").style.display = "none";
                    document.getElementById("already-registred-waiting").style.display = "block";
                }
            }
        }
    };
    xhr.send();
}

function loadUpcomingEvents(){
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "php/events/get_last_next_event.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            populateSpan("UrmatorulTarg", data.UrmatorulTarg);
            populateSpan("UltimulTarg", data.UltimulTarg);
        }
    };
    xhr.send();
}
loadUpcomingEvents()