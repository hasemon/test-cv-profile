document.addEventListener('DOMContentLoaded', () => {
    const profileForm = document.getElementById('profile-form');
    if (!profileForm) return;

    const nameInput = document.getElementById('name');
    const photoInput = document.getElementById('photo');
    const genderRadios = document.querySelectorAll('input[name="gender"]');
    const photoPreview = document.getElementById('photo-preview');

    const MAX_FILE_SIZE_BYTES = 2 * 1024 * 1024; // 2MB

    // Utility function to display/clear errors
    const displayError = (id, message) => {
        const errorElement = document.getElementById(id + '-error');
        if (errorElement) {
            errorElement.textContent = message;
        }
    };
    const clearError = (id) => displayError(id, '');

    // --- Validation Functions ---

    const validateName = () => {
        const value = nameInput.value.trim();
        clearError('name');
        if (value === '') {
            displayError('name', 'Name is required.');
            return false;
        }
        if (value.length < 3) {
            displayError('name', 'Name must be at least 3 characters long.');
            return false;
        }
        if (!/^[a-zA-Z\s'-]+$/.test(value)) {
            displayError('name', 'Name can only contain letters, spaces, hyphens, and apostrophes.');
            return false;
        }
        return true;
    };

    const validateGender = () => {
        const isChecked = Array.from(genderRadios).some(radio => radio.checked);
        clearError('gender');
        if (!isChecked) {
            displayError('gender', 'Gender is required.');
            return false;
        }
        return true;
    };

    const validatePhoto = () => {
        clearError('photo');
        const file = photoInput.files[0];
        if (!file) return true; // Photo is optional

        // File Type Validation
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            displayError('photo', 'Photo must be a JPEG, PNG, or JPG image.');
            photoInput.value = ''; 
            return false;
        }

        // File Size Validation
        if (file.size > MAX_FILE_SIZE_BYTES) {
            displayError('photo', 'Photo size must not exceed 2MB.');
            photoInput.value = ''; 
            return false;
        }

        return true;
    };

    // --- Real-time Interactions ---

    nameInput.addEventListener('input', validateName);
    genderRadios.forEach(radio => radio.addEventListener('change', validateGender));

    // Image Preview and Validation on Change
    photoInput.addEventListener('change', () => {
        if (validatePhoto()) {
            const file = photoInput.files[0];
            if (file) {
                photoPreview.src = URL.createObjectURL(file);
            }
        }
    });

    // --- Form Submission Handler ---

    profileForm.addEventListener('submit', (e) => {
        const isNameValid = validateName();
        const isGenderValid = validateGender();
        const isPhotoValid = validatePhoto();

        if (!isNameValid || !isGenderValid || !isPhotoValid) {
            e.preventDefault();
            alert('Please correct the validation errors before submitting.');
        }
    });
});