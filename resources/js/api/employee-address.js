import { getRegions, getProvinces, getCities, getNCRCities, getBarangays } from "./psgc.js";

document.addEventListener("DOMContentLoaded", async () => {
    const NCR_CODE = "130000000";

    function createOption(code, name) {
        const option = document.createElement("option");
        option.value = code;
        option.textContent = name;
        option.dataset.name = name;
        return option;
    }

    // ----------------------------- RESIDENTIAL ADDRESS -----------------------------
    const region = document.getElementById("region");
    const province = document.getElementById("province");
    const city = document.getElementById("city");
    const barangay = document.getElementById("barangay");
    const region_name = document.getElementById("region_name");
    const province_name = document.getElementById("province_name");
    const city_name = document.getElementById("city_name");
    const barangay_name = document.getElementById("barangay_name");

    const regions = await getRegions();
    regions.forEach(r => region.appendChild(createOption(r.code, r.name)));

    async function populateProvinces(regionCode, select, nameInput) {
        select.innerHTML = "<option value=''>Select Province</option>";
        nameInput.value = "";
        if (!regionCode || regionCode === NCR_CODE) return;
        const provinces = await getProvinces(regionCode);
        provinces.forEach(p => select.appendChild(createOption(p.code, p.name)));
    }

    async function populateCities(provinceCode, select, nameInput) {
        select.innerHTML = "<option value=''>Select City</option>";
        nameInput.value = "";
        if (!provinceCode) return;
        const cities = await getCities(provinceCode);
        cities.forEach(c => select.appendChild(createOption(c.code, c.name)));
    }

    async function populateBarangays(cityCode, select, nameInput) {
        select.innerHTML = "<option value=''>Select Barangay</option>";
        nameInput.value = "";
        if (!cityCode) return;
        const barangays = await getBarangays(cityCode);
        barangays.forEach(b => select.appendChild(createOption(b.code, b.name)));
    }

    region.addEventListener("change", async () => {
        region_name.value = region.selectedOptions[0]?.dataset.name || "";
        province.disabled = region.value === NCR_CODE;
        await populateProvinces(region.value, province, province_name);
        city.innerHTML = "<option value=''>Select City</option>";
        barangay.innerHTML = "<option value=''>Select Barangay</option>";
        city_name.value = "";
        barangay_name.value = "";
        if (region.value === NCR_CODE) {
            const cities = await getNCRCities(NCR_CODE);
            cities.forEach(c => city.appendChild(createOption(c.code, c.name)));
        }
    });

    province.addEventListener("change", async () => {
        province_name.value = province.selectedOptions[0]?.dataset.name || "";
        await populateCities(province.value, city, city_name);
        barangay.innerHTML = "<option value=''>Select Barangay</option>";
        barangay_name.value = "";
    });

    city.addEventListener("change", async () => {
        city_name.value = city.selectedOptions[0]?.dataset.name || "";
        await populateBarangays(city.value, barangay, barangay_name);
    });

    barangay.addEventListener("change", () => {
        barangay_name.value = barangay.selectedOptions[0]?.dataset.name || "";
    });

    // ----------------------------- ID ADDRESS -----------------------------
    const id_region = document.getElementById("id_region");
    const id_province = document.getElementById("id_province");
    const id_city = document.getElementById("id_city");
    const id_barangay = document.getElementById("id_barangay");
    const id_region_name = document.getElementById("id_region_name");
    const id_province_name = document.getElementById("id_province_name");
    const id_city_name = document.getElementById("id_city_name");
    const id_barangay_name = document.getElementById("id_barangay_name");

    regions.forEach(r => id_region.appendChild(createOption(r.code, r.name)));

    id_region.addEventListener("change", async () => {
        id_region_name.value = id_region.selectedOptions[0]?.dataset.name || "";
        id_province.disabled = id_region.value === NCR_CODE;
        await populateProvinces(id_region.value, id_province, id_province_name);
        id_city.innerHTML = "<option value=''>Select City</option>";
        id_barangay.innerHTML = "<option value=''>Select Barangay</option>";
        id_city_name.value = "";
        id_barangay_name.value = "";
        if (id_region.value === NCR_CODE) {
            const cities = await getNCRCities(NCR_CODE);
            cities.forEach(c => id_city.appendChild(createOption(c.code, c.name)));
        }
    });

    id_province.addEventListener("change", async () => {
        id_province_name.value = id_province.selectedOptions[0]?.dataset.name || "";
        await populateCities(id_province.value, id_city, id_city_name);
        id_barangay.innerHTML = "<option value=''>Select Barangay</option>";
        id_barangay_name.value = "";
    });

    id_city.addEventListener("change", async () => {
        id_city_name.value = id_city.selectedOptions[0]?.dataset.name || "";
        await populateBarangays(id_city.value, id_barangay, id_barangay_name);
    });

    id_barangay.addEventListener("change", () => {
        id_barangay_name.value = id_barangay.selectedOptions[0]?.dataset.name || "";
    });

    // ----------------------------- SAME AS RESIDENTIAL -----------------------------
    const sameCheckbox = document.getElementById("same_address");
    sameCheckbox.addEventListener("change", async () => {
        if (!sameCheckbox.checked) {
            ["id_region","id_province","id_city","id_barangay","id_region_name","id_province_name","id_city_name","id_barangay_name","id_zip","id_street","id_house_number"].forEach(id => {
                const el = document.getElementById(id);
                if(el) el.value = "";
            });
            return;
        }

        // Copy region
        id_region.value = region.value;
        id_region.dispatchEvent(new Event("change"));
        await new Promise(r => setTimeout(r, 50)); // wait for provinces/cities to populate

        // Copy province
        if (region.value !== NCR_CODE) {
            id_province.value = province.value;
            id_province.dispatchEvent(new Event("change"));
            await new Promise(r => setTimeout(r, 50));
        }

        // Copy city
        id_city.value = city.value;
        id_city.dispatchEvent(new Event("change"));
        await new Promise(r => setTimeout(r, 50));

        // Copy barangay
        id_barangay.value = barangay.value;

        // Copy hidden name fields
        id_region_name.value = region_name.value;
        id_province_name.value = province_name.value;
        id_city_name.value = city_name.value;
        id_barangay_name.value = barangay_name.value;

        // Copy other inputs
        document.getElementById("id_zip").value = document.getElementById("zip").value;
        document.getElementById("id_street").value = document.getElementById("street").value;
        document.getElementById("id_house_number").value = document.getElementById("house_number").value;
    });
});
