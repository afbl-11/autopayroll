const BASE_URL = "https://psgc.gitlab.io/api";

export async function getRegions() {
    const response = await fetch(`${BASE_URL}/regions/`);
    return response.json();
}

export async function getProvinces(regionCode) {
    const response = await fetch(`${BASE_URL}/regions/${regionCode}/provinces/`);
    return response.json();
}

export async function getCities(provinceCode) {
    const response = await fetch(`${BASE_URL}/provinces/${provinceCode}/cities-municipalities/`);
    return response.json();
}

export async function getBarangays(cityCode) {
    const response = await fetch(`${BASE_URL}/cities-municipalities/${cityCode}/barangays/`);
    return response.json();
}
