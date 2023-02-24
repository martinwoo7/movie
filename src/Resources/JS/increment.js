function change(id) {
	var total;
	
	var totalChild = parseInt(document.getElementById("child").value);
	var totalSenior = parseInt(document.getElementById("senior").value);
	var totalAdult = parseInt(document.getElementById("adult").value);
	var seats = parseInt(document.getElementById("seats").value);
						  
	total = totalChild + totalSenior + totalAdult;
	//var totalCost = parseInt(document.getElementById("totalcost").innerHTML);
	var totalCost = (totalChild * 9.99) + (totalSenior * 10.99) + (totalAdult * 13.99);
	
	
	if (id == "incChild" && (seats - 1 > 0)) {
		
		document.getElementById("child").value = totalChild + 1;
		total = total + 1;
		
		document.getElementById("totalticket").innerHTML = total;
		document.getElementById("totalticket2").innerHTML = total;
		document.getElementById("total").value = total;
		
		totalCost = totalCost + 9.99;
		
		totalCost = Number(totalCost.toFixed(2));
		
		
		document.getElementById("totalcost").innerHTML = totalCost;
		document.getElementById("totalcost2").innerHTML = totalCost;
		document.getElementById("total2").value = totalCost;
		document.getElementById("c").value = document.getElementById("c").value + 1;
		
		seats = seats - 1;
		document.getElementById("seats").value = seats;
	}
	
	if (id == "decChild") {
		if (totalChild > 0) {
			document.getElementById("child").value = totalChild - 1;
			total = total - 1;
			document.getElementById("totalticket").innerHTML = total;
			document.getElementById("totalticket2").innerHTML = total;
			document.getElementById("total").value = total;
			
			totalCost = totalCost - 9.99;
			totalCost = Number(totalCost.toFixed(2));
			
			document.getElementById("totalcost").innerHTML = totalCost;
			document.getElementById("totalcost2").innerHTML = totalCost;
			
			document.getElementById("total2").value = totalCost;
			document.getElementById("c").value = document.getElementById("c").value - 1;
			
			seats = seats + 1;
			document.getElementById("seats").value = seats;
		}
	}
	
	if (id == "incSen" && seats - 1 >0) {
		document.getElementById("senior").value = totalSenior + 1;
		total = total + 1;
		document.getElementById("totalticket").innerHTML = total;
		document.getElementById("totalticket2").innerHTML = total;
		document.getElementById("total").value = total;
		
		totalCost = totalCost + 10.99;
		totalCost = Number(totalCost.toFixed(2));
		
		document.getElementById("totalcost").innerHTML = totalCost;
		document.getElementById("totalcost2").innerHTML = totalCost;
		document.getElementById("total2").value = totalCost;
		document.getElementById("s").value = document.getElementById("s").value + 1;
		
		seats = seats - 1;
		document.getElementById("seats").value = seats;
	}
	
	if (id == "decSen") {
		if (totalSenior > 0) {
			document.getElementById("senior").value = totalSenior - 1;
			total = total - 1;
			document.getElementById("totalticket").innerHTML = total;
			document.getElementById("totalticket2").innerHTML = total;
			document.getElementById("total").value = total;
			
			totalCost = totalCost - 10.99;
			totalCost = Number(totalCost.toFixed(2));
			
			document.getElementById("totalcost").innerHTML = totalCost;
			document.getElementById("totalcost2").innerHTML = totalCost;
			document.getElementById("total2").value = totalCost;
			document.getElementById("s").value = document.getElementById("s").value - 1;
			
			seats = seats + 1;
			document.getElementById("seats").value = seats;
		}
	}
	
	if (id == "incAd" && seats - 1 > 0) {
		document.getElementById("adult").value = totalAdult + 1;
		total = total + 1;
		document.getElementById("totalticket").innerHTML = total;
		document.getElementById("totalticket2").innerHTML = total;
		document.getElementById("total").value = total;
		
		totalCost = totalCost + 13.99;
		totalCost = Number(totalCost.toFixed(2));
		
		document.getElementById("totalcost").innerHTML = totalCost;
		document.getElementById("totalcost2").innerHTML = totalCost;
		document.getElementById("total2").value = totalCost;
		document.getElementById("g").value = document.getElementById("g").value + 1;
		
		seats = seats - 1;
		document.getElementById("seats").value = seats;
	} 
	
	if (id == "decAd") {
		if (totalAdult > 0) {
			document.getElementById("adult").value = totalAdult - 1;
			total = total -1;
			document.getElementById("totalticket").innerHTML = total;
			document.getElementById("totalticket2").innerHTML = total;
			document.getElementById("total").value = total;
			
			totalCost = totalCost - 13.99;
			totalCost = Number(totalCost.toFixed(2));
			
			document.getElementById("totalcost").innerHTML = totalCost;
			document.getElementById("totalcost2").innerHTML = totalCost;
			document.getElementById("total2").value = totalCost;
			document.getElementById("g").value = document.getElementById("g").value - 1;
			
			seats = seats + 1;
			document.getElementById("seats").value = seats;
		}
	}
}
