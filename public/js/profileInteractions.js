document.addEventListener('DOMContentLoaded', () => {
    // --- Utility Functions ---
    const displayError = (id, message) => {
        const errorElement = document.getElementById(id + '-error');
        if (errorElement) {
            errorElement.textContent = message;
        }
    };
    const clearError = (id) => displayError(id, '');
    const MAX_COMMENT_IMAGE_SIZE_BYTES = 2 * 1024 * 1024; // 2MB

    // --- 1. Education Form Validation ---
    const educationForm = document.getElementById('education-form');
    if (educationForm) {
        const degreeInput = document.getElementById('degree');
        const instituteInput = document.getElementById('institute');
        const startDateInput = document.getElementById('start_date');
        const endYearInput = document.getElementById('end_year');

        const validateRequired = (input, id, label) => {
            clearError(id);
            if (input.value.trim() === '') {
                displayError(id, `${label} is required.`);
                return false;
            }
            return true;
        };

        const validateStartDate = () => {
            if (!validateRequired(startDateInput, 'start_date', 'Start Date')) return false;
            // dd/mm/yy format regex
            const dateRegex = /^\d{1,2}\/\d{1,2}\/\d{2}$/; 
            const value = startDateInput.value.trim();
            if (!dateRegex.test(value)) {
                displayError('start_date', 'Format must be DD/MM/YY (e.g., 01/05/23).');
                return false;
            }
            return true;
        };

        const validateEndYear = () => {
            if (!validateRequired(endYearInput, 'end_year', 'End Year')) return false;
            // Year format regex (exactly 4 digits)
            const yearRegex = /^\d{4}$/; 
            const value = endYearInput.value.trim();

            if (!yearRegex.test(value)) {
                displayError('end_year', 'Format must be YYYY (e.g., 2024).');
                return false;
            }
            
            const currentYear = new Date().getFullYear();
            if (parseInt(value) > currentYear) {
                 displayError('end_year', 'End year cannot be in the future.');
                 return false;
            }

            return true;
        };

        // Real-time event listeners
        degreeInput.addEventListener('input', () => validateRequired(degreeInput, 'degree', 'Degree'));
        instituteInput.addEventListener('input', () => validateRequired(instituteInput, 'institute', 'Institute'));
        startDateInput.addEventListener('input', validateStartDate);
        endYearInput.addEventListener('input', validateEndYear);

        // Form submission handler
        educationForm.addEventListener('submit', (e) => {
            const isDegreeValid = validateRequired(degreeInput, 'degree', 'Degree');
            const isInstituteValid = validateRequired(instituteInput, 'institute', 'Institute');
            const isStartDateValid = validateStartDate();
            const isEndYearValid = validateEndYear();

            if (!isDegreeValid || !isInstituteValid || !isStartDateValid || !isEndYearValid) {
                e.preventDefault();
                alert('Please correct all errors in the educational details form.');
            }
        });
    }

    // --- 2. Comment Form Validation ---
    const commentForm = document.getElementById('comment-form');
    if (commentForm) {
        const contentInput = document.getElementById('content');
        const imageInput = document.getElementById('comment_image');
        const imagePreview = document.getElementById('comment_image-preview');

        const validateCommentContent = () => {
            clearError('content');
            clearError('comment_image');
            
            const content = contentInput.value.trim();
            const hasImage = imageInput.files.length > 0;
            
            if (content === '' && !hasImage) {
                displayError('content', 'Comment text or an image is required.');
                return false;
            }
            
            if (content.length > 500) {
                 displayError('content', 'Comment text cannot exceed 500 characters.');
                 return false;
            }
            return true;
        };

        const validateCommentImage = () => {
            clearError('comment_image');
            const file = imageInput.files[0];
            if (!file) return true; // Optional if content is present

            // File Type Validation
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                displayError('comment_image', 'Image must be a JPEG, PNG, or JPG.');
                imageInput.value = ''; 
                imagePreview.classList.add('d-none');
                return false;
            }

            // File Size Validation
            if (file.size > MAX_COMMENT_IMAGE_SIZE_BYTES) {
                displayError('comment_image', 'Image size must not exceed 2MB.');
                imageInput.value = '';
                imagePreview.classList.add('d-none');
                return false;
            }
            
            return true;
        };
        
        // Real-time listeners
        contentInput.addEventListener('input', validateCommentContent);

        imageInput.addEventListener('change', () => {
            if (validateCommentImage()) {
                validateCommentContent();
                const file = imageInput.files[0];
                if (file) {
                    imagePreview.src = URL.createObjectURL(file);
                    imagePreview.classList.remove('d-none');
                } else {
                    imagePreview.classList.add('d-none');
                }
            }
        });

        // Form submission handler
        commentForm.addEventListener('submit', (e) => {
            const isContentValid = validateCommentContent();
            const isImageValid = validateCommentImage();

            if (!isContentValid || !isImageValid) {
                e.preventDefault();
                alert('Please check the comment content and image before posting.');
            }
        });
    }
});