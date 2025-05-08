import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(() => {
    $('.popup-dismiss').on('click', function(){
        $(this).closest('.popup-container').fadeOut();
    });

    $('.show-water-quality-parameters').on('click', function(){
        $('#water-quality-parameters-popup').parent().show();
    });
});
