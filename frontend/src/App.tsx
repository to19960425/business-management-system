import { useState } from 'react'
import { ThemeProvider, createTheme } from '@mui/material/styles'
import CssBaseline from '@mui/material/CssBaseline'
import { Container, Typography, Box, Card, CardContent, Button } from '@mui/material'

const theme = createTheme({
  palette: {
    primary: {
      main: '#1976d2',
    },
    secondary: {
      main: '#dc004e',
    },
  },
})

function App() {
  const [count, setCount] = useState(0)

  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <Container maxWidth="lg">
        <Box sx={{ my: 4 }}>
          <Typography variant="h2" component="h1" gutterBottom>
            Business Management System
          </Typography>
          <Card>
            <CardContent>
              <Typography variant="h5" component="h2">
                Frontend Service Running
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                React + TypeScript + Vite + Material-UI
              </Typography>
              <Typography variant="body2">
                Docker Compose health check: Frontend container is running successfully.
              </Typography>
              <Box sx={{ mt: 2 }}>
                <Button 
                  variant="contained" 
                  onClick={() => setCount((count) => count + 1)}
                >
                  Count is {count}
                </Button>
              </Box>
            </CardContent>
          </Card>
        </Box>
      </Container>
    </ThemeProvider>
  )
}

export default App