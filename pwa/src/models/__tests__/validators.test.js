/**
 * Validators Test Suite
 * Tests for authentication validation utilities
 */

import { describe, it, expect } from 'vitest';
import {
  isValidEmail,
  validateEmail,
  isValidPassword,
  validatePassword,
  isValidAge,
  validateDateOfBirth,
  getPasswordStrength,
  validateFullName,
  validatePasswordConfirmation,
  validateRegistrationForm,
  validateLoginForm,
} from '../../utils/validators';

describe('Email Validation', () => {
  it('should validate correct email formats', () => {
    expect(isValidEmail('user@example.com')).toBe(true);
    expect(isValidEmail('test.user@domain.co.uk')).toBe(true);
    expect(isValidEmail('user+tag@example.com')).toBe(true);
  });

  it('should reject invalid email formats', () => {
    expect(isValidEmail('invalid')).toBe(false);
    expect(isValidEmail('user@')).toBe(false);
    expect(isValidEmail('@example.com')).toBe(false);
    expect(isValidEmail('user @example.com')).toBe(false);
    expect(isValidEmail('')).toBe(false);
    expect(isValidEmail(null)).toBe(false);
  });

  it('should return appropriate error messages', () => {
    expect(validateEmail('')).toBe('El correo electrónico es requerido');
    expect(validateEmail('invalid')).toBe('El formato del correo electrónico no es válido');
    expect(validateEmail('user@example.com')).toBe(null);
  });
});

describe('Password Validation', () => {
  it('should validate passwords meeting all requirements', () => {
    expect(isValidPassword('Password123')).toBe(true);
    expect(isValidPassword('SecurePass1')).toBe(true);
    expect(isValidPassword('MyP@ssw0rd')).toBe(true);
  });

  it('should reject passwords not meeting requirements', () => {
    expect(isValidPassword('short1A')).toBe(false); // Too short
    expect(isValidPassword('nouppercase1')).toBe(false); // No uppercase
    expect(isValidPassword('NOLOWERCASE1')).toBe(false); // No lowercase
    expect(isValidPassword('NoNumbers')).toBe(false); // No numbers
    expect(isValidPassword('')).toBe(false);
    expect(isValidPassword(null)).toBe(false);
  });

  it('should return appropriate error messages', () => {
    expect(validatePassword('')).toBe('La contraseña es requerida');
    expect(validatePassword('short')).toBe('La contraseña debe tener al menos 8 caracteres');
    expect(validatePassword('nouppercase1')).toBe(
      'La contraseña debe contener al menos una letra mayúscula'
    );
    expect(validatePassword('NOLOWERCASE1')).toBe(
      'La contraseña debe contener al menos una letra minúscula'
    );
    expect(validatePassword('NoNumbers')).toBe('La contraseña debe contener al menos un número');
    expect(validatePassword('Password123')).toBe(null);
  });

  it('should calculate password strength correctly', () => {
    expect(getPasswordStrength('weak')).toBe('weak');
    expect(getPasswordStrength('Password1')).toBe('medium');
    expect(getPasswordStrength('StrongP@ssw0rd123')).toBe('strong');
  });
});

