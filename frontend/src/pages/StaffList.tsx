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
} from '@mui/material';
import { Add, Edit, Delete } from '@mui/icons-material';

const mockStaff = [
  {
    id: 1,
    name: '田中 太郎',
    email: 'tanaka@example.com',
    position: 'シニアエンジニア',
    department: '開発部',
    isActive: true,
  },
  {
    id: 2,
    name: '佐藤 花子',
    email: 'sato@example.com',
    position: 'プロジェクトマネージャー',
    department: 'プロジェクト管理部',
    isActive: true,
  },
];

export const StaffList: React.FC = () => {
  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 3 }}>
        <Typography variant="h4" component="h1">
          スタッフ管理
        </Typography>
        <Button
          variant="contained"
          startIcon={<Add />}
          onClick={() => {}}
        >
          スタッフ追加
        </Button>
      </Box>

      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>名前</TableCell>
              <TableCell>メールアドレス</TableCell>
              <TableCell>職位</TableCell>
              <TableCell>部署</TableCell>
              <TableCell>ステータス</TableCell>
              <TableCell>アクション</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {mockStaff.map((staff) => (
              <TableRow key={staff.id}>
                <TableCell>{staff.name}</TableCell>
                <TableCell>{staff.email}</TableCell>
                <TableCell>{staff.position}</TableCell>
                <TableCell>{staff.department}</TableCell>
                <TableCell>
                  <Chip
                    label={staff.isActive ? 'アクティブ' : '非アクティブ'}
                    color={staff.isActive ? 'success' : 'default'}
                    size="small"
                  />
                </TableCell>
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