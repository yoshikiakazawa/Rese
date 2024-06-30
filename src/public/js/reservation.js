'use strict';
{
    document.addEventListener('DOMContentLoaded', () => {
        const d = new Date();
        const dateInput = document.querySelector('#date');
        const timeInput = document.querySelector('#time');
        const numberInput = document.querySelector('#number');

        const formattedDate = d.toISOString().split('T')[0];
        console.log(formattedDate);
        dateInput.value = formattedDate;

        updateReservationData();
        dateInput.addEventListener('input', updateReservationData);
        timeInput.addEventListener('input', updateReservationData);
        numberInput.addEventListener('input', updateReservationData);

        function updateReservationData() {
            document.querySelector('.reservation-data__table--text-date').textContent = dateInput.value;
            document.querySelector('.reservation-data__table--text-time').textContent = timeInput.value;
            document.querySelector('.reservation-data__table--text-number').textContent = numberInput.value + "人";
        }
    });
}
