
        // Dữ liệu tỉnh thành mẫu
        const provinces = [
            { id: 1, name: "Hồ Chí Minh" },
            { id: 2, name: "Hà Nội" },
            { id: 3, name: "Đà Nẵng" },
            { id: 4, name: "Cần Thơ" },
            { id: 5, name: "Bình Dương" }
        ];

        const districts = {
            1: [
                { id: 1, name: "Quận 1" },
                { id: 2, name: "Quận 3" },
                { id: 3, name: "Quận Bình Tân" },
                { id: 4, name: "Quận Tân Phú" }
            ],
            2: [
                { id: 5, name: "Quận Ba Đình" },
                { id: 6, name: "Quận Hoàn Kiếm" },
                { id: 7, name: "Quận Đống Đa" }
            ]
        };

        let selectedAddressId = 1;
        let savedAddresses = [
            {
                id: 1,
                name: "Trần Đăng",
                phone: "0915378844",
                address: "4449, Nguyễn Cửu Phú, Phường Tân Tạo A, Quận Bình Tân, Hồ Chí Minh",
                type: "home",
                isDefault: true
            }
        ];

        function openAddressModal() {
            document.getElementById('addressModal').classList.add('show');
            renderAddressList();
        }

        function closeAddressModal() {
            document.getElementById('addressModal').classList.remove('show');
        }

        function openAddAddressModal() {
            closeAddressModal();
            document.getElementById('addAddressModal').classList.add('show');
            resetAddAddressForm();
        }

        function closeAddAddressModal() {
            document.getElementById('addAddressModal').classList.remove('show');
        }

        function resetAddAddressForm() {
            document.getElementById('addAddressForm').reset();
            
            // Reset địa chỉ type buttons
            document.querySelectorAll('.toggle-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.type === 'home') {
                    btn.classList.add('active');
                }
            });

            // Disable location fields
            toggleLocationFields();
            
            // Load provinces
            loadProvinces();
        }

        function toggleLocationFields() {
            const phone = document.getElementById('phoneNumber').value.trim();
            const name = document.getElementById('fullName').value.trim();
            const hasPhoneAndName = phone && name;
            const provinceSelect = document.getElementById('province');
            const provinceHint = document.getElementById('provinceHint');
            provinceSelect.disabled = !hasPhoneAndName;
            if (hasPhoneAndName) {
                provinceHint.textContent = "Vui lòng chọn tỉnh/thành phố";
            } else {
                provinceHint.textContent = "Vui lòng nhập số điện thoại và họ tên trước";
            }
        }

        function loadProvinces() {
            const provinceSelect = document.getElementById('province');
            provinceSelect.innerHTML = '<option value="">Chọn Tỉnh/Thành phố</option>';
            
            provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province.id;
                option.textContent = province.name;
                provinceSelect.appendChild(option);
            });
        }

        function loadDistricts() {
            const provinceId = parseInt(document.getElementById('province').value);
            const districtSelect = document.getElementById('district');
            const streetInput = document.getElementById('streetAddress');
            const districtHint = document.getElementById('districtHint');
            districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
            districtSelect.disabled = !provinceId;
            streetInput.disabled = true;
            if (provinceId && districts[provinceId]) {
                districts[provinceId].forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = district.name;
                    districtSelect.appendChild(option);
                });
                districtSelect.disabled = false;
                districtHint.textContent = "Vui lòng chọn quận/huyện";
            } else {
                districtHint.textContent = "Vui lòng chọn Tỉnh/TP trước";
            }
        }

        function loadWards() {
            const districtId = document.getElementById('district').value;
            const streetInput = document.getElementById('streetAddress');
            const streetHint = document.getElementById('streetHint');
            if (districtId) {
                streetInput.disabled = false;
                streetHint.textContent = "Nhập số nhà và tên đường";
            } else {
                streetInput.disabled = true;
                streetHint.textContent = "Vui lòng chọn Quận/Huyện trước";
            }
        }

        function validatePhone() {
            const phoneInput = document.getElementById('phoneNumber');
            const phoneError = document.getElementById('phoneError');
            const value = phoneInput.value.trim();
            const phonePattern = /^0\d{9}$/;
            if (value && !phonePattern.test(value)) {
                phoneError.textContent = 'Số điện thoại không hợp lệ.';
                phoneError.style.display = 'block';
            } else {
                phoneError.textContent = '';
                phoneError.style.display = 'none';
            }
            // Chỉ cho phép nhập số
            phoneInput.value = value.replace(/[^0-9]/g, '').slice(0, 10);
        }

        function validateName() {
            const nameInput = document.getElementById('fullName');
            const nameError = document.getElementById('nameError');
            const value = nameInput.value;
            if (/\d/.test(value)) {
                nameError.textContent = 'Họ và tên không hợp lệ.';
                nameError.style.display = 'block';
            } else {
                nameError.textContent = '';
                nameError.style.display = 'none';
            }
        }

        function submitNewAddress() {
            const phone = document.getElementById('phoneNumber').value.trim();
            const name = document.getElementById('fullName').value.trim();
            const provinceId = document.getElementById('province').value;
            const districtId = document.getElementById('district').value;
            const street = document.getElementById('streetAddress').value.trim();
            const phonePattern = /^0\d{9}$/;
            if (!phone || !name || !provinceId || !districtId || !street) {
                alert('Vui lòng điền đầy đủ thông tin!');
                return;
            }
            if (!phonePattern.test(phone)) {
                alert('Số điện thoại phải bắt đầu bằng số 0 và đủ 10 số!');
                return;
            }
            if (/\d/.test(name)) {
                alert('Họ và tên không được chứa số!');
                return;
            }
            closeAddAddressModal();
            document.getElementById('confirmModal').classList.add('show');
        }

        function confirmAddAddress() {
            // Lấy thông tin từ form
            const phone = document.getElementById('phoneNumber').value.trim();
            const name = document.getElementById('fullName').value.trim();
            const provinceId = parseInt(document.getElementById('province').value);
            const districtId = parseInt(document.getElementById('district').value);
            const street = document.getElementById('streetAddress').value.trim();
            const isDefault = document.getElementById('setDefault').checked;
            const addressType = document.querySelector('.toggle-btn.active').dataset.type;
            
            // Tạo địa chỉ đầy đủ
            const provinceName = provinces.find(p => p.id === provinceId)?.name || '';
            const districtName = districts[provinceId]?.find(d => d.id === districtId)?.name || '';
            const fullAddress = `${street}, ${districtName}, ${provinceName}`;
            
            // Thêm địa chỉ mới
            const newAddress = {
                id: Date.now(),
                name: name,
                phone: phone,
                address: fullAddress,
                type: addressType,
                isDefault: isDefault
            };
            
            // Nếu đặt làm mặc định, bỏ mặc định của các địa chỉ khác
            if (isDefault) {
                savedAddresses.forEach(addr => addr.isDefault = false);
            }
            
            savedAddresses.push(newAddress);
            selectedAddressId = newAddress.id;
            
            // Đóng modal xác nhận và mở lại modal chọn địa chỉ
            document.getElementById('confirmModal').classList.remove('show');
            openAddressModal();
        }

        function renderAddressList() {
            const addressList = document.getElementById('addressList');
            addressList.innerHTML = '';
            
            savedAddresses.forEach(address => {
                const addressItem = document.createElement('div');
                addressItem.className = `address-item ${address.id === selectedAddressId ? 'selected' : ''}`;
                addressItem.dataset.id = address.id;
                addressItem.onclick = () => selectAddressItem(address.id);
                
                const tags = [];
                if (address.type === 'home') tags.push('<span class="address-tag tag-home">Nhà riêng</span>');
                if (address.type === 'office') tags.push('<span class="address-tag tag-home">Công ty</span>');
                if (address.isDefault) tags.push('<span class="address-tag tag-default">Địa chỉ mặc định</span>');
                
                addressItem.innerHTML = `
                    <h4>${address.name} - ${address.phone}</h4>
                    <p>${address.address}</p>
                    <div class="address-tags">${tags.join('')}</div>
                `;
                
                addressList.appendChild(addressItem);
            });
        }

        function selectAddressItem(addressId) {
            selectedAddressId = addressId;
            document.querySelectorAll('.address-item').forEach(item => {
                item.classList.remove('selected');
            });
            document.querySelector(`[data-id="${addressId}"]`).classList.add('selected');
        }

        function selectAddress() {
            const selectedAddress = savedAddresses.find(addr => addr.id === selectedAddressId);
            if (selectedAddress) {
                updateCurrentAddress(selectedAddress);
                closeAddressModal();
            }
        }

        function updateCurrentAddress(address) {
            const currentAddressDiv = document.getElementById('currentAddress');
            const tags = [];
            if (address.type === 'home') tags.push('<span class="address-tag tag-home">Nhà riêng</span>');
            if (address.type === 'office') tags.push('<span class="address-tag tag-home">Công ty</span>');
            if (address.isDefault) tags.push('<span class="address-tag tag-default">Địa chỉ mặc định</span>');
            
            currentAddressDiv.innerHTML = `
                <div class="address-info">
                    <h4>${address.name} - ${address.phone}</h4>
                    <p>${address.address}</p>
                    <div class="address-tags">${tags.join('')}</div>
                </div>
                <div class="address-actions">
                    <button class="btn btn-link" onclick="openAddressModal()">Thay đổi</button>
                </div>
            `;
        }

        // Event listeners cho address type toggle
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Đóng modal khi click outside
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.remove('show');
                    }
                });
            });

            // Load provinces khi mở modal
            loadProvinces();
        });

        // Đóng modal bằng phím ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal.show').forEach(modal => {
                    modal.classList.remove('show');
                });
            }
        });

        // Invoice functionality variables
