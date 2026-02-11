/**
 * Validation utilities for authentication and user input
 */

/**
 * Email validation
 * @param {string} email - Email address to validate
 * @returns {boolean} True if email is valid
 */
export const isValidEmail = email => {
  if (!email || typeof email !== 'string') return false;
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email.trim());
};

/**
 * Get email validation error message
 * @param {string} email - Email to validate
 * @returns {string|null} Error message or null if valid
 */
export const validateEmail = email => {
  if (!email) return 'El correo electrónico es requerido';
  if (!isValidEmail(email)) return 'El formato del correo electrónico no es válido';
  return null;
};

/**
 * Password validation (min 8 chars, 1 uppercase, 1 lowercase, 1 number)
 * @param {string} password - Password to validate
 * @returns {boolean} True if password meets requirements
 */
export const isValidPassword = password => {
  if (!password || typeof password !== 'string') return false;
  if (password.length < 8) return false;
  if (!/[A-Z]/.test(password)) return false;
  if (!/[a-z]/.test(password)) return false;
  if (!/[0-9]/.test(password)) return false;
  return true;
};

/**
 * Get password validation error message
 * @param {string} password - Password to validate
 * @returns {string|null} Error message or null if valid
 */
export const validatePassword = password => {
  if (!password) return 'La contraseña es requerida';
  if (password.length < 8) return 'La contraseña debe tener al menos 8 caracteres';
  if (!/[A-Z]/.test(password)) return 'La contraseña debe contener al menos una letra mayúscula';
  if (!/[a-z]/.test(password)) return 'La contraseña debe contener al menos una letra minúscula';
  if (!/[0-9]/.test(password)) return 'La contraseña debe contener al menos un número';
  return null;
};

/**
 * Age validation (minimum 16 years)
 * @param {Date|string} dateOfBirth - Date of birth to validate
 * @returns {boolean} True if age is 16 or older
 */
export const isValidAge = dateOfBirth => {
  if (!dateOfBirth) return false;

  const today = new Date();
  const birthDate = new Date(dateOfBirth);

  // Check if date is valid
  if (isNaN(birthDate.getTime())) return false;

  // Check if date is not in the future
  if (birthDate > today) return false;

  const age = today.getFullYear() - birthDate.getFullYear();
  const monthDiff = today.getMonth() - birthDate.getMonth();

  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
    return age - 1 >= 16;
  }
  return age >= 16;
};

/**
 * Get date of birth validation error message
 * @param {Date|string} dateOfBirth - Date of birth to validate
 * @returns {string|null} Error message or null if valid
 */
export const validateDateOfBirth = dateOfBirth => {
  if (!dateOfBirth) return 'La fecha de nacimiento es requerida';

  const birthDate = new Date(dateOfBirth);
  if (isNaN(birthDate.getTime())) return 'La fecha de nacimiento no es válida';

  const today = new Date();
  if (birthDate > today) return 'La fecha de nacimiento no puede estar en el futuro';

  if (!isValidAge(dateOfBirth)) return 'Debes tener al menos 16 años para registrarte';

  return null;
};

/**
 * Get password strength
 * @param {string} password - Password to evaluate
 * @returns {string} Strength level: 'weak', 'medium', or 'strong'
 */
export const getPasswordStrength = password => {
  if (!password) return 'weak';

  let strength = 0;
  if (password.length >= 8) strength++;
  if (password.length >= 12) strength++;
  if (/[a-z]/.test(password)) strength++;
  if (/[A-Z]/.test(password)) strength++;
  if (/[0-9]/.test(password)) strength++;
  if (/[^a-zA-Z0-9]/.test(password)) strength++;

  if (strength <= 2) return 'weak';
  if (strength <= 4) return 'medium';
  return 'strong';
};

/**
 * Validate full name
 * @param {string} fullName - Full name to validate
 * @returns {string|null} Error message or null if valid
 */
export const validateFullName = fullName => {
  if (!fullName) return 'El nombre completo es requerido';
  if (fullName.trim().length < 2) return 'El nombre debe tener al menos 2 caracteres';
  if (fullName.trim().length > 100) return 'El nombre no puede exceder 100 caracteres';
  return null;
};

/**
 * Validate password confirmation
 * @param {string} password - Original password
 * @param {string} confirmPassword - Confirmation password
 * @returns {string|null} Error message or null if valid
 */
export const validatePasswordConfirmation = (password, confirmPassword) => {
  if (!confirmPassword) return 'Debes confirmar la contraseña';
  if (password !== confirmPassword) return 'Las contraseñas no coinciden';
  return null;
};

/**
 * Validate all registration fields
 * @param {Object} data - Registration data
 * @returns {Object} Object with isValid boolean and errors object
 */
export const validateRegistrationForm = data => {
  const errors = {};

  const emailError = validateEmail(data.email);
  if (emailError) errors.email = emailError;

  const fullNameError = validateFullName(data.fullName);
  if (fullNameError) errors.fullName = fullNameError;

  const dateOfBirthError = validateDateOfBirth(data.dateOfBirth);
  if (dateOfBirthError) errors.dateOfBirth = dateOfBirthError;

  const passwordError = validatePassword(data.password);
  if (passwordError) errors.password = passwordError;

  const confirmPasswordError = validatePasswordConfirmation(data.password, data.confirmPassword);
  if (confirmPasswordError) errors.confirmPassword = confirmPasswordError;

  return {
    isValid: Object.keys(errors).length === 0,
    errors,
  };
};

/**
 * Validate login credentials
 * @param {Object} credentials - Login credentials
 * @returns {Object} Object with isValid boolean and errors object
 */
export const validateLoginForm = credentials => {
  const errors = {};

  const emailError = validateEmail(credentials.email);
  if (emailError) errors.email = emailError;

  if (!credentials.password) {
    errors.password = 'La contraseña es requerida';
  }

  return {
    isValid: Object.keys(errors).length === 0,
    errors,
  };
};
