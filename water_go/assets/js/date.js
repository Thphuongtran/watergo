var date = new function() {
		
	this.getTodate = function() {	
		
		var today = new Date();		
		var day = today.getDate();
		var month = today.getMonth()+1;
		var year = today.getFullYear();
		
		var value = year + '-' + month + '-' + day;
		
		return value;
	};
	
	this.changeDay = function(day) {		
		
		var today = new Date();		

		today.setDate(today.getDate()+day); 
		
		var day = today.getDate();
		var month = today.getMonth()+1;
		var year = today.getFullYear();
		
		var value = year + '-' + month + '-' + day;
		
		return value;
	};
	
	this.changeMonth = function(month) {		
		
		var today = new Date();		

		today.setMonth(today.getMonth()+month);
		
		var day = today.getDate();
		var month = today.getMonth()+1;
		var year = today.getFullYear();
		
		var value = year + '-' + month + '-' + day;
		
		return value;
	};
	
	
};