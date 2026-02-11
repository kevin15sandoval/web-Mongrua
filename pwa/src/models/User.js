/**
 * User Model and Interfaces
 * Defines the structure for user data in the authentication system
 */

/**
 * User Role Enum
 * @enum {string}
 */
export const UserRole = {
  STUDENT: 'student',
  ADMINISTRATOR: 'administrator',
};

/**
 * User Interface
 * @typedef {Object} User
 * @property {string} id - Unique user identifier
 * @property {string} email - User email address
 * @property {string} fullName - User's full name
 * @property {Date|string} dateOfBirth - User's date of birth
 * @property {UserRole} role - User's role in the system
 * @property {Date|string} createdAt - Account creation timestamp
 * @property {boolean} emailVerified - Whether email has been verified
 */

/**
 * Create a User object
 * @param {Object} data - User data
 * @returns {User}
 */
export const createUser = data => ({
  id: data.id,
  email: data.email,
  fullName: data.fullName || data.full_name,
  dateOfBirth: data.dateOfBirth || data.date_of_birth,
  role: data.role || UserRole.STUDENT,
  createdAt: data.createdAt || data.created_at || new Date(),
  emailVerified: data.emailVerified || data.email_verified || false,
});

/**
 * Check if user has a specific role
 * @param {User} user - User object
 * @param {UserRole} role - Role to check
 * @returns {boolean}
 */
export const hasRole = (user, role) => {
  return user?.role === role;
};

/**
 * Check if user is an administrator
 * @param {User} user - User object
 * @returns {boolean}
 */
export const isAdministrator = user => {
  return hasRole(user, UserRole.ADMINISTRATOR);
};

/**
 * Check if user is a student
 * @param {User} user - User object
 * @returns {boolean}
 */
export const isStudent = user => {
  return hasRole(user, UserRole.STUDENT);
};

/**
 * Get user display name
 * @param {User} user - User object
 * @returns {string}
 */
export const getUserDisplayName = user => {
  return user?.fullName || user?.email || 'Usuario';
};

/**
 * Check if user's email is verified
 * @param {User} user - User object
 * @returns {boolean}
 */
export const isEmailVerified = user => {
  return user?.emailVerified === true;
};
