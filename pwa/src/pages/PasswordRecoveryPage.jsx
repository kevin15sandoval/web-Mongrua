import { useState } from 'react';
import { Link, useSearchParams } from 'react-router-dom';
import { useAuth } from '../hooks/useAuth';
import { isValidEmail, isValidPassword, getPasswordStrength } from '../utils/validators';

/**
 * Password recovery page component
 * Handles both password reset request and password reset with token
 */
export const PasswordRecoveryPage = () => {
  const [searchParams] = useSearchParams();
  const resetToken = searchParams.get('token');
  const isResetMode = !!resetToken;

  const [email, setEmail] = useState('');
  const [newPassword, setNewPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);
  const [emailError, setEmailError] = useState('');
  const [passwordError, setPasswordError] = useState('');
  const [confirmPasswordError, setConfirmPasswordError] = useState('');
  const [passwordStrength, setPasswordStrength] = useState(null);
  const [success, setSuccess] = useState(false);

  const { forgotPassword, resetPassword, isLoading, error, clearError } = useAuth();

  const handleEmailChange = e => {
    const value = e.target.value;
    setEmail(value);
    setEmailError('');
    clearError();
  };

  const handleEmailBlur = () => {
    if (email && !isValidEmail(email)) {
      setEmailError('Por favor ingresa un email válido');
    }
  };

  const handlePasswordChange = e => {
    const value = e.target.value;
    setNewPassword(value);
    setPasswordError('');
    clearError();
    setPasswordStrength(getPasswordStrength(value));
  };

  const handlePasswordBlur = () => {
    if (newPassword && !isValidPassword(newPassword)) {
      setPasswordError(
        'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número'
      );
    }
  };

  const handleConfirmPasswordChange = e => {
    const value = e.target.value;
    setConfirmPassword(value);
    setConfirmPasswordError('');
    clearError();
  };

  const handleConfirmPasswordBlur = () => {
    if (confirmPassword && confirmPassword !== newPassword) {
      setConfirmPasswordError('Las contraseñas no coinciden');
    }
  };

  const handleRequestReset = async e => {
    e.preventDefault();
    clearError();

    if (!isValidEmail(email)) {
      setEmailError('Por favor ingresa un email válido');
      return;
    }

    try {
      await forgotPassword(email);
      setSuccess(true);
    } catch (err) {
      console.error('Password reset request error:', err);
    }
  };

  const handleResetPassword = async e => {
    e.preventDefault();
    clearError();

    if (!isValidPassword(newPassword)) {
      setPasswordError(
        'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número'
      );
      return;
    }

    if (newPassword !== confirmPassword) {
      setConfirmPasswordError('Las contraseñas no coinciden');
      return;
    }

    try {
      await resetPassword(resetToken, newPassword);
      setSuccess(true);
    } catch (err) {
      console.error('Password reset error:', err);
    }
  };

  if (success && !isResetMode) {
    return (
      <div className="auth-page password-recovery-page">
        <div className="auth-container">
          <div className="success-message">
            <div className="success-icon">✓</div>
            <h2>Email Enviado</h2>
            <p>
              Hemos enviado un enlace de recuperación a <strong>{email}</strong>
            </p>
            <p className="text-secondary">
              Por favor revisa tu bandeja de entrada y sigue las instrucciones para restablecer tu
              contraseña.
            </p>
            <Link to="/login" className="btn btn-primary" style={{ marginTop: '1.5rem' }}>
              Volver al inicio de sesión
            </Link>
          </div>
        </div>
      </div>
    );
  }

  if (success && isResetMode) {
    return (
      <div className="auth-page password-recovery-page">
        <div className="auth-container">
          <div className="success-message">
            <div className="success-icon">✓</div>
            <h2>Contraseña Restablecida</h2>
            <p>Tu contraseña ha sido actualizada exitosamente.</p>
            <Link to="/login" className="btn btn-primary" style={{ marginTop: '1.5rem' }}>
              Iniciar Sesión
            </Link>
          </div>
        </div>
      </div>
    );
  }

  if (isResetMode) {
    return (
      <div className="auth-page password-recovery-page">
        <div className="auth-container">
          <div className="auth-header">
            <h1>Restablecer Contraseña</h1>
            <p className="auth-subtitle">Ingresa tu nueva contraseña</p>
          </div>

          <form onSubmit={handleResetPassword} className="auth-form">
            <div className="form-group">
              <label htmlFor="newPassword">Nueva Contraseña</label>
              <div className="password-input-wrapper">
                <input
                  id="newPassword"
                  type={showPassword ? 'text' : 'password'}
                  value={newPassword}
                  onChange={handlePasswordChange}
                  onBlur={handlePasswordBlur}
                  placeholder="••••••••"
                  required
                  autoComplete="new-password"
                  minLength={8}
                  className={passwordError ? 'input-error' : ''}
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
              {passwordError && <span className="field-error">{passwordError}</span>}
            </div>

            <div className="form-group">
              <label htmlFor="confirmPassword">Confirmar Contraseña</label>
              <div className="password-input-wrapper">
                <input
                  id="confirmPassword"
                  type={showConfirmPassword ? 'text' : 'password'}
                  value={confirmPassword}
                  onChange={handleConfirmPasswordChange}
                  onBlur={handleConfirmPasswordBlur}
                  placeholder="••••••••"
                  required
                  autoComplete="new-password"
                  minLength={8}
                  className={confirmPasswordError ? 'input-error' : ''}
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
              {confirmPasswordError && <span className="field-error">{confirmPasswordError}</span>}
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
                  Restableciendo...
                </>
              ) : (
                'Restablecer Contraseña'
              )}
            </button>
          </form>

          <div className="auth-footer">
            <Link to="/login" className="link-primary">
              Volver al inicio de sesión
            </Link>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="auth-page password-recovery-page">
      <div className="auth-container">
        <div className="auth-header">
          <h1>Recuperar Contraseña</h1>
          <p className="auth-subtitle">
            Ingresa tu email y te enviaremos un enlace para restablecer tu contraseña
          </p>
        </div>

        <form onSubmit={handleRequestReset} className="auth-form">
          <div className="form-group">
            <label htmlFor="email">Email</label>
            <input
              id="email"
              type="email"
              value={email}
              onChange={handleEmailChange}
              onBlur={handleEmailBlur}
              placeholder="tu@email.com"
              required
              autoComplete="email"
              className={emailError ? 'input-error' : ''}
            />
            {emailError && <span className="field-error">{emailError}</span>}
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
                Enviando...
              </>
            ) : (
              'Enviar Enlace de Recuperación'
            )}
          </button>
        </form>

        <div className="auth-footer">
          <Link to="/login" className="link-primary">
            Volver al inicio de sesión
          </Link>
        </div>
      </div>
    </div>
  );
};
