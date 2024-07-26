function updateFormData(form, data) {
  Object.keys(form).forEach(key => {
    if (data[key] !== undefined) {
      form[key] = data[key];
    }
  });
};

function emailToFileName(email) {
  return email.replace(/[^a-zA-Z0-9]/g, '_');
}

function checkAvatarImage(email) {
  const emailName = emailToFileName(email);
  const defaultSrc = '/storage/images/avatars/no_image.jpg';
  const src = `/storage/images/avatars/${emailName}.jpg`;

  return new Promise((resolve) => {
    const img = new Image();
    img.onload = () => resolve(src);         // Image loaded successfully
    img.onerror = () => resolve(defaultSrc); // Error loading image, load default
    img.src = src;
  });
}

function textToSlug(text) {
  return text
    .toString()                 // Cast to string
    .normalize('NFD')           // Normalize the string to NFD Unicode normal form decomposing combined graphemes into the base graphemes and diacritical marks
    .replace(/[\u0300-\u036f]/g, '') // Remove all previously split diacritics
    .toLowerCase()              // Convert the string to lowercase
    .trim()                     // Remove whitespace from both sides of a string
    .replace(/\s+/g, '-')       // Replace spaces with -
    .replace(/[^\w\-]+/g, '')   // Remove all non-word chars
    .replace(/\-\-+/g, '-');    // Replace multiple - with single -
}
function toggleParentId(form) {
  if (form.parent_id === 0) {
    form.parent_id = null;
  } else if (form.parent_id === null) {
    form.parent_id = 0;
  }
}

function toggleBoolean(value) {
  if (typeof value === 'number') {
    return value === 1 ? true : false;
  }
  else if (typeof value === 'boolean') {
    return value ? 1 : 0;
  }
  return value;
}

function getNestedValue(obj, path, defaultValue = '') {
  return path.split('.').reduce((acc, part) => acc && acc[part] !== undefined ? acc[part] : defaultValue, obj);
}
// Export the function
export { emailToFileName, checkAvatarImage, updateFormData, textToSlug, toggleParentId, toggleBoolean, getNestedValue };