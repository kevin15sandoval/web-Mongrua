# Authentication Models and Utilities

This directory contains the TypeScript-style interfaces and models for the authentication system in the PWA.

## Overview

The authentication module provides:
- User and authentication data models
- Validation utilities for forms and inputs
- Token management with JWT
- Secure storage utilities
- Authentication service with API integration
- Zustand store for state management
- Custom React hooks for easy integration

## Models

### User Model (`User.js`)

Defines the structure for user data:

```javascript
{
  id: string,
  email: string,
  fullName: string,
  dateOfBirth: Date|string,
  role: UserRole,
  createdAt: Date|string,
  emailVerified: boolean
}
```

**UserRole Enum:**
- `STUDENT`: Regular student user (default)
- `ADMINISTRATOR`: Admin user with elevated privileges

**Helper Functions:**
- `createUser(data)`: Create a User object from API response
- `hasRole(user, role)`: Check if user has specific role
- `isAdministrator(user)`: Check if user is admin
- `isStudent(user)`: Check if user is student
- `getUserDisplayName(user)`: Get user's display name
- `isEmailVerified(user)`: Check if email is verified

### Auth Model (`Auth.js`)

Defines authentication-related structures:

**AuthCredentials:**
```javascript
{
  email: string,
  password: string
}
```

**RegistrationData:**
```javascript
{
  email: string,
  fullName: string,
  dateOfBirth: Date|string,
  password: string,
  confirmPassword: string
}
```

**AuthToken:**
```javascript
{
  accessToken: string,
  refreshToken: string,
  expiresIn: number
}
```

**Helper Functions:**
- `createAuthCredentials(email, password)`: Create credentials object
- `createRegistrationData(data)`: Create registration data object
- `validateRegistrationData(data)`: Validate registration form
- `createAuthToken(data)`: Create token object from API response
- `isTokenExpired(token, issuedAt)`: Check if token is expired
- `createPasswordResetRequest(email)`: Create password reset request
- `createPasswordResetData(data)`: Create password reset data
- `validatePasswordResetData(data)`: Validate password reset form

## Validators (`utils/validators.js`)

Comprehensive validation utilities:

### Email Validation
- `isValidEmail(email)`: Check if email format is valid
- `validateEmail(email)`: Get validation error message

### Password Validation
- `isValidPassword(password)`: Check if password meets requirements
  - Minimum 8 characters
  - At least 1 uppercase letter
  - At least 1 lowercase letter
  - At least 1 number
- `validatePassword(password)`: Get validation error message
- `getPasswordStrength(password)`: Get password strength ('weak', 'medium', 'strong')

### Age Validation
- `isValidAge(dateOfBirth)`: Check if user is at least 16 years old
- `validateDateOfBirth(dateOfBirth)`: Get validation error message

### Form Validation
- `validateFullName(fullName)`: Validate full name (2-100 characters)
- `validatePasswordConfirmation(password, confirmPassword)`: Check passwords match
- `validateRegistrationForm(data)`: Validate entire registration form
- `validateLoginForm(credentials)`: Validate login form

## Storage (`utils/storage.js`)

Safe localStorage utilities with error handling:

### General Storage
- `storage.get(key, defaultValue)`: Get item from localStorage
- `storage.set(key, value)`: Set item in localStorage (JSON serialized)
- `storage.remove(key)`: Remove item from localStorage
- `storage.clear()`: Clear all localStorage
- `storage.has(key)`: Check if key exists
- `storage.keys()`: Get all keys
- `storage.getSize()`: Get approximate storage size in bytes

### Token Storage
- `tokenStorage.setToken(token)`: Store access token
- `tokenStorage.getToken()`: Get access token
- `tokenStorage.removeToken()`: Remove access token
- `tokenStorage.setRefreshToken(token)`: Store refresh token
- `tokenStorage.getRefreshToken()`: Get refresh token
- `tokenStorage.removeRefreshToken()`: Remove refresh token
- `tokenStorage.clearTokens()`: Clear all tokens

## Authentication Service (`services/authService.js`)

API service for authentication operations:

### Methods

**User Registration:**
```javascript
await authService.register({
  email: 'user@example.com',
  fullName: 'John Doe',
  dateOfBirth: '1990-01-01',
  password: 'SecurePass123'
});
```

**User Login:**
```javascript
const { user, token } = await authService.login({
  email: 'user@example.com',
  password: 'SecurePass123'
});
```

**Logout:**
```javascript
authService.logout(); // Clears all tokens
```

**Email Verification:**
```javascript
await authService.verifyEmail(verificationToken);
```

**Password Reset:**
```javascript
// Request reset
await authService.forgotPassword('user@example.com');

// Reset with token
await authService.resetPassword(resetToken, 'NewPass123');
```

