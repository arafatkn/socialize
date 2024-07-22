export type NotificationType = {
  id?: number;
  type: 'success' | 'error' | 'warning' | 'info';
  title: string;
  message?: string;
  timeout?: number;
};

export type NotificationParamType = string | { title: string; message?: string };
