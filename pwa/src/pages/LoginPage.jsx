import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '../hooks/useAuth';
import { isValidEmail } from '../utils/validators';

/**
 * Login page component with improved UI and validation
 */
export const LoginPage = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [emailError, setEmailError] = useState('');

  const navigate = useNavigate();
  const { login, isLoading, error, clearError } = useAuth();

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

  const handleSubmit = async e => {
    e.preventDefault();
    clearError();

    // Client-side validation
    if (!isValidEmail(email)) {
      setEmailError('Por favor ingresa un email válido');
      return;
    }

    if (!password) {
      return;
    }

    try {
      await login({ email, password });
      navigate('/');
    } catch (err) {
      // Error is handled by useAuth hook
      console.error('Login error:', err);
    }
  };

  return (
    <div className="auth-page login-page">
      <div className="auth-container">
        <div className="auth-header">
          <h1>Bienvenido</h1>
          <p className="auth-subtitle">Inicia sesión para continuar</p>
        </div>

        <form onSubmit={handleSubmit} className="auth-form">
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

          <div className="form-group">
            <label htmlFor="password">Contraseña</label>
            <div className="password-input-wrapper">
              <input
                id="password"
                type={showPassword ? 'text' : 'password'}
                value={password}
                onChange={e => {
                  setPassword(e.target.value);
                  clearError();
                }}
                placeholder="••••••••"
                required
                autoComplete="current-password"
                minLength={8}
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
                Iniciando sesión...
              </>
            ) : (
              'Iniciar Sesión'
            )}
          </button>

          <div className="auth-links">
            <Link to="/password-recovery" className="link-secondary">
              ¿Olvidaste tu contraseña?
            </Link>
          </div>
        </form>

        <div className="auth-footer">
          <p>
            ¿No tienes cuenta?{' '}
            <Link to="/register" className="link-primary">
              Regístrate aquí
            </Link>
          </p>
        </div>
      </div>
    </div>
  );
};
