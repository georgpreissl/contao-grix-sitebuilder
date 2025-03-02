class GrixElement {
	constructor(dataObj){
		// console.log('GrixElement constructor is called');
		this.margin = {
			xs:"",
			sm:"",
			md:"",
			lg:""
		};	
		if(dataObj) {	
			for (const [key, value] of Object.entries(dataObj)) {
				this[key] = value;
			}
		}
	}
  }
  
  class GrixRow extends GrixElement {

	constructor(dataObj) {
		super(dataObj);
		this.type = 'row';
		this.unitsConf = {
			xs:"12",
			sm:"12",
			md:"12",
			lg:"12"
		};
	
		this.classes = '';
		this.elements = [];		
	  
	  
	}

	addCol(obCol){
		// console.log(obCol);
		this.elements.push(obCol);
	}

  }


  class GrixCol extends GrixElement {
	constructor(dataObj) {
		// console.log('GrixCol constructor is called');
		super(dataObj);
		this.type = 'col';
	
	  
	  
	}
	setDefault(){
		this.width = {
			xs:"12",
			sm:"",
			md:"",
			lg:""
		};
		this.offset = {
			xs:"",
			sm:"",
			md:"",
			lg:""
		};	
		this.push = {
			xs:"",
			sm:"",
			md:"",
			lg:""
		};
		this.pull = {
			xs:"",
			sm:"",
			md:"",
			lg:""
		};

	
		this.classes = '';
		this.elements = [];	
	}


  }


  class GrixCE extends GrixElement {
	constructor(dataObj) {
		super(dataObj);
		this.type = 'ce';
		this.classes = '';
	
		this.classes = '';
		this.elements = [];		
	  
	  
	}



  }




