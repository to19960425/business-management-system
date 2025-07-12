import React from 'react';
import {
  Grid,
  Card,
  CardContent,
  Typography,
  Box,
  Paper,
} from '@mui/material';
import {
  People,
  Business,
  Assignment,
  TrendingUp,
} from '@mui/icons-material';

const StatCard: React.FC<{
  title: string;
  value: string;
  icon: React.ReactElement;
  color: string;
}> = ({ title, value, icon, color }) => (
  <Card sx={{ height: '100%' }}>
    <CardContent>
      <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
        <Box
          sx={{
            bgcolor: color,
            color: 'white',
            borderRadius: 1,
            p: 1,
            mr: 2,
          }}
        >
          {icon}
        </Box>
        <Typography variant="h6" component="div">
          {title}
        </Typography>
      </Box>
      <Typography variant="h4" component="div" color="primary">
        {value}
      </Typography>
    </CardContent>
  </Card>
);

export const Dashboard: React.FC = () => {
  return (
    <Box>
      <Typography variant="h4" component="h1" gutterBottom>
        ダッシュボード
      </Typography>
      
      <Grid container spacing={3} sx={{ mb: 4 }}>
        <Grid item xs={12} sm={6} md={3}>
          <StatCard
            title="総スタッフ数"
            value="24"
            icon={<People />}
            color="primary.main"
          />
        </Grid>
        <Grid item xs={12} sm={6} md={3}>
          <StatCard
            title="アクティブクライアント"
            value="18"
            icon={<Business />}
            color="secondary.main"
          />
        </Grid>
        <Grid item xs={12} sm={6} md={3}>
          <StatCard
            title="進行中プロジェクト"
            value="12"
            icon={<Assignment />}
            color="success.main"
          />
        </Grid>
        <Grid item xs={12} sm={6} md={3}>
          <StatCard
            title="今月の売上"
            value="¥2,450,000"
            icon={<TrendingUp />}
            color="warning.main"
          />
        </Grid>
      </Grid>

      <Grid container spacing={3}>
        <Grid item xs={12} md={8}>
          <Paper sx={{ p: 3, height: 400 }}>
            <Typography variant="h6" gutterBottom>
              プロジェクト進捗
            </Typography>
            <Typography variant="body2" color="text.secondary">
              プロジェクト進捗グラフがここに表示されます
            </Typography>
          </Paper>
        </Grid>
        <Grid item xs={12} md={4}>
          <Paper sx={{ p: 3, height: 400 }}>
            <Typography variant="h6" gutterBottom>
              最近の活動
            </Typography>
            <Typography variant="body2" color="text.secondary">
              最近の活動リストがここに表示されます
            </Typography>
          </Paper>
        </Grid>
      </Grid>
    </Box>
  );
};