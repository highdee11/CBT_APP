$(function(){

	var ctx=$("#mycanvas");
	var data={
		labels:['Jamb','Waec','Neco','N-Power'],
		datasets:[{
			label:'Student Attempt',
			fill:true,
			lineTension:0.9,
			backgroundColor:'pink',
			borderColor:'rgba(75,192,192,1)',
			borderCapStyle:'butt',
			borderDash:[],
			borderDashOffset:0.0,
			borderJoinStyle:'miter',
			pointBorderColor:'rgba(75,192,192,1)',
			pointBackgroundColor:'#fff',
			pointBorderWidth:1,
			pointHoverRadius:5,
			pointHoverBackgroundColor:'rgba(75,192,192,1)',
			pointHoverBorderColor:'rgba(220,220,220,1)',
			pointHoverBorderWidth:2,
			pointRadius:1,
			pointHitRadius:10,
			data:[20,30,90,60]
		}]
	};
	var chart=new Chart(ctx,{
		type:'bar',
		data:data,
		options:{
			scales:{
				yAxes:[{
					ticks:{
						beginAtZero:true
					}
				}]
			}
		}


	});

	var ctx2=$("#mycanvas2");
	var data2={
		labels:['Jamb','Waec','Neco','N-Power','Ican'],
		datasets:[{
			label:'Student Attempt',
			fill:false,
			lineTension:0.9,
			backgroundColor:'#cfd40b',
			borderColor:'rgba(75,192,192,1)',
			borderCapStyle:'butt',
			borderDash:[],
			borderDashOffset:0.0,
			borderJoinStyle:'miter',
			pointBorderColor:'rgba(75,192,192,1)',
			pointBackgroundColor:'#fff',
			pointBorderWidth:1,
			pointHoverRadius:5,
			pointHoverBackgroundColor:'rgba(75,192,192,1)',
			pointHoverBorderColor:'rgba(220,220,220,1)',
			pointHoverBorderWidth:2,
			pointRadius:1,
			pointHitRadius:10,
			data:[10,30,90,60,100]
		}]
	};
	var chart=new Chart(ctx2,{
		type:'line',
		data:data2,
		options:{
			scales:{
				yAxes:[{
					ticks:{
						beginAtZero:true
					}
				}]
			}
		}


	});
    
   
    
    
    
    
    
    //-------------------------------------------------------------LOGING OUT--------------------------------------------------------------------//
    
    $("#logout").click(function(){
        $.post("../db/connect.php",{logout:1},function(data){
            console.log(data);
            window.location="../";
            
        });    
    });
    

});
