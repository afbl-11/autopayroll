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

export async function getNCRCities(regionCode) {
    const response = await fetch(`${BASE_URL}/regions/${regionCode}/cities/`);
    if (!response.ok) throw new Error("Failed to fetch NCR cities");
    return response.json();
}


export async function getBarangays(cityCode) {
    const response = await fetch(`${BASE_URL}/cities-municipalities/${cityCode}/barangays/`);
    return response.json();
}
