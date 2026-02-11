import { useAuthStore } from '../store/authStore';
import { authService } from '../services/authService';
import { UserRole } from '../models/User';

/**
 * Custom hook for authentication
 * Provides access to auth state and actions
 */
export const useAuth = () => {
  const {
    user,
    token,
    isAuthenticated,
    isLoading,
    error,
    setUser,
    setToken,
    setAuth,
    setLoading,
    setError,
    clearError,
    logout,
    hasRole,
    isAdmin,
    isStudent,
    getUser,
    getToken,
    updateUser,
  } = useAuthStore();

  /**
   * Login with credentials
   * @param {Object} credentials - Email and password
   * @returns {Promise<Object>} Login result
   */
  const login = async credentials => {
    setLoading(true);
    clearError();
    try {
      const result = await authService.login(credentials);
      setAuth(result.user, result.token);
      return result;
    } catch (err) {
      const errorMessage = err.response?.data?.message || 'Error al iniciar sesión';
      setError(errorMessage);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  /**
   * Register new user
   * @param {Object} userData - Registration data
   * @returns {Promise<Object>} Registration result
   */
  const register = async userData => {
    setLoading(true);
    clearError();
    try {
      const result = await authService.register(userData);
      return result;
    } catch (err) {
      const errorMessage = err.response?.data?.message || 'Error al registrar usuario';
      setError(errorMessage);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  /**
   * Logout current user
   */
  const handleLogout = () => {
    authService.logout();
    logout();
  };

  /**
   * Verify email with token
   * @param {string} verificationToken - Email verification token
   * @returns {Promise<Object>} Verification result
   */
  const verifyEmail = async verificationToken => {
    setLoading(true);
    clearError();
    try {
      const result = await authService.verifyEmail(verificationToken);
      if (user) {
        updateUser({ emailVerified: true });
      }
      return result;
    } catch (err) {
      const errorMessage = err.response?.data?.message || 'Error al verificar email';
      setError(errorMessage);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  /**
   * Request password reset
   * @param {string} email - User email
   * @returns {Promise<Object>} Password reset request result
   */
  const forgotPassword = async email => {
    setLoading(true);
    clearError();
    try {
      const result = await authService.forgotPassword(email);
      return result;
    } catch (err) {
      const errorMessage =
        err.response?.data?.message || 'Error al solicitar restablecimiento de contraseña';
      setError(errorMessage);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  /**
   * Reset password with token
   * @param {string} resetToken - Password reset token
   * @param {string} newPassword - New password
   * @returns {Promise<Object>} Password reset result
   */
  const resetPassword = async (resetToken, newPassword) => {
    setLoading(true);
    clearError();
    try {
      const result = await authService.resetPassword(resetToken, newPassword);
      return result;
    } catch (err) {
      const errorMessage = err.response?.data?.message || 'Error al restablecer contraseña';
      setError(errorMessage);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  /**
   * Get current user from server
   * @returns {Promise<Object>} Current user data
   */
  const refreshUser = async () => {
    setLoading(true);
    clearError();
    try {
      const userData = await authService.getCurrentUser();
      setUser(userData);
      return userData;
    } catch (err) {
      const errorMessage = err.response?.data?.message || 'Error al obtener datos del usuario';
      setError(errorMessage);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  return {
    // State
    user,
    token,
    isAuthenticated,
    isLoading,
    error,

    // Role checks
    hasRole,
    isAdmin: isAdmin(),
    isStudent: isStudent(),

    // Actions
    login,
    register,
    logout: handleLogout,
    verifyEmail,
    forgotPassword,
    resetPassword,
    refreshUser,
    setUser,
    setToken,
    setAuth,
    updateUser,
    clearError,

    // Getters
    getUser,
    getToken,

    // Role enum for convenience
    UserRole,
  };
};

