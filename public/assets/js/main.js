(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()

$(document).ready(function () {
    function buttonState(element, state) {
        const defaultState = element.find('.default-state');

        const loadingState = element.find('.loading-state');

        if (state === 'loading') {
            defaultState.addClass('d-none');

            loadingState.removeClass('d-none');
            return;
        }

        defaultState.removeClass('d-none');

        loadingState.addClass('d-none');
    }

    function setFormGlobalStatusHtml(element, message, status) {
        let html = '';

        if (message.length > 0) {
            if (status === 'success') {
                html = `<span class="text-success">${message}</span>`;
            } else {
                html = `<span class="text-danger">${message}</span>`;
            }
        }

        element.html(html);
    }

    function setFormInputError(element, message) {
        element.addClass('is-invalid');

        element.closest('div').find('.invalid-feedback').html(message).addClass('invalid-feedback-overrided');
    }

    $(document).on("submit", "#book-records-form", function () {
        const form = $(this);

        const button = form.find('button[type="submit"]');

        const formGlobalStatusInfo = form.find('.form-info');

        $('.is-invalid').removeClass('is-invalid');

        setFormGlobalStatusHtml(formGlobalStatusInfo, '');

        buttonState(button, 'loading');

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serializeArray(),
            dataType: "json",
            success: function (data) {
                buttonState(button, 'default');

                setFormGlobalStatusHtml(formGlobalStatusInfo, data.message, 'success');

                form[0].reset();

                form.removeClass('was-validated');
            },
            error: function (data) {
                buttonState(button, 'default');

                const input = $(`[name="${data.responseJSON.field}"]`);

                if (data.responseJSON.field === undefined || input.length === 0) {
                    setFormGlobalStatusHtml(formGlobalStatusInfo, (data.responseJSON.message === undefined) ? 'Wystąpił bląd' : data.responseJSON.message, 'danger');
                    return;
                }

                setFormInputError(input, data.responseJSON.message);

                form.removeClass('was-validated');
            }
        });

        return false;
    });

    $(document).on("input", "#book-records-form input, #book-records-form textarea", function () {
        const element = $(this);

        if (!element.hasClass('is-invalid')) {
            return;
        }

        const overridedFeedback = element.closest('div').find('.invalid-feedback-overrided');

        if (overridedFeedback.length === 0) {
            return;
        }

        overridedFeedback.html(overridedFeedback.attr('data-default'));

        element.removeClass('is-invalid');
    });

    $(document).on("click", ".delete-book-record", function () {
        const button = $(this);

        if (!confirm("Jesteś pewny?")) {
            return;
        }

        buttonState(button, 'loading');

        $.ajax({
            type: "POST",
            url: "/address/delete/",
            data: {
                id: button.attr('data-id')
            },
            dataType: "json",
            success: function (data) {
                button.closest('tr').remove();

                tableEmptyCheck();
            },
            error: function (data) {
                buttonState(button, 'default');

                alert((data.message === undefined) ? 'Wystąpił bląd' : data.message);
            }
        });
    });

    function tableEmptyCheck() {
        const tbody = $('tbody');

        if (tbody.children().length === 0) {
            tbody.html(`<tr><td colspan="8">Brak informacji <a href="/address/add/" class="btn btn-primary">Dodaj adres</a></td></tr>`);
        }
    }
});