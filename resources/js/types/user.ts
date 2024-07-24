export type User = {
  id: number;
  username: string;
  name: string;
  email: string;
  permissions: {
    feed: boolean;
    admin: boolean;
  };
  status: string;
  public_profile_url: string;
};