let invoiceInfo = null;

function openInvoiceModal() {
    const modal = document.getElementById('invoiceModal');
    const modalContent = document.getElementById('invoiceModalContent');
    
    modal.classList.add('show');
    
    // Check if mobile
    if (window.innerWidth <= 768) {
        modalContent.style.position = 'fixed';
        modalContent.style.top = '0';
        modalContent.style.left = '0';
        modalContent.style.right = '0';
        modalContent.style.bottom = '0';
        modalContent.style.width = '100%';
        modalContent.style.height = '100%';
        modalContent.style.maxWidth = 'none';
        modalContent.style.maxHeight = 'none';
        modalContent.style.borderRadius = '0';
        modalContent.style.overflow = 'auto';
        modalContent.style.transform = 'none';
        modalContent.style.margin = '0';
    } else {
        // Desktop styles
        modalContent.style.position = 'relative';
        modalContent.style.top = '30px';
        modalContent.style.left = 'auto';
        modalContent.style.right = 'auto';
        modalContent.style.bottom = 'auto';
        modalContent.style.width = 'auto';
        modalContent.style.height = 'auto';
        modalContent.style.maxWidth = '600px';
        modalContent.style.maxHeight = '85%';
        modalContent.style.borderRadius = '8px';
        modalContent.style.overflow = 'auto';
        modalContent.style.transform = 'none';
        modalContent.style.margin = 'auto';
    }
    
    // Load existing data if available
    if (invoiceInfo) {
        loadInvoiceData();
    }
}

