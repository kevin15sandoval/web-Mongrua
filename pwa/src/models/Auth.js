/**
 * Authentication Models and Interfaces
 * Defines structures for authentication-related data
 */

/**
 * Authentication Credentials Interface
 * @typedef {Object} AuthCredentials
 * @property {string} email - User email address
 * @property {string} password - User password
 */

/**
 * Create AuthCredentials object
 * @param {string} email - User email
 * @param {string} password - User password
 * @returns {AuthCredentials}
 */
export const createAuthCredentials = (email, password) => ({
  email,
  password,
});

/**
 * Registration Data Interface
 * @typedef {Object} RegistrationData
 * @property {string} email - User email address
 * @property {string} fullName - User's full name
 * @property {Date|string} dateOfBirth - User's date of birth
 * @property {string} password - User password
 * @property {string} confirmPassword - Password confirmation
 */

/**
 * Create RegistrationData object
 * @param {Object} data - Registration form data
 * @returns {RegistrationData}
 */
export const createRegistrationData = data => ({
  email: data.email,
  fullName: data.fullName,
  dateOfBirth: data.dateOfBirth,
  password: data.password,
  confirmPassword: data.confirmPassword,
});

/**
 * Validate registration data
 * @param {RegistrationData} data - Registration data to validate
 * @returns {Object} Validation result with isValid and errors
 */
export const validateRegistrationData = data => {
  const errors = {};

  if (!data.email) {
    errors.email = 'El correo electrónico es requerido';
  }

  if (!data.fullName || data.fullName.trim().length < 2) {
    errors.fullName = 'El nombre completo debe tener al menos 2 caracteres';
  }

  if (!data.dateOfBirth) {
    errors.dateOfBirth = 'La fecha de nacimiento es requerida';
  }

  if (!data.password) {
    errors.password = 'La contraseña es requerida';
  }

  if (data.password !== data.confirmPassword) {
    errors.confirmPassword = 'Las contraseñas no coinciden';
  }

  return {
    isValid: Object.keys(errors).length === 0,
    errors,
  };
};

/**
 * Authentication Token Interface
 * @typedef {Object} AuthToken
 * @property {string} accessToken - JWT access token
 * @property {string} refreshToken - JWT refresh token
 * @property {number} expiresIn - Token expiration time in seconds
 */

/**
 * Create AuthToken object
 * @param {Object} data - Token data from server
 * @returns {AuthToken}
 */
export const createAuthToken = data => ({
  accessToken: data.accessToken || data.access_token || data.token,
  refreshToken: data.refreshToken || data.refresh_token,
  expiresIn: data.expiresIn || data.expires_in || 3600,
});

/**
 * Check if token is expired
 * @param {AuthToken} token - Token object
 * @param {Date} issuedAt - When the token was issued
 * @returns {boolean}
 */
export const isTokenExpired = (token, issuedAt) => {
  if (!token || !issuedAt) return true;

  const now = new Date();
  const issued = new Date(issuedAt);
  const expirationTime = issued.getTime() + token.expiresIn * 1000;

  return now.getTime() >= expirationTime;
};

/**
 * Password Reset Request Interface
 * @typedef {Object} PasswordResetRequest
 * @property {string} email - User email address
 */

/**
 * Create PasswordResetRequest object
 * @param {string} email - User email
 * @returns {PasswordResetRequest}
 */
export const createPasswordResetRequest = email => ({
  email,
});

/**
 * Password Reset Data Interface
 * @typedef {Object} PasswordResetData
 * @property {string} token - Reset token from email
 * @property {string} newPassword - New password
 * @property {string} confirmPassword - Password confirmation
 */

/**
 * Create PasswordResetData object
 * @param {Object} data - Reset form data
 * @returns {PasswordResetData}
 */
export const createPasswordResetData = data => ({
  token: data.token,
  newPassword: data.newPassword,
  confirmPassword: data.confirmPassword,
});

/**
 * Validate password reset data
 * @param {PasswordResetData} data - Reset data to validate
 * @returns {Object} Validation result with isValid and errors
 */
export const validatePasswordResetData = data => {
  const errors = {};

  if (!data.token) {
    errors.token = 'Token de restablecimiento inválido';
  }

  if (!data.newPassword) {
    errors.newPassword = 'La nueva contraseña es requerida';
  }

  if (data.newPassword !== data.confirmPassword) {
    errors.confirmPassword = 'Las contraseñas no coinciden';
  }

  return {
    isValid: Object.keys(errors).length === 0,
    errors,
  };
};
