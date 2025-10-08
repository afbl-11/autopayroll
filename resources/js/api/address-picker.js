import {getRegions, getCities,getProvinces,getBarangays} from "./psgc.js";

document.addEventListener("DOMContentLoaded", async () => {
    const regionSelect = document.getElementById("region");
    const citySelect = document.getElementById("city");
    const provinceSelect = document.getElementById("province");
    const barangaySelect = document.getElementById("barangay");

//     load regions
    const  regions = await getRegions();
    regions.forEach(region => {
       const option = document.createElement("option");
       option.value = region.code;
       option.textContent = region.name;
        option.setAttribute("data-name", region.name);
       regionSelect.appendChild(option);
    });

//on region change province
    regionSelect.addEventListener("change", async () => {
        provinceSelect.innerHTML = "<option value=''>Select Province</option>";
        citySelect.innerHTML = "<option value=''>Select City / Municipality</option> ";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option> ";

        if(!regionSelect.value) return;

        // load province
        const provinces = await getProvinces(regionSelect.value);
        provinces.forEach(province => {
            const option = document.createElement("option");
            option.value = province.code;
            option.textContent = province.name;
            option.setAttribute("data-name", province.name);
            provinceSelect.appendChild(option);
        });
    });
    regionSelect.addEventListener("change", async () => {
        console.log("Selected region code:", regionSelect.value);
        const provinces = await getProvinces(regionSelect.value);
        console.log("Loaded provinces:", provinces);
    });

//     on province change city
    provinceSelect.addEventListener("change", async () => {
        citySelect.innerHTML = "<option value=''>Select City / Municipality</option> ";
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option> ";

        if (!provinceSelect.value) return;

    //     load city
        const cities = await getCities(provinceSelect.value);
        cities.forEach(city => {
            const option = document.createElement("option");
            option.value = city.code;
            option.textContent = city.name;
            option.setAttribute("data-name", city.name);
            citySelect.appendChild(option);
        });
    });

//     on city change barangay
    citySelect.addEventListener("change", async () => {
        barangaySelect.innerHTML = "<option value=''>Select Barangay</option> ";

        if(!citySelect.value) return;

    //     load barangay
        const barangays = await getBarangays(citySelect.value);
        barangays.forEach(barangay => {
            const option = document.createElement("option");
            option.value = barangay.code;
            option.textContent = barangay.name;
            option.setAttribute("data-name", barangay.name);
            barangaySelect.appendChild(option);
        });
    });
});

//TODO: change stored value from code to name
//example: region code: 000022002 to eastern samar
