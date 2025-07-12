import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { ThemeProvider } from '@mui/material/styles';
import CssBaseline from '@mui/material/CssBaseline';
import { theme } from './styles/theme';
import { MainLayout } from './components/common/MainLayout';
import { Dashboard } from './pages/Dashboard';
import { StaffList } from './pages/StaffList';
import { ClientList } from './pages/ClientList';
import { ProjectList } from './pages/ProjectList';
import { ROUTES } from './constants/routes';

function App() {
  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <Router>
        <Routes>
          <Route path={ROUTES.HOME} element={<Navigate to={ROUTES.DASHBOARD} replace />} />
          <Route
            path={ROUTES.DASHBOARD}
            element={
              <MainLayout>
                <Dashboard />
              </MainLayout>
            }
          />
          <Route
            path={ROUTES.STAFF.LIST}
            element={
              <MainLayout>
                <StaffList />
              </MainLayout>
            }
          />
          <Route
            path={ROUTES.CLIENTS.LIST}
            element={
              <MainLayout>
                <ClientList />
              </MainLayout>
            }
          />
          <Route
            path={ROUTES.PROJECTS.LIST}
            element={
              <MainLayout>
                <ProjectList />
              </MainLayout>
            }
          />
        </Routes>
      </Router>
    </ThemeProvider>
  );
}

export default App