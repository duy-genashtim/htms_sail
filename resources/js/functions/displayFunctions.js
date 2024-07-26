export function showStatusActiveInactive(status, textOnly = false) {
    if (textOnly) {
        return status === 1 ? 'Active' : 'Inactive';
    }
    return status === 1
        ? `<span class="right badge badge-success">Active</span>`
        : '<span class="right badge badge-danger">Inactive</span>';
}

export function getFullName(employee) {
    let fullName = `${employee.first_name || ''} ${employee.middle_name ? employee.middle_name + ' ' : ''}${employee.last_name || ''}${employee.extension_name ? ' ' + employee.extension_name : ''}`;
    return fullName.trim();
}

export function getDepartmentLeadInfo(lead) {
    if (lead) {
      return `${lead.first_name} ${lead.last_name}`;
    //   return `${lead.first_name} ${lead.last_name} (${lead.email})`;
    }
    return '';
  }