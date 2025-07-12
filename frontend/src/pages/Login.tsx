import React, { useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import {
  Container,
  Paper,
  TextField,
  Button,
  Typography,
  Box,
  Alert,
  CircularProgress,
} from '@mui/material';
import { useAuth } from '../contexts/AuthContext';

interface LocationState {
  from?: {
    pathname: string;
  };
}

const Login: React.FC = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const { login, loading } = useAuth();
  
  const [formData, setFormData] = useState({
    email: '',
    password: '',
  });
  const [error, setError] = useState<string | null>(null);
  const [isSubmitting, setIsSubmitting] = useState(false);

  const state = location.state as LocationState;
  const redirectPath = state?.from?.pathname || '/dashboard';

  const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setFormData(prev => ({
      ...prev,
      [name]: value,
    }));
    
    // Clear error when user starts typing
    if (error) {
      setError(null);
    }
  };

  const handleSubmit = async (event: React.FormEvent) => {
    event.preventDefault();
    
    if (!formData.email || !formData.password) {
      setError('メールアドレスとパスワードを入力してください');
      return;
    }

    setIsSubmitting(true);
    setError(null);

    try {
      await login(formData.email, formData.password);
      navigate(redirectPath, { replace: true });
    } catch (err: any) {
      console.error('Login error:', err);
      
      if (err.response?.status === 401) {
        setError('メールアドレスまたはパスワードが正しくありません');
      } else if (err.response?.data?.message) {
        setError(err.response.data.message);
      } else {
        setError('ログインに失敗しました。もう一度お試しください。');
      }
    } finally {
      setIsSubmitting(false);
    }
  };

  if (loading) {
    return (
      <Container maxWidth="sm">
        <Box
          display="flex"
          justifyContent="center"
          alignItems="center"
          minHeight="100vh"
        >
          <CircularProgress />
        </Box>
      </Container>
    );
  }

  return (
    <Container maxWidth="sm">
      <Box
        display="flex"
        flexDirection="column"
        justifyContent="center"
        alignItems="center"
        minHeight="100vh"
      >
        <Paper elevation={3} sx={{ p: 4, width: '100%', maxWidth: 400 }}>
          <Box textAlign="center" mb={3}>
            <Typography variant="h4" component="h1" gutterBottom>
              ログイン
            </Typography>
            <Typography variant="body2" color="text.secondary">
              ビジネス管理システム
            </Typography>
          </Box>

          {error && (
            <Alert severity="error" sx={{ mb: 2 }}>
              {error}
            </Alert>
          )}

          <Box component="form" onSubmit={handleSubmit}>
            <TextField
              fullWidth
              name="email"
              type="email"
              label="メールアドレス"
              value={formData.email}
              onChange={handleInputChange}
              margin="normal"
              required
              autoComplete="email"
              autoFocus
              disabled={isSubmitting}
            />

            <TextField
              fullWidth
              name="password"
              type="password"
              label="パスワード"
              value={formData.password}
              onChange={handleInputChange}
              margin="normal"
              required
              autoComplete="current-password"
              disabled={isSubmitting}
            />

            <Button
              type="submit"
              fullWidth
              variant="contained"
              size="large"
              disabled={isSubmitting}
              sx={{ mt: 3, mb: 2 }}
            >
              {isSubmitting ? (
                <CircularProgress size={24} color="inherit" />
              ) : (
                'ログイン'
              )}
            </Button>
          </Box>

          <Box textAlign="center" mt={2}>
            <Typography variant="body2" color="text.secondary">
              システム管理者から提供されたアカウントでログインしてください
            </Typography>
          </Box>
        </Paper>
      </Box>
    </Container>
  );
};

export default Login;