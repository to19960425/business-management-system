import { describe, it, expect } from 'vitest';
import { API_BASE_URL } from '../../constants/api';

describe('apiService', () => {
  it('should have correct base URL', () => {
    expect(API_BASE_URL).toBe('http://localhost:8000/api/v1');
  });
});