import type { FunctionalComponent } from 'vue';
import type { AnyObject } from './index';

export type DataTableColumnType = {
  title: string;
  value: string | ((row: any) => string);
  link?: string | ((row: AnyObject) => string);
};

export type DataTableActionType = {
  title: string;
  icon?: FunctionalComponent;
  color?: string;
  onClick?: string | ((row: AnyObject) => any);
};
