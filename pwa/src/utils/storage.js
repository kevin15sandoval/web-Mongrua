/**
 * LocalStorage utilities with error handling
 * Provides safe access to browser localStorage with JSON serialization
 */

export const storage = {
  /**
   * Get item from localStorage
   * @param {string} key - Storage key
   * @param {*} defaultValue - Default value if key doesn't exist
   * @returns {*} Stored value or default value
   */
  get: (key, defaultValue = null) => {
    try {
      const item = localStorage.getItem(key);
      return item ? JSON.parse(item) : defaultValue;
    } catch (error) {
      console.error(`Error reading from localStorage: ${key}`, error);
      return defaultValue;
    }
  },

  /**
   * Set item in localStorage
   * @param {string} key - Storage key
   * @param {*} value - Value to store (will be JSON stringified)
   * @returns {boolean} True if successful
   */
  set: (key, value) => {
    try {
      localStorage.setItem(key, JSON.stringify(value));
      return true;
    } catch (error) {
      console.error(`Error writing to localStorage: ${key}`, error);
      return false;
    }
  },

  /**
   * Remove item from localStorage
   * @param {string} key - Storage key
   * @returns {boolean} True if successful
   */
  remove: key => {
    try {
      localStorage.removeItem(key);
      return true;
    } catch (error) {
      console.error(`Error removing from localStorage: ${key}`, error);
      return false;
    }
  },

  /**
   * Clear all localStorage
   * @returns {boolean} True if successful
   */
  clear: () => {
    try {
      localStorage.clear();
      return true;
    } catch (error) {
      console.error('Error clearing localStorage', error);
      return false;
    }
  },

  /**
   * Check if key exists in localStorage
   * @param {string} key - Storage key
   * @returns {boolean} True if key exists
   */
  has: key => {
    try {
      return localStorage.getItem(key) !== null;
    } catch (error) {
      console.error(`Error checking localStorage: ${key}`, error);
      return false;
    }
  },

  /**
   * Get all keys from localStorage
   * @returns {string[]} Array of all keys
   */
  keys: () => {
    try {
      return Object.keys(localStorage);
    } catch (error) {
      console.error('Error getting localStorage keys', error);
      return [];
    }
  },

  /**
   * Get storage size in bytes (approximate)
   * @returns {number} Approximate size in bytes
   */
  getSize: () => {
    try {
      let size = 0;
      for (let key in localStorage) {
        if (localStorage.hasOwnProperty(key)) {
          size += localStorage[key].length + key.length;
        }
      }
      return size;
    } catch (error) {
      console.error('Error calculating localStorage size', error);
      return 0;
    }
  },
};

/**
 * Token-specific storage utilities
 */
export const tokenStorage = {
  /**
   * Store authentication token
   * @param {string} token - JWT token
   */
  setToken: token => {
    storage.set('auth-token', token);
  },

  /**
   * Get authentication token
   * @returns {string|null} Token or null
   */
  getToken: () => {
    return storage.get('auth-token');
  },

  /**
   * Remove authentication token
   */
  removeToken: () => {
    storage.remove('auth-token');
  },

  /**
   * Store refresh token
   * @param {string} token - Refresh token
   */
  setRefreshToken: token => {
    storage.set('refresh-token', token);
  },

  /**
   * Get refresh token
   * @returns {string|null} Refresh token or null
   */
  getRefreshToken: () => {
    return storage.get('refresh-token');
  },

  /**
   * Remove refresh token
   */
  removeRefreshToken: () => {
    storage.remove('refresh-token');
  },

  /**
   * Clear all tokens
   */
  clearTokens: () => {
    tokenStorage.removeToken();
    tokenStorage.removeRefreshToken();
    storage.remove('token-issued-at');
  },
};

