function showPositionStart(position){
	var php_latitude = position.coords.latitude.toFixed(6);
	var php_longitude = position.coords.longitude.toFixed(6);
	var locAPI = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude.toFixed(6)+","+position.coords.longitude.toFixed(6)+"&key=AIzaSyDh8Tpk9hwkfZ2z-AYcBV5k1Xrhko7hy0M";
	if(confirm("Do you want to start working?")){
		$.get({
			url: locAPI,
			success: function(data){
			console.log(data);
			var address_length = data.results[0].address_components.length;
			var php_location = data.results[0].address_components[address_length - 3].long_name + ", " + data.results[0].address_components[address_length - 2].long_name + ", " + data.results[0].address_components[address_length - 1].long_name;
			var x = "start";
			$.ajax({
				method:"POST",
				url:"senddata.php",
				data:{lat: php_latitude, long: php_longitude, loc: php_location, func: x}
			})
			.done(function(msg2){
				x.innerHTML += msg2;
			  	})
			}
		});	
	}
	else{
		return;
	}		
}

function showPositionEnd(position){
	var php_latitude = position.coords.latitude.toFixed(6);
	var php_longitude = position.coords.longitude.toFixed(6);
	var locAPI = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude.toFixed(6)+","+position.coords.longitude.toFixed(6)+"&key=AIzaSyDh8Tpk9hwkfZ2z-AYcBV5k1Xrhko7hy0M";
	if(confirm("Do you want to end working?")){
		$.get({
			url: locAPI,
			success: function(data){
			console.log(data);
			var address_length = data.results[0].address_components.length;
			var php_location = data.results[0].address_components[address_length - 3].long_name + ", " + data.results[0].address_components[address_length - 2].long_name + ", " + data.results[0].address_components[address_length - 1].long_name;
			var x = "end";
			$.ajax({
				method:"POST",
				url:"senddata.php",
				data:{lat: php_latitude, long: php_longitude, loc: php_location, func: x}
			})
			.done(function(msg2){
				x.innerHTML += msg2;
			  	})
			}
		});	
	}
	else{
		return;
	}		
}