/**
 * Models Index
 * Central export point for all model definitions
 */

// User models
export {
  UserRole,
  createUser,
  hasRole,
  isAdministrator,
  isStudent,
  getUserDisplayName,
  isEmailVerified,
} from './User';

// Auth models
export {
  createAuthCredentials,
  createRegistrationData,
  validateRegistrationData,
  createAuthToken,
  isTokenExpired,
  createPasswordResetRequest,
  createPasswordResetData,
  validatePasswordResetData,
} from './Auth';
