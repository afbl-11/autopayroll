import { getRegions, getProvinces, getCities, getBarangays } from "./psgc.js";

document.addEventListener("DOMContentLoaded", async () => {

    const countrySelect = document.getElementById('country');
    const regionSelect1 = document.getElementById("region");
    const provinceSelect1 = document.getElementById("province");
    const citySelect1 = document.getElementById("city");
    const barangaySelect1 = document.getElementById("barangay");

    const regionNameInput = document.getElementById("region_name");
    const provinceNameInput = document.getElementById("province_name");
    const cityNameInput = document.getElementById("city_name");
    const barangayNameInput = document.getElementById("barangay_name");


    const countrySelect2 = document.getElementById("id_country");
    const regionSelect2 = document.getElementById("id_region");
    const provinceSelect2 = document.getElementById("id_province");
    const citySelect2 = document.getElementById("id_city");
    const barangaySelect2 = document.getElementById("id_barangay");
    const postalSelect2 = document.getElementById("id_zip");
    const streetSelect2 = document.getElementById("id_street");
    const houseSelect2 = document.getElementById("id_house_number");

    const checkbox = document.getElementById("same_address");

    // --- Helper to create <option> with data-name ---
    function createOption(code, name) {
        const opt = document.createElement("option");
        opt.value = code;
        opt.textContent = name;
        opt.setAttribute("data-name", name);
        return opt;
    }

    // --- Load regions for both dropdowns ---
    const regions = await getRegions();
    [regionSelect1, regionSelect2].forEach(select => {
        select.innerHTML = "<option value=''>Select Region</option>";
        regions.forEach(region => {
            select.appendChild(createOption(region.code, region.name));
        });
    });

    // --- Helper population functions ---
    async function populateProvinces(regionSelect, provinceSelect, citySelect, barangaySelect) {
        provinceSelect.innerHTML = "<option value=''>Select Province</option>";
        citySelect.innerHTML = "<option value=''>Select City / Municipality</option>";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        if (!regionSelect.value) return;
        const provinces = await getProvinces(regionSelect.value);
        provinces.forEach(p => provinceSelect.appendChild(createOption(p.code, p.name)));
    }

    async function populateCities(provinceSelect, citySelect, barangaySelect) {
        citySelect.innerHTML = "<option value=''>Select City / Municipality</option>";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        if (!provinceSelect.value) return;
        const cities = await getCities(provinceSelect.value);
        cities.forEach(c => citySelect.appendChild(createOption(c.code, c.name)));
    }

    async function populateBarangays(citySelect, barangaySelect) {
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        if (!citySelect.value) return;
        const barangays = await getBarangays(citySelect.value);
        barangays.forEach(b => barangaySelect.appendChild(createOption(b.code, b.name)));
    }

    // --- Primary address event chain (with hidden input updates) ---
    regionSelect1.addEventListener("change", async () => {
        const selected = regionSelect1.options[regionSelect1.selectedIndex];
        regionNameInput.value = selected?.dataset?.name || "";
        provinceNameInput.value = cityNameInput.value = barangayNameInput.value = "";
        await populateProvinces(regionSelect1, provinceSelect1, citySelect1, barangaySelect1);
    });

    provinceSelect1.addEventListener("change", async () => {
        const selected = provinceSelect1.options[provinceSelect1.selectedIndex];
        provinceNameInput.value = selected?.dataset?.name || "";
        cityNameInput.value = barangayNameInput.value = "";
        await populateCities(provinceSelect1, citySelect1, barangaySelect1);
    });

    citySelect1.addEventListener("change", async () => {
        const selected = citySelect1.options[citySelect1.selectedIndex];
        cityNameInput.value = selected?.dataset?.name || "";
        barangayNameInput.value = "";
        await populateBarangays(citySelect1, barangaySelect1);
    });

    barangaySelect1.addEventListener("change", () => {
        const selected = barangaySelect1.options[barangaySelect1.selectedIndex];
        barangayNameInput.value = selected?.dataset?.name || "";
    });

    // --- Checkbox logic ---
    checkbox.addEventListener("change", async () => {
        if (checkbox.checked) {
            copyTextFields();
            countrySelect2.value = "Philippines";
            countrySelect2.classList.add("read-mode-only");

            regionSelect2.value = regionSelect1.value;
            regionSelect2.classList.add("read-mode-only");

            await populateProvinces(regionSelect2, provinceSelect2, citySelect2, barangaySelect2);
            provinceSelect2.value = provinceSelect1.value;
            provinceSelect2.classList.add("read-mode-only");

            await populateCities(provinceSelect2, citySelect2, barangaySelect2);
            citySelect2.value = citySelect1.value;
            citySelect2.classList.add("read-mode-only");

            await populateBarangays(citySelect2, barangaySelect2);
            barangaySelect2.value = barangaySelect1.value;
            barangaySelect2.classList.add("read-mode-only");

            postalSelect2.classList.add("read-mode-only");
            streetSelect2.classList.add("read-mode-only");
            houseSelect2.classList.add("read-mode-only");

            toggleSecondAddress(true);
        } else {
            toggleSecondAddress(false);
            [
                countrySelect2,
                regionSelect2,
                provinceSelect2,
                citySelect2,
                barangaySelect2,
                postalSelect2,
                streetSelect2,
                houseSelect2,
            ].forEach(el => el.classList.remove("read-mode-only"));
            clearSecondAddress();
        }
    });

    // --- Helpers ---
    function copyTextFields() {
        const pairs = [
            ["country", "id_country"],
            ["zip", "id_zip"],
            ["street", "id_street"],
            ["house_number", "id_house_number"],
        ];
        pairs.forEach(([from, to]) => {
            const fromEl = document.getElementById(from);
            const toEl = document.getElementById(to);
            if (fromEl && toEl) toEl.value = fromEl.value;
        });
    }

    function clearSecondAddress() {
        ["id_zip", "id_street", "id_house_number"].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = "";
        });
        [regionSelect2, provinceSelect2, citySelect2, barangaySelect2].forEach(sel => (sel.value = ""));
    }

    function toggleSecondAddress(readonly) {
        [
            regionSelect2,
            provinceSelect2,
            citySelect2,
            barangaySelect2,
            document.getElementById("id_country"),
            document.getElementById("id_zip"),
            document.getElementById("id_street"),
            document.getElementById("id_house_number"),
        ].forEach(el => {
            if (el) {
                el.readOnly = readonly;
                el.classList.toggle(readonly);
            }
        });
    }

    // --- Final safeguard before submitting (recheck hidden inputs) ---
    const form = document.querySelector("form");
    form.addEventListener("submit", () => {
        const r = regionSelect1.options[regionSelect1.selectedIndex];
        const p = provinceSelect1.options[provinceSelect1.selectedIndex];
        const c = citySelect1.options[citySelect1.selectedIndex];
        const b = barangaySelect1.options[barangaySelect1.selectedIndex];

        regionNameInput.value = regionNameInput.value || r?.dataset?.name || "";
        provinceNameInput.value = provinceNameInput.value || p?.dataset?.name || "";
        cityNameInput.value = cityNameInput.value || c?.dataset?.name || "";
        barangayNameInput.value = barangayNameInput.value || b?.dataset?.name || "";
    });
});
