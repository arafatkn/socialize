import type { File } from '@/types/post';
import type { TimeStamp } from '@/types/index';
import type { User } from '@/types/user';

export type Chat = {
  id: number;
  user1_id: number;
  user2_id: number;
  user1?: User;
  user2?: User;
  user1_unread_count: number;
  user2_unread_count: number;
  created_at: number;
};

export type Message = {
  id: number;
  sender_id: number;
  sender: User;
  chat_id: number;
  content?: string;
  files?: File[];
  pinned: boolean;
  is_new: boolean;
  created_ago: string;
} & TimeStamp;
