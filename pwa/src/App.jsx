import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { Layout } from './components/Layout';
import { ProtectedRoute } from './components/ProtectedRoute';
import { HomePage } from './pages/HomePage';
import { LoginPage } from './pages/LoginPage';
import { RegistrationPage } from './pages/RegistrationPage';
import { PasswordRecoveryPage } from './pages/PasswordRecoveryPage';
import './App.css';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<HomePage />} />
          <Route path="login" element={<LoginPage />} />
          <Route path="register" element={<RegistrationPage />} />
          <Route path="password-recovery" element={<PasswordRecoveryPage />} />
          {/* Protected routes will be added in future tasks */}
        </Route>
      </Routes>
    </Router>
  );
}

export default App;

