
export function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

export function isNotEmpty(value) {
    if (value === undefined) {
        return false; // Return false if the value is undefined
    }
    if (typeof value === 'number') {
        return true; // All numbers are considered non-empty
    }
    return typeof value === 'string' && value.trim().length > 0;
}

export function isValidDate(value) {
    const date = Date.parse(value);
    return !isNaN(date);
}
export function getErrorMessage(field, type) {
    const messages = {
        required: `${field} is required.`,
        email: `${field} is not a valid email.`,
        date: `${field} is not a valid date.`,
        default: `${field} is not valid.`
    };
    return messages[type] || messages.default;
}
export function validateEmployeeForm(data) {
    const errors = {};

    if (!isNotEmpty(data.email)) {
        errors.email = getErrorMessage('Email', 'required');
    } else if (!isValidEmail(data.email)) {
        errors.email = getErrorMessage('Email', 'email');
    }

    if (!isNotEmpty(data.personal_email)) {
        errors.personal_email = getErrorMessage('Personal Email', 'required');
    } else if (!isValidEmail(data.personal_email)) {
        errors.personal_email = getErrorMessage('Personal Email', 'email');
    }
    if (!isNotEmpty(data.address)) {
        errors.address = getErrorMessage('Home address', 'required');
    }

    if (!isNotEmpty(data.first_name)) {
        errors.first_name = getErrorMessage('First Name', 'required');
    }
    if (!isNotEmpty(data.job_title)) {
        errors.job_title = getErrorMessage('Job Title', 'required');
    }
    if (!isNotEmpty(data.last_name)) {
        errors.last_name = getErrorMessage('Last Name', 'required');
    }
   
    if (!isNotEmpty(data.phone_number)) {
        errors.phone_number = getErrorMessage('Phone Number', 'required');
    }

    if (!isNotEmpty(data.marital_status)) {
        errors.marital_status = getErrorMessage('Marital Status', 'required');
    }
    if (!isNotEmpty(data.country)) {
        errors.country = getErrorMessage('Country', 'required');
    }
    if (!isNotEmpty(data.gender)) {
        errors.gender = getErrorMessage('Gender', 'required');
    }

    if (!isValidDate(data.hire_date)) {
        errors.hire_date = getErrorMessage('Hire Date', 'date');
    }

    if (!isValidDate(data.date_of_birth)) {
        errors.date_of_birth = getErrorMessage('Date of Birth', 'date');
    }

    if (!isNotEmpty(data.core_folder)) {
        errors.core_folder = getErrorMessage('Folder Link', 'required');
    }
    if (!isNotEmpty(data.current_status)) {
        errors.current_status = getErrorMessage('Employee Status', 'required');
    }

    return errors;
}

export function validateEmergencyContactForm(data) {
    const errors = {};

    if (!isNotEmpty(data.full_name)) {
        errors.full_name = getErrorMessage('Full Name', 'required');
    }
    if (!isNotEmpty(data.phone_number)) {
        errors.phone_number = getErrorMessage('Phone Number', 'required');
    }
    if (!isNotEmpty(data.relationship)) {
        errors.relationship = getErrorMessage('Relationship', 'required');
    }
   
    return errors;
}