// Function to format date from yyyy-mm-dd to dd/mm/yyyy
export function formatDateToDDMMYYYY(dateString) {
    if (!dateString) return '';
    const [year, month, day] = dateString.split('-');
    return `${day}/${month}/${year}`;
  }
  
  // Function to parse date from dd/mm/yyyy to yyyy-mm-dd
  export function parseDateToYYYYMMDD(dateString) {
    if (!dateString) return '';
    const [day, month, year] = dateString.split('/');
    return `${year}-${month}-${day}`;
  }
  