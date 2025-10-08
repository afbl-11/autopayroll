console.log("address-name-submit.js loaded");

document.querySelector("form").addEventListener("submit", (e) => {
    const regionName = regionSelect.options[regionSelect.selectedIndex]?.dataset.name || "";
    const provinceName = provinceSelect.options[provinceSelect.selectedIndex]?.dataset.name || "";
    const cityName = citySelect.options[citySelect.selectedIndex]?.dataset.name || "";
    const barangayName = barangaySelect.options[barangaySelect.selectedIndex]?.dataset.name || "";

    // Create hidden fields dynamically
    const inputs = [
        { name: "region_name", value: regionName },
        { name: "province_name", value: provinceName },
        { name: "city_name", value: cityName },
        { name: "barangay_name", value: barangayName },
    ];

    inputs.forEach(({ name, value }) => {
        let hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = name;
        hidden.value = value;
        e.target.appendChild(hidden);
    });
});
