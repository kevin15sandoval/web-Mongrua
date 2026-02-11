import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '../hooks/useAuth';
import { isValidEmail, isValidPassword, isValidAge, getPasswordStrength } from '../utils/validators';

/**
 * Registration page component with improved UI and validation
 */
export const RegistrationPage = () => {
  const [formData, setFormData] = useState({
    email: '',
    fullName: '',
    dateOfBirth: '',
    password: '',
    confirmPassword: '',
  });
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);
  const [fieldErrors, setFieldErrors] = useState({});
  const [passwordStrength, setPasswordStrength] = useState(null);
  const [success, setSuccess] = useState(false);

  const navigate = useNavigate();
  const { register, isLoading, error, clearError } = useAuth();

  const handleChange = e => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
    setFieldErrors({ ...fieldErrors, [name]: '' });
    clearError();

    // Update password strength indicator
    if (name === 'password') {
      setPasswordStrength(getPasswordStrength(value));
    }
  };

  const validateField = (name, value) => {
    let error = '';

    switch (name) {
      case 'email':
        if (value && !isValidEmail(value)) {
          error = 'Email inválido';
        }
        break;
      case 'fullName':
        if (value && value.trim().length < 3) {
          error = 'El nombre debe tener al menos 3 caracteres';
        }
        break;
      case 'dateOfBirth':
        if (value && !isValidAge(value)) {
          error = 'Debes tener al menos 16 años';
        }
        break;
      case 'password':
        if (value && !isValidPassword(value)) {
          error = 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número';
        }
        break;
      case 'confirmPassword':
        if (value && value !== formData.password) {
          error = 'Las contraseñas no coinciden';
        }
        break;
    }

    return error;
  };

  const handleBlur = e => {
    const { name, value } = e.target;
    const error = validateField(name, value);
    if (error) {
      setFieldErrors({ ...fieldErrors, [name]: error });
    }
  };

  const handleSubmit = async e => {
    e.preventDefault();
    clearError();

    // Validate all fields
    const errors = {};
    Object.keys(formData).forEach(key => {
      const error = validateField(key, formData[key]);
      if (error) errors[key] = error;
    });

    if (Object.keys(errors).length > 0) {
      setFieldErrors(errors);
      return;
    }

    try {
      await register({
        email: formData.email,
        fullName: formData.fullName,
        dateOfBirth: formData.dateOfBirth,
        password: formData.password,
      });
      setSuccess(true);
      setTimeout(() => navigate('/login'), 2000);
    } catch (err) {
      console.error('Registration error:', err);
    }
  };

  if (success) {
    return (
      <div className="auth-page registration-page">
        <div className="auth-container">
          <div className="success-message">
            <div className="success-icon">✓</div>
            <h2>¡Registro Exitoso!</h2>
            <p>Tu cuenta ha sido creada. Redirigiendo al inicio de sesión...</p>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="auth-page registration-page">
      <div className="auth-container">
        <div className="auth-header">
          <h1>Crear Cuenta</h1>
          <p className="auth-subtitle">Completa el formulario para registrarte</p>
        </div>

        <form onSubmit={handleSubmit} className="auth-form">
          <div className="form-group">
            <label htmlFor="fullName">Nombre Completo</label>
            <input
              id="fullName"
              type="text"
              name="fullName"
              value={formData.fullName}
              onChange={handleChange}
              onBlur={handleBlur}
              placeholder="Juan Pérez"
              required
              autoComplete="name"
              className={fieldErrors.fullName ? 'input-error' : ''}
            />
            {fieldErrors.fullName && <span className="field-error">{fieldErrors.fullName}</span>}
          </div>

          <div className="form-group">
            <label htmlFor="email">Email</label>
            <input
              id="email"
              type="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              onBlur={handleBlur}
              placeholder="tu@email.com"
              required
              autoComplete="email"
              className={fieldErrors.email ? 'input-error' : ''}
            />
            {fieldErrors.email && <span className="field-error">{fieldErrors.email}</span>}
          </div>

          <div className="form-group">
            <label htmlFor="dateOfBirth">Fecha de Nacimiento</label>
            <input
              id="dateOfBirth"
              type="date"
              name="dateOfBirth"
              value={formData.dateOfBirth}
              onChange={handleChange}
              onBlur={handleBlur}
              required
              className={fieldErrors.dateOfBirth ? 'input-error' : ''}
            />
            {fieldErrors.dateOfBirth && <span className="field-error">{fieldErrors.dateOfBirth}</span>}
          </div>

          <div className="form-group">
            <label htmlFor="password">Contraseña</label>
            <div className="password-input-wrapper">
              <input
                id="password"
                type={showPassword ? 'text' : 'password'}
                name="password"
                value={formData.password}
                onChange={handleChange}
                onBlur={handleBlur}
                placeholder="••••••••"
                required
                autoComplete="new-password"
                minLength={8}
                className={fieldErrors.password ? 'input-error' : ''}
              />
              <button
                type="button"
                className="password-toggle"
                onClick={() => setShowPassword(!showPassword)}
                aria-label={showPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'}
              >
                {showPassword ? '👁️' : '👁️‍🗨️'}
              </button>
            </div>
            {passwordStrength && (
              <div className="password-strength">
                <div className={`strength-bar strength-${passwordStrength.level}`}>
                  <div className="strength-fill"></div>
                </div>
                <span className={`strength-text strength-${passwordStrength.level}`}>
                  {passwordStrength.text}
                </span>
              </div>
            )}
            {fieldErrors.password && <span className="field-error">{fieldErrors.password}</span>}
          </div>

          <div className="form-group">
            <label htmlFor="confirmPassword">Confirmar Contraseña</label>
            <div className="password-input-wrapper">
              <input
                id="confirmPassword"
                type={showConfirmPassword ? 'text' : 'password'}
                name="confirmPassword"
                value={formData.confirmPassword}
                onChange={handleChange}
                onBlur={handleBlur}
                placeholder="••••••••"
                required
                autoComplete="new-password"
                minLength={8}
                className={fieldErrors.confirmPassword ? 'input-error' : ''}
              />
              <button
                type="button"
                className="password-toggle"
                onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                aria-label={showConfirmPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'}
              >
                {showConfirmPassword ? '👁️' : '👁️‍🗨️'}
              </button>
            </div>
            {fieldErrors.confirmPassword && <span className="field-error">{fieldErrors.confirmPassword}</span>}
          </div>

          {error && (
            <div className="error-message" role="alert">
              {error}
            </div>
          )}

          <button type="submit" className="btn btn-primary btn-block" disabled={isLoading}>
            {isLoading ? (
              <>
                <span className="spinner"></span>
                Registrando...
              </>
            ) : (
              'Crear Cuenta'
            )}
          </button>
        </form>

        <div className="auth-footer">
          <p>
            ¿Ya tienes cuenta?{' '}
            <Link to="/login" className="link-primary">
              Inicia sesión aquí
            </Link>
          </p>
        </div>
      </div>
    </div>
  );
};
