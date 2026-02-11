import api from './api';
import { createAuthToken } from '../models/Auth';
import { createUser } from '../models/User';
import { storage } from '../utils/storage';

// Token storage keys
const TOKEN_KEY = 'auth-token';
const REFRESH_TOKEN_KEY = 'refresh-token';
const TOKEN_ISSUED_AT_KEY = 'token-issued-at';

/**
 * Authentication Service
 * Handles all authentication-related API calls and token management
 */
export const authService = {
  /**
   * Register new user
   * @param {Object} userData - User registration data
   * @returns {Promise<Object>} Registration response
   */
  register: async userData => {
    const response = await api.post('/auth/register', {
      email: userData.email,
      full_name: userData.fullName,
      date_of_birth: userData.dateOfBirth,
      password: userData.password,
    });
    return response.data;
  },

  /**
   * Login user
   * @param {Object} credentials - Login credentials (email, password)
   * @returns {Promise<Object>} Login response with user and tokens
   */
  login: async credentials => {
    const response = await api.post('/auth/login', credentials);
    const data = response.data;

    // Store tokens
    if (data.token || data.accessToken) {
      const token = createAuthToken(data);
      authService.setTokens(token);
    }

    // Return user data
    return {
      user: data.user ? createUser(data.user) : null,
      token: data.token || data.accessToken,
    };
  },

  /**
   * Logout user
   * Clears all authentication data from storage
   */
  logout: () => {
    storage.remove(TOKEN_KEY);
    storage.remove(REFRESH_TOKEN_KEY);
    storage.remove(TOKEN_ISSUED_AT_KEY);
    localStorage.removeItem(TOKEN_KEY);
  },

  /**
   * Verify email with token
   * @param {string} token - Email verification token
   * @returns {Promise<Object>} Verification response
   */
  verifyEmail: async token => {
    const response = await api.get(`/auth/verify/${token}`);
    return response.data;
  },

  /**
   * Request password reset
   * @param {string} email - User email address
   * @returns {Promise<Object>} Password reset request response
   */
  forgotPassword: async email => {
    const response = await api.post('/auth/forgot-password', { email });
    return response.data;
  },

  /**
   * Reset password with token
   * @param {string} token - Password reset token
   * @param {string} newPassword - New password
   * @returns {Promise<Object>} Password reset response
   */
  resetPassword: async (token, newPassword) => {
    const response = await api.post('/auth/reset-password', {
      token,
      newPassword,
    });
    return response.data;
  },

  /**
   * Resend verification email
   * @param {string} email - User email address
   * @returns {Promise<Object>} Resend verification response
   */
  resendVerification: async email => {
    const response = await api.post('/auth/resend-verification', { email });
    return response.data;
  },

  /**
   * Setup initial admin with activation code
   * @param {string} userId - User ID
   * @param {string} activationCode - Admin activation code
   * @returns {Promise<Object>} Setup admin response
   */
  setupAdmin: async (userId, activationCode) => {
    const response = await api.post('/auth/setup-admin', {
      userId,
      activationCode,
    });
    return response.data;
  },

  /**
   * Get current user profile
   * @returns {Promise<Object>} User profile data
   */
  getCurrentUser: async () => {
    const response = await api.get('/auth/me');
    return createUser(response.data);
  },

  /**
   * Store authentication tokens
   * @param {Object} token - Token object with accessToken, refreshToken, expiresIn
   */
  setTokens: token => {
    if (token.accessToken) {
      storage.set(TOKEN_KEY, token.accessToken);
      localStorage.setItem(TOKEN_KEY, token.accessToken);
    }
    if (token.refreshToken) {
      storage.set(REFRESH_TOKEN_KEY, token.refreshToken);
    }
    storage.set(TOKEN_ISSUED_AT_KEY, new Date().toISOString());
  },

  /**
   * Get stored access token
   * @returns {string|null} Access token or null
   */
  getAccessToken: () => {
    return storage.get(TOKEN_KEY) || localStorage.getItem(TOKEN_KEY);
  },

  /**
   * Get stored refresh token
   * @returns {string|null} Refresh token or null
   */
  getRefreshToken: () => {
    return storage.get(REFRESH_TOKEN_KEY);
  },

  /**
   * Check if user is authenticated
   * @returns {boolean} True if user has valid token
   */
  isAuthenticated: () => {
    return !!authService.getAccessToken();
  },

  /**
   * Refresh access token using refresh token
   * @returns {Promise<Object>} New token data
   */
  refreshAccessToken: async () => {
    const refreshToken = authService.getRefreshToken();
    if (!refreshToken) {
      throw new Error('No refresh token available');
    }

    const response = await api.post('/auth/refresh', { refreshToken });
    const token = createAuthToken(response.data);
    authService.setTokens(token);
    return token;
  },
};

