export function windowLocation() {
  const url = new URL(window.location.href);
  const domainUrl = url.origin;
  return domainUrl;
}

export function validateEmail(email) {
  // Regular expression to verify a valid email address
  const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  return emailRegex.test(email);
}

export const truncateText = (text, maxLength) => {
  if (typeof text !== 'string') {
    console.error('O argumento text deve ser uma string.');
    return '';
  }

  if (text.length > maxLength) {
    return text.substring(0, maxLength) + '...';
  }
  return text;
};

export function funCopy(item) {
  navigator.clipboard.writeText(item);
}

export function getInitials(fullName) {
  if (!fullName) return '';

  const names = fullName.trim().split(' ');

  // Verifica se há pelo menos um nome e um sobrenome
  if (names.length < 2) return '';

  const firstNameInitial = names[0][0].toUpperCase();
  const lastNameInitial = names[names.length - 1][0].toUpperCase();

  return `${firstNameInitial}${lastNameInitial}`;
}

export function formatDateToDayMonthYear(dateString) {
  const date = new Date(dateString);

  const monthNames = [
    'jan',
    'fev',
    'mar',
    'abr',
    'mai',
    'jun',
    'jul',
    'ago',
    'set',
    'out',
    'nov',
    'dez',
  ];

  // Gets day, month and year
  const day = date.getDate().toString().padStart(2, '0');
  const month = monthNames[date.getMonth()];
  const year = date.getFullYear();

  // Returns the date in the desired format
  return `${day} ${month}, ${year}`;
}

// Function to validate CPF
export async function validateCPF(cpf) {
  cpf = cpf.replace(/[^\d]+/g, ''); // Remove non-numeric characters

  if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
    // Check for invalid CPF (all digits are the same)
    return false;
  }

  let sum = 0;
  let remainder;

  // Validate the first digit
  for (let i = 0; i < 9; i++) {
    sum += parseInt(cpf.charAt(i)) * (10 - i); // Multiply each digit by its respective weight
  }
  remainder = sum % 11;
  if (remainder < 2) {
    remainder = 0;
  } else {
    remainder = 11 - remainder;
  }
  if (parseInt(cpf.charAt(9)) !== remainder) {
    // Check if the first verification digit is valid
    return false;
  }

  sum = 0;
  // Validate the second digit
  for (let i = 0; i < 10; i++) {
    sum += parseInt(cpf.charAt(i)) * (11 - i); // Multiply each digit by its respective weight
  }
  remainder = sum % 11;
  if (remainder < 2) {
    remainder = 0;
  } else {
    remainder = 11 - remainder;
  }

  return parseInt(cpf.charAt(10)) === remainder; // Check if the second verification digit is valid
}

export const validatePhone = (phone) => {
  // Remove any non-numeric characters
  phone = phone?.replace(/[^\d]/g, '');

  // Checks if the phone has exactly 11 digits
  return phone?.length === 11;
};

export async function convertToBase64(imagePath) {
  const response = await fetch(imagePath);
  const blob = await response.blob();
  return new Promise((resolve) => {
    const reader = new FileReader();
    reader.onloadend = () => resolve(reader.result);
    reader.readAsDataURL(blob);
  });
}