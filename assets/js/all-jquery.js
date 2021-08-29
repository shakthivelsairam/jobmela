function initCharts() {
			
				if ($('#multipleBarsChart').length != 0) {
					
					/* ----------==========    Rounded Line Chart initialization    ==========---------- */
					

					var dataMultipleBarsChart = {
						labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
						series: [
							[542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895],
							[412, 243, 280, 580, 453, 353, 300, 364, 368, 410, 636, 695]
						]
					};

					var optionsMultipleBarsChart = {
						seriesBarDistance: 10,
						axisX: {
							showGrid: false
						},
						height: '300px'
					};

					var responsiveOptionsMultipleBarsChart = [
						['screen and (max-width: 640px)', {
							seriesBarDistance: 5,
							axisX: {
								labelInterpolationFnc: function(value) {
									return value[0];
								}
							}
						}]
					];

					var multipleBarsChart = Chartist.Bar('#multipleBarsChart', dataMultipleBarsChart, optionsMultipleBarsChart, responsiveOptionsMultipleBarsChart);
					

					//start animation for the Emails Subscription Chart
					md.startAnimationForBarChart(multipleBarsChart);
				}
				
				
				if ($('#multipleBarsChart2').length != 0) {
					
					/* ----------==========    Rounded Line Chart initialization    ==========---------- */
					

					var dataMultipleBarsChart = {
						labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
						series: [
							[542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895],
							[412, 243, 280, 580, 453, 353, 300, 364, 368, 410, 636, 695]
						]
					};

					var optionsMultipleBarsChart = {
						seriesBarDistance: 10,
						axisX: {
							showGrid: false
						},
						height: '300px'
					};

					var responsiveOptionsMultipleBarsChart = [
						['screen and (max-width: 640px)', {
							seriesBarDistance: 5,
							axisX: {
								labelInterpolationFnc: function(value) {
									return value[0];
								}
							}
						}]
					];

					var multipleBarsChart = Chartist.Bar('#multipleBarsChart2', dataMultipleBarsChart, optionsMultipleBarsChart, responsiveOptionsMultipleBarsChart);
					

					//start animation for the Emails Subscription Chart
					md.startAnimationForBarChart(multipleBarsChart);
				}
				
				
				
				if ($('#multipleBarsChart3').length != 0) {
					
					/* ----------==========    Rounded Line Chart initialization    ==========---------- */
					

					var dataMultipleBarsChart = {
						labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
						series: [
							[542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895],
							[412, 243, 280, 580, 453, 353, 300, 364, 368, 410, 636, 695]
						]
					};

					var optionsMultipleBarsChart = {
						seriesBarDistance: 10,
						axisX: {
							showGrid: false
						},
						height: '300px'
					};

					var responsiveOptionsMultipleBarsChart = [
						['screen and (max-width: 640px)', {
							seriesBarDistance: 5,
							axisX: {
								labelInterpolationFnc: function(value) {
									return value[0];
								}
							}
						}]
					];

					var multipleBarsChart = Chartist.Bar('#multipleBarsChart3', dataMultipleBarsChart, optionsMultipleBarsChart, responsiveOptionsMultipleBarsChart);
					

					//start animation for the Emails Subscription Chart
					md.startAnimationForBarChart(multipleBarsChart);
				}
				
				/*  **************** Simple Bar Chart - barchart ******************** */
						if ($('#simpleBarChart').length != 0) {
							   var dataSimpleBarChart = {
										labels: ['0', '1', '2', '3', '4'],
										series: [
											[542, 100, 320, 780,900 ]
										]
									};

									var optionsSimpleBarChart = {
										seriesBarDistance: 50,
										axisX: {
											showGrid: false
										}
									};

									var responsiveOptionsSimpleBarChart = [
										['screen and (max-width: 640px)', {
											seriesBarDistance: 15,
											axisX: {
												labelInterpolationFnc: function(value) {
													return value[0];
												}
											}
										}]
									];

									var simpleBarChart = Chartist.Bar('#simpleBarChart', dataSimpleBarChart, optionsSimpleBarChart, responsiveOptionsSimpleBarChart);

									//start animation for the Emails Subscription Chart
									md.startAnimationForBarChart(simpleBarChart);
						}
						if ($('#simpleBarChart2').length != 0) {
							   var dataSimpleBarChart = {
								labels: ['0', '1', '2', '3', '4'],
								series: [
									[540, 90, 310, 770,890 ]
								]
							};

							var optionsSimpleBarChart = {
								seriesBarDistance: 30,
								axisX: {
									showGrid: false
								}
							};

							var responsiveOptionsSimpleBarChart = [
								['screen and (max-width: 640px)', {
									seriesBarDistance: 10,
									axisX: {
										labelInterpolationFnc: function(value) {
											return value[0];
										}
									}
								}]
							];

							var simpleBarChart2 = Chartist.Bar('#simpleBarChart2', dataSimpleBarChart, optionsSimpleBarChart, responsiveOptionsSimpleBarChart);

							//start animation for the Emails Subscription Chart
							md.startAnimationForBarChart(simpleBarChart2);
						}

					}
			
		
			
			
	$(document).ready(function() {
   $('#testimonial').utilCarousel({
					showItems : 1,
					breakPoints : [[1920, 1]],
					autoPlay : true,
					navigation : true, 
					pagination : false,
					navigationText : ['<i class="icon-left-open-big"></i>', '<i class=" icon-right-open-big"></i>'],
	});	
	
 });		
