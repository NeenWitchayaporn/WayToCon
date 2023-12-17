<?php 
    include('server.php');
    session_start();
if(!isset($_SESSION['StaffEmail'])){
    $_SESSION['message'] = 'You must log in first';
    header('location:stafflogin.php');
}

if(!isset($_SESSION['Role'])){
    $_SESSION['message'] = "You don't have permission";
    header('location:stafflogin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Sales | WayToCon Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "stafforder.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js" ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
</head>
<body>
<?php include_once('staffheader.php'); ?>
<div class="ordertable">
    <div class="h4 text-center mb-1 mt-5" > Dashboard </div>        
            <div class="row mt-4">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 text-center">
                <div class="card mt-3"  style="padding-left: 20px;">
                    <div class="h6 text-center mb-1 mt-3" > Total Event Type Sales </div>
                    <div id="chart-container" class="text-center">
                    <canvas id="graphCanvas1"></canvas>
                     </div>
                </div></div>
                
                <div class="col-sm-5 text-center">
                <div class="card mt-3"  style="padding-left: 20px;">
                <div class="h6 text-center mb-1 mt-3" > Top 4 Giftshop Collection Sales </div>
                <div id="chart-container" class="text-center">
                    <canvas id="graphCanvas2"></canvas>
                </div>

        
                </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 text-center">
                <div class="card mt-3"  style="padding-left: 20px;">
                    <div class="h6 text-center mb-1 mt-3" > Monthly Event Sales </div>
                    <div id="chart-container" class="text-center">
                    <canvas id="graphCanvas3"></canvas>
                     </div>
                </div></div>
                
                <div class="col-sm-5 text-center">
                <div class="card mt-3"  style="padding-left: 20px;">
                <div class="h6 text-center mb-1 mt-3" > Monthly Giftshop Sales </div>
                <div id="chart-container" class="text-center">
                    <canvas id="graphCanvas4"></canvas>
                </div>

        
                </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 text-center">
                <div class="card mt-3"  style="padding-left: 20px;">
                    <div class="h6 text-center mb-1 mt-3" > Event Sales with User Gender</div>
                    <div id="chart-container" class="text-center">
                    <canvas id="graphCanvas5"></canvas>
                     </div>
                </div></div>
                
                <div class="col-sm-5 text-center">
                <div class="card mt-3"  style="padding-left: 20px;">
                <div class="h6 text-center mb-1 mt-3" > Giftshop Sales with User Gender</div>
                <div id="chart-container" class="text-center">
                    <canvas id="graphCanvas6"></canvas>
                </div>

        
                </div>
                </div>
            </div>


        <br><br><br>
</div>

</body>
</html>

<script>
        $(document).ready(function () {
            showGraph1();
        });


        function showGraph1()
        {
            {
                $.post("dataeventeachtype.php",
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var marks = [];

                    for (var i in data) {
                        name.push(data[i].TypeName);
                        marks.push(data[i].TotalPrice);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Total Sales (THB)',
                                backgroundColor: '#F3722C',
                                borderColor: '#F3722C',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas1");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
        </script>

<script>
                $(document).ready(function () {
                    showGraph2();
                });


                function showGraph2()
                {
                    {
                        $.post("top4collection.php",
                        function (data)
                        {
                            console.log(data);
                            var name = [];
                            var marks = [];

                            for (var i in data) {
                                name.push(data[i].ProductColName);
                                marks.push(data[i].TotalPrice);
                            }

                            var chartdata = {
                                labels: name,
                                datasets: [
                                    {
                                        label: 'Total Sales (THB)',
                                        backgroundColor: '#8F4FEA',
                                        borderColor: '#8F4FEA',
                                        hoverBackgroundColor: '#CCCCCC',
                                        hoverBorderColor: '#666666',
                                        data: marks
                                    }
                                ]
                            };

                            var graphTarget = $("#graphCanvas2");

                            var barGraph = new Chart(graphTarget, {
                                type: 'bar',
                                data: chartdata
                            });
                        });
                    }
                }
                </script>

<script>
        $(document).ready(function () {
            showGraph3();
        });


        function showGraph3()
        {
            {
                $.post("datasaleevent.php",
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var marks = [];

                    for (var i in data) {
                        var n = data[i].BookYear + ', ' + data[i].BookMonth;
                        name.push(n);
                        marks.push(data[i].TotalPrice);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Total Sales (THB)',
                                backgroundColor: '#F8961E',
                                borderColor: '#F3722C',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas3");

                    var lineGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata
                    });
                });
            }
        }
        </script>

<script>
        $(document).ready(function () {
            showGraph4();
        });


        function showGraph4()
        {
            {
                $.post("datasalegiftshop.php",
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var marks = [];

                    for (var i in data) {
                        var n = data[i].OrderYear + ', ' + data[i].OrderMonth;
                        name.push(n);
                        marks.push(data[i].TotalPrice);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Total Sales (THB)',
                                backgroundColor: '#C1A5EA',
                                borderColor: '#8F4FEA',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas4");

                    var lineGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata
                    });
                });
            }
        }
        </script>


<script>
        $(document).ready(function () {
            showGraph5();
        });


        function showGraph5()
        {
            {
                $.post("dataeventgender.php",
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var marks = [];

                    for (var i in data) {
                        if( data[i].UserGender == 'F')
                        {
                            var n = 'Female';
                        }
                        else
                        {
                            var n = 'Male';
                        }
                        
                        name.push(n);
                        marks.push(data[i].TotalPrice);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Total Sales (THB)',
                                backgroundColor: ['#F8961E','#F3722C'],
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas5");

                    var pieGraph = new Chart(graphTarget, {
                        type: 'pie',
                        data: chartdata
                    });
                });
            }
        }
</script>

<script>
        $(document).ready(function () {
            showGraph6();
        });


        function showGraph6()
        {
            {
                $.post("datagiftshopgender.php",
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var marks = [];

                    for (var i in data) {
                        if( data[i].UserGender == 'F')
                        {
                            var n = 'Female';
                        }
                        else
                        {
                            var n = 'Male';
                        }
                        
                        name.push(n);
                        marks.push(data[i].TotalPrice);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Total Sales (THB)',
                                backgroundColor: ['#C1A5EA','#8F4FEA'],
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas6");

                    var pieGraph = new Chart(graphTarget, {
                        type: 'pie',
                        data: chartdata
                    });
                });
            }
        }
</script>
