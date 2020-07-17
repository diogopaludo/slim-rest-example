export class User {
  public id: number;
  public name: string;
  public email: string;
  public password: string;
  public image: string;
  public constructor(json: any = []) {
    this.id = json.id ? parseInt(json.id, 10) : null;
    this.name = json.name;
    this.email = json.email;
    this.password = null;
    this.image = json.image;
  }
}
