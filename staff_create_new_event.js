document.addEventListener("DOMContentLoaded", function() {
    let showDateCounter = 1;
    let zoneCounter = 1;

    // Manage Show Dates
    function createNewDateSlot() {
        var showDatesContainer = document.getElementById('show-dates-container');

        var newDateSlot = document.createElement('div');
        newDateSlot.className = 'show-date-slot';

        var slotLabel = document.createElement('p');
        slotLabel.textContent = "Slot " + (showDateCounter);

        var newDateInput = document.createElement('input');
        newDateInput.type = 'datetime-local';
        newDateInput.name = 'show_date[]';

        var deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete this slot';
        deleteButton.type = 'button';
        deleteButton.classList.add('delete-button');
        deleteButton.addEventListener('click', function() {
            newDateSlot.remove();
            --showDateCounter;
            updateLabels('show-date-slot');
            manageDeleteButtons('show-date-slot');
        });

        newDateSlot.appendChild(slotLabel);
        newDateSlot.appendChild(newDateInput);
        newDateSlot.appendChild(deleteButton);

        var addDateButton = document.getElementById('add_date_new_slot');
        showDatesContainer.insertBefore(newDateSlot, addDateButton);
        showDateCounter++;
        updateLabels('show-date-slot');
    }

    // Manage Zones
    function createNewZoneSlot() {
        console.log('creating new zone slot');
        var zonesContainer = document.getElementById('zones-container');

        var newZoneSlot = document.createElement('div');
        newZoneSlot.className = 'zone-slot';

        var slotLabel = document.createElement('p');
        slotLabel.textContent = "Zone " + (zoneCounter);

        var newZoneInput = document.createElement('input');
        newZoneInput.type = 'text';
        newZoneInput.name = 'zone_name[]';
        newZoneInput.placeholder = 'Zone Name';

        var newZonePriceInput = document.createElement('input');
        newZonePriceInput.type = 'number';
        newZonePriceInput.name = 'zone_price[]';
        newZonePriceInput.min = '0';
        newZonePriceInput.placeholder = 'Zone Price';

        var zoneTypeSelect = document.createElement('select');
        zoneTypeSelect.name = 'zone_type[]';
        var option1 = document.createElement('option');
        option1.value = 'stand';
        option1.textContent = 'Stand';
        zoneTypeSelect.appendChild(option1);
        var option2 = document.createElement('option');
        option2.value = 'sit';
        option2.textContent = 'Sit';
        zoneTypeSelect.appendChild(option2);

        var newZoneSeatsInput = document.createElement('input');
        newZoneSeatsInput.type = 'number';
        newZoneSeatsInput.name = 'zone_seats[]';
        newZoneSeatsInput.min = '1';
        newZoneSeatsInput.placeholder = 'Number of Seats (1-99999)';

        var deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete this zone';
        deleteButton.type = 'button';
        deleteButton.classList.add('delete-button');
        deleteButton.addEventListener('click', function() {
            newZoneSlot.remove();
            --zoneCounter;
            updateLabels('zone-slot');
            manageDeleteButtons('zone-slot');
        });

        newZoneSlot.appendChild(slotLabel);
        newZoneSlot.appendChild(newZoneInput);
        newZoneSlot.appendChild(newZonePriceInput);
        newZoneSlot.appendChild(zoneTypeSelect);
        newZoneSlot.appendChild(newZoneSeatsInput);
        newZoneSlot.appendChild(deleteButton);

        var addZoneButton = document.getElementById('add_zone_new_slot');
        zonesContainer.insertBefore(newZoneSlot, addZoneButton);
        zoneCounter++;
        updateLabels('zone-slot');
    }

    // Manage Delete Buttons
    function manageDeleteButtons(slotClassName) {
        var slots = document.getElementsByClassName(slotClassName);
        for(let i=0; i < slots.length; i++) {
            var deleteButton = slots[i].querySelector('.delete-button');
            deleteButton.disabled = slots.length === 1;
        }
    }

    // Update labels
    function updateLabels(slotClassName) {
        console.log('updating labels for', slotClassName);
        var slots = document.getElementsByClassName(slotClassName);
        for(let i=0; i < slots.length; i++) {
            var label = slots[i].querySelector('p');
            if(slotClassName === 'show-date-slot') {
                label.textContent = "Slot " + (i+1);
            } else {
                label.textContent = "Zone " + (i+1);
            }
        }
    }

    // Add Event Listeners
    document.getElementById('add_date_new_slot').addEventListener('click', createNewDateSlot);
    document.getElementById('add_zone_new_slot').addEventListener('click', createNewZoneSlot);

    // Manage Delete Buttons on Page Load
    manageDeleteButtons('show-date-slot');
    manageDeleteButtons('zone-slot');
});