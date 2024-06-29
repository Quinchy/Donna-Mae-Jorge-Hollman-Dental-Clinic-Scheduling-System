document.addEventListener('DOMContentLoaded', function() {
    var enableDates = JSON.parse(document.getElementById('enableDates').textContent).map(date => new Date(date));
    flatpickr("#calendarInline", {
        inline: true,
        monthSelectorType: 'static',
        yearSelectorType: 'static',
        minDate: "today",
        enable: enableDates,
        onChange: function(selectedDates, dateStr, instance) {
            document.getElementById('appointmentDate').value = dateStr;
            submitDate(dateStr);
        }
    });

    function submitDate(dateStr) {
        const endpoint = '/fetch-appointment-time-slots';
        const data = { date: dateStr };
        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token for Laravel
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            updateRadioButtons(data.availableTimeSlots, data.bookedTimeSlots);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }

    function updateRadioButtons(availableTimeSlots, bookedTimeSlots) {
        const ul = document.querySelector('.custom-radio');
        ul.innerHTML = ''; 
        availableTimeSlots.forEach((time, index) => {
            const li = document.createElement('li');
            li.className = 'slot';
            li.innerHTML = `
                <input type="radio" name="time_slot" value="${time}" id="available${index}" />
                <label for="available${index}">${time}</label>
            `;
            ul.appendChild(li);
        });
        bookedTimeSlots.forEach((time, index) => {
            const li = document.createElement('li');
            li.className = 'slot booked'; 
            li.innerHTML = `
                <input type="radio" name="time_slot" value="${time}" id="booked${index}" disabled />
                <label for="booked${index}" class="booked">${time}</label>
            `;
            ul.appendChild(li);
        });
    }

    document.querySelectorAll('.dropdown .item').forEach(item => {
        item.addEventListener('click', function() {
            document.getElementById('destination').textContent = this.textContent;
            document.getElementById('appointmentService').value = this.textContent;
        });
    });
});
