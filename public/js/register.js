document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('registration_form_isCompany');

    function toggleFields() {
        const isCompany = checkbox.checked;

        document.querySelectorAll('.company-field').forEach(row => {
            row.style.display = isCompany ? '' : 'none';
        });

        document.querySelectorAll('.person-field').forEach(row => {
            row.style.display = isCompany ? 'none' : '';
        });
    }

    checkbox.addEventListener('change', toggleFields);
    toggleFields();
});