function closeInvoiceModal() {
    document.getElementById('invoiceModal').classList.remove('show');
}

function toggleInvoiceType() {
    const companyRadio = document.querySelector('input[name="invoiceType"][value="company"]');
    const companyFields = document.getElementById('companyFields');
    const individualFields = document.getElementById('individualFields');
    
    if (companyRadio.checked) {
        companyFields.style.display = 'block';
        individualFields.style.display = 'none';
    } else {
        companyFields.style.display = 'none';
        individualFields.style.display = 'block';
    }
}

function toggleDeliveryAddress() {
    const useDeliveryAddress = document.getElementById('useDeliveryAddress').checked;
    const addressField = document.getElementById('individualAddress');
    
    if (useDeliveryAddress) {
        // Get current delivery address (from existing address section)
        const currentAddress = document.querySelector('#currentAddress .address-info p');
        if (currentAddress) {
            addressField.value = currentAddress.textContent.trim();
        }
        addressField.disabled = true;
        addressField.style.background = '#e9ecef';
    } else {
        addressField.disabled = false;
        addressField.style.background = '#f8f9fa';
    }
}

function saveInvoiceInfo() {
    const invoiceType = document.querySelector('input[name="invoiceType"]:checked').value;
    
    if (invoiceType === 'company') {
        const taxCode = document.getElementById('taxCode').value.trim();
        const companyName = document.getElementById('companyName').value.trim();
        const companyAddress = document.getElementById('companyAddress').value.trim();
        const companyEmail = document.getElementById('companyEmail').value.trim();
        
        if (!companyName || !companyAddress || !companyEmail) {
            alert('Vui lòng điền đầy đủ thông tin công ty!');
            return;
        }
        
        invoiceInfo = {
            type: 'company',
            taxCode: taxCode,
            companyName: companyName,
            address: companyAddress,
            email: companyEmail
        };
    } else {
        const taxCode = document.getElementById('individualTaxCode').value.trim();
        const name = document.getElementById('individualName').value.trim();
        const idNumber = document.getElementById('individualId').value.trim();
        const phone = document.getElementById('individualPhone').value.trim();
        const address = document.getElementById('individualAddress').value.trim();
        const email = document.getElementById('individualEmail').value.trim();
        
        if (!name || !address || !email) {
            alert('Vui lòng điền đầy đủ thông tin cá nhân!');
            return;
        }
        
        invoiceInfo = {
            type: 'individual',
            taxCode: taxCode,
            name: name,
            idNumber: idNumber,
            phone: phone,
            address: address,
            email: email
        };
    }
    
    displayInvoiceInfo();
    closeInvoiceModal();
}

