/**
 * Goong.io Address Helper
 * Provides enhanced address selection functionality using Goong.io API
 */

class GoongAddressManager {
    constructor(options = {}) {
        this.citySelect = options.citySelect || null;
        this.districtSelect = options.districtSelect || null;
        this.wardSelect = options.wardSelect || null;
        this.addressInput = options.addressInput || null;
        
        // Current values for pre-selection
        this.currentCity = options.currentCity || '';
        this.currentDistrict = options.currentDistrict || '';
        this.currentWard = options.currentWard || '';
        
        // Autocomplete settings
        this.enableAutocomplete = options.enableAutocomplete || false;
        this.autocompleteContainer = options.autocompleteContainer || null;
        
        this.init();
    }
    
    async init() {
        await this.loadProvinces();
        this.bindEvents();
        
        if (this.enableAutocomplete && this.addressInput) {
            this.initAutocomplete();
        }
    }
    
    async loadProvinces() {
        try {
            this.showLoading(this.citySelect, 'Đang tải tỉnh/thành phố...');
            
            const response = await fetch('/api/provinces');
            const data = await response.json();
            
            if (data.success && data.data) {
                this.populateSelect(this.citySelect, data.data, 'name', 'name', '-- Chọn Tỉnh/Thành phố --');
                this.citySelect.parentElement.classList.remove('address-loading');
                
                // Pre-select current city if exists
                if (this.currentCity) {
                    this.selectOptionByText(this.citySelect, this.currentCity);
                    const selectedOption = this.citySelect.options[this.citySelect.selectedIndex];
                    if (selectedOption.dataset.code) {
                        await this.loadDistricts(selectedOption.dataset.code);
                    }
                }
            } else {
                this.showError(this.citySelect, 'Không thể tải danh sách tỉnh/thành phố');
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
            this.showError(this.citySelect, 'Lỗi kết nối. Vui lòng thử lại');
        }
    }
    
    async loadDistricts(provinceCode) {
        try {
            this.showLoading(this.districtSelect, 'Đang tải quận/huyện...');
            this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
            this.wardSelect.disabled = true;
            
            const response = await fetch(`/api/districts/${provinceCode}`);
            const data = await response.json();
            
            if (data.success && data.data) {
                this.populateSelect(this.districtSelect, data.data, 'name', 'name', '-- Chọn Quận/Huyện --');
                this.districtSelect.parentElement.classList.remove('address-loading');
                
                // Pre-select current district if exists
                if (this.currentDistrict) {
                    this.selectOptionByText(this.districtSelect, this.currentDistrict);
                    const selectedOption = this.districtSelect.options[this.districtSelect.selectedIndex];
                    if (selectedOption.dataset.code) {
                        await this.loadWards(selectedOption.dataset.code);
                    }
                }
            } else {
                this.showError(this.districtSelect, 'Không thể tải danh sách quận/huyện');
            }
        } catch (error) {
            console.error('Error loading districts:', error);
            this.showError(this.districtSelect, 'Lỗi kết nối. Vui lòng thử lại');
        }
    }
    
    async loadWards(districtCode) {
        try {
            this.showLoading(this.wardSelect, 'Đang tải phường/xã...');
            
            const response = await fetch(`/api/wards/${districtCode}`);
            const data = await response.json();
            
            if (data.success && data.data) {
                this.populateSelect(this.wardSelect, data.data, 'name', 'name', '-- Chọn Phường/Xã --');
                this.wardSelect.parentElement.classList.remove('address-loading');
                
                // Pre-select current ward if exists
                if (this.currentWard) {
                    this.selectOptionByText(this.wardSelect, this.currentWard);
                }
            } else {
                this.showError(this.wardSelect, 'Không thể tải danh sách phường/xã');
            }
        } catch (error) {
            console.error('Error loading wards:', error);
            this.showError(this.wardSelect, 'Lỗi kết nối. Vui lòng thử lại');
        }
    }
    
    initAutocomplete() {
        if (!this.addressInput || !this.autocompleteContainer) return;
        
        let debounceTimer;
        
        this.addressInput.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            const input = e.target.value.trim();
            
            if (input.length < 2) {
                this.hideAutocomplete();
                return;
            }
            
            debounceTimer = setTimeout(async () => {
                await this.searchAddresses(input);
            }, 300);
        });
        
