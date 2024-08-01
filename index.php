<!-- Created by MUHAMMAD SYAKIR ADAM BIN MOHAMAD NAZRI -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Consumption Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .btn-lg-custom {
            font-size: 1.25rem;
            padding: 0.75rem 1.25rem;
        }

        .results-table th, .results-table td {
            text-align: center;
        }
    </style>

</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">ELECTRICITY CONSUMPTION CALCULATOR</h2>
    <form method="post" class="mt-4">
        <div class="form-group">
            <label for="voltage">Voltage (V)</label>
            <input type="" class="form-control" id="voltage" name="voltage" required>
        </div>
        <div class="form-group">
            <label for="current">Current (A)</label>
            <input type="" class="form-control" id="current" name="current" required>
        </div>
        <div class="form-group">
            <label for="rate">Current Rate (sen/kWh)</label>
            <input type="" class="form-control" id="rate" name="rate" required>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-lg btn-lg-custom">Calculate</button>
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $voltage = $_POST['voltage'];
        $current = $_POST['current'];
        $rate = $_POST['rate'];

        function calculatePower($voltage, $current) {
            return $voltage * $current;
        }

        function calculateEnergy($power, $hours) {
            return ($power * $hours) / 1000;
        }

        function calculateTotalCharge($energy, $rate) {
            return $energy * ($rate / 100);
        }

        $power = calculatePower($voltage, $current);
        $energyPerHour = calculateEnergy($power, 1);
        $energyPerDay = calculateEnergy($power, 24);
        $totalChargePerHour = calculateTotalCharge($energyPerHour, $rate);
        $totalChargePerDay = calculateTotalCharge($energyPerDay, $rate);

        echo "<div class='d-flex justify-content-center mt-4'>
                <div class='card' style='width: 20rem;'>
                    <div class='card-body'>
                        <p class='card-text'>Power : <strong>" . number_format($power, 2) . "W</strong></p>
                        <p class='card-text'>Energy per Hour : <strong>" . number_format($energyPerHour, 5) . "kWh</strong></p>
                        <p class='card-text'>Total Charge per Hour: <strong>RM" . number_format($totalChargePerHour, 3) . "</strong></p>
                        <p class='card-text'>Energy per Day : <strong>" . number_format($energyPerDay, 5) . "kWh</strong></p>
                        <p class='card-text'>Total Charge per Day: <strong>RM" . number_format($totalChargePerDay, 3) . "</strong></p>
                    </div>
                </div>
             </div>";

        echo "<div class='mt-4'>
                <table class='table table-bordered results-table'>
                    <thead>
                        <tr>
                            <th>Hour</th>
                            <th>Energy (kWh)</th>
                            <th>Total (RM)</th>
                        </tr>
                    </thead>
                    <tbody>";

        for ($hour = 1; $hour <= 24; $hour++) {
            $energy = calculateEnergy($power, $hour);
            $totalCharge = calculateTotalCharge($energy, $rate);
            echo "<tr>
                    <td>$hour</td>
                    <td>" . number_format($energy, 5) . "</td>
                    <td>" . number_format($totalCharge, 2) . "</td>
                  </tr>";
        }

        echo "      </tbody>
                </table>
              </div>";
    }
    ?>

</div>
</body>
</html>