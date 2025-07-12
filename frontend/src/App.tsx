import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { ThemeProvider } from '@mui/material/styles';
import CssBaseline from '@mui/material/CssBaseline';
import { theme } from './styles/theme';
import { AuthProvider } from './contexts/AuthContext';
import ProtectedRoute from './components/auth/ProtectedRoute';
import { MainLayout } from './components/common/MainLayout';
import { Dashboard } from './pages/Dashboard';
import { StaffList } from './pages/StaffList';
import { ClientList } from './pages/ClientList';
import { ProjectList } from './pages/ProjectList';
import Login from './pages/Login';
import { ROUTES } from './constants/routes';

function App() {
  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <AuthProvider>
        <Router>
          <Routes>
            <Route path={ROUTES.LOGIN} element={<Login />} />
            <Route path={ROUTES.HOME} element={<Navigate to={ROUTES.DASHBOARD} replace />} />
            <Route
              path={ROUTES.DASHBOARD}
              element={
                <ProtectedRoute>
                  <MainLayout>
                    <Dashboard />
                  </MainLayout>
                </ProtectedRoute>
              }
            />
            <Route
              path={ROUTES.STAFF.LIST}
              element={
                <ProtectedRoute>
                  <MainLayout>
                    <StaffList />
                  </MainLayout>
                </ProtectedRoute>
              }
            />
            <Route
              path={ROUTES.CLIENTS.LIST}
              element={
                <ProtectedRoute>
                  <MainLayout>
                    <ClientList />
                  </MainLayout>
                </ProtectedRoute>
              }
            />
            <Route
              path={ROUTES.PROJECTS.LIST}
              element={
                <ProtectedRoute>
                  <MainLayout>
                    <ProjectList />
                  </MainLayout>
                </ProtectedRoute>
              }
            />
          </Routes>
        </Router>
      </AuthProvider>
    </ThemeProvider>
  );
}

export default App