function beforeSend(element_id) {

    document.getElementById(element_id).className += " disabled";
    document.getElementById(element_id).disabled = true;

}

let generateError = function (text) {

    let error = document.createElement('div');
    error.className = 'error';
    error.style.color = 'red';
    error.innerHTML = text;
    return error;

}

let removeValidation = function (form, error_class) {

    let errors = form.querySelectorAll('.' + error_class);

    for (let i = 0; i < errors.length; i++) {

        errors[i].remove();

    }
}

let checkFieldsPresence = function (form, validate_class) {

    let fields = form.querySelectorAll('.' + validate_class);

    for (let i = 0; i < fields.length; i++) {

        if (!fields[i].value) {

            let error = generateError('Это поле не может быть пустым')
            fields[i].parentElement.insertBefore(error, fields[i])
            fields[i].focus();
            return;

        }
    }
}


/**
 * Validate form fields.
 *
 * @since 1.0.0
 *
 * @param string  form. Form id.
 *
 * @param string  validate_class. Set fields class which  need validate, which  should be not be empty
 *
 * @param string  error_class. Add your class for invalid fields, which can overwrite default style
 *
 * @return boolean
 *
 */
let validateForm = function (form, validate_class, error_class) {

    removeValidation(form, error_class);

    checkFieldsPresence(form, validate_class);

    let errors = form.querySelectorAll('.' + error_class);

    if (errors.length > 0) {

        return false;

    } else {

        return true;
    }

}

function submitNewBetForm() {

    let form = document.getElementById('add-new-bet');

    if (!form) {

        return
    }

    let validate_class = 'field';

    let error_class = 'error';

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        if (validateForm(form, validate_class, error_class)) {

            let request = new XMLHttpRequest();

            let bet_title = document.getElementById("bet-title").value;

            let bet_content = document.getElementById("bet-content").value;

            let bet_type = document.getElementById("bet-type").value;

            let security = document.getElementById("new-bet-security").value;

            request.open('POST', theme_options.ajaxurl, true);

            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');

            request.onload = function () {

                if (this.status >= 200 && this.status < 400) {

                    // If successful
                    let result = JSON.parse(this.response);

                    document.getElementById("add-new-bet").reset();
                    document.getElementById("add-new-bet").getElementsByClassName("result")[0].innerHTML = result.msg;
                    document.getElementById("add-new-bet").getElementsByClassName("result")[0].style.display = 'block';
                    document.getElementById("submit-new-bet").classList.remove("disabled");
                    document.getElementById("submit-new-bet").disabled = false;

                } else {

                    // If fail
                    document.getElementById("add-new-bet").getElementsByClassName("result")[0].innerHTML = result.msg;
                }

                setTimeout(function () {

                    document.getElementById("add-new-bet").getElementsByClassName("result")[0].innerHTML = '';
                    document.getElementById("add-new-bet").getElementsByClassName("result")[0].style.display = 'none';

                }, 2500)
            };

            request.onerror = function () {

                // Connection error
                document.getElementById("add-new-bet").getElementsByClassName("result")[0].innerHTML = 'Произошла ошибка';

            };

            beforeSend('submit-new-bet');

            request.send('action=add_new_bet&bet_title=' + bet_title + '&bet_content=' + bet_content + '&bet_type=' + bet_type + '&security=' + security);

        }


    });

}

function submitSetBetVoteForm() {

    let form = document.getElementById('set-bet-vote');

    if (!form) {

        return;
    }

    let validate_class = 'field';

    let error_class = 'error';

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        if (validateForm(form, validate_class, error_class)) {

            let request = new XMLHttpRequest();

            let bet_id = document.getElementById("set-bet-vote").getAttribute('data-bet-id');

            let bet_vote = document.getElementById("bet-vote").value;

            let security = document.getElementById("set-bet-vote-security").value;

            request.open('POST', theme_options.ajaxurl, true);

            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');

            request.onload = function () {

                if (this.status >= 200 && this.status < 400) {

                    // If successful
                    let result = JSON.parse(this.response);

                    document.getElementById("set-bet-vote").getElementsByClassName("result")[0].innerHTML = result.msg;
                    document.getElementById("set-bet-vote").getElementsByClassName("result")[0].style.display = 'block';
                    document.getElementById("set-bet-vote").reset();

                } else {

                    // If fail
                    document.getElementById("add-new-bet").getElementsByClassName("result")[0].innerHTML = result.msg;

                }

                setTimeout(function () {

                    document.getElementById("set-bet-vote").getElementsByClassName("result")[0].innerHTML = '';
                    document.getElementById("set-bet-vote").getElementsByClassName("result")[0].style.display = 'none';

                }, 2500)
            };

            request.onerror = function () {

                // Connection error
                document.getElementById("set-bet-vote").getElementsByClassName("result")[0].innerHTML = 'Произошла ошибка';

            };

            beforeSend('submit-set-vote');

            request.send('action=set_bet_vote&bet_id=' + bet_id + '&bet_vote=' + bet_vote + '&security=' + security);

        }

    });
}

document.addEventListener('DOMContentLoaded', function () {

    submitNewBetForm();
    submitSetBetVoteForm();

});


