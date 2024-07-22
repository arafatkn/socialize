import type { User } from '@/types/user';
import type { TimeStamp } from '@/types/index';

export type Post = {
  id: number;
  content: string;
  created_at: string;
  user: User;
  created_ago: string;
  is_new: boolean;
} & TimeStamp;