**Resend Verification:**
```javascript
await authService.resendVerification('user@example.com');
```

**Setup Initial Admin:**
```javascript
await authService.setupAdmin(userId, activationCode);
```

**Get Current User:**
```javascript
const user = await authService.getCurrentUser();
```

**Token Management:**
```javascript
// Check authentication
const isAuth = authService.isAuthenticated();

// Get tokens
const accessToken = authService.getAccessToken();
const refreshToken = authService.getRefreshToken();

// Refresh token
await authService.refreshAccessToken();
```

## Authentication Store (`store/authStore.js`)

Zustand store for authentication state management:

### State
- `user`: Current user object
- `token`: JWT access token
- `isAuthenticated`: Authentication status
- `isLoading`: Loading state
- `error`: Error message

### Actions
- `setUser(user)`: Set user data
- `setToken(token)`: Set token
- `setAuth(user, token)`: Set both user and token
- `setLoading(isLoading)`: Set loading state
- `setError(error)`: Set error message
- `clearError()`: Clear error
- `logout()`: Clear all auth data
- `hasRole(role)`: Check user role
- `isAdmin()`: Check if admin
- `isStudent()`: Check if student
- `getUser()`: Get current user
- `getToken()`: Get current token
- `updateUser(updates)`: Update user data

## useAuth Hook (`hooks/useAuth.js`)

Custom React hook for easy authentication integration:

### Usage

```javascript
import { useAuth } from '../hooks/useAuth';

function MyComponent() {
  const {
    user,
    isAuthenticated,
    isLoading,
    error,
    isAdmin,
    isStudent,
    login,
    register,
    logout,
    verifyEmail,
    forgotPassword,
    resetPassword,
    refreshUser,
    clearError,
  } = useAuth();

  // Use authentication state and methods
}
```

### Available Properties
- `user`: Current user object
- `token`: JWT token
- `isAuthenticated`: Boolean authentication status
- `isLoading`: Boolean loading state
- `error`: Error message string
- `isAdmin`: Boolean admin check
- `isStudent`: Boolean student check

### Available Methods
- `login(credentials)`: Login user
- `register(userData)`: Register new user
- `logout()`: Logout user
- `verifyEmail(token)`: Verify email
- `forgotPassword(email)`: Request password reset
- `resetPassword(token, newPassword)`: Reset password
- `refreshUser()`: Refresh user data from server
- `clearError()`: Clear error message

## API Interceptors (`services/api.js`)

Axios instance with JWT interceptors:

### Features
- Automatically adds JWT token to requests
- Handles 401 errors with automatic token refresh
- Queues failed requests during token refresh
- Redirects to login on refresh failure
- Configurable base URL and timeout

### Configuration

Set the API base URL in `.env`:
```
VITE_API_BASE_URL=http://localhost:3000/api
```

## Security Features

1. **Password Requirements:**
   - Minimum 8 characters
   - At least 1 uppercase letter
   - At least 1 lowercase letter
   - At least 1 number

2. **Age Verification:**
   - Minimum age: 16 years
   - Validates date is not in future

3. **Token Management:**
   - JWT access tokens with expiration
   - Refresh tokens for seamless re-authentication
   - Automatic token refresh on 401 errors
   - Secure storage in localStorage

4. **Email Verification:**
   - Required for account activation
   - Resend verification option

5. **Password Reset:**
   - Secure token-based reset
   - Token expiration

## Error Handling

All authentication operations include comprehensive error handling:

```javascript
try {
  await login(credentials);
} catch (error) {
  // Error is automatically set in store
  console.error(error.response?.data?.message);
}
```

## Testing

The authentication module is designed to be testable:

1. **Unit Tests:** Test individual validators and utilities
2. **Integration Tests:** Test service methods with mocked API
3. **Property-Based Tests:** Test validation logic with random inputs

## Requirements Validation

This implementation satisfies the following requirements:

- ✅ 1.1: User registration with required fields
- ✅ 1.2: Email, password, date of birth collection
- ✅ 1.3: Email format validation
- ✅ 1.4: Age validation (minimum 16 years)
- ✅ 1.5: Password security requirements
- ✅ 2.1: User authentication with credentials
- ✅ 2.2: Invalid credentials handling
- ✅ 2.3: Secure session token creation
- ✅ 2.4: Session expiration handling
- ✅ 2.5: Password recovery functionality

## Next Steps

After implementing this authentication module, the next tasks are:

1. Create authentication pages (RegistrationPage, LoginPage, PasswordRecoveryPage)
2. Implement protected routes
3. Add role-based access control
4. Implement initial admin setup flow
