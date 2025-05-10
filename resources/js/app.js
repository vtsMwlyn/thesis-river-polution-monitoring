import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(() => {
    // For popups
    $('.popup-dismiss').on('click', function(){
        $(this).closest('.popup-container').fadeOut();
    });
});