function displayInvoiceInfo() {
    const display = document.getElementById('invoiceDisplay');
    const content = document.getElementById('invoiceContent');
    
    if (!invoiceInfo) {
        display.style.display = 'none';
        return;
    }
    
    let html = '';
    
    if (invoiceInfo.type === 'company') {
        html = `
            <div style="font-weight: 500; margin-bottom: 8px;">Thông tin xuất hóa đơn - Công ty</div>
            ${invoiceInfo.taxCode ? `<div style="margin-bottom: 4px;"><strong>Mã số thuế:</strong> ${invoiceInfo.taxCode}</div>` : ''}
            <div style="margin-bottom: 4px;"><strong>Tên công ty:</strong> ${invoiceInfo.companyName}</div>
            <div style="margin-bottom: 4px;"><strong>Địa chỉ:</strong> ${invoiceInfo.address}</div>
            <div style="margin-bottom: 4px;"><strong>Email:</strong> ${invoiceInfo.email}</div>
        `;
    } else {
        html = `
            <div style="font-weight: 500; margin-bottom: 8px;">Thông tin xuất hóa đơn - Cá nhân</div>
            ${invoiceInfo.taxCode ? `<div style="margin-bottom: 4px;"><strong>Mã số thuế:</strong> ${invoiceInfo.taxCode}</div>` : ''}
            <div style="margin-bottom: 4px;"><strong>Họ và tên:</strong> ${invoiceInfo.name}</div>
            ${invoiceInfo.idNumber ? `<div style="margin-bottom: 4px;"><strong>Số CCCD:</strong> ${invoiceInfo.idNumber}</div>` : ''}
            ${invoiceInfo.phone ? `<div style="margin-bottom: 4px;"><strong>Số điện thoại:</strong> ${invoiceInfo.phone}</div>` : ''}
            <div style="margin-bottom: 4px;"><strong>Địa chỉ:</strong> ${invoiceInfo.address}</div>
            <div style="margin-bottom: 4px;"><strong>Email:</strong> ${invoiceInfo.email}</div>
        `;
    }
    
    content.innerHTML = html;
    display.style.display = 'block';
    
    // Update button text
    const button = document.querySelector('.section-title button[onclick="openInvoiceModal()"]');
    if (button) {
        button.textContent = 'Thay đổi';
        button.style.color = '#28a745';
    }
}

function loadInvoiceData() {
    if (!invoiceInfo) return;
    
    // Set invoice type
    const typeRadio = document.querySelector(`input[name="invoiceType"][value="${invoiceInfo.type}"]`);
    if (typeRadio) {
        typeRadio.checked = true;
        toggleInvoiceType();
    }
    
    if (invoiceInfo.type === 'company') {
        document.getElementById('taxCode').value = invoiceInfo.taxCode || '';
        document.getElementById('companyName').value = invoiceInfo.companyName || '';
        document.getElementById('companyAddress').value = invoiceInfo.address || '';
        document.getElementById('companyEmail').value = invoiceInfo.email || '';
    } else {
        document.getElementById('individualTaxCode').value = invoiceInfo.taxCode || '';
        document.getElementById('individualName').value = invoiceInfo.name || '';
        document.getElementById('individualId').value = invoiceInfo.idNumber || '';
        document.getElementById('individualPhone').value = invoiceInfo.phone || '';
        document.getElementById('individualAddress').value = invoiceInfo.address || '';
        document.getElementById('individualEmail').value = invoiceInfo.email || '';
    }
}

// Handle window resize for responsive modal
window.addEventListener('resize', function() {
    const modal = document.getElementById('invoiceModal');
    if (modal.classList.contains('show')) {
        // Re-apply modal styles based on screen size
        openInvoiceModal();
    }
});

// Close modal when clicking outside (add this to existing modal event listeners)
document.getElementById('invoiceModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInvoiceModal();
    }
});
    