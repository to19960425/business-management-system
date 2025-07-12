import React, { useState, useEffect } from 'react';
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
  CircularProgress,
  Alert,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  IconButton,
  Tooltip,
} from '@mui/material';
import { Add, Edit, Delete } from '@mui/icons-material';
import { staffService } from '../services/staffService';
import { StaffForm } from '../components/forms/StaffForm';
import type { Staff, StaffCreateRequest, StaffUpdateRequest } from '../types';

export const StaffList: React.FC = () => {
  const [staff, setStaff] = useState<Staff[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [formOpen, setFormOpen] = useState(false);
  const [selectedStaff, setSelectedStaff] = useState<Staff | null>(null);
  const [deleteDialogOpen, setDeleteDialogOpen] = useState(false);
  const [staffToDelete, setStaffToDelete] = useState<Staff | null>(null);
  const [formLoading, setFormLoading] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  useEffect(() => {
    loadStaff();
  }, []);

  const loadStaff = async () => {
    try {
      setLoading(true);
      const response = await staffService.getAll();
      
      if (response.success && response.data) {
        setStaff(response.data);
        setError(null);
      } else {
        setError(response.error || 'スタッフ一覧の取得に失敗しました');
      }
    } catch (err) {
      setError('スタッフ一覧の取得に失敗しました');
    } finally {
      setLoading(false);
    }
  };

  const handleAddStaff = () => {
    setSelectedStaff(null);
    setFormError(null);
    setFormOpen(true);
  };

  const handleEditStaff = (staff: Staff) => {
    setSelectedStaff(staff);
    setFormError(null);
    setFormOpen(true);
  };

  const handleDeleteStaff = (staff: Staff) => {
    setStaffToDelete(staff);
    setDeleteDialogOpen(true);
  };

  const confirmDelete = async () => {
    if (!staffToDelete) return;

    try {
      setFormLoading(true);
      const response = await staffService.delete(staffToDelete.id);
      
      if (response.success) {
        await loadStaff();
        setDeleteDialogOpen(false);
        setStaffToDelete(null);
      } else {
        setError(response.error || 'スタッフの削除に失敗しました');
      }
    } catch (err) {
      setError('スタッフの削除に失敗しました');
    } finally {
      setFormLoading(false);
    }
  };

  const handleFormSubmit = async (data: StaffCreateRequest | StaffUpdateRequest) => {
    try {
      setFormLoading(true);
      setFormError(null);

      let response;
      if (selectedStaff) {
        response = await staffService.update(selectedStaff.id, data as StaffUpdateRequest);
      } else {
        response = await staffService.create(data as StaffCreateRequest);
      }

      if (response.success) {
        await loadStaff();
        setFormOpen(false);
        setSelectedStaff(null);
      } else {
        setFormError(response.error || 'スタッフの保存に失敗しました');
      }
    } catch (err) {
      setFormError('スタッフの保存に失敗しました');
    } finally {
      setFormLoading(false);
    }
  };

  const getFullName = (staff: Staff) => {
    return `${staff.last_name} ${staff.first_name}`;
  };

  if (loading) {
    return (
      <Box display="flex" justifyContent="center" alignItems="center" minHeight="200px">
        <CircularProgress />
      </Box>
    );
  }

  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 3 }}>
        <Typography variant="h4" component="h1">
          スタッフ管理
        </Typography>
        <Button
          variant="contained"
          startIcon={<Add />}
          onClick={handleAddStaff}
        >
          スタッフ追加
        </Button>
      </Box>

      {error && (
        <Alert severity="error" sx={{ mb: 2 }}>
          {error}
        </Alert>
      )}

      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>社員ID</TableCell>
              <TableCell>名前</TableCell>
              <TableCell>メールアドレス</TableCell>
              <TableCell>職位</TableCell>
              <TableCell>部署</TableCell>
              <TableCell>ステータス</TableCell>
              <TableCell>アクション</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {staff.length === 0 ? (
              <TableRow>
                <TableCell colSpan={7} align="center">
                  スタッフが登録されていません
                </TableCell>
              </TableRow>
            ) : (
              staff.map((staffMember) => (
                <TableRow key={staffMember.id}>
                  <TableCell>{staffMember.employee_id}</TableCell>
                  <TableCell>{getFullName(staffMember)}</TableCell>
                  <TableCell>{staffMember.user?.email || '-'}</TableCell>
                  <TableCell>{staffMember.position || '-'}</TableCell>
                  <TableCell>{staffMember.department || '-'}</TableCell>
                  <TableCell>
                    <Chip
                      label={staffMember.active ? 'アクティブ' : '非アクティブ'}
                      color={staffMember.active ? 'success' : 'default'}
                      size="small"
                    />
                  </TableCell>
                  <TableCell>
                    <Tooltip title="編集">
                      <IconButton
                        size="small"
                        onClick={() => handleEditStaff(staffMember)}
                      >
                        <Edit />
                      </IconButton>
                    </Tooltip>
                    <Tooltip title="削除">
                      <IconButton
                        size="small"
                        color="error"
                        onClick={() => handleDeleteStaff(staffMember)}
                      >
                        <Delete />
                      </IconButton>
                    </Tooltip>
                  </TableCell>
                </TableRow>
              ))
            )}
          </TableBody>
        </Table>
      </TableContainer>

      <StaffForm
        open={formOpen}
        onClose={() => {
          setFormOpen(false);
          setSelectedStaff(null);
          setFormError(null);
        }}
        onSubmit={handleFormSubmit}
        staff={selectedStaff}
        loading={formLoading}
        error={formError}
      />

      <Dialog open={deleteDialogOpen} onClose={() => setDeleteDialogOpen(false)}>
        <DialogTitle>スタッフの削除</DialogTitle>
        <DialogContent>
          {staffToDelete && (
            <Typography>
              「{getFullName(staffToDelete)}」を削除してもよろしいですか？
              この操作は取り消すことができません。
            </Typography>
          )}
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setDeleteDialogOpen(false)}>
            キャンセル
          </Button>
          <Button
            onClick={confirmDelete}
            color="error"
            variant="contained"
            disabled={formLoading}
          >
            削除
          </Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
};