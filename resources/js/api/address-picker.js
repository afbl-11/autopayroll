import {
    getRegions,
    getProvinces,
    getCities,
    getNCRCities,
    getBarangays
} from "./psgc.js";

document.addEventListener("DOMContentLoaded", async () => {

    const regionSelect = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const citySelect = document.getElementById("city");
    const barangaySelect = document.getElementById("barangay");

    const regionNameInput = document.getElementById("region_name");
    const provinceNameInput = document.getElementById("province_name");
    const cityNameInput = document.getElementById("city_name");
    const barangayNameInput = document.getElementById("barangay_name");

    const NCR_CODE = "130000000"; // <<< THIS IS ACTUAL PSGC NCR CODE

    function createOption(code, name) {
        const option = document.createElement("option");
        option.value = code;
        option.textContent = name;
        option.dataset.name = name;
        return option;
    }

    // Load regions
    const regions = await getRegions();
    regions.forEach(r => regionSelect.appendChild(createOption(r.code, r.name)));

    // ---------------------------
    // REGION CHANGE
    // ---------------------------
    regionSelect.addEventListener("change", async () => {

        provinceSelect.innerHTML = "<option value=''>Select Province</option>";
        citySelect.innerHTML = "<option value=''>Select City</option>";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";

        provinceNameInput.value = "";
        cityNameInput.value = "";
        barangayNameInput.value = "";

        const selectedRegion = regionSelect.selectedOptions[0];
        regionNameInput.value = selectedRegion?.dataset?.name || "";

        if (!regionSelect.value) return;

        // ---------- NCR LOGIC ----------
        if (regionSelect.value === NCR_CODE) {
            console.log("NCR detected — skipping provinces");

            // disable province
            provinceSelect.disabled = true;

            // load NCR cities
            const cities = await getNCRCities(NCR_CODE);
            cities.forEach(c => citySelect.appendChild(createOption(c.code, c.name)));

            return; // <<< IMPORTANT: stop here (skip province fetch)
        }

        // ---------- NORMAL REGIONS ----------
        provinceSelect.disabled = false;

        const provinces = await getProvinces(regionSelect.value);
        provinces.forEach(p => provinceSelect.appendChild(createOption(p.code, p.name)));
    });

    // ---------------------------
    // PROVINCE CHANGE (NOT USED FOR NCR)
    // ---------------------------
    provinceSelect.addEventListener("change", async () => {

        if (provinceSelect.disabled) return; // NCR case → skip listener

        citySelect.innerHTML = "<option value=''>Select City</option>";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        cityNameInput.value = "";
        barangayNameInput.value = "";

        const selectedProvince = provinceSelect.selectedOptions[0];
        provinceNameInput.value = selectedProvince?.dataset?.name || "";

        if (!provinceSelect.value) return;

        const cities = await getCities(provinceSelect.value);
        cities.forEach(c => citySelect.appendChild(createOption(c.code, c.name)));
    });

    // ---------------------------
    // CITY CHANGE (WORKS FOR ALL)
    // ---------------------------
    citySelect.addEventListener("change", async () => {

        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        barangayNameInput.value = "";

        const selectedCity = citySelect.selectedOptions[0];
        cityNameInput.value = selectedCity?.dataset?.name || "";

        if (!citySelect.value) return;

        const barangays = await getBarangays(citySelect.value);
        barangays.forEach(b => barangaySelect.appendChild(createOption(b.code, b.name)));
    });

    barangaySelect.addEventListener("change", () => {
        const selectedBarangay = barangaySelect.selectedOptions[0];
        barangayNameInput.value = selectedBarangay?.dataset?.name || "";
    });
});