        // Hide autocomplete when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.addressInput.contains(e.target) && 
                !this.autocompleteContainer.contains(e.target)) {
                this.hideAutocomplete();
            }
        });
    }
    
    async searchAddresses(input) {
        try {
            const response = await fetch(`/api/address-autocomplete?input=${encodeURIComponent(input)}`);
            const data = await response.json();
            
            if (data.success && data.data) {
                this.showAutocompleteResults(data.data);
            } else {
                this.hideAutocomplete();
            }
        } catch (error) {
            console.error('Error searching addresses:', error);
            this.hideAutocomplete();
        }
    }
    
    showAutocompleteResults(results) {
        if (!this.autocompleteContainer) return;
        
        this.autocompleteContainer.innerHTML = '';
        
        if (results.length === 0) {
            this.hideAutocomplete();
            return;
        }
        
        results.forEach(result => {
            const item = document.createElement('div');
            item.className = 'autocomplete-item';
            item.innerHTML = `
                <div class="autocomplete-main">${result.formatted_address}</div>
                <div class="autocomplete-secondary">${result.description}</div>
            `;
            
            item.addEventListener('click', () => {
                this.selectAddress(result);
            });
            
            this.autocompleteContainer.appendChild(item);
        });
        
        this.autocompleteContainer.style.display = 'block';
    }
    
    selectAddress(address) {
        if (this.addressInput) {
            this.addressInput.value = address.formatted_address;
        }
        
        // Auto-populate city/district/ward if available
        if (address.compound) {
            if (address.compound.province && this.citySelect) {
                this.selectOptionByText(this.citySelect, address.compound.province);
                this.citySelect.dispatchEvent(new Event('change'));
            }
        }
        
        this.hideAutocomplete();
    }
    
    hideAutocomplete() {
        if (this.autocompleteContainer) {
            this.autocompleteContainer.style.display = 'none';
        }
    }
    
    // Helper methods
    populateSelect(select, items, valueField, textField, placeholder) {
        if (!select) return;
        
        select.innerHTML = `<option value="">${placeholder}</option>`;
        
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item[valueField];
            option.textContent = item[textField];
            option.dataset.code = item.code || '';
            select.appendChild(option);
        });
        
        select.disabled = false;
    }
    
    resetSelect(select, placeholder) {
        if (!select) return;
        
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = true;
    }
    
    showLoading(select, message) {
        if (!select) return;
        
        select.innerHTML = `<option value="" class="loading-option">${message}</option>`;
        select.disabled = true;
        select.parentElement.classList.add('address-loading');
    }
    
    showError(select, message) {
        if (!select) return;
        
        select.innerHTML = `<option value="" class="error-option">${message}</option>`;
        select.disabled = true;
        select.parentElement.classList.remove('address-loading');
    }
    
    selectOptionByText(select, text) {
        if (!select || !text) return;
        
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].text === text) {
                select.selectedIndex = i;
                break;
            }
        }
    }
    
    bindEvents() {
        if (this.citySelect) {
            this.citySelect.addEventListener('change', async (e) => {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const provinceCode = selectedOption.dataset.code;
                
                if (provinceCode) {
                    await this.loadDistricts(provinceCode);
                } else {
                    this.resetSelect(this.districtSelect, '-- Chọn Quận/Huyện --');
                    this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
                }
                
                // Clear current values when changing
                this.currentDistrict = '';
                this.currentWard = '';
            });
        }
        
        if (this.districtSelect) {
            this.districtSelect.addEventListener('change', async (e) => {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const districtCode = selectedOption.dataset.code;
                
                if (districtCode) {
                    await this.loadWards(districtCode);
                } else {
                    this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
                }
                
                // Clear current ward when changing district
                this.currentWard = '';
            });
        }
    }
}

// Export for use in other scripts
if (typeof window !== 'undefined') {
    window.GoongAddressManager = GoongAddressManager;
}