import { create } from 'zustand';
import { persist } from 'zustand/middleware';
import { UserRole, isAdministrator, isStudent } from '../models/User';

/**
 * Authentication Store
 * Manages authentication state using Zustand
 */
export const useAuthStore = create(
  persist(
    (set, get) => ({
      // State
      user: null,
      token: null,
      isAuthenticated: false,
      isLoading: false,
      error: null,

      // Actions
      /**
       * Set user data
       * @param {Object} user - User object
       */
      setUser: user =>
        set({
          user,
          isAuthenticated: !!user,
          error: null,
        }),

      /**
       * Set authentication token
       * @param {string} token - JWT token
       */
      setToken: token =>
        set({
          token,
          error: null,
        }),

      /**
       * Set both user and token
       * @param {Object} user - User object
       * @param {string} token - JWT token
       */
      setAuth: (user, token) =>
        set({
          user,
          token,
          isAuthenticated: true,
          error: null,
        }),

      /**
       * Set loading state
       * @param {boolean} isLoading - Loading state
       */
      setLoading: isLoading => set({ isLoading }),

      /**
       * Set error message
       * @param {string} error - Error message
       */
      setError: error => set({ error }),

      /**
       * Clear error message
       */
      clearError: () => set({ error: null }),

      /**
       * Logout user and clear all auth data
       */
      logout: () =>
        set({
          user: null,
          token: null,
          isAuthenticated: false,
          error: null,
        }),

      /**
       * Check if user has specific role
       * @param {string} role - Role to check (from UserRole enum)
       * @returns {boolean}
       */
      hasRole: role => {
        const { user } = get();
        return user?.role === role;
      },

      /**
       * Check if current user is an administrator
       * @returns {boolean}
       */
      isAdmin: () => {
        const { user } = get();
        return isAdministrator(user);
      },

      /**
       * Check if current user is a student
       * @returns {boolean}
       */
      isStudent: () => {
        const { user } = get();
        return isStudent(user);
      },

      /**
       * Get current user
       * @returns {Object|null} User object or null
       */
      getUser: () => {
        return get().user;
      },

      /**
       * Get current token
       * @returns {string|null} Token or null
       */
      getToken: () => {
        return get().token;
      },

      /**
       * Update user data
       * @param {Object} updates - Partial user data to update
       */
      updateUser: updates => {
        const { user } = get();
        if (user) {
          set({
            user: { ...user, ...updates },
          });
        }
      },
    }),
    {
      name: 'auth-storage',
      partialize: state => ({
        user: state.user,
        token: state.token,
        isAuthenticated: state.isAuthenticated,
      }),
    }
  )
);

