'use strict';
{
    document.addEventListener('DOMContentLoaded', () => {
        const dateInput = document.querySelector('#date');
        const timeInput = document.querySelector('#time');
        const numberInput = document.querySelector('#number');

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
