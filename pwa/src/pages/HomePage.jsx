import { Link } from 'react-router-dom';
import { useAuth } from '../hooks/useAuth';

// Home page component
export const HomePage = () => {
  const { user, isAuthenticated, logout } = useAuth();

  return (
    <div className="home-page">
      <div className="hero-section">
        <h1>🎓 Sistema de Certificación de Cursos</h1>
        <p className="subtitle">Plataforma de gestión y certificación de cursos educativos</p>
      </div>

      {isAuthenticated ? (
        <div className="user-section">
          <div className="welcome-card">
            <h2>¡Bienvenido, {user?.fullName || user?.email}! 👋</h2>
            <p className="user-role">
              Rol: <span className="badge">{user?.role === 'administrator' ? '👨‍💼 Administrador' : '👨‍🎓 Estudiante'}</span>
            </p>
            <p className="user-email">📧 {user?.email}</p>
            <button onClick={logout} className="btn btn-secondary">
              Cerrar Sesión
            </button>
          </div>

          <div className="features-grid">
            <div className="feature-card">
              <h3>📚 Mis Cursos</h3>
              <p>Accede a tus cursos activos y completados</p>
              <button className="btn btn-primary" disabled>Próximamente</button>
            </div>
            <div className="feature-card">
              <h3>🎖️ Mis Certificados</h3>
              <p>Visualiza y descarga tus certificados digitales</p>
              <button className="btn btn-primary" disabled>Próximamente</button>
            </div>
            <div className="feature-card">
              <h3>🔔 Notificaciones</h3>
              <p>Mantente al día con las novedades</p>
              <button className="btn btn-primary" disabled>Próximamente</button>
            </div>
          </div>
        </div>
      ) : (
        <div className="auth-section">
          <div className="auth-card">
            <h2>Comienza tu viaje de aprendizaje</h2>
            <p>Regístrate o inicia sesión para acceder a todos los cursos y obtener certificados digitales</p>
            
            <div className="auth-buttons">
              <Link to="/register" className="btn btn-primary">
                📝 Registrarse
              </Link>
              <Link to="/login" className="btn btn-secondary">
                🔐 Iniciar Sesión
              </Link>
            </div>
          </div>

          <div className="features-grid">
            <div className="feature-card">
              <div className="feature-icon">✅</div>
              <h3>Validación Segura</h3>
              <p>Email válido, contraseña segura (8+ caracteres, mayúsculas, minúsculas, números)</p>
            </div>
            <div className="feature-card">
              <div className="feature-icon">🔒</div>
              <h3>Tokens JWT</h3>
              <p>Autenticación segura con renovación automática de tokens</p>
            </div>
            <div className="feature-card">
              <div className="feature-icon">👥</div>
              <h3>Roles de Usuario</h3>
              <p>Sistema de roles: Estudiante y Administrador</p>
            </div>
            <div className="feature-card">
              <div className="feature-icon">📧</div>
              <h3>Verificación de Email</h3>
              <p>Confirma tu cuenta mediante email de verificación</p>
            </div>
            <div className="feature-card">
              <div className="feature-icon">🔄</div>
              <h3>Recuperación de Contraseña</h3>
              <p>Restablece tu contraseña de forma segura</p>
            </div>
            <div className="feature-card">
              <div className="feature-icon">💾</div>
              <h3>Almacenamiento Seguro</h3>
              <p>Tus datos protegidos con localStorage cifrado</p>
            </div>
          </div>
        </div>
      )}

      <div className="info-section">
        <h2>📊 Estado de Implementación</h2>
        <div className="status-grid">
          <div className="status-item completed">
            <span className="status-icon">✅</span>
            <div>
              <strong>Módulo de Autenticación</strong>
              <p>Modelos, validadores, servicios y store completados</p>
            </div>
          </div>
          <div className="status-item in-progress">
            <span className="status-icon">🔄</span>
            <div>
              <strong>Páginas de Autenticación</strong>
              <p>Login y Registro funcionales, falta mejorar UI</p>
            </div>
          </div>
          <div className="status-item pending">
            <span className="status-icon">⏳</span>
            <div>
              <strong>Gestión de Cursos</strong>
              <p>Próxima tarea a implementar</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
