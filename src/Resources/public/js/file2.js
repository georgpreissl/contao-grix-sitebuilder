export default class Example {

  constructor(name, year) {
    this.name = name;
    this.year = year;
  }  

  test() {
    console.log(this.name);
  }
}