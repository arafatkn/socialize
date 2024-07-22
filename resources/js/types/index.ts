import type { User } from '@/types/user';

export type AnyObject = Record<string, any>;

export type AnyFunction = (...args: unknown[]) => unknown;

export interface InertiaProps {
  errors?: { message: string } & AnyObject;
  route: {
    name: string;
    params: AnyObject;
  };
  flash: { message?: string; success?: string; error?: string };
  user?: User | null;
}

export interface TimeStamp {
  created_at?: string;
  updated_at?: string;
}

export interface PaginatedData<T = AnyObject> {
  data: T[];
  meta: AnyObject;
  links: {
    first?: string | null;
    last?: string | null;
    prev?: string | null;
    next?: string | null;
  };
}
