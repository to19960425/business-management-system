import { describe, it, expect } from 'vitest';
import { render, screen } from '../../test/testUtils';
import { Dashboard } from '../Dashboard';

describe('Dashboard', () => {
  it('renders dashboard title', () => {
    render(<Dashboard />);
    
    expect(screen.getByText('ダッシュボード')).toBeInTheDocument();
  });

  it('renders all stat cards', () => {
    render(<Dashboard />);
    
    expect(screen.getByText('総スタッフ数')).toBeInTheDocument();
    expect(screen.getByText('アクティブクライアント')).toBeInTheDocument();
    expect(screen.getByText('進行中プロジェクト')).toBeInTheDocument();
    expect(screen.getByText('今月の売上')).toBeInTheDocument();
  });

  it('renders stat values', () => {
    render(<Dashboard />);
    
    expect(screen.getByText('24')).toBeInTheDocument();
    expect(screen.getByText('18')).toBeInTheDocument();
    expect(screen.getByText('12')).toBeInTheDocument();
    expect(screen.getByText('¥2,450,000')).toBeInTheDocument();
  });

  it('renders chart and activity sections', () => {
    render(<Dashboard />);
    
    expect(screen.getByText('プロジェクト進捗')).toBeInTheDocument();
    expect(screen.getByText('最近の活動')).toBeInTheDocument();
  });
});