describe('Age Validation', () => {
  it('should validate users 16 years or older', () => {
    const sixteenYearsAgo = new Date();
    sixteenYearsAgo.setFullYear(sixteenYearsAgo.getFullYear() - 16);
    sixteenYearsAgo.setDate(sixteenYearsAgo.getDate() - 1); // One day past 16th birthday

    const twentyYearsAgo = new Date();
    twentyYearsAgo.setFullYear(twentyYearsAgo.getFullYear() - 20);

    expect(isValidAge(sixteenYearsAgo)).toBe(true);
    expect(isValidAge(twentyYearsAgo)).toBe(true);
  });

  it('should reject users under 16 years', () => {
    const fifteenYearsAgo = new Date();
    fifteenYearsAgo.setFullYear(fifteenYearsAgo.getFullYear() - 15);

    const today = new Date();

    expect(isValidAge(fifteenYearsAgo)).toBe(false);
    expect(isValidAge(today)).toBe(false);
  });

  it('should reject invalid dates', () => {
    expect(isValidAge('invalid')).toBe(false);
    expect(isValidAge(null)).toBe(false);
    expect(isValidAge('')).toBe(false);
  });

  it('should return appropriate error messages', () => {
    expect(validateDateOfBirth('')).toBe('La fecha de nacimiento es requerida');
    expect(validateDateOfBirth('invalid')).toBe('La fecha de nacimiento no es válida');

    const futureDate = new Date();
    futureDate.setFullYear(futureDate.getFullYear() + 1);
    expect(validateDateOfBirth(futureDate)).toBe(
      'La fecha de nacimiento no puede estar en el futuro'
    );

    const fifteenYearsAgo = new Date();
    fifteenYearsAgo.setFullYear(fifteenYearsAgo.getFullYear() - 15);
    expect(validateDateOfBirth(fifteenYearsAgo)).toBe(
      'Debes tener al menos 16 años para registrarte'
    );

    const twentyYearsAgo = new Date();
    twentyYearsAgo.setFullYear(twentyYearsAgo.getFullYear() - 20);
    expect(validateDateOfBirth(twentyYearsAgo)).toBe(null);
  });
});

describe('Full Name Validation', () => {
  it('should validate valid names', () => {
    expect(validateFullName('John Doe')).toBe(null);
    expect(validateFullName('María García')).toBe(null);
    expect(validateFullName('A B')).toBe(null); // Minimum 2 chars
  });

  it('should reject invalid names', () => {
    expect(validateFullName('')).toBe('El nombre completo es requerido');
    expect(validateFullName('A')).toBe('El nombre debe tener al menos 2 caracteres');
    expect(validateFullName('A'.repeat(101))).toBe('El nombre no puede exceder 100 caracteres');
  });
});

describe('Password Confirmation Validation', () => {
  it('should validate matching passwords', () => {
    expect(validatePasswordConfirmation('Password123', 'Password123')).toBe(null);
  });

  it('should reject non-matching passwords', () => {
    expect(validatePasswordConfirmation('Password123', 'Different123')).toBe(
      'Las contraseñas no coinciden'
    );
    expect(validatePasswordConfirmation('Password123', '')).toBe('Debes confirmar la contraseña');
  });
});

describe('Registration Form Validation', () => {
  it('should validate complete valid registration data', () => {
    const twentyYearsAgo = new Date();
    twentyYearsAgo.setFullYear(twentyYearsAgo.getFullYear() - 20);

    const validData = {
      email: 'user@example.com',
      fullName: 'John Doe',
      dateOfBirth: twentyYearsAgo,
      password: 'Password123',
      confirmPassword: 'Password123',
    };

    const result = validateRegistrationForm(validData);
    expect(result.isValid).toBe(true);
    expect(Object.keys(result.errors).length).toBe(0);
  });

  it('should return all validation errors for invalid data', () => {
    const invalidData = {
      email: 'invalid',
      fullName: 'A',
      dateOfBirth: 'invalid',
      password: 'weak',
      confirmPassword: 'different',
    };

    const result = validateRegistrationForm(invalidData);
    expect(result.isValid).toBe(false);
    expect(result.errors.email).toBeDefined();
    expect(result.errors.fullName).toBeDefined();
    expect(result.errors.dateOfBirth).toBeDefined();
    expect(result.errors.password).toBeDefined();
    expect(result.errors.confirmPassword).toBeDefined();
  });
});

describe('Login Form Validation', () => {
  it('should validate valid login credentials', () => {
    const validCredentials = {
      email: 'user@example.com',
      password: 'Password123',
    };

    const result = validateLoginForm(validCredentials);
    expect(result.isValid).toBe(true);
    expect(Object.keys(result.errors).length).toBe(0);
  });

  it('should return validation errors for invalid credentials', () => {
    const invalidCredentials = {
      email: 'invalid',
      password: '',
    };

    const result = validateLoginForm(invalidCredentials);
    expect(result.isValid).toBe(false);
    expect(result.errors.email).toBeDefined();
    expect(result.errors.password).toBeDefined();
  });
});
