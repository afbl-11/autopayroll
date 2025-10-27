import { getRegions, getProvinces, getCities, getBarangays } from "./psgc.js";

document.addEventListener("DOMContentLoaded", async () => {
    const regionSelect = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const citySelect = document.getElementById("city");
    const barangaySelect = document.getElementById("barangay");

    // hidden name inputs
    const regionNameInput = document.getElementById("region_name");
    const provinceNameInput = document.getElementById("province_name");
    const cityNameInput = document.getElementById("city_name");
    const barangayNameInput = document.getElementById("barangay_name");

    function createOption(code, name) {
        const option = document.createElement("option");
        option.value = code;           // keep code so nested fetch endpoints work
        option.textContent = name;
        option.setAttribute("data-name", name);
        return option;
    }

    // load regions
    const regions = await getRegions();
    regions.forEach(region => {
        regionSelect.appendChild(createOption(region.code, region.name));
    });


    regionSelect.addEventListener("change", async () => {

        provinceSelect.innerHTML = "<option value=''>Select Province</option>";
        citySelect.innerHTML = "<option value=''>Select City / Municipality</option>";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        provinceNameInput.value = "";
        cityNameInput.value = "";
        barangayNameInput.value = "";

        // set region name hidden input
        const selectedRegionOption = regionSelect.options[regionSelect.selectedIndex];
        regionNameInput.value = selectedRegionOption?.dataset?.name || "";

        if (!regionSelect.value) return;

        // load provinces by region code
        const provinces = await getProvinces(regionSelect.value);
        provinces.forEach(prov => {
            provinceSelect.appendChild(createOption(prov.code, prov.name));
        });
    });


    provinceSelect.addEventListener("change", async () => {
        citySelect.innerHTML = "<option value=''>Select City / Municipality</option>";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        cityNameInput.value = "";
        barangayNameInput.value = "";

        const selectedProvinceOption = provinceSelect.options[provinceSelect.selectedIndex];
        provinceNameInput.value = selectedProvinceOption?.dataset?.name || "";

        if (!provinceSelect.value) return;

        const cities = await getCities(provinceSelect.value);
        cities.forEach(city => {
            citySelect.appendChild(createOption(city.code, city.name));
        });
    });


    citySelect.addEventListener("change", async () => {
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
        barangayNameInput.value = "";

        const selectedCityOption = citySelect.options[citySelect.selectedIndex];
        cityNameInput.value = selectedCityOption?.dataset?.name || "";

        if (!citySelect.value) return;

        const barangays = await getBarangays(citySelect.value);
        barangays.forEach(b => {
            barangaySelect.appendChild(createOption(b.code, b.name));
        });
    });

    barangaySelect.addEventListener("change", () => {
        const selectedBarangayOption = barangaySelect.options[barangaySelect.selectedIndex];
        barangayNameInput.value = selectedBarangayOption?.dataset?.name || "";
    });

    const form = document.querySelector("form");
    form.addEventListener("submit", (e) => {
        // region
        const rOpt = regionSelect.options[regionSelect.selectedIndex];
        regionNameInput.value = regionNameInput.value || rOpt?.dataset?.name || rOpt?.text || "";

        // province
        const pOpt = provinceSelect.options[provinceSelect.selectedIndex];
        provinceNameInput.value = provinceNameInput.value || pOpt?.dataset?.name || pOpt?.text || "";

        // city
        const cOpt = citySelect.options[citySelect.selectedIndex];
        cityNameInput.value = cityNameInput.value || cOpt?.dataset?.name || cOpt?.text || "";

        // barangay
        const bOpt = barangaySelect.options[barangaySelect.selectedIndex];
        barangayNameInput.value = barangayNameInput.value || bOpt?.dataset?.name || bOpt?.text || "";
    });
});
