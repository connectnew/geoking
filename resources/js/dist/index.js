(function() {
       
        if($('#profile_score').length){ 
            $('#profile_score').easyPieChart({
                barColor: '#c20404',
                size: 250,
                trackColor: '#c3c3c3',
                scaleColor: false,
                animate: true,
                lineWidth: 8,
                lineCap: 'square'
            });
        }

        if($('#site-score-area-chart').length){
            Highcharts.chart('site-score-area-chart', {
                  chart: {
                      type: 'areaspline',
                  },
                  title: {
                      text: ''
                  },
                  legend: {
                      enabled:true,
                      symbolWidth: 12,
                    symbolHeight: 12,
                    symbolRadius: 0,
                    squareSymbol: false,
                    
                  },
                  xAxis: {
                      categories: [
                          'January',
                          'February',
                          'March',
                          'April',
                          'May',
                          'June',
                          'July'
                      ] ,
                      min: 0.5, 
                      max: 5.5,
                      labels: {
                          style: {
                                 fontSize:'12px',
                                 color:'#262932'
                          }
                      }             
                  },
                  yAxis: {
                      title: {
                          text: ''
                      },
                      gridLineWidth: 0,
                      labels: {
                          style: {
                                 fontSize:'12px', color:'#262932'
                          }
                      }  
                  },
                  exporting:{
                      enabled:false
                  },
                  tooltip: {
                      shared: false,
                      useHTML: true,
                      pointFormat: '<b style="font-size:1.5em; font-family:Arial; margin:10px 0 0 0; font-weight:bold; ">{point.y}</b> ', 
                  },
                  credits: {
                      enabled: false
                  },
                  plotOptions: {
                      areaspline: {
                          fillOpacity: 1
                      }
                  },
                  series: [{
                            name: 'FB',
                            fillColor:'rgba(210,214,223, 1)',
                            lineColor:'rgba(210,214,223, 1)',
                            data: [95, 94, 75, 60, 70, 95, 90],
                            marker:{
                            enabled: false,
                       }
                      }, {
                      name: 'Google',                  
                      fillColor:'rgba(79,150,192, 1)',                 
                      data: [35, 45, 70, 60, 95, 38, 95],
                      lineColor:'rgba(79,150,192, 1)', 
                        marker:{
                          enabled: false,
                       }
                     },
                       {
                      name: 'Bing',                  
                      fillColor:'rgba(5,197,158, 1)',                 
                      data: [84, 90, 70, 55, 60, 92, 75],
                      lineColor:'rgba(5,197,158, 1)', 
                       marker:{
                          enabled: false,
                       }
                     },
                       {
                      name: 'Booking',                  
                      fillColor:'rgba(197,19,5, 1)',                 
                      data: [25, 45, 45, 28, 85, 28, 90],
                      lineColor:'rgba(197,19,5, 1)', 
                       marker:{
                          enabled: false,
                       }
                     }
                  ]

            });
        }

        /* Home Chart Review Analysis */
        if($('#home_review_analysis').length){
             Highcharts.chart('home_review_analysis', {
                 chart: {
                     type: 'column',
         
                 },
                 title: {
                     text: ''
                 },
                 subtitle: {
                     text: ''
                 },
                 xAxis: {
                     categories: [
                         'Jan',
                         'Feb',
                         'Mar',
                         'Apr',
                         'May',
                         'Jun',
                         'Jul',
                         'Aug',
                         'Sep',
                     ],
                     crosshair: true
                 },
                 credits:{
                     enabled:false
                 },
                 exporting:{
                     enabled:false
                 },
                 yAxis: {
                     min: 0,
                     title: {
                         text: ''
                     }
                 },
                 legend: {
                    symbolWidth: 12,
                    symbolHeight: 12,
                    symbolRadius: 0,
                    squareSymbol: false
                 },
                 tooltip: {
                     headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                         '<td style="padding:0"><b>{point.y}</b></td></tr>',
                     footerFormat: '</table>',
                     shared: true,
                     useHTML: true
                 },
                 plotOptions: {
                     column: {
                         borderWidth: 0,
                         padding:0
                     } ,
                     series: {
                         pointPadding: 0,
                         groupPadding: 0.23,
                         cursor: 'pointer',
                         point: {
                            events: {
                                click: function () {
                                    $('#home_review_analysis_modal').modal('show');
                                }
                            }
                        }
                     }                  
                 },
                 series: [{
                     name: 'Positive',
                     data: [32, 28, 40, 55, 40, 23, 18, 28, 48],
                     color: '#00a65a'
         
                 }, {
                     name: 'Negative',
                     data: [80, 73, 60, 74, 60, 30, 24, 52, 74],
                     color: '#de4b39'
         
                 }]
             });
        }
        /* Home Chart Review Analysis */


        



        /* Reason for Dissatisfaction */
        if($('#reason_for_dis').length){
          google.charts.load("current", {packages:["corechart"]});

          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Reasons', 'Reasons for Dissatisfaction'],
              ['Food',35],
              ['Location',28],
              ['Price',15],
              ['Service',24],
              ['Menu',10],
              ['Parking',6]
            ]);

            var options = {
              pieHole: 0.5,
              chartArea: {"left":30,"top":80,'width': '100%', 'height': '90%'},
              colors: ['#f66955', '#00a65a', '#f39c11', '#00c0ef', '#3c8dbc', '#d2d6df'], 
              pieSliceTextStyle: {
                color: 'transparent',
              }, 
            };

            var chart = new google.visualization.PieChart(document.getElementById('reason_for_dis'));
            google.visualization.events.addListener(chart, 'select', reason_dissatisfaction);
            chart.draw(data, options);
          }
        }
        function reason_dissatisfaction(){
          $('#reason_dis_modal').modal('show');
        }
        /* Reason for Dissatisfaction */

         /* Photo quantity */
        if($('#photo_quantity').length){
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Reasons', 'Reasons for Dissatisfaction'],
              ['Customer photos',25],
              ['Owner photos',75],
            ]);

            var options = {
              pieHole: 0.75,
              chartArea: {"left":0,"top":50,'width': '100%', 'height': '80%'},
              colors: ['#f8bf00', '#4783f5'],
              vAxis: {
                    textPosition: 'none'
                }, 
              pieSliceTextStyle: {
                    color: 'transparent',
                  },   
            };

            var chart = new google.visualization.PieChart(document.getElementById('photo_quantity'));
            chart.draw(data, options);
          }
        }
        /* Photo quantity */

         /* Local posts performance */
        if($('#local_posts').length){
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Reasons', 'Reasons for Dissatisfaction'],
              ['Views',100],
              ['Call to action', 0],
            ]);

            var options = {
              pieHole: 0.75,
              chartArea: {"left":0,"top":50,'width': '100%', 'height': '80%'},
              colors: ['#a64491', '#fa6ae5'],
              vAxis: {
                    textPosition: 'none'
                }, 
              pieSliceTextStyle: {
                    color: 'transparent',
                  },   
            };

            var chart = new google.visualization.PieChart(document.getElementById('local_posts'));
            chart.draw(data, options);
          }
        }
        /* Local posts performance */

        /* photo_views_graph Open */
        if($('#photo_views_graph').length){
            Highcharts.chart('photo_views_graph', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                credits:{
                  enabled:false 
                },
                exporting:{
                  enabled:false 
                },
                xAxis: {
                    type: 'datetime',
                    tickInterval:24 * 3600 * 1000 * 5,
                    tickPositioner: function(min, max){
                         var interval = this.options.tickInterval,
                             ticks = [],
                             count = 0;
                        
                        while(min < max) {
                            ticks.push(min);
                            min += interval;
                            count ++;
                        }
                        
                        ticks.info = {
                            unitName: 'day',
                            count: 5,
                            higherRanks: {},
                            totalRange: interval * count
                        }                        
                        return ticks;
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'normal'
                    }
                },

                series: [{
                    name: 'Customer photos',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2018, 8, 25),
                    color:"#febc06",
                    data: [[140],[127],[35],[132],[192],[179],[131],[206],[92],[57],[352],[370],[281],[282],[128],[100],[33],[215],[154],[226],[225],[334],[105],[60],[264],[227],[151],[115],[184],[74]]      
                },{
                    name: 'Owner photos',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2018, 8, 25),
                    color:"#4386ee",
                    data: [[140],[127],[35],[132],[192],[179],[131],[206],[92],[57],[352],[370],[281],[282],[128],[100],[33],[215],[154],[226],[225],[334],[105],[60],[264],[227],[151],[115],[184],[74]]          
                }]  
            });
        }

        /* photo_views_graph Open */

        /* local_posts_performance_graph Open */
         if($('#local_posts_performance_graph').length){
            Highcharts.chart('local_posts_performance_graph', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                credits:{
                  enabled:false 
                },
                exporting:{
                  enabled:false 
                },
                xAxis: {
                    type: 'datetime',
                    tickInterval:24 * 3600 * 1000 * 5,
                    tickPositioner: function(min, max){
                         var interval = this.options.tickInterval,
                             ticks = [],
                             count = 0;
                        
                        while(min < max) {
                            ticks.push(min);
                            min += interval;
                            count ++;
                        }
                        
                        ticks.info = {
                            unitName: 'day',
                            count: 5,
                            higherRanks: {},
                            totalRange: interval * count
                        }

                        
                        return ticks;
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'normal'
                    }
                },
                series: [{
                        name: 'Views',
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2018, 8, 25),
                        color:"#a64491",
                        data: [[140],[127],[35],[132],[192],[179],[131],[206],[92],[57],[352],[370],[281],[282],[128],[100],[33],[215],[154],[226],[225],[334],[105],[60],[264],[227],[151],[115],[184],[74]]      
                    },{
                        name: 'Call to action',
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2018, 8, 25),
                        color:"#fa6ae5",
                        data: [[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0],[0]]        
                    }]               
            });
        }
        /* local_posts_performance_graph Open */


        /* performance trend Open */
        if($('#performance_trend').length){
            Highcharts.chart('performance_trend', {
                chart: {
                    type: 'spline',
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                xAxis: {
                        type: 'datetime',
                        tickInterval:24 * 3600 * 1000 * 1,
                        tickPositioner: function(min, max){
                             var interval = this.options.tickInterval,
                                 ticks = [],
                                 count = 0;
                            
                            while(min < max) {
                                ticks.push(min);
                                min += interval;
                                count ++;
                            }
                            
                            ticks.info = {
                                unitName: 'day',
                                count: 1,
                                higherRanks: {},
                                totalRange: interval * count
                            }

                            
                            return ticks;
                        }
                    },
                yAxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                        format: ''
                    },
                    lineWidth: 2
                },
                legend: {
                     layout: 'vertical',
                       align: 'right',
                       verticalAlign: 'top',
                       itemMarginTop: 10,
                       itemMarginBottom: 10,
                       symbolWidth: 12,
                        symbolHeight: 12,
                        symbolRadius: 0,
                        squareSymbol: true
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br/>',
                    pointFormat: '{point.x} : {point.y}'
                },
                plotOptions: {
                    spline: {
                        marker: {
                            enable: false
                        }
                    }
                },
                series: [{
                    name: 'Competitor 1',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2018, 8, 25),
                    color :'#3366cc',
                    data: [20,30,10,40,20,30,10,40,20],
                    marker: {
                        symbol: 'circle'
                    }
                },{
                    name: 'Competitor 2',
                    color :'#dc3912',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2018, 8, 25),
                    data: [10,30,15,50,10,30,15,50, 30],
                    marker: {
                        symbol: 'circle'
                    }
                },{
                    name: 'Competitor 3',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2018, 8, 25),
                    color :'#ff9900',
                    data: [15,40,30,20, 15,40,30,20, 60],
                    marker: {
                        symbol: 'circle'
                    }
       
                },{
                    name: 'Competitor 4',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2018, 8, 25),
                    color :'#109618',
                    data: [25,60,80,40, 25,60,80,40, 10],
                    marker: {
                        symbol: 'circle'
                    }
                },{
                    name: 'Competitor 5',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2018, 8, 25),
                    color :'#990099',
                    data: [35,70,40,20, 35,70,40,20, 50],
                    marker: {
                        symbol: 'circle'
                    }
                }]
            });
        }
        /* performance trend Open */

        /* attribute score*/
        if($('#attribute_score').length){
            Highcharts.chart('attribute_score', {

                chart: {
                    type: 'column'
                },

                title: {
                    text: ''
                },
                credits: {
                            enabled: false
                        },
                        exporting: {
                            enabled: false
                        },
                xAxis: {
                    categories: ['Price', 'Service', 'Food', 'Others']
                },

                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: ''
                    }
                },

                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
                    }
                },

                plotOptions: {
                    column: {
                        stacking: 'normal',
                        borderWidth: 0,
                    }
                },

                series: [{
                    name: 'Resturant A',
                    color:'#2cbebb',
                    data: [15, 13, 14, 17],
                }, {
                    name: 'Resturant B',
                     color:'#4ea6c7',
                    data: [13, 14, 28, 22],
                }, {
                    name: 'Resturant C',
                     color:'#6aa2b8',
                    data: [12, 25, 16, 12],
                }, {
                    name: 'Resturant D',
                     color:'#5dd0fc',
                    data: [13,16, 24, 28],
                }]
            });
        }
        /* Attribute Score End*/

        /* Customer Action Open*/
        if($('#customer_action').length){
         Highcharts.chart('customer_action', {
              chart: {
                type: 'area',
              },
              title: {
                text: ''
              },
              credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
              subtitle: {
                text: '',
                floating: true,
                align: 'right',
                verticalAlign: 'bottom',
                y: 15
              },
              legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                borderWidth: 1,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
              },
              xAxis: {
                    type: 'datetime',
                    tickInterval:24 * 3600 * 1000 * 7,
                    tickPositioner: function(min, max){
                         var interval = this.options.tickInterval,
                             ticks = [],
                             count = 0;
                        
                        while(min < max) {
                            ticks.push(min);
                            min += interval;
                            count ++;
                        }
                        
                        ticks.info = {
                            unitName: 'day',
                            count: 7,
                            higherRanks: {},
                            totalRange: interval * count
                        }

                        
                        return ticks;
                    }
                },
              yAxis: {
                title: {
                  text: ''
                },
                labels: {
                  formatter: function () {
                    return this.value;
                  }
                }
              },
              tooltip: {
                formatter: function () {
                  return '<b>' + this.series.name + '</b><br/>' +
                    this.x + ': ' + this.y;
                }
              },
              legend:{
                enabled: false
              },
              plotOptions: {
                area: {
                  fillOpacity: 1
                }            
              },
              credits: {
                enabled: false
              },
              series: [{
                name: 'Visit your website',
                pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(2018, 12, 22),
                color: '#238c54',
                data: [0, 1, 4, 0, 5, 0, 3, 0],
                marker:{
                    enabled: false,
                }
              }, {
                name: 'Request direction',
                color: '#c7cf42',
                pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(2018, 12, 22),
                data: [1, 0, 3, 0, 3, 0, 2, 0],
                marker:{
                    enabled: false,
                }
              }, {
                name: 'Call you',
                 color: '#578ef8',
                pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(2018, 12, 22),
                data: [3, 0, 3, 0, 0, 2, 0, 4],
                marker:{
                    enabled: false,
                }
              }]
            });
        }
        /* Customer Action End */





        /* Customer Search Business */
          if($('#customer_search_business').length){
              google.charts.load("current", {packages:["corechart"]});
              google.charts.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Search', 'Customers Search for your business'],
                  ['Direct',25],
                  ['Discovery',75],
                ]);

                var options = {
                  pieHole: 0.70,
                  chartArea: {"left":0,"top":20,'width': '100%', 'height': '80%'},
                  colors: ['#0a8043', '#578ef8'],
                  pieSliceTextStyle: {
                    color: 'transparent',
                  },            
                  legend: 'none'  
                };

                var chart = new google.visualization.PieChart(document.getElementById('customer_search_business'));
                chart.draw(data, options);
              }
          }

        /* Customer Search Business */


        /* Business Result Profile Score */
          if($('#business_profile_score').length){ 
              $('#business_profile_score').easyPieChart({
                  barColor: '#f9cc16',
                  size: 100,
                  trackColor: '#c6c6c6',
                  scaleColor: false,
                  animate: true,
                  lineWidth: 7,
                  lineCap: 'square'
              });
          }         

        /* Business Result Profile Score */




        /* How customers search for your business - PIE CHART */
        if($('#cust_srch_business').length){
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Search Type','Value'],
              ['Direct (search queries)',28],
              ['Discovery (search queries)' ,72],
            ]);
            var options = {
              pieHole: 0.75,
              chartArea: {"left":0,"top":50,'width': '100%', 'height': '80%'},
              colors: ['#4bb867', '#2d409d'],
              vAxis: {
                    textPosition: 'none'
                }, 
              pieSliceTextStyle: {
                color: 'transparent',
              },
              legend: { 
                textStyle: {
                  fontSize: 20                  
                },
                formatter: function(){
                  return 'asdjlasjdlsa'
                }  
              }, 
              
            };

            var chart = new google.visualization.PieChart(document.getElementById('cust_srch_business'));
            chart.draw(data, options);

          }
        }
        /* How customers search for your business - PIE CHART */

        /* Where customer view your business on Google - PIE CHART */
        if($('#business_on_google').length){
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);



          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Reasons', 'Reasons for Dissatisfaction'],
              ['Search views', 78],
              ['Map views ', 22],
            ]);

            var options = {
              pieHole: 0.75,
              chartArea: {"left":0,"top":50,'width': '100%', 'height': '80%'},
              colors: ['#ffbe01', '#dc2d3c'],
              vAxis: {
                    textPosition: 'none'
                }, 
              pieSliceTextStyle: {
                color: 'transparent',
              },
              legend: { 
                textStyle: {
                  fontSize: 20
                }                
              },   
            };

            var chart = new google.visualization.PieChart(document.getElementById('business_on_google'));
            chart.draw(data, options);
          }
        }
        /* Where customer view your business on Google - PIE CHART */



        /* How customers search for your business - STACK BAR CHART */
        if($('#cust_srch_business_bar').length){
            Highcharts.chart('cust_srch_business_bar', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                credits:{
                  enabled:false 
                },
                exporting:{
                  enabled:false 
                },
                xAxis: {
                    type: 'datetime',
                    tickInterval:24 * 3600 * 1000 * 5,
                    tickPositioner: function(min, max){
                         var interval = this.options.tickInterval,
                             ticks = [],
                             count = 0;
                        
                        while(min < max) {
                            ticks.push(min);
                            min += interval;
                            count ++;
                        }
                        
                        ticks.info = {
                            unitName: 'day',
                            count: 5,
                            higherRanks: {},
                            totalRange: interval * count
                        }                        
                        return ticks;
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                legend: { 
                  position: 'bottom',
                  itemStyle: {
                     fontSize:'18px',
                     color: '#1e1e1e'
                  },
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'normal'
                    }
                },

                series: [{
                    name: 'Direct (search queries)',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2018, 8, 25),
                    color:"#4bb867",
                    data: [[140],[127],[35],[132],[192],[179],[131],[206],[92],[57],[352],[370],[281],[282],[128],[100],[33],[215],[154],[226],[225],[334],[105],[60],[264],[227],[151],[115],[184],[74]]      
                },{
                    name: 'Discovery (search queries)',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2018, 8, 25),
                    color:"#2d409d",
                    data: [[140],[127],[35],[132],[192],[179],[131],[206],[92],[57],[352],[370],[281],[282],[128],[100],[33],[215],[154],[226],[225],[334],[105],[60],[264],[227],[151],[115],[184],[74]]          
                }]  
            });
        }

        /* How customers search for your business - STACK BAR CHART */

        /* Where customer view your business on Google - STACK BAR CHART */
         if($('#business_on_google_bar').length){
            Highcharts.chart('business_on_google_bar', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                credits:{
                  enabled:false 
                },
                exporting:{
                  enabled:false 
                },
                xAxis: {
                    type: 'datetime',
                    tickInterval:24 * 3600 * 1000 * 5,
                    tickPositioner: function(min, max){
                         var interval = this.options.tickInterval,
                             ticks = [],
                             count = 0;
                        
                        while(min < max) {
                            ticks.push(min);
                            min += interval;
                            count ++;
                        }
                        
                        ticks.info = {
                            unitName: 'day',
                            count: 5,
                            higherRanks: {},
                            totalRange: interval * count
                        }

                        
                        return ticks;
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'normal'
                    }
                },
                legend: { 
                  position: 'bottom',
                  itemStyle: {
                     fontSize:'18px',
                     color: '#1e1e1e'
                  },
                },
                series: [{
                        name: 'Search views',
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2018, 8, 25),
                        color:"#ffbe01",
                        data: [[140],[127],[35],[132],[192],[179],[131],[206],[92],[57],[352],[370],[281],[282],[128],[100],[33],[215],[154],[226],[225],[334],[105],[60],[264],[227],[151],[115],[184],[74]]      
                    },{
                        name: 'Map views',
                        pointInterval: 24 * 3600 * 1000,
                        pointStart: Date.UTC(2018, 8, 25),
                        color:"#dc2d3c",
                        data: [[140],[127],[35],[132],[192],[179],[131],[206],[92],[57],[352],[370],[281],[282],[128],[100],[33],[215],[154],[226],[225],[334],[105],[60],[264],[227],[151],[115],[184],[74]]      
                    }]               
            });
        }
         /* Where customer view your business on Google - STACK BAR CHART */






        /* Fans Interaction1 - PIE CHART */
        if($('#fans-interaction1').length){
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Fans', 'Interaction Types'],
              ['Likes', 89],
              ['Comments',4],
              ['Share' ,7]
            ]);
            var options = {
              pieHole: 0.55,
              backgroundColor: 'transparent',
              chartArea: {"left":0,"top":35,'width': '100%', 'height': '80%'},
              colors: ['#043e88', '#043e88', '#043e88'],
              vAxis: {
                    textPosition: 'none'
                }, 
              pieSliceTextStyle: {
                color: 'transparent',
              },
              legend: { 
                position: 'none', 
                alignment: 'start',
                textStyle: {
                  fontSize: 20                  
                },
              }, 
              
            };

            var chart = new google.visualization.PieChart(document.getElementById('fans-interaction1'));
            chart.draw(data, options);

          }
        }
        /* Fans Interaction1 - PIE CHART */

        /* Fans Interaction2 - PIE CHART */
        if($('#fans-interaction2').length){
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Fans', 'Interaction Types'],
              ['Likes', 93],
              ['Comments',5],
              ['Share' ,2]
            ]);
            var options = {
              pieHole: 0.55,
              backgroundColor: 'transparent',
              chartArea: {"left":0,"top":35,'width': '100%', 'height': '80%'},
              colors: ['#0ad0c9', '#0ad0c9', '#0ad0c9'],
              vAxis: {
                    textPosition: 'none'
                }, 
              pieSliceTextStyle: {
                color: 'transparent',
              },
              pieSliceStrokeWidth:{
                border: 2
              },
              legend: { 
                position: 'none', 
                alignment: 'start',
                textStyle: {
                  fontSize: 20                  
                },
              }, 
              
            };

            var chart = new google.visualization.PieChart(document.getElementById('fans-interaction2'));
            chart.draw(data, options);

          }
        }
        /* Fans Interaction2 - PIE CHART */


        /* Attribute Score Consumer Start*/
        if($('#attribute_score_consumer').length){
            Highcharts.chart('attribute_score_consumer', {
                chart: {
                  type: 'column'
                },
                title: {
                  text: ''
                },
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                xAxis: {
                  categories: ['Price', 'Service', 'Food', 'Others'],
                  labels: {
                      style: {
                        fontSize: '14px',
                      }
                  }
                },
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: ''
                    }
                },

                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Total: ' + this.point.stackTotal;
                    }
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        borderWidth: 0,
                    },
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    $('#attributeScoreModal').modal('show');
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Location 1',
                    color:'#2cbebb',
                    data: [15, 13, 14, 17],
                }, {
                    name: 'Location 2',
                     color:'#4ea6c7',
                    data: [13, 14, 28, 22],
                }, {
                    name: 'Location 3',
                     color:'#6aa2b8',
                    data: [12, 25, 16, 12],
                }, {
                    name: 'Location 4',
                     color:'#5dd0fc',
                    data: [13,16, 24, 28],
                }]
            });
        }
        /* Attribute Score Consumer End*/

        /* Popular Times Start*/
        if($('#popular_times').length){
            Highcharts.chart('popular_times', {

                chart: {
                    type: 'column'
                },

                title: {
                    text: ''
                },
                credits: {
                            enabled: false
                        },
                        exporting: {
                            enabled: false
                        },
                xAxis: {
                    categories: ['6a', '8a', '10a', '12p', '2p', '4p', '6p', '8p', '10p' , '12a', '2a','4a'],
                    labels: {
                        style: {
                            fontSize: '14px',
                        }
                    }
                },

                yAxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                      enabled : false
                    }
                },

                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b>';
                           
                            
                    }
                },

                plotOptions: {
                    column: {
                        stacking: 'normal',
                        borderWidth: 0,
                    },
                    series: {
                        pointPadding: 0,
                        groupPadding: 0.05,
                    }
                },
                legend:{
                  enabled:false
                },
                series: [{
                    color:'#7baaf7',
                    data: [15, 13, 14, 17,50,10,19,25,60,24,20,18],
                } ]
            });
        }
        /* Popular Times End*/

})();
