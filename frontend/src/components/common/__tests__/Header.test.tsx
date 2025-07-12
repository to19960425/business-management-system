import { describe, it, expect, vi, beforeEach } from 'vitest';
import { render, screen, fireEvent } from '../../../test/testUtils';
import { Header } from '../Header';

describe('Header', () => {
  const mockOnMenuClick = vi.fn();

  beforeEach(() => {
    mockOnMenuClick.mockClear();
  });

  it('renders header with title', () => {
    render(<Header onMenuClick={mockOnMenuClick} />);
    
    expect(screen.getByText('ビジネス管理システム')).toBeInTheDocument();
  });

  it('calls onMenuClick when menu button is clicked', () => {
    render(<Header onMenuClick={mockOnMenuClick} />);
    
    const menuButton = screen.getByLabelText('open drawer');
    fireEvent.click(menuButton);
    
    expect(mockOnMenuClick).toHaveBeenCalledTimes(1);
  });

  it('opens profile menu when profile button is clicked', () => {
    render(<Header onMenuClick={mockOnMenuClick} />);
    
    const profileButton = screen.getByLabelText('account of current user');
    fireEvent.click(profileButton);
    
    expect(screen.getByText('設定')).toBeInTheDocument();
    expect(screen.getByText('ログアウト')).toBeInTheDocument();
  });
});