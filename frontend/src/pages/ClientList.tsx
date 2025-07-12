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

const mockClients = [
  {
    id: 1,
    name: '株式会社ABC',
    email: 'contact@abc-corp.com',
    company: '株式会社ABC',
    phone: '03-1234-5678',
    isActive: true,
  },
  {
    id: 2,
    name: '山田商事',
    email: 'info@yamada-trade.com',
    company: '山田商事株式会社',
    phone: '06-9876-5432',
    isActive: true,
  },
];

export const ClientList: React.FC = () => {
  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 3 }}>
        <Typography variant="h4" component="h1">
          クライアント管理
        </Typography>
        <Button
          variant="contained"
          startIcon={<Add />}
          onClick={() => {}}
        >
          クライアント追加
        </Button>
      </Box>

      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>名前</TableCell>
              <TableCell>会社名</TableCell>
              <TableCell>メールアドレス</TableCell>
              <TableCell>電話番号</TableCell>
              <TableCell>ステータス</TableCell>
              <TableCell>アクション</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {mockClients.map((client) => (
              <TableRow key={client.id}>
                <TableCell>{client.name}</TableCell>
                <TableCell>{client.company}</TableCell>
                <TableCell>{client.email}</TableCell>
                <TableCell>{client.phone}</TableCell>
                <TableCell>
                  <Chip
                    label={client.isActive ? 'アクティブ' : '非アクティブ'}
                    color={client.isActive ? 'success' : 'default'}
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