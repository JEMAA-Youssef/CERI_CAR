
$(document).ready(function () {
    //fonction notification
    function showNotification(message, type = 'info') {
        $('#notification')
            .removeClass('alert-success alert-warning alert-danger alert-info')
            .addClass(`alert-${type}`)
            .text(message)
            .fadeIn()
            .delay(3000)
            .fadeOut();
    }

    let rechercheForm = $('#recherche-form');

    rechercheForm.on('submit', function (e) {
        e.preventDefault();
        rechercheForm.find("input").each((index, element) => {
            if (element.type == "text") {
                element.value = element.value.slice(0, 1).toUpperCase() + element.value.slice(1).toLowerCase();
            }
        });

        let villeDepart = $('#recherche-form input[name="RechercheVoyage[villeDepart]"]').val().trim();
        let villeArrivee = $('#recherche-form input[name="RechercheVoyage[villeArrivee]"]').val().trim();
        let nombrePersonnes = $('#recherche-form input[name="RechercheVoyage[nombrePersonnes]"]').val();

        if (!villeDepart || !villeArrivee) {
            showNotification('Veuillez remplir les champs Ville de départ et Ville d\'arrivée.', 'warning');
            return;
        }

        if (isNaN(nombrePersonnes) || nombrePersonnes <= 0) {
            showNotification('Veuillez indiquer un nombre valide de personnes (au moins 1).', 'warning');
            return;
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.html) {
                    $('#resultats-container').html(response.html).fadeIn();
                } else {
                    $('#resultats-container').html('').fadeOut();
                }

                showNotification(response.message, response.message.includes('Aucun') ? 'warning' : 'success');
            },
            error: function () {
                showNotification('Une erreur est survenue. Veuillez réessayer.', 'danger');
                $('#resultats-container').fadeOut();
            }
        });
    });

    // Gestionnaire d'événements pour le bouton Réserver
    $(document).on('click', '.btn-reserver', function () {
        let button = $(this);
        let voyageId = button.data('id');
        let nombrePersonnes = button.data('nombre-personnes');

        $.ajax({
            url: 'reservervoyage',
            type: 'POST',
            data: {
                id: voyageId,
                nbplaceresa: nombrePersonnes,
                _csrf: yii.getCsrfToken(),
            },
            success: function (response) {
                if (response.status === 'success') {
                    showNotification(response.message, 'success');
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                } else {
                    showNotification(response.message, 'danger');
                }
            },
            error: function () {
                showNotification('Une erreur est survenue. Veuillez réessayer.', 'danger');
            }
        });
    });
    //login
    $('#login-form').on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    showNotification(response.message, 'success');
                    window.location.href = response.redirect;
                } else {
                    showNotification(response.message, 'danger');
                }
            },
            error: function () {
                showNotification('Une erreur interne est survenue. Veuillez réessayer.', 'danger');
            }
        });
    });
    //logout
    $(document).on('click', '.logout-button', function (e) {
        e.preventDefault();

        $.ajax({
            url: '/~uapv2305767/ArchiecturesWeb/web/site/logout',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: yii.getCsrfToken()
            },
            success: function (response) {
                if (response.status === 'success') {
                    showNotification(response.message, 'success');
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 500);
                } else {
                    showNotification(response.message, 'danger');
                }
            },
            error: function () {
                showNotification('Une erreur interne est survenue. Veuillez réessayer.', 'danger');
            }
        });
    });
    
    $('#ajax-propose-btn').on('click', function (e) {
        e.preventDefault();
    
        let form = $('#propose-voyage-form');
        
        // Transforme les champs de texte pour mettre la première lettre en majuscule et le reste en minuscule
        form.find("input[name='Voyage[depart]'], input[name='Voyage[arrivee]']").each((index, element) => {
            element.value = element.value.slice(0, 1).toUpperCase() + element.value.slice(1).toLowerCase();
        });
    
        let formData = form.serialize();
    
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    if (response.redirect) {
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 1000);
                    }
                } else {
                    showNotification(response.message, 'danger');
                }
            },
            error: function () {
                showNotification('Une erreur est survenue lors de la soumission du formulaire.', 'danger');
            }
        });
    });
    

    $('#register-form').on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let submitButton = $(this).find(':submit');
        submitButton.prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    showNotification(response.message, 'success');
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 500);
                } else {
                    let errorMessages = response.message;
                    if (response.errors) {
                        errorMessages = '';
                        for (let field in response.errors) {
                            errorMessages += response.errors[field].join(', ') + '<br>';
                        }
                    }
                    showNotification(errorMessages, 'danger');
                }
            },
            error: function () {
                showNotification('Une erreur interne est survenue. Veuillez réessayer.', 'danger');
            },
            complete: function () {
                submitButton.prop('disabled', false);
            }
        });
    });
});
