import React from 'react';
import {
  Box,
  Typography,
  Button,
  Paper,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Chip,
  LinearProgress,
} from '@mui/material';
import { Add, Edit, Delete } from '@mui/icons-material';

const mockProjects = [
  {
    id: 1,
    name: 'Webサイトリニューアル',
    clientName: '株式会社ABC',
    status: 'in_progress' as const,
    progress: 65,
    startDate: '2024-01-15',
    endDate: '2024-03-31',
  },
  {
    id: 2,
    name: 'モバイルアプリ開発',
    clientName: '山田商事',
    status: 'planning' as const,
    progress: 20,
    startDate: '2024-02-01',
    endDate: '2024-06-30',
  },
];

const statusColors = {
  planning: 'info',
  in_progress: 'warning',
  completed: 'success',
  cancelled: 'error',
} as const;

const statusLabels = {
  planning: '計画中',
  in_progress: '進行中',
  completed: '完了',
  cancelled: 'キャンセル',
} as const;

export const ProjectList: React.FC = () => {
  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 3 }}>
        <Typography variant="h4" component="h1">
          プロジェクト管理
        </Typography>
        <Button
          variant="contained"
          startIcon={<Add />}
          onClick={() => {}}
        >
          プロジェクト追加
        </Button>
      </Box>

      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>プロジェクト名</TableCell>
              <TableCell>クライアント</TableCell>
              <TableCell>ステータス</TableCell>
              <TableCell>進捗</TableCell>
              <TableCell>開始日</TableCell>
              <TableCell>終了予定日</TableCell>
              <TableCell>アクション</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {mockProjects.map((project) => (
              <TableRow key={project.id}>
                <TableCell>{project.name}</TableCell>
                <TableCell>{project.clientName}</TableCell>
                <TableCell>
                  <Chip
                    label={statusLabels[project.status]}
                    color={statusColors[project.status]}
                    size="small"
                  />
                </TableCell>
                <TableCell>
                  <Box sx={{ display: 'flex', alignItems: 'center' }}>
                    <LinearProgress
                      variant="determinate"
                      value={project.progress}
                      sx={{ width: 100, mr: 1 }}
                    />
                    <Typography variant="body2">{project.progress}%</Typography>
                  </Box>
                </TableCell>
                <TableCell>{project.startDate}</TableCell>
                <TableCell>{project.endDate}</TableCell>
                <TableCell>
                  <Button size="small" startIcon={<Edit />}>
                    編集
                  </Button>
                  <Button size="small" startIcon={<Delete />} color="error">
                    削除
                  </Button>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </Box>
  );
};