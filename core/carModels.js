const carModels = {
    Honda: {
        'Civic LX': { year: 2022, price: 22000 },
        'Civic Sport': { year: 2021, price: 20500 },
        'Civic EX': { year: 2020, price: 19000 },
        'Civic Touring': { year: 2019, price: 17500 },
        'Civic Si': { year: 2018, price: 16000 }
    },
    Toyota: {
        'Corolla LE': { year: 2022, price: 20000 },
        'Camry SE': { year: 2021, price: 25000 },
        'RAV4 XLE': { year: 2020, price: 28000 },
        'Highlander': { year: 2019, price: 32000 },
        'Tacoma TRD': { year: 2018, price: 33000 }
    },
    Tesla: {
        'Model S': { year: 2021, price: 95000 },
        'Model 3': { year: 2020, price: 45000 },
        'Model X': { year: 2022, price: 100000 },
        'Model Y': { year: 2022, price: 52000 },
        'Roadster': { year: 2023, price: 200000 }
    },
    Ferrari: {
        '488 GTB': { year: 2020, price: 250000 },
        'F8 Tributo': { year: 2022, price: 280000 },
        'Roma': { year: 2021, price: 220000 },
        'SF90 Stradale': { year: 2023, price: 500000 },
        'Portofino M': { year: 2022, price: 230000 }
    },
    Ford: {
        'F-150': { year: 2021, price: 30000 },
        'Explorer': { year: 2022, price: 35000 },
        'Escape': { year: 2020, price: 28000 },
        'Mustang Mach-E': { year: 2022, price: 43000 },
        'Bronco': { year: 2021, price: 40000 }
    }
};

function updateModelDetails() {
    const modelSelect = document.getElementById('model_name');
    const selectedModel = modelSelect.value;
    const yearInput = document.getElementById('year');
    const priceInput = document.getElementById('price');

    const companySelect = document.getElementById('company_name');
    const selectedCompany = companySelect.options[companySelect.selectedIndex].text; // Get the company name

    if (carModels[selectedCompany] && carModels[selectedCompany][selectedModel]) {
        yearInput.value = carModels[selectedCompany][selectedModel].year;
        priceInput.value = carModels[selectedCompany][selectedModel].price;
    } else {
        yearInput.value = '';
        priceInput.value = '';
    }
}

function populateModels() {
    const companySelect = document.getElementById('company_name');
    const modelSelect = document.getElementById('model_name');
    modelSelect.innerHTML = ''; // Clear existing options

    // Add the default "Select a Model" option
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Select a Model';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    modelSelect.appendChild(defaultOption);

    const selectedCompany = companySelect.options[companySelect.selectedIndex].text;
    if (carModels[selectedCompany]) {
        for (const model in carModels[selectedCompany]) {
            const option = document.createElement('option');
            option.value = model;
            option.textContent = model;
            modelSelect.appendChild(option);
        }
    }
}

// Run on DOM load to reset fields and attach events
document.addEventListener('DOMContentLoaded', function() {
    const yearInput = document.getElementById('year');
    const priceInput = document.getElementById('price');
    
    // Clear year and price initially
    yearInput.value = '';
    priceInput.value = '';

    populateModels();
    
    const companySelect = document.getElementById('company_name');
    const modelSelect = document.getElementById('model_name');

    companySelect.addEventListener('change', populateModels);
    modelSelect.addEventListener('change', updateModelDetails);
});
    