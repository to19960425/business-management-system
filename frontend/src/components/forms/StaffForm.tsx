import React, { useState, useEffect } from 'react';
import {
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  TextField,
  Button,
  Grid,
  FormControlLabel,
  Switch,
  CircularProgress,
  Alert,
} from '@mui/material';
import type { Staff, StaffCreateRequest, StaffUpdateRequest } from '../../types';

interface StaffFormProps {
  open: boolean;
  onClose: () => void;
  onSubmit: (data: StaffCreateRequest | StaffUpdateRequest) => Promise<void>;
  staff?: Staff | null;
  loading?: boolean;
  error?: string | null;
}

export const StaffForm: React.FC<StaffFormProps> = ({
  open,
  onClose,
  onSubmit,
  staff,
  loading = false,
  error = null,
}) => {
  const [formData, setFormData] = useState<StaffCreateRequest>({
    user_id: 1,
    employee_id: '',
    first_name: '',
    last_name: '',
    first_name_kana: '',
    last_name_kana: '',
    phone: '',
    mobile: '',
    position: '',
    department: '',
    hire_date: '',
    salary: '',
    hourly_rate: '',
    notes: '',
    active: true,
  });

  const [formErrors, setFormErrors] = useState<Record<string, string>>({});

  useEffect(() => {
    if (staff) {
      setFormData({
        user_id: staff.user_id,
        employee_id: staff.employee_id,
        first_name: staff.first_name,
        last_name: staff.last_name,
        first_name_kana: staff.first_name_kana || '',
        last_name_kana: staff.last_name_kana || '',
        phone: staff.phone || '',
        mobile: staff.mobile || '',
        position: staff.position || '',
        department: staff.department || '',
        hire_date: staff.hire_date || '',
        salary: staff.salary || '',
        hourly_rate: staff.hourly_rate || '',
        notes: staff.notes || '',
        active: staff.active ?? true,
      });
    } else {
      setFormData({
        user_id: 1,
        employee_id: '',
        first_name: '',
        last_name: '',
        first_name_kana: '',
        last_name_kana: '',
        phone: '',
        mobile: '',
        position: '',
        department: '',
        hire_date: '',
        salary: '',
        hourly_rate: '',
        notes: '',
        active: true,
      });
    }
    setFormErrors({});
  }, [staff, open]);

  const handleChange = (field: keyof StaffCreateRequest) => (
    event: React.ChangeEvent<HTMLInputElement>
  ) => {
    const value = event.target.type === 'checkbox' ? event.target.checked : event.target.value;
    setFormData(prev => ({ ...prev, [field]: value }));
    
    // Clear error when user starts typing
    if (formErrors[field]) {
      setFormErrors(prev => ({ ...prev, [field]: '' }));
    }
  };

  const validateForm = (): boolean => {
    const errors: Record<string, string> = {};

    if (!formData.employee_id.trim()) {
      errors.employee_id = '社員IDは必須です';
    }
    if (!formData.first_name.trim()) {
      errors.first_name = '名前（名）は必須です';
    }
    if (!formData.last_name.trim()) {
      errors.last_name = '名前（姓）は必須です';
    }

    setFormErrors(errors);
    return Object.keys(errors).length === 0;
  };

  const handleSubmit = async () => {
    if (!validateForm()) {
      return;
    }

    try {
      await onSubmit(formData);
      handleClose();
    } catch (error) {
      // Error handling is done in parent component
    }
  };

  const handleClose = () => {
    setFormData({
      user_id: 1,
      employee_id: '',
      first_name: '',
      last_name: '',
      first_name_kana: '',
      last_name_kana: '',
      phone: '',
      mobile: '',
      position: '',
      department: '',
      hire_date: '',
      salary: '',
      hourly_rate: '',
      notes: '',
      active: true,
    });
    setFormErrors({});
    onClose();
  };

  return (
    <Dialog open={open} onClose={handleClose} maxWidth="md" fullWidth>
      <DialogTitle>
        {staff ? 'スタッフ編集' : 'スタッフ追加'}
      </DialogTitle>
      <DialogContent>
        {error && (
          <Alert severity="error" sx={{ mb: 2 }}>
            {error}
          </Alert>
        )}
        
        <Grid container spacing={2} sx={{ mt: 1 }}>
          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="社員ID *"
              value={formData.employee_id}
              onChange={handleChange('employee_id')}
              error={!!formErrors.employee_id}
              helperText={formErrors.employee_id}
              disabled={loading}
            />
          </Grid>
          
          <Grid item xs={12} sm={6}>
            <FormControlLabel
              control={
                <Switch
                  checked={formData.active}
                  onChange={handleChange('active')}
                  disabled={loading}
                />
              }
              label="アクティブ"
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="姓 *"
              value={formData.last_name}
              onChange={handleChange('last_name')}
              error={!!formErrors.last_name}
              helperText={formErrors.last_name}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="名 *"
              value={formData.first_name}
              onChange={handleChange('first_name')}
              error={!!formErrors.first_name}
              helperText={formErrors.first_name}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="姓（カナ）"
              value={formData.last_name_kana}
              onChange={handleChange('last_name_kana')}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="名（カナ）"
              value={formData.first_name_kana}
              onChange={handleChange('first_name_kana')}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="電話番号"
              value={formData.phone}
              onChange={handleChange('phone')}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="携帯電話"
              value={formData.mobile}
              onChange={handleChange('mobile')}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="職位"
              value={formData.position}
              onChange={handleChange('position')}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="部署"
              value={formData.department}
              onChange={handleChange('department')}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="入社日"
              type="date"
              value={formData.hire_date}
              onChange={handleChange('hire_date')}
              InputLabelProps={{ shrink: true }}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="年俸"
              type="number"
              value={formData.salary}
              onChange={handleChange('salary')}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12} sm={6}>
            <TextField
              fullWidth
              label="時給"
              type="number"
              value={formData.hourly_rate}
              onChange={handleChange('hourly_rate')}
              disabled={loading}
            />
          </Grid>

          <Grid item xs={12}>
            <TextField
              fullWidth
              label="備考"
              multiline
              rows={3}
              value={formData.notes}
              onChange={handleChange('notes')}
              disabled={loading}
            />
          </Grid>
        </Grid>
      </DialogContent>
      <DialogActions>
        <Button onClick={handleClose} disabled={loading}>
          キャンセル
        </Button>
        <Button
          onClick={handleSubmit}
          variant="contained"
          disabled={loading}
          startIcon={loading ? <CircularProgress size={20} /> : undefined}
        >
          {staff ? '更新' : '作成'}
        </Button>
      </DialogActions>
    </Dialog>
  );
};