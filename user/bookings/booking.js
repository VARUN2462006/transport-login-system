document.addEventListener("DOMContentLoaded", function () {
    const vehicleSelect = document.getElementById("vehicle");
    const distanceInput = document.getElementById("distance");
    const priceDisplay = document.getElementById("priceDisplay");
    const pricePerKmInput = document.getElementById("pricePerKm");
    const totalPriceInput = document.getElementById("totalPrice");

    function updatePrice() {
        const selectedOption = vehicleSelect.options[vehicleSelect.selectedIndex];
        const pricePerKm = parseFloat(selectedOption.getAttribute("data-price")) || 0;
        const distance = parseFloat(distanceInput.value) || 0;

        const totalPrice = pricePerKm * distance;

        priceDisplay.innerHTML = `Total Price: &#8377;${totalPrice}`;

        pricePerKmInput.value = pricePerKm;
        totalPriceInput.value = totalPrice;
    }

    vehicleSelect.addEventListener("change", updatePrice);
    distanceInput.addEventListener("input", updatePrice);
});
