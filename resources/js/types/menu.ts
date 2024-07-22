export type MenuItem = {
  name: string;
  href: string;
  icon?: any;
  current?: boolean;
  children?: MenuItem[];
};
