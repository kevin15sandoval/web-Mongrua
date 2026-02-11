import { Outlet } from 'react-router-dom';

// Main layout component
export const Layout = () => {
  return (
    <div className="app-layout">
      <header className="app-header">
        <h1>Sistema de Certificación de Cursos</h1>
      </header>
      <main className="app-main">
        <Outlet />
      </main>
      <footer className="app-footer">
        <p>&copy; 2026 Sistema de Certificación de Cursos</p>
      </footer>
    </div>
  );
};
