import { getRegions, getProvinces, getCities, getBarangays } from "./psgc.js";

document.addEventListener("DOMContentLoaded", async () => {
    const regionSelect1 = document.getElementById("region");
    const provinceSelect1 = document.getElementById("province");
    const citySelect1 = document.getElementById("city");
    const barangaySelect1 = document.getElementById("barangay");

    const regionSelect2 = document.getElementById("region2");
    const provinceSelect2 = document.getElementById("province2");
    const citySelect2 = document.getElementById("city2");
    const barangaySelect2 = document.getElementById("barangay2");

    const checkbox = document.getElementById("same_address");

    // --- Load regions for both dropdowns ---
    const regions = await getRegions();
    [regionSelect1, regionSelect2].forEach(select => {
        select.innerHTML = "<option value=''>Select Region</option>";
        regions.forEach(region => {
            const opt = document.createElement("option");
            opt.value = region.name;
            opt.textContent = region.name;
            select.appendChild(opt);
        });
    });

    // --- Helper population functions ---
    async function populateProvinces(regionSelect, provinceSelect, citySelect, barangaySelect) {
        provinceSelect.innerHTML = "<option value=''>Select Province</option>";
        citySelect.innerHTML = "<option value=''>Select City</option>";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        if (!regionSelect.value) return;
        const provinces = await getProvinces(regionSelect.value);
        provinces.forEach(p => {
            const opt = document.createElement("option");
            opt.value = p.name;
            opt.textContent = p.name;
            provinceSelect.appendChild(opt);
        });
    }

    async function populateCities(provinceSelect, citySelect, barangaySelect) {
        citySelect.innerHTML = "<option value=''>Select City</option>";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        if (!provinceSelect.value) return;
        const cities = await getCities(provinceSelect.value);
        cities.forEach(c => {
            const opt = document.createElement("option");
            opt.value = c.name;
            opt.textContent = c.name;
            citySelect.appendChild(opt);
        });
    }

    async function populateBarangays(citySelect, barangaySelect) {
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        if (!citySelect.value) return;
        const barangays = await getBarangays(citySelect.value);
        barangays.forEach(b => {
            const opt = document.createElement("option");
            opt.value = b.name;
            opt.textContent = b.name;
            barangaySelect.appendChild(opt);
        });
    }

    // --- Primary address event chain ---
    regionSelect1.addEventListener("change", async () => {
        await populateProvinces(regionSelect1, provinceSelect1, citySelect1, barangaySelect1);
    });

    provinceSelect1.addEventListener("change", async () => {
        await populateCities(provinceSelect1, citySelect1, barangaySelect1);
    });

    citySelect1.addEventListener("change", async () => {
        await populateBarangays(citySelect1, barangaySelect1);
    });

    // --- Checkbox logic ---
    checkbox.addEventListener("change", async () => {
        if (checkbox.checked) {
            copyTextFields();
            regionSelect2.value = regionSelect1.value;

            await populateProvinces(regionSelect2, provinceSelect2, citySelect2, barangaySelect2);
            provinceSelect2.value = provinceSelect1.value;

            await populateCities(provinceSelect2, citySelect2, barangaySelect2);
            citySelect2.value = citySelect1.value;

            await populateBarangays(citySelect2, barangaySelect2);
            barangaySelect2.value = barangaySelect1.value;

            toggleSecondAddress(true); // disable all fields
        } else {
            toggleSecondAddress(false); // re-enable
            clearSecondAddress();
        }
    });

    // --- Helpers ---
    function copyTextFields() {
        const pairs = [
            ["country", "country2"],
            ["zip", "zip2"],
            ["street", "street2"],
            ["house-number", "house-number2"]
        ];
        pairs.forEach(([from, to]) => {
            const fromEl = document.getElementById(from);
            const toEl = document.getElementById(to);
            if (fromEl && toEl) toEl.value = fromEl.value;
        });
    }

    function clearSecondAddress() {
        [
            "country2",
            "zip2",
            "street2",
            "house-number2"
        ].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = "";
        });
        [regionSelect2, provinceSelect2, citySelect2, barangaySelect2].forEach(sel => (sel.value = ""));
    }
    function toggleSecondAddress(disabled) {
        [
            regionSelect2,
            provinceSelect2,
            citySelect2,
            barangaySelect2,
            document.getElementById("country2"),
            document.getElementById("zip2"),
            document.getElementById("street2"),
            document.getElementById("house-number2")
        ].forEach(el => {
            if (el) el.disabled = disabled;
        });
    }
});
