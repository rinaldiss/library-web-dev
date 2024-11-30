document.addEventListener('DOMContentLoaded', function() {
    const numberInput = document.getElementById('year_of_publication');

    function allowOnlyNumbers(event) {
        const charCode = event.which ? event.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault();
        }
    }

    numberInput.addEventListener('keypress', allowOnlyNumbers);

    numberInput.addEventListener('input', function() {
        numberInput.value = numberInput.value.replace(/\D/g, '');
    });

    numberInput.addEventListener('paste', function(event) {
        setTimeout(function() {
            numberInput.value = numberInput.value.replace(/\D/g, '');
        }, 0);
    });
});
