document.addEventListener("DOMContentLoaded", function () {
  let zoneCounter = 1;

  // Function to create a new zone slot
  function createNewZoneSlot() {
    var zonesContainer = document.getElementById("zones-container");

    var newZoneSlot = document.createElement("div");
    newZoneSlot.className = "zone-slot";
    newZoneSlot.dataset.zoneId = "zone-" + zoneCounter; // Add a unique ID to the zone slot

    var slotLabel = document.createElement("p");
    slotLabel.textContent = "Zone ";

    var newZoneSelect = document.createElement("select");
    newZoneSelect.name = "show_type[]";

    var disabledOption = document.createElement("option");
    disabledOption.disabled = true;
    disabledOption.selected = true;
    disabledOption.style.color = "gray";
    disabledOption.hidden = true;
    disabledOption.textContent = "Type";

    var SitOption = document.createElement("option");
    SitOption.value = "Sit";
    SitOption.textContent = "Sit";

    var StandOption = document.createElement("option");
    StandOption.value = "Stand";
    StandOption.textContent = "Stand";

    newZoneSelect.appendChild(disabledOption);
    newZoneSelect.appendChild(SitOption);
    newZoneSelect.appendChild(StandOption);

    var newZoneCapacityInput = document.createElement("input");
    newZoneCapacityInput.type = "text";
    newZoneCapacityInput.name = "zonecapacity[]";
    newZoneCapacityInput.placeholder = "Capacity(Seats)";

    var deleteZoneButton = document.createElement("button");
    deleteZoneButton.textContent = "Delete this zone";
    deleteZoneButton.type = "button";
    deleteZoneButton.addEventListener("click", function () {
      newZoneSlot.remove();
      --zoneCounter;
    });

    newZoneSlot.appendChild(slotLabel);
    newZoneSlot.appendChild(newZoneSelect);
    newZoneSlot.appendChild(newZoneCapacityInput);
    newZoneSlot.appendChild(deleteZoneButton);

    zonesContainer.appendChild(newZoneSlot);
    zoneCounter++;
  }

  // Add event listener to the "Add New Zone" button
  var addZoneButton = document.getElementById("add_zone_new_slot");
  addZoneButton.addEventListener("click", createNewZoneSlot);
});